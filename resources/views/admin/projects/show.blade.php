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

<div class="table-responsive">
    <table class="table table-striped">
        <thead class="table-secondary">
        <tr>
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

@foreach ($entries as $entry)
    @include('admin.partials.entry-modals', ['entry' => $entry])
@endforeach
@endsection
