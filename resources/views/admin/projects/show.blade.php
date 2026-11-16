@extends('admin.layouts.admin')

@section('title', $project->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h2 class="m-0">{{ $project->name }}</h2>
    <div class="d-flex gap-2 align-items-center flex-wrap">
        <div class="card text-bg-danger p-2" style="min-width: 95px; font-size:12px;">
            <div class="text-center"><div style="font-weight:bold; font-size:14px;">📦 Maliyet: {{ number_format($outgoing, 0, ',', '.') }} TL</div></div>
        </div>
        <div class="card text-bg-success p-2" style="min-width: 95px; font-size:12px;">
            <div class="text-center"><div style="font-weight:bold; font-size:14px;">💰 Satış: {{ number_format($incoming, 0, ',', '.') }} TL</div></div>
        </div>
        <div class="card text-bg-primary p-2" style="min-width: 95px; font-size:12px;">
            <div class="text-center">
                <div style="font-weight:bold; font-size:14px;">
                    💹 Kâr: {{ number_format($incoming - $outgoing, 0, ',', '.') }} TL
                    @if ($profitPercent !== null)(%{{ round($profitPercent) }})@endif
                </div>
            </div>
        </div>
        <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary btn-sm">← Tüm Projeler</a>
    </div>
</div>

@include('admin.partials.flash')

@if ($entries->isNotEmpty())
<form method="POST" action="{{ route('projects.entries.reassign', $project) }}" id="bulkReassignForm">
    @csrf
    <div class="d-flex flex-wrap align-items-center gap-2 mb-3 p-2 border rounded bg-light">
        <span class="small text-muted me-1">Seçilen kayıtları taşı:</span>
        <select name="target_project_id" class="form-select form-select-sm" style="max-width: 280px;" required>
            <option value="">Hedef proje seçin</option>
            @foreach ($otherProjects as $other)
                <option value="{{ $other->id }}" @selected((string) old('target_project_id') === (string) $other->id)>{{ $other->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-sm btn-primary" id="bulkReassignBtn" disabled>
            Projeye taşı
        </button>
        <span class="small text-muted" id="bulkSelectedCount">0 seçili</span>
        @error('entry_ids')
            <div class="w-100 text-danger small">{{ $message }}</div>
        @enderror
        @error('target_project_id')
            <div class="w-100 text-danger small">{{ $message }}</div>
        @enderror
        @if ($otherProjects->isEmpty())
            <div class="w-100 text-muted small">Taşımak için başka aktif proje yok.</div>
        @endif
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="table-secondary">
            <tr>
                <th style="width:2.5rem;">
                    <input type="checkbox" class="form-check-input" id="selectAllEntries" title="Tümünü seç" @disabled($otherProjects->isEmpty())>
                </th>
                <th>TL</th>
                <th>USD</th>
                <th>Yüzde</th>
                <th>Tarih</th>
                <th>Malzeme</th>
                <th>Açıklama</th>
                <th>Firma</th>
                <th class="text-center">İşlemler</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($entries as $entry)
                <tr class="{{ $entry->type == 1 ? 'income-row' : '' }}">
                    <td>
                        <input
                            type="checkbox"
                            class="form-check-input entry-select"
                            name="entry_ids[]"
                            value="{{ $entry->id }}"
                            @disabled($otherProjects->isEmpty())
                        >
                    </td>
                    <td>₺{{ number_format($entry->amount_try, 0, ',', '.') }}</td>
                    <td>${{ number_format((float) $entry->amount_usd, 2, ',', '.') }}</td>
                    <td>
                        @if ($entry->type == 0 && $outgoing > 0)
                            %{{ number_format(($entry->amount_try / $outgoing) * 100, 1, ',', '.') }}
                        @endif
                    </td>
                    <td>{{ $entry->recorded_on->format('d/m/Y') }}</td>
                    <td>
                        @if ($entry->material)
                            <a href="{{ route('materials.show', $entry->material) }}">{{ $entry->material->name }}</a>
                        @else
                            {{ $entry->note }}
                        @endif
                    </td>
                    <td>{{ $entry->description }}</td>
                    <td>@if ($entry->company)<a href="{{ route('companies.show', $entry->company) }}">{{ $entry->company->name }}</a>@endif</td>
                    <td class="text-center"><div class="d-flex justify-content-center gap-2">@include('admin.partials.entry-actions', ['entry' => $entry])</div></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</form>
@else
    <div class="alert alert-light border">Bu projede henüz muhasebe kaydı yok.</div>
@endif

@foreach ($entries as $entry)
    @include('admin.partials.entry-modals', ['entry' => $entry])
@endforeach
@endsection

@push('scripts')
<script>
(() => {
    const form = document.getElementById('bulkReassignForm');
    if (!form) return;

    const selectAll = document.getElementById('selectAllEntries');
    const boxes = () => [...form.querySelectorAll('.entry-select')];
    const btn = document.getElementById('bulkReassignBtn');
    const countEl = document.getElementById('bulkSelectedCount');
    const target = form.querySelector('[name="target_project_id"]');

    function refresh() {
        const selected = boxes().filter((b) => b.checked);
        const total = boxes().length;
        countEl.textContent = selected.length + ' seçili';
        btn.disabled = selected.length === 0 || !target.value;
        if (selectAll) {
            selectAll.checked = total > 0 && selected.length === total;
            selectAll.indeterminate = selected.length > 0 && selected.length < total;
        }
    }

    selectAll?.addEventListener('change', () => {
        boxes().forEach((b) => { b.checked = selectAll.checked; });
        refresh();
    });

    form.addEventListener('change', (e) => {
        if (e.target.classList.contains('entry-select') || e.target === target) refresh();
    });

    form.addEventListener('submit', (e) => {
        const n = boxes().filter((b) => b.checked).length;
        if (n === 0 || !target.value) {
            e.preventDefault();
            return;
        }
        const name = target.options[target.selectedIndex]?.text || 'hedef proje';
        if (!confirm(n + ' kaydı «' + name + '» projesine taşımak istiyor musunuz?')) {
            e.preventDefault();
        }
    });

    refresh();
})();
</script>
@endpush
