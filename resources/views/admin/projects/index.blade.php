@extends('admin.layouts.admin')

@section('title', 'Projeler')

@push('head')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .project-name { font-weight: 500; text-decoration: none; }
        .project-name.sold { color: #2e7d32; }
        .project-name.not-sold { color: #9e9e9e; }
    </style>
@endpush

@section('content')
<div class="container-fluid mt-3">
    <div class="d-flex justify-content-between mb-3">
        <h2>Projeler</h2>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#projectProfitChartModal">
                <i class="bi bi-bar-chart-line-fill"></i> Grafik
            </button>
            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addProjectModal">Yeni Proje Ekle</button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="table-secondary">
            <tr>
                <th>#</th>
                <th>Proje Adı</th>
                <th>Maliyet</th>
                <th>Maliyet $</th>
                <th>Satış</th>
                <th>Satış $</th>
                <th>Kâr TL</th>
                <th>Kâr USD</th>
                <th>Kâr Yüzde</th>
                <th>Tarih</th>
                <th class="text-center">İşlemler</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($rows as $key => $row)
                @php $project = $row->project; @endphp
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>
                        <a href="{{ route('projects.show', $project) }}" class="project-name {{ $project->is_sold ? 'sold' : 'not-sold' }}">{{ $project->name }}</a>
                    </td>
                    <td>{{ number_format($row->outgoing, 0, ',', '.') }} TL</td>
                    <td>${{ number_format($row->outgoing_usd, 0, ',', '.') }}</td>
                    <td>{{ number_format($row->incoming, 0, ',', '.') }} TL</td>
                    <td>${{ number_format($row->incoming_usd, 0, ',', '.') }}</td>
                    <td>{{ number_format($row->profit, 0, ',', '.') }} TL</td>
                    <td>${{ number_format($row->profit_usd, 0, ',', '.') }}</td>
                    <td>{{ $row->profit_percent === null ? '-' : '%'.round($row->profit_percent) }}</td>
                    <td>{{ $project->recorded_on->format('d/m/Y') }}</td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <i class="bi bi-pencil-square text-primary cursor-pointer" data-bs-toggle="modal" data-bs-target="#editModal{{ $project->id }}"></i>
                            <i class="bi bi-trash text-danger cursor-pointer" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $project->id }}"></i>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@foreach ($rows as $row)
    @php $project = $row->project; @endphp
    <div class="modal fade" id="editModal{{ $project->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('projects.update', $project) }}">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Proje Düzenle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label>Proje Adı</label>
                        <input type="text" class="form-control form-control-sm" name="name" value="{{ $project->name }}" required>

                        <label>Tarih</label>
                        <input type="date" name="recorded_on" class="form-control form-control-sm" value="{{ $project->recorded_on->format('Y-m-d') }}" required>

                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="include_in_reports" value="1" id="includeInReports{{ $project->id }}" @checked($project->include_in_reports)>
                            <label class="form-check-label" for="includeInReports{{ $project->id }}">Maliyet Grafiğinde Göster</label>
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="show_in_profit_chart" value="1" id="showInProfitChart{{ $project->id }}" @checked($project->show_in_profit_chart)>
                            <label class="form-check-label" for="showInProfitChart{{ $project->id }}">Proje Kâr Grafiğinde Göster</label>
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="is_sold" value="1" id="isSold{{ $project->id }}" @checked($project->is_sold)>
                            <label class="form-check-label" for="isSold{{ $project->id }}">Satıldı</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Kaydet</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="deleteModal{{ $project->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('projects.destroy', $project) }}">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Proje Sil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">Bu projeyi silmek istediğinize emin misiniz?</div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Evet, Sil</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endforeach

<!-- Add project -->
<div class="modal fade" id="addProjectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('projects.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Yeni Proje Ekle</h5>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label>Proje Adı</label>
                    <input type="text" name="name" class="form-control form-control-sm" placeholder="Proje Adı" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Kaydet</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Profit chart -->
<div class="modal fade" id="projectProfitChartModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Proje Bazlı Kâr Yüzdesi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @if (empty($profitChartLabels))
                    <div class="alert alert-warning mb-0">
                        Grafikte gösterilecek proje yok. Düzenleme formundan "Proje Kâr Grafiğinde Göster" alanını işaretleyebilirsiniz.
                    </div>
                @else
                    <div style="min-height:420px;"><canvas id="projectProfitChart"></canvas></div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        const chartLabels = {!! json_encode($profitChartLabels, JSON_UNESCAPED_UNICODE) !!};
        const chartValues = {!! json_encode($profitChartValues) !!};
        const chartCanvas = document.getElementById('projectProfitChart');
        const chartModal = document.getElementById('projectProfitChartModal');
        let chart = null;
        if (!chartCanvas || !chartModal || !chartLabels.length) return;
        chartModal.addEventListener('shown.bs.modal', function () {
            if (chart) return;
            chart = new Chart(chartCanvas, {
                type: 'bar',
                data: { labels: chartLabels, datasets: [{ label: 'Kâr Yüzdesi (%)', data: chartValues, borderWidth: 1 }] },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: true } },
                    scales: { y: { title: { display: true, text: 'Yüzde (%)' } } }
                }
            });
        });
    })();
</script>
@endpush
