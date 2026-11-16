@extends('admin.layouts.admin')

@section('title', 'Malzemeler')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Malzemeler</h2>
        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addMaterialModal">Yeni Malzeme Ekle</button>
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="table-secondary">
            <tr>
                <th>#</th>
                <th>Malzeme Adı</th>
                <th>Toplam İşlem</th>
                <th>Toplam TL</th>
                <th>Toplam USD</th>
                <th>İşlemler</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($materials as $key => $material)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td><a href="{{ route('materials.show', $material) }}">{{ $material->name }}</a></td>
                    <td>{{ $material->total_operations ?? 0 }}</td>
                    <td>₺{{ number_format((float) $material->total_try, 2, ',', '.') }}</td>
                    <td>${{ number_format((float) $material->total_usd, 2, ',', '.') }}</td>
                    <td>
                        <i class="bi bi-pencil-square text-primary cursor-pointer me-3" data-bs-toggle="modal" data-bs-target="#editModal{{ $material->id }}"></i>
                        <i class="bi bi-trash text-danger cursor-pointer" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $material->id }}"></i>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@foreach ($materials as $material)
    <div class="modal fade" id="editModal{{ $material->id }}" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('materials.update', $material) }}">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Malzemeyi Düzenle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label>Malzeme Adı</label>
                            <input type="text" name="name" class="form-control form-control-sm" value="{{ $material->name }}" required>
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="include_in_reports" value="1" id="includeInReports{{ $material->id }}" @checked($material->include_in_reports)>
                            <label class="form-check-label" for="includeInReports{{ $material->id }}">Maliyet Grafiğinde Göster</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Kaydet</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="deleteModal{{ $material->id }}" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('materials.destroy', $material) }}">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Malzemeyi Sil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>{{ $material->name }}</strong> adlı malzemeyi silmek istediğinize emin misiniz?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Evet, Sil</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endforeach

<div class="modal fade" id="addMaterialModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('materials.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Yeni Malzeme Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label>Malzeme Adı</label>
                        <input type="text" name="name" class="form-control form-control-sm" placeholder="Malzeme adı" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Ekle</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
