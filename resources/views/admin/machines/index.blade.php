@extends('admin.layouts.admin')

@section('title', 'Makineler')

@push('head')
    <style>
        .thumb { width: 60px; height: 40px; object-fit: cover; object-position: center; border-radius: 6px; display: block; }
    </style>
@endpush

@php
    $fields = [
        ['video_url', 'Video (YouTube embed linki)', 'video_url'],
        ['speed', 'Makine Hızı', 'speed'],
        ['weight_info', 'Gram', 'weight_info'],
        ['length', 'Uzunluk', 'length'],
        ['width', 'Genişlik', 'width'],
        ['height', 'Yükseklik', 'height'],
    ];
@endphp

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Makineler</h2>
        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addMachineModal">Yeni Makine Ekle</button>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="table-secondary">
            <tr>
                <th>#</th>
                <th>Resim</th>
                <th>Makine Adı</th>
                <th>Hız</th>
                <th>Gram</th>
                <th>Sıra</th>
                <th>İşlemler</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($machines as $key => $m)
                @php $firstImage = trim(explode(',', (string) $m->image)[0]); @endphp
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>
                        @if ($firstImage !== '')
                            <img src="{{ asset('img/'.$firstImage) }}" width="60" class="thumb rounded" alt="">
                        @endif
                    </td>
                    <td>{{ $m->name }}</td>
                    <td>{{ $m->speed }}</td>
                    <td>{{ $m->weight_info }}</td>
                    <td>{{ $m->sort_order }}</td>
                    <td>
                        <i class="bi bi-pencil-square text-primary cursor-pointer me-3" data-bs-toggle="modal" data-bs-target="#editModal{{ $m->id }}"></i>
                        <i class="bi bi-trash text-danger cursor-pointer" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $m->id }}"></i>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@foreach ($machines as $m)
    <div class="modal fade" id="editModal{{ $m->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="{{ route('machines.update', $m) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Makine Düzenle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label>Makine Adı</label>
                        <input type="text" name="name" class="form-control form-control-sm" value="{{ $m->name }}" required>
                        <label>Sıralama</label>
                        <input type="number" min="0" name="sort_order" class="form-control form-control-sm" value="{{ $m->sort_order }}">
                        @foreach ($fields as [$name, $label, $attr])
                            <label>{{ $label }}</label>
                            <input type="text" name="{{ $name }}" class="form-control form-control-sm" value="{{ $m->{$attr} }}">
                        @endforeach
                        @if ($m->image)
                            <label>Mevcut Resimler</label>
                            <div class="small text-muted">{{ $m->image }}</div>
                        @endif
                        <label>Yeni Resim Ekle (İsteğe Bağlı)</label>
                        <input type="file" name="image" accept="image/*" class="form-control form-control-sm">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Kaydet</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="deleteModal{{ $m->id }}" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('machines.destroy', $m) }}">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Makine Sil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">Bu makineyi silmek istediğinize emin misiniz?</div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Evet, Sil</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endforeach

<div class="modal fade" id="addMachineModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('machines.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Yeni Makine Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label>Makine Adı</label>
                    <input type="text" name="name" class="form-control form-control-sm" required>
                    @foreach ($fields as [$name, $label, $attr])
                        <label>{{ $label }}</label>
                        <input type="text" name="{{ $name }}" class="form-control form-control-sm">
                    @endforeach
                    <label>Resim</label>
                    <input type="file" name="image" accept="image/*" class="form-control form-control-sm">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Kaydet</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
