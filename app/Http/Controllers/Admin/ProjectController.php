<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountingEntry;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $sumFor = fn (int $type) => fn ($q) => $q->where('is_deleted', false)->where('type', $type);

        $projects = Project::active()
            ->withSum(['accountingEntries as incoming' => $sumFor(AccountingEntry::TYPE_INCOME)], 'amount_try')
            ->withSum(['accountingEntries as outgoing' => $sumFor(AccountingEntry::TYPE_EXPENSE)], 'amount_try')
            ->withSum(['accountingEntries as incoming_usd' => $sumFor(AccountingEntry::TYPE_INCOME)], 'amount_usd')
            ->withSum(['accountingEntries as outgoing_usd' => $sumFor(AccountingEntry::TYPE_EXPENSE)], 'amount_usd')
            ->orderByDesc('recorded_on')
            ->orderByDesc('id')
            ->get();

        // Use stored USD amounts from accounting entries — avoid live TCMB calls on list load.
        $rows = $projects->map(function (Project $project) {
            $incoming = (float) $project->incoming;
            $outgoing = (float) $project->outgoing;
            $incomingUsd = (float) $project->incoming_usd;
            $outgoingUsd = (float) $project->outgoing_usd;

            return (object) [
                'project' => $project,
                'incoming' => $incoming,
                'outgoing' => $outgoing,
                'incoming_usd' => $incomingUsd,
                'outgoing_usd' => $outgoingUsd,
                'profit' => $incoming - $outgoing,
                'profit_usd' => $incomingUsd - $outgoingUsd,
                'profit_percent' => $outgoing > 0 ? ($incoming / $outgoing) * 100 : null,
            ];
        });

        // Profit chart: oldest on the left.
        $chartRows = $rows
            ->filter(fn ($r) => $r->project->show_in_profit_chart && $r->outgoing > 0)
            ->reverse()
            ->values();

        return view('admin.projects.index', [
            'rows' => $rows,
            'profitChartLabels' => $chartRows->map(fn ($r) => $r->project->name)->all(),
            'profitChartValues' => $chartRows->map(fn ($r) => round((($r->incoming - $r->outgoing) / $r->outgoing) * 100, 2))->all(),
        ]);
    }

    public function show(Project $project): View
    {
        abort_if($project->is_deleted, 404);

        $entries = AccountingEntry::active()
            ->where('project_id', $project->id)
            ->with(['material:id,name', 'company:id,name'])
            ->orderByDesc('recorded_on')
            ->orderByDesc('id')
            ->get();

        $outgoing = (float) $entries->where('type', AccountingEntry::TYPE_EXPENSE)->sum('amount_try');
        $incoming = (float) $entries->where('type', AccountingEntry::TYPE_INCOME)->sum('amount_try');

        return view('admin.projects.show', [
            'project' => $project,
            'entries' => $entries,
            'outgoing' => $outgoing,
            'incoming' => $incoming,
            'profitPercent' => $outgoing > 0 ? (($incoming - $outgoing) / $outgoing) * 100 : null,
            ...AccountingController::selectLists(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:255']]);

        Project::create([
            'name' => $data['name'],
            'recorded_on' => now()->toDateString(),
            'is_deleted' => false,
        ]);

        return redirect()->route('projects.index')->with('status', 'Proje eklendi.');
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'recorded_on' => ['required', 'date'],
        ]);

        $project->update([
            'name' => $data['name'],
            'recorded_on' => $data['recorded_on'],
            'include_in_reports' => $request->boolean('include_in_reports'),
            'show_in_profit_chart' => $request->boolean('show_in_profit_chart'),
            'is_sold' => $request->boolean('is_sold'),
        ]);

        return redirect()->route('projects.index')->with('status', 'Proje güncellendi.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->softDeleteFlag();

        return redirect()->route('projects.index')->with('status', 'Proje silindi.');
    }
}
