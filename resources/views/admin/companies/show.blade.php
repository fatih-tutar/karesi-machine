@extends('admin.layouts.admin')

@section('title', $company->name)

@section('content')
<div class="d-flex justify-content-between align-items-center">
    <div style="font-weight:bold; font-size:25px;">{{ $company->name }}</div>
    <a href="{{ route('companies.index') }}" class="btn btn-outline-secondary btn-sm">← Tüm Firmalar</a>
</div>
<div class="table-responsive mt-2">
    <table class="table table-striped">
        <thead class="table-secondary">
        <tr>
            <th>TL</th>
            <th>USD</th>
            <th>Tarih</th>
            <th>Malzeme</th>
            <th>Açıklama</th>
            <th>Proje</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($entries as $entry)
            <tr>
                <td>₺{{ number_format($entry->amount_try, 0, ',', '.') }}</td>
                <td>${{ number_format((float) $entry->amount_usd, 2, ',', '.') }}</td>
                <td>{{ $entry->recorded_on->format('d/m/Y') }}</td>
                <td>
                    @if ($entry->material)
                        <a href="{{ route('materials.show', $entry->material) }}">{{ $entry->material->name }}</a>
                    @else
                        {{ $entry->note }}
                    @endif
                </td>
                <td>{{ $entry->description }}</td>
                <td>@if ($entry->project)<a href="{{ route('projects.show', $entry->project) }}">{{ $entry->project->name }}</a>@endif</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<h3 class="text-end">Toplam: {{ number_format($total, 0, ',', '.') }} TL</h3>
@endsection
