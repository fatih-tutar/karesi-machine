{{-- Edit + delete modals for one accounting entry. Vars: $entry, $materials, $companies, $projects --}}
<div class="modal fade" id="editModal{{ $entry->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kaydı Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('accounting.update', $entry) }}">
                    @csrf
                    @method('PUT')
                    @include('admin.partials.entry-fields', ['entry' => $entry])
                    <div class="text-end mt-2">
                        <button type="submit" class="btn btn-success">Güncelle</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal{{ $entry->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kaydı Sil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Bu kaydı silmek istediğinize emin misiniz?</p>
                <form method="POST" action="{{ route('accounting.destroy', $entry) }}">
                    @csrf
                    @method('DELETE')
                    <div class="text-end">
                        <button type="submit" class="btn btn-danger">Evet, Sil</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
