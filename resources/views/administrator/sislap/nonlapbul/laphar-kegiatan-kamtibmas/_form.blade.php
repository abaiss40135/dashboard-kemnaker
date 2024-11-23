@if(roles(['operator_bagopsnalev_polda']))
<div class="form-group">
    <label for="polresInput">Polres <small>(Hanya menampilkan pilihan polres yang belum lapor)</small></label>
    <input list="listPolres" name="polres" class="form-control" id="polresInput" placeholder="Pilih polres" autocomplete="off" autofocus>
    <datalist id="listPolres">

    </datalist>
</div>
@endif
<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="text-center">
            <th>No</th>
            <th>Kegiatan</th>
            <th>Jumlah</th>
        </thead>
        <tbody>
            @foreach($kegiatans as $list_kegiatan_id => $kegiatan)
            <tr>
                <td class="align-middle text-center">{{ $loop->iteration }}</td>
                <td class="align-middle">{{ $kegiatan }}</td>
                <td class="align-middle">
                    <input aria-label="jumlah kegiatan"
                        min="0"
                        type="number"
                        name="kegiatan[{{ $list_kegiatan_id }}][jumlah]"
                        class="form-control"
                        placeholder="0"
                        value="{{ isset($laporan) ? old('kegiatan.'. $list_kegiatan_id . '.jumlah', $laporan->kegiatans->where('pivot.list_kegiatan_id', $list_kegiatan_id)->first()->pivot->jumlah) : old('kegiatan.'. $list_kegiatan_id . '.jumlah', 0) }}"
                        required>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@push('scripts')
<script>
    document.getElementById('polresInput')?.addEventListener('onfocus', getListPolres());

    function getListPolres() {
        axios.post("{{ $route_list ?? '' }}" || route('approval-laporan.list-polres'), {
            date: "{{  date('Y-m-d') }}",
            model: 'App\\Models\\Sislap\\Nonlapbul\\KegiatanCegahTindakPidanaKamtibmas\\LapharKegiatanKamtibmas'
        })
        .then((response) => response.data)
        .then((data) => {
            Object.entries(data.status_lapor).filter(([key, value]) => !value.status).forEach(([key, value]) => {
                $('#listPolres').append(`<option value="${value.nama_satuan}"`);
            });
        });
    }
</script>
@endpush
