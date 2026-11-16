<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountingEntry;
use App\Models\Material;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class FinanceController extends Controller
{
    public function index(Request $request): View
    {
        $range = in_array($request->query('range'), ['1y', '3y', '5y', 'all'], true)
            ? $request->query('range')
            : 'all';
        $currency = $request->query('currency') === 'usd' ? 'usd' : 'try';
        $amountField = $currency === 'usd' ? 'amount_usd' : 'amount_try';

        $startDate = match ($range) {
            '1y' => Carbon::today()->subYear()->toDateString(),
            '3y' => Carbon::today()->subYears(3)->toDateString(),
            '5y' => Carbon::today()->subYears(5)->toDateString(),
            default => null,
        };

        // Legacy finance charts leave salary-material expenses out of the balance entirely.
        $salaryMaterialId = (int) config('tradeops.salary_material_id');
        $isCounted = fn ($item) => $item->type == AccountingEntry::TYPE_INCOME
            || (int) $item->material_id !== $salaryMaterialId;

        // 1) Opening balance
        $balanceStart = 0.0;

        if ($startDate) {
            $previous = AccountingEntry::active()
                ->where('recorded_on', '<', $startDate)
                ->get(['type', 'material_id', $amountField.' as amount']);

            foreach ($previous as $p) {
                if ($p->type == AccountingEntry::TYPE_INCOME) {
                    $balanceStart += (float) $p->amount;
                } elseif ($isCounted($p)) {
                    $balanceStart -= (float) $p->amount;
                }
            }
        }

        // 2) Filtered rows
        $rows = AccountingEntry::active()
            ->when($startDate, fn ($q) => $q->where('recorded_on', '>=', $startDate))
            ->orderBy('recorded_on')
            ->orderBy('id')
            ->get(['recorded_on', 'type', 'material_id', $amountField.' as amount']);

        // 3) Monthly close + income
        $balance = $balanceStart;
        $monthlyBalance = [];
        $monthlyIncome = [];
        $monthlyExpense = [];

        foreach ($rows as $item) {
            $key = $item->recorded_on->format('Y-m');
            $monthlyIncome[$key] ??= 0;
            $monthlyExpense[$key] ??= 0;

            if ($item->type == AccountingEntry::TYPE_INCOME) {
                $balance += (float) $item->amount;
                $monthlyIncome[$key] += (float) $item->amount;
            } elseif ($isCounted($item)) {
                $balance -= (float) $item->amount;
                $monthlyExpense[$key] += (float) $item->amount;
            }

            $monthlyBalance[$key] = round($balance, 2);
        }

        $months = array_keys($monthlyBalance);
        $incomeData = array_map(fn ($m) => round($monthlyIncome[$m] ?? 0, 2), $months);
        $profitData = array_map(fn ($m) => round(($monthlyIncome[$m] ?? 0) - ($monthlyExpense[$m] ?? 0), 2), $months);

        return view('admin.finance.index', [
            'range' => $range,
            'currency' => $currency,
            'months' => $months,
            'balanceData' => array_values($monthlyBalance),
            'incomeData' => $incomeData,
            'profitData' => $profitData,
            ...$this->materialAnalysis(),
        ]);
    }

    /**
     * Bottom chart: share (%) of each report material in each report project's expenses.
     *
     * @return array{projectLabels: list<string>, productDatasets: list<array<string, mixed>>}
     */
    private function materialAnalysis(): array
    {
        $materials = Material::query()->where('include_in_reports', true)->pluck('name', 'id');
        $projects = Project::query()->where('include_in_reports', true)->pluck('name', 'id');

        $productRows = AccountingEntry::active()
            ->where('type', AccountingEntry::TYPE_EXPENSE)
            ->whereIn('material_id', $materials->keys())
            ->whereIn('project_id', $projects->keys())
            ->selectRaw('project_id, material_id, SUM(amount_try) AS product_try')
            ->groupBy('project_id', 'material_id')
            ->get();

        $projectTotals = AccountingEntry::active()
            ->where('type', AccountingEntry::TYPE_EXPENSE)
            ->whereIn('project_id', $projects->keys())
            ->selectRaw('project_id, SUM(amount_try) AS total_try')
            ->groupBy('project_id')
            ->pluck('total_try', 'project_id');

        $chartData = [];
        foreach ($productRows as $r) {
            if (! isset($projectTotals[$r->project_id]) || $projectTotals[$r->project_id] <= 0) {
                continue;
            }
            $chartData[$r->material_id][$r->project_id] = round(($r->product_try / $projectTotals[$r->project_id]) * 100, 2);
        }

        $projectLabels = [];
        foreach ($projectTotals->keys() as $projectId) {
            $projectLabels[$projectId] = $projects[$projectId] ?? '-';
        }

        $datasets = [];
        foreach ($chartData as $materialId => $perProject) {
            $datasets[] = [
                'label' => $materials[$materialId] ?? 'Malzeme',
                'data' => array_map(fn ($pid) => $perProject[$pid] ?? 0, array_keys($projectLabels)),
                'tension' => 0.3,
                'fill' => false,
            ];
        }

        return [
            'projectLabels' => array_values($projectLabels),
            'productDatasets' => $datasets,
        ];
    }
}
