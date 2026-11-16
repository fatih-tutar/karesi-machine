<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AccountingEntryRequest;
use App\Models\AccountingEntry;
use App\Models\Company;
use App\Models\Material;
use App\Models\Project;
use App\Services\TcmbExchangeRate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class AccountingController extends Controller
{
    public const DEFAULT_SALARY_MULTIPLIER = 1.8;

    public function __construct(private readonly TcmbExchangeRate $rates) {}

    public function index(Request $request): View
    {
        $multiplier = self::salaryMultiplier();
        $salaryMaterialId = (int) config('tradeops.salary_material_id');

        $income = (float) AccountingEntry::active()
            ->where('type', AccountingEntry::TYPE_INCOME)
            ->sum('amount_try');

        $expenses = (float) AccountingEntry::active()
            ->where('type', AccountingEntry::TYPE_EXPENSE)
            ->where(fn ($q) => $q->whereNull('material_id')->orWhere('material_id', '!=', $salaryMaterialId))
            ->sum('amount_try');

        $salaryExpenses = (float) AccountingEntry::active()
            ->where('type', AccountingEntry::TYPE_EXPENSE)
            ->where('material_id', $salaryMaterialId)
            ->sum('amount_try');

        // Salary rows are weighted by the multiplier (employer cost).
        $salaries = $multiplier * $salaryExpenses;
        $balance = $income - $expenses - $salaries;

        $entries = AccountingEntry::active()
            ->with(['material:id,name', 'company:id,name', 'project:id,name'])
            ->orderByDesc('recorded_on')
            ->orderByDesc('id')
            ->paginate((int) config('tradeops.accounting_per_page', 50))
            ->withQueryString();

        return view('admin.accounting.index', [
            'entries' => $entries,
            'balance' => $balance,
            'turnover' => $salaries + $balance,
            'salaryMultiplier' => $multiplier,
            ...self::selectLists(),
        ]);
    }

    public function store(AccountingEntryRequest $request): RedirectResponse
    {
        $data = $this->payload($request->validated(), now()->toDateString());

        AccountingEntry::create($data);

        return redirect()->route('accounting.index')->with('status', 'Muhasebe kaydı eklendi.');
    }

    public function update(AccountingEntryRequest $request, AccountingEntry $entry): RedirectResponse
    {
        $entry->update($this->payload($request->validated(), $entry->recorded_on->toDateString()));

        return back()->with('status', 'Kayıt güncellendi.');
    }

    public function destroy(AccountingEntry $entry): RedirectResponse
    {
        $entry->softDeleteFlag();

        return back()->with('status', 'Kayıt silindi.');
    }

    public function saveSalaryMultiplier(Request $request): RedirectResponse
    {
        $input = str_replace(',', '.', (string) $request->input('salary_multiplier', self::DEFAULT_SALARY_MULTIPLIER));
        $multiplier = is_numeric($input) ? (float) $input : self::DEFAULT_SALARY_MULTIPLIER;

        if ($multiplier <= 0) {
            $multiplier = self::DEFAULT_SALARY_MULTIPLIER;
        }

        $request->session()->put('salary_multiplier', $multiplier);

        $page = $request->query('page');

        return redirect()->route('accounting.index', is_numeric($page) ? ['page' => (int) $page] : []);
    }

    public static function salaryMultiplier(): float
    {
        $value = session('salary_multiplier');

        return is_numeric($value) && (float) $value > 0
            ? (float) $value
            : self::DEFAULT_SALARY_MULTIPLIER;
    }

    /**
     * Option lists used by the accounting entry forms.
     *
     * @return array{materials: Collection, companies: Collection, projects: Collection}
     */
    public static function selectLists(): array
    {
        return [
            'materials' => Material::active()->orderBy('name')->get(['id', 'name']),
            'companies' => Company::active()->orderBy('name')->get(['id', 'name']),
            'projects' => Project::active()->orderBy('name')->get(['id', 'name']),
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function payload(array $data, string $defaultDate): array
    {
        $data['recorded_on'] = $data['recorded_on'] ?? $defaultDate;
        $data['amount_try'] = (int) round((float) $data['amount_try']);

        // USD value at the TCMB rate for the entry date.
        $rate = $this->rates->getUsdRate($data['recorded_on']);
        $data['amount_usd'] = $rate ? round($data['amount_try'] / $rate, 2) : 0;

        $data['is_deleted'] = false;

        return $data;
    }
}
