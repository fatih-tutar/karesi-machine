<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountingEntry;
use App\Models\Material;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class MaterialController extends Controller
{
    public function index(): View
    {
        $materials = Material::active()
            ->withCount(['accountingEntries as total_operations' => fn ($q) => $q->where('is_deleted', false)])
            ->withSum(['accountingEntries as total_try' => fn ($q) => $q->where('is_deleted', false)], 'amount_try')
            ->withSum(['accountingEntries as total_usd' => fn ($q) => $q->where('is_deleted', false)], 'amount_usd')
            ->orderBy('name')
            ->get();

        return view('admin.materials.index', ['materials' => $materials]);
    }

    public function show(Material $material): View
    {
        abort_if($material->is_deleted, 404);

        $entries = AccountingEntry::active()
            ->where('material_id', $material->id)
            ->with(['company:id,name', 'project:id,name'])
            ->orderByDesc('recorded_on')
            ->orderByDesc('id')
            ->get();

        return view('admin.materials.show', [
            'material' => $material,
            'entries' => $entries,
            'total' => $entries->sum('amount_try'),
            'chart' => $this->shareChart($material, $entries),
            ...AccountingController::selectLists(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:255']]);

        Material::create([
            'name' => $data['name'],
            'recorded_on' => now()->toDateString(),
            'include_in_reports' => false,
            'is_deleted' => false,
        ]);

        return redirect()->route('materials.index')->with('status', 'Malzeme eklendi.');
    }

    public function update(Request $request, Material $material): RedirectResponse
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:255']]);

        $material->update([
            'name' => $data['name'],
            'include_in_reports' => $request->boolean('include_in_reports'),
        ]);

        return redirect()->route('materials.index')->with('status', 'Malzeme güncellendi.');
    }

    public function destroy(Material $material): RedirectResponse
    {
        $material->softDeleteFlag();

        return redirect()->route('materials.index')->with('status', 'Malzeme silindi.');
    }

    /**
     * Cost share of this material inside each project's total expenses (chronological).
     *
     * @param  Collection<int, AccountingEntry>  $entries
     * @return array{labels: list<string>, percentages: list<float>, tooltips: list<array<string, mixed>>}
     */
    private function shareChart(Material $material, $entries): array
    {
        $perProject = [];

        foreach ($entries as $entry) {
            if (! $entry->project_id) {
                continue;
            }

            $perProject[$entry->project_id] ??= [
                'name' => $entry->project?->name ?? '-',
                'product_try' => 0,
                'product_usd' => 0,
                'first_date' => $entry->recorded_on,
            ];

            $perProject[$entry->project_id]['product_try'] += $entry->amount_try;
            $perProject[$entry->project_id]['product_usd'] += (float) $entry->amount_usd;

            if ($entry->recorded_on->lt($perProject[$entry->project_id]['first_date'])) {
                $perProject[$entry->project_id]['first_date'] = $entry->recorded_on;
            }
        }

        uasort($perProject, fn ($a, $b) => $a['first_date'] <=> $b['first_date']);

        $totals = AccountingEntry::active()
            ->where('type', AccountingEntry::TYPE_EXPENSE)
            ->whereIn('project_id', array_keys($perProject))
            ->selectRaw('project_id, SUM(amount_try) AS total_try, SUM(amount_usd) AS total_usd')
            ->groupBy('project_id')
            ->get()
            ->keyBy('project_id');

        $labels = [];
        $percentages = [];
        $tooltips = [];

        foreach ($perProject as $projectId => $p) {
            $sum = $totals->get($projectId);

            if (! $sum || $sum->total_try <= 0) {
                continue;
            }

            $percent = round(($p['product_try'] / $sum->total_try) * 100, 2);

            $labels[] = $p['name'];
            $percentages[] = $percent;
            $tooltips[] = [
                'product_try' => $p['product_try'],
                'product_usd' => round($p['product_usd'], 2),
                'project_try' => (float) $sum->total_try,
                'project_usd' => round((float) $sum->total_usd, 2),
                'percent' => $percent,
                'project_name' => $p['name'],
            ];
        }

        return compact('labels', 'percentages', 'tooltips');
    }
}
