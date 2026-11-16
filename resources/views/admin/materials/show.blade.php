@extends('admin.layouts.admin')

@section('title', $material->name)

@push('head')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="row align-items-center mb-3">
    <div class="col-8" style="font-weight:bold; font-size:25px;">{{ $material->name }}</div>
    <div class="col-4 text-end">
        <a href="{{ route('materials.index') }}" class="btn btn-outline-secondary btn-sm">← Tüm Malzemeler</a>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#materialChartModal">📊 Grafik</button>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead class="table-secondary">
        <tr>
            <th>TL</th>
            <th>USD</th>
            <th>Tarih</th>
            <th>Açıklama</th>
            <th>Firma</th>
            <th>Proje</th>
            <th>İşlemler</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($entries as $entry)
            <tr>
                <td>₺{{ number_format($entry->amount_try, 0, ',', '.') }}</td>
                <td>${{ number_format((float) $entry->amount_usd, 2, ',', '.') }}</td>
                <td>{{ $entry->recorded_on->format('d/m/Y') }}</td>
                <td>{{ $entry->description }}</td>
                <td>@if ($entry->company)<a href="{{ route('companies.show', $entry->company) }}">{{ $entry->company->name }}</a>@endif</td>
                <td>@if ($entry->project)<a href="{{ route('projects.show', $entry->project) }}">{{ $entry->project->name }}</a>@endif</td>
                <td>@include('admin.partials.entry-actions', ['entry' => $entry])</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@foreach ($entries as $entry)
    @include('admin.partials.entry-modals', ['entry' => $entry])
@endforeach

<div class="row">
    <div class="col-md-12">
        <h3>Toplam: {{ number_format($total, 0, ',', '.') }} TL</h3>
    </div>
</div>

<!-- Chart modal -->
<div class="modal fade" id="materialChartModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $material->name }} – Proje Bazlı Maliyet Grafiği</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @if (empty($chart['labels']))
                    <div class="alert alert-warning mb-0">Grafik için yeterli proje verisi yok.</div>
                @else
                    <canvas id="materialChart" height="120"></canvas>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        const projLabels = {!! json_encode($chart['labels'], JSON_UNESCAPED_UNICODE) !!};
        const projPerc = {!! json_encode($chart['percentages']) !!};
        const projInfo = {!! json_encode($chart['tooltips'], JSON_UNESCAPED_UNICODE) !!};
        const canvas = document.getElementById('materialChart');
        const modalEl = document.getElementById('materialChartModal');
        if (!canvas || !modalEl || !projLabels.length) return;
        let chart = null;
        modalEl.addEventListener('shown.bs.modal', function () {
            if (chart) return;
            chart = new Chart(canvas.getContext('2d'), {
                type: 'line',
                data: {
                    labels: projLabels,
                    datasets: [{
                        label: 'Malzemenin Proje İçindeki Gider Payı (%)',
                        data: projPerc,
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13,110,253,0.2)',
                        borderWidth: 2,
                        tension: 0.25,
                        fill: true,
                        pointRadius: 6,
                        pointHoverRadius: 9
                    }]
                },
                options: {
                    responsive: true,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (ctx) {
                                    const d = projInfo[ctx.dataIndex];
                                    return [
                                        'Proje: ' + d.project_name,
                                        'Malzeme ₺: ₺' + d.product_try.toLocaleString(),
                                        'Malzeme $: $' + d.product_usd.toLocaleString(),
                                        'Proje Gider ₺: ₺' + d.project_try.toLocaleString(),
                                        'Proje Gider $: $' + d.project_usd.toLocaleString(),
                                        'Pay: %' + d.percent
                                    ];
                                }
                            }
                        }
                    },
                    scales: {
                        y: { beginAtZero: true, ticks: { callback: function (v) { return v + '%'; } } }
                    }
                }
            });
        });
    })();
</script>
@endpush
