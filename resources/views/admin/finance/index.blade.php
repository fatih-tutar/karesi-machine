@extends('admin.layouts.admin')

@section('title', 'Bakiye ve Malzeme Analizi')

@push('head')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container { width:95%; margin:auto; background:white; padding:20px; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.1); margin-bottom:40px; }
        .range-buttons, .currency-buttons { text-align:center; margin-bottom:18px; }
        .range-buttons a, .currency-buttons a { padding:7px 15px; text-decoration:none; background:#ddd; margin:0 5px; border-radius:5px; color:black; font-weight:600; display:inline-block; }
        .currency-buttons a.active { background:#007bff !important; color:white !important; }
        .range-buttons a.active { background:#cd1f21 !important; color:white !important; }
        .tabs { display:flex; justify-content:center; margin-bottom:20px; }
        .tabs button { border:none; padding:10px 20px; font-weight:600; background:#ddd; cursor:pointer; margin:0 5px; border-radius:6px; }
        .tabs button.active { background:#0d6efd; color:white; }
        .tab-content { display:none; }
        .tab-content.active { display:block; }
    </style>
@endpush

@section('content')
<div class="tabs">
    <button class="tab-btn active" data-tab="balance">📈 Bakiye Grafiği</button>
    <button class="tab-btn" data-tab="products">📊 Malzeme Analizi</button>
</div>

<div id="balance" class="tab-content active">
    <div class="chart-container">
        <div class="currency-buttons">
            <a href="{{ route('finance.index', ['currency' => 'try', 'range' => $range]) }}" class="{{ $currency == 'try' ? 'active' : '' }}">TRY</a>
            <a href="{{ route('finance.index', ['currency' => 'usd', 'range' => $range]) }}" class="{{ $currency == 'usd' ? 'active' : '' }}">USD</a>
        </div>
        <div class="range-buttons">
            @foreach (['1y' => '1 Yıl', '3y' => '3 Yıl', '5y' => '5 Yıl', 'all' => 'Tümü'] as $key => $label)
                <a href="{{ route('finance.index', ['currency' => $currency, 'range' => $key]) }}" class="{{ $range == $key ? 'active' : '' }}">{{ $label }}</a>
            @endforeach
        </div>
        <canvas id="financeChart" height="110"></canvas>
    </div>
</div>

<div id="products" class="tab-content">
    <div class="chart-container">
        <canvas id="productCompareChart" height="110"></canvas>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.tab-btn').forEach(function (btn) {
        btn.onclick = function () {
            document.querySelectorAll('.tab-btn').forEach(function (b) { b.classList.remove('active'); });
            document.querySelectorAll('.tab-content').forEach(function (c) { c.classList.remove('active'); });
            btn.classList.add('active');
            document.getElementById(btn.dataset.tab).classList.add('active');
        };
    });

    new Chart(document.getElementById('financeChart'), {
        data: {
            labels: {!! json_encode($months) !!},
            datasets: [
                { type: 'line', label: 'Bakiye', data: {!! json_encode($balanceData) !!}, borderColor: '#007bff', backgroundColor: 'rgba(0,123,255,0.15)', tension: 0.25, fill: true, yAxisID: 'y' },
                { type: 'bar', label: 'Aylık Gelir', data: {!! json_encode($incomeData) !!}, backgroundColor: 'rgba(40,167,69,0.6)', yAxisID: 'y1' },
                { type: 'bar', label: 'Aylık Kâr', data: {!! json_encode($profitData) !!}, backgroundColor: 'rgba(255,193,7,0.7)', yAxisID: 'y1' }
            ]
        },
        options: {
            responsive: true,
            interaction: { mode: 'index', intersect: false },
            scales: {
                y: { type: 'linear', position: 'left', beginAtZero: true },
                y1: { type: 'linear', position: 'right', beginAtZero: true, grid: { drawOnChartArea: false } }
            }
        }
    });

    new Chart(document.getElementById('productCompareChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($projectLabels, JSON_UNESCAPED_UNICODE) !!},
            datasets: {!! json_encode($productDatasets, JSON_UNESCAPED_UNICODE) !!}
        }
    });
</script>
@endpush
