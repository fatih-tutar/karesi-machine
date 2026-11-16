@extends('admin.layouts.admin')

@section('title', 'Firmalar')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Firmalar</h2>
        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addCompanyModal">Yeni Firma Ekle</button>
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="table-secondary">
            <tr>
                <th>#</th>
                <th>Firma Adı</th>
                <th>Toplam İşlem</th>
                <th>Toplam TL</th>
                <th>Toplam USD</th>
                <th>İşlemler</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($companies as $key => $company)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td><a href="{{ route('companies.show', $company) }}">{{ $company->name }}</a></td>
                    <td>{{ $company->total_operations ?? 0 }}</td>
                    <td>₺{{ number_format((float) $company->total_try, 2, ',', '.') }}</td>
                    <td>${{ number_format((float) $company->total_usd, 2, ',', '.') }}</td>
                    <td>
                        <i class="bi bi-pencil-square text-primary cursor-pointer me-3" data-bs-toggle="modal" data-bs-target="#editModal{{ $company->id }}"></i>
                        <i class="bi bi-trash text-danger cursor-pointer" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $company->id }}"></i>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@foreach ($companies as $company)
    <div class="modal fade" id="editModal{{ $company->id }}" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('companies.update', $company) }}">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Firmayı Düzenle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label>Firma Adı</label>
                            <input type="text" name="name" class="form-control form-control-sm" value="{{ $company->name }}" required>
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
    <div class="modal fade" id="deleteModal{{ $company->id }}" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('companies.destroy', $company) }}">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Firmayı Sil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">Bu firmayı silmek istediğinize emin misiniz?</div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Evet, Sil</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endforeach

<div class="modal fade" id="addCompanyModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('companies.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Yeni Firma Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label>Firma Adı</label>
                        <input type="text" name="name" class="form-control form-control-sm" placeholder="Firma adı" required>
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
