@extends('admin.layouts.admin')

@section('title', 'Muhasebe')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <!-- Desktop add button -->
    <button id="openPopup" class="btn btn-danger d-none d-md-block" data-bs-toggle="modal" data-bs-target="#addModal">
        Muhasebe Kaydı Ekle
    </button>
    <div class="d-flex align-items-center gap-2 gap-md-3 flex-wrap justify-content-end">
        <form method="POST" action="{{ route('accounting.salary-multiplier', request()->has('page') ? ['page' => request('page')] : []) }}" class="d-flex align-items-center gap-2">
            @csrf
            <label for="salary_multiplier" class="small fw-bold text-muted mb-0">Çarpan</label>
            <input id="salary_multiplier" name="salary_multiplier" type="number" step="0.01" min="0.01"
                   class="form-control form-control-sm" style="width: 95px;"
                   value="{{ number_format($salaryMultiplier, 2, '.', '') }}">
            <button type="submit" class="btn btn-sm btn-outline-secondary">Kaydet</button>
        </form>
        <div class="p-2 bg-success text-white rounded">
            <strong>Bakiye:</strong> ₺{{ number_format($balance, 2, ',', '.') }}
        </div>
        <div class="p-2 bg-primary text-white rounded">
            <strong>Ciro:</strong> ₺{{ number_format($turnover, 2, ',', '.') }}
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Muhasebe Kaydı Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('accounting.store') }}">
                    @csrf
                    @include('admin.partials.entry-fields', ['entry' => null])
                    <div class="text-end mt-2">
                        <button type="submit" class="btn btn-danger">Kaydet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Transactions -->
<div class="table-responsive">
    <table class="table table-striped">
        <thead class="table-secondary">
        <tr>
            <th>Bilgi / Malzeme</th>
            <th>TL</th>
            <th>USD</th>
            <th>Açıklama</th>
            <th>Tip</th>
            <th>Firma</th>
            <th>Proje</th>
            <th>Tarih</th>
            <th>İşlemler</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($entries as $entry)
            <tr class="{{ $entry->type == 1 ? 'income-row' : '' }}">
                <td>
                    @if ($entry->material)
                        <a href="{{ route('materials.show', $entry->material) }}">{{ $entry->material->name }}</a>
                    @else
                        {{ $entry->note }}
                    @endif
                </td>
                <td>₺{{ number_format($entry->amount_try, 0, ',', '.') }}</td>
                <td>${{ number_format((float) $entry->amount_usd, 2, ',', '.') }}</td>
                <td>{{ $entry->description }}</td>
                <td>{{ $entry->type == 1 ? 'Gelir' : 'Gider' }}</td>
                <td>
                    @if ($entry->company)
                        <a href="{{ route('companies.show', $entry->company) }}">{{ $entry->company->name }}</a>
                    @endif
                </td>
                <td>
                    @if ($entry->project)
                        <a href="{{ route('projects.show', $entry->project) }}">{{ $entry->project->name }}</a>
                    @endif
                </td>
                <td>{{ $entry->recorded_on->format('d/m/Y') }}</td>
                <td>@include('admin.partials.entry-actions', ['entry' => $entry])</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@foreach ($entries as $entry)
    @include('admin.partials.entry-modals', ['entry' => $entry])
@endforeach

<!-- Pagination -->
@if ($entries->hasPages())
    <nav class="d-flex justify-content-center">
        {{ $entries->links() }}
    </nav>
@endif

<!-- Mobile floating + button -->
<button id="fabAdd" class="fab-add d-md-none" data-bs-toggle="modal" data-bs-target="#addModal">
    <i class="bi bi-plus-lg"></i>
</button>
@endsection
