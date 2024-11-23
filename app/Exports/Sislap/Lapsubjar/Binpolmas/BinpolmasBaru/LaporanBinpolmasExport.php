<?php

namespace App\Exports\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru;

use App\Models\Personel;
use App\Models\Provinsi;
use App\Services\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru\DataFkpmKawasanService;
use App\Services\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru\DataFkpmWilayahService;
use App\Services\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru\DataKomunitasMasyarakatService;
use App\Services\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru\DataOrsosmasService;
use App\Services\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru\DataPranataService;
use App\Services\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru\PembinaPolmasService;
use App\Services\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru\PetugasPolmasService;
use App\Services\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru\SupervisorPolmasService;
use App\Services\Sislap\Lapsubjar\Binpolmas\KegiatanPetugasPolmasService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class LaporanBinpolmasExport implements FromView, ShouldAutoSize, WithStrictNullComparison
{
    use Exportable;

    private $path = 'excel.template-laporan.rekapitulasi-data-laporan-binpolmas';

    public function __construct()
    {

    }

    public function view(): View
    {
        $satuan = request()->get('satuan');
        $start_date = request()->get('start_date');
        $end_date = request()->get('end_date');

        $collection = null;

        if($satuan === 'Mabes Polri') {
            $collection = $this->nationalAccumulation($start_date, $end_date);
        } else {
            $collection = $this->regionalAccumulation($start_date, $end_date);
        }

        return view($this->path, [
            'type' => $satuan === 'Mabes Polri' ? 'nasional' : 'regional',
            'collection' => $collection,
        ]);
    }

    private function nationalAccumulation($start_date, $end_date)
    {
        $collection = [];
        foreach(Provinsi::orderBy('code')->get() as $provinsi) {
            if($provinsi->polda === '' || $provinsi->polda === null) {
                continue;
            }

            request()->merge(['search' => 'POLDA ' . $provinsi->polda]);
            $collection['POLDA ' . $provinsi->polda]['data_komunitas_masyarakat'] = (new DataKomunitasMasyarakatService())->exportWithCount(request());

            $collection['POLDA ' . $provinsi->polda]['data_fkpm_kawasan'] = (new DataFkpmKawasanService())->exportWithCount(request());
            $collection['POLDA ' . $provinsi->polda]['data_fkpm_wilayah'] = (new DataFkpmWilayahService())->exportWithCount(request());
            $collection['POLDA ' . $provinsi->polda]['data_pranata'] = (new DataPranataService())->exportWithCount(request());
            $collection['POLDA ' . $provinsi->polda]['data_orsosmas'] = (new DataOrsosmasService())->exportWithCount(request());
            $collection['POLDA ' . $provinsi->polda]['data_komunitas_masyarakat'] = (new DataKomunitasMasyarakatService())->exportWithCount(request());
            $collection['POLDA ' . $provinsi->polda]['petugas_polmas_wilayah'] = (new PetugasPolmasService('wilayah'))->ExportWithTotalCount(request(), 'jumlah_petugas_wilayah');
            $collection['POLDA ' . $provinsi->polda]['petugas_polmas_kawasan'] = (new PetugasPolmasService('kawasan'))->ExportWithTotalCount(request(), 'jumlah_petugas_kawasan');
            $collection['POLDA ' . $provinsi->polda]['supervisor_polmas'] = (new SupervisorPolmasService())->exportWithCount(request());
            $collection['POLDA ' . $provinsi->polda]['pembina_polmas'] = (new PembinaPolmasService())->exportWithCount(request());
            $collection['POLDA ' . $provinsi->polda]['kegiatan_polmas_sambang'] = (new KegiatanPetugasPolmasService('sambang'))->ExportWithTotalCount(request(), 'sambang');
            $collection['POLDA ' . $provinsi->polda]['kegiatan_polmas_pemecahan_masalah'] = (new KegiatanPetugasPolmasService('pemecahan_masalah'))->ExportWithTotalCount(request(), 'pemecahan_masalah');
            $collection['POLDA ' . $provinsi->polda]['kegiatan_polmas_laporan_informasi'] = (new KegiatanPetugasPolmasService('laporan_informasi'))->ExportWithTotalCount(request(), 'laporan_informasi');
            $collection['POLDA ' . $provinsi->polda]['kegiatan_polmas_penanganan_perkara_ringan'] = (new KegiatanPetugasPolmasService('penanganan_perkara_ringan'))->ExportWithTotalCount(request(), 'penanganan_perkara_ringan');
        }

        return $collection;
    }

    private function regionalAccumulation($start_date, $end_date)
    {
        $kode_satuan = explode('-', Personel::firstWhere('satuan1', 'ilike', '%' . request()->get('satuan') . '%')->satuan1)[1];
        $polres_list = \App\Helpers\ApiHelper::getChildSatuanByKodeSatuan($kode_satuan, true);

        $collection = [];
        foreach($polres_list as $code => $data) {
            request()->merge(['search' => $data['nama_satuan']]);

            $collection[$data['nama_satuan']]['data_fkpm_kawasan'] = (new DataFkpmKawasanService())->exportWithCount(request());
            $collection[$data['nama_satuan']]['data_fkpm_wilayah'] = (new DataFkpmWilayahService())->exportWithCount(request());
            $collection[$data['nama_satuan']]['data_pranata'] = (new DataPranataService())->exportWithCount(request());
            $collection[$data['nama_satuan']]['data_orsosmas'] = (new DataOrsosmasService())->exportWithCount(request());
            $collection[$data['nama_satuan']]['data_komunitas_masyarakat'] = (new DataKomunitasMasyarakatService())->exportWithCount(request());
            $collection[$data['nama_satuan']]['petugas_polmas_wilayah'] = (new PetugasPolmasService('wilayah'))->exportWithTotalCount(request(), 'jumlah_petugas_wilayah');
            $collection[$data['nama_satuan']]['petugas_polmas_kawasan'] = (new PetugasPolmasService('kawasan'))->exportWithTotalCount(request(), 'jumlah_petugas_kawasan');
            $collection[$data['nama_satuan']]['supervisor_polmas'] = (new SupervisorPolmasService('total_count'))->exportWithTotalCount(request(), 'total');
            $collection[$data['nama_satuan']]['pembina_polmas'] = (new PembinaPolmasService())->exportWithTotalCount(request(), 'total');
            $collection[$data['nama_satuan']]['kegiatan_polmas_sambang'] = (new KegiatanPetugasPolmasService('sambang'))->ExportWithTotalCount(request(), 'sambang');
            $collection[$data['nama_satuan']]['kegiatan_polmas_pemecahan_masalah'] = (new KegiatanPetugasPolmasService('pemecahan_masalah'))->ExportWithTotalCount(request(), 'pemecahan_masalah');
            $collection[$data['nama_satuan']]['kegiatan_polmas_laporan_informasi'] = (new KegiatanPetugasPolmasService('laporan_informasi'))->ExportWithTotalCount(request(), 'laporan_informasi');
            $collection[$data['nama_satuan']]['kegiatan_polmas_penanganan_perkara_ringan'] = (new KegiatanPetugasPolmasService('penanganan_perkara_ringan'))->ExportWithTotalCount(request(), 'penanganan_perkara_ringan');
        }

        return $collection;
    }
}
