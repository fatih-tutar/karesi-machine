{{-- Shared accounting entry form fields. Vars: $entry (nullable), $materials, $companies, $projects, $withDate --}}
@php $entry = $entry ?? null; @endphp
<div class="mb-1"><b>Kayıt Tipi</b></div>
<div class="mb-1">
    <select name="type" class="form-control form-control-sm mb-1">
        <option value="0" @selected($entry && $entry->type == 0)>Gider</option>
        <option value="1" @selected($entry && $entry->type == 1)>Gelir</option>
    </select>
</div>
<div class="mb-1"><b>Malzeme</b></div>
<div class="mb-1">
    <select name="material_id" class="form-control form-control-sm mb-1">
        <option value="0">Malzeme Seçiniz</option>
        @foreach ($materials as $material)
            <option value="{{ $material->id }}" @selected($entry && $entry->material_id == $material->id)>{{ $material->name }}</option>
        @endforeach
    </select>
</div>
<div class="mb-1"><b>Türk Lirası</b></div>
<div class="mb-1">
    <input type="text" name="amount_try" class="form-control form-control-sm mb-1" placeholder="Türk lirası" value="{{ $entry?->amount_try }}" required>
</div>
@if ($entry)
    <div class="mb-1"><b>Dolar</b> <small class="text-muted">(TCMB kuruyla otomatik hesaplanır)</small></div>
    <div class="mb-1">
        <input type="text" class="form-control form-control-sm mb-1" value="{{ $entry->amount_usd }}" readonly disabled>
    </div>
@endif
<div class="mb-1"><b>Firma</b></div>
<div class="mb-1">
    <select name="company_id" class="form-control form-control-sm mb-1">
        <option value="0">Firma Seçiniz</option>
        @foreach ($companies as $company)
            <option value="{{ $company->id }}" @selected($entry && $entry->company_id == $company->id)>{{ $company->name }}</option>
        @endforeach
    </select>
</div>
<div class="mb-1"><b>Proje</b></div>
<div class="mb-1">
    <select name="project_id" class="form-control form-control-sm mb-1">
        <option value="0">Proje Seçiniz</option>
        @foreach ($projects as $project)
            <option value="{{ $project->id }}" @selected($entry && $entry->project_id == $project->id)>{{ $project->name }}</option>
        @endforeach
    </select>
</div>
<div class="mb-1"><b>Bilgi</b></div>
<div class="mb-1">
    <input type="text" name="note" class="form-control form-control-sm mb-1" placeholder="Kayıt bilgisi" value="{{ $entry?->note }}">
</div>
<div class="mb-1"><b>Açıklama</b></div>
<div class="mb-1">
    <input type="text" name="description" class="form-control form-control-sm mb-1" placeholder="Açıklama" value="{{ $entry?->description }}">
</div>
@if ($entry)
    <div class="mb-1"><b>Tarih</b></div>
    <div class="mb-1">
        <input type="date" name="recorded_on" class="form-control form-control-sm" value="{{ $entry->recorded_on->format('Y-m-d') }}" required>
    </div>
@endif
