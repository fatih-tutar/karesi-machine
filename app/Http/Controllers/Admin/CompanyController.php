<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountingEntry;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function index(): View
    {
        $companies = Company::active()
            ->withCount(['accountingEntries as total_operations' => fn ($q) => $q->where('is_deleted', false)])
            ->withSum(['accountingEntries as total_try' => fn ($q) => $q->where('is_deleted', false)], 'amount_try')
            ->withSum(['accountingEntries as total_usd' => fn ($q) => $q->where('is_deleted', false)], 'amount_usd')
            ->orderBy('name')
            ->get();

        return view('admin.companies.index', ['companies' => $companies]);
    }

    public function show(Company $company): View
    {
        abort_if($company->is_deleted, 404);

        $entries = AccountingEntry::active()
            ->where('company_id', $company->id)
            ->with(['material:id,name', 'project:id,name'])
            ->orderByDesc('recorded_on')
            ->orderByDesc('id')
            ->get();

        return view('admin.companies.show', [
            'company' => $company,
            'entries' => $entries,
            'total' => $entries->sum('amount_try'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:255']]);

        Company::create([
            'name' => $data['name'],
            'recorded_on' => now()->toDateString(),
            'is_deleted' => false,
        ]);

        return redirect()->route('companies.index')->with('status', 'Firma eklendi.');
    }

    public function update(Request $request, Company $company): RedirectResponse
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:255']]);

        $company->update(['name' => $data['name']]);

        return redirect()->route('companies.index')->with('status', 'Firma güncellendi.');
    }

    public function destroy(Company $company): RedirectResponse
    {
        $company->softDeleteFlag();

        return redirect()->route('companies.index')->with('status', 'Firma silindi.');
    }
}
