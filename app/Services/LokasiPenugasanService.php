<?php


namespace App\Services;


use App\Helpers\Constants;
use App\Repositories\Abstracts\DesaRepositoryAbstract;
use App\Repositories\Abstracts\LokasiPenugasanRepositoryAbstract;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class LokasiPenugasanService implements Interfaces\LokasiPenugasanServiceInterface
{
    protected $lokasiPenugasanRepository;
    protected $desaRepository;

    /**
     * LokasiPenugasanService constructor.
     * @param LokasiPenugasanRepositoryAbstract $lokasiPenugasanRepository
     */
    public function __construct(LokasiPenugasanRepositoryAbstract $lokasiPenugasanRepository, DesaRepositoryAbstract $desaRepository)
    {
        $this->lokasiPenugasanRepository = $lokasiPenugasanRepository;
        $this->desaRepository = $desaRepository;
    }

    public function get(array $request, array $columns = ['*'])
    {
        return $this->lokasiPenugasanRepository->getFilterWithAllData($request, $columns);
    }

    public function store(array $data)
    {
        if(is_array($data['jenis_lokasi'])){
            $lokasi = [];
            foreach ($data['jenis_lokasi'] as $key => $jenis_lokasi) {
                $desaId = $data['desa_id'][$key] ?? null;

                if ($desaId == 'lainnya'){
                    $desaId = $this->saveNewDesa($data['kecamatan_id'][$key], $data['desa_lainnya'][$key])->code;
                }
                $data = [
                    'user_id' => auth()->user()->id,
                    'jenis_lokasi' => $jenis_lokasi,
                    'province_code' => $data['provinsi_id'][$key],
                    'city_code' => $data['kota_id'][$key] ?? null,
                    'district_code' => $data['kecamatan_id'][$key] ?? null,
                    'village_code' => $desaId,
                    'kawasan' => $data['kawasan'][$key] ?? null
                ];

                if (auth()->user()->polda === 'POLDA METRO JAYA'&& $jenis_lokasi === 'kawasan'){
                    $data['province_code'] = Constants::idMetroJaya;
                }
                $lokasi[] = $this->lokasiPenugasanRepository->create($data);
            }
        } else {
            $lokasi = $this->lokasiPenugasanRepository->create($this->mapFormData($data));
        }
        return $lokasi;
    }

    public function show($id)
    {
        $lokasi = $this->lokasiPenugasanRepository->find($id);
        $lokasi->provinsi = $lokasi->provinsi;
        $lokasi->kota = $lokasi->kota;
        $lokasi->kecamatan = $lokasi->kecamatan;
        $lokasi->desa = $lokasi->desa;

        return $lokasi;
    }

    public function update(array $data, $id)
    {
        if(is_array($data['jenis_lokasi'])){
            $lokasi = [];
            foreach ($data['jenis_lokasi'] as $key => $jenis_lokasi) {
                $desaId = $data['desa_id'][$key] ?? null;

                if ($desaId == 'lainnya'){
                    $desaId = $this->saveNewDesa($data['kecamatan_id'][$key], $data['desa_lainnya'][$key])->code;
                }
                $data = [
                    'user_id' => auth()->user()->id,
                    'jenis_lokasi' => $jenis_lokasi,
                    'city_code' => $data['kota_id'][$key] ?? null,
                    'district_code' => $data['kecamatan_id'][$key] ?? null,
                    'village_code' => $desaId,
                    'kawasan' => $data['kawasan'][$key] ?? null
                ];
                if (auth()->user()->polda !== 'POLDA METRO JAYA'&& $jenis_lokasi === 'kawasan'){
                    $data = array_merge($data, [
                        'province_code' => $data['provinsi_id'][$key],
                    ]);
                }
                $lokasi[] = $this->lokasiPenugasanRepository->update($data, $id);
            }
        } else {
            $lokasi = $this->lokasiPenugasanRepository->update($this->mapFormData($data), $id);
        }
        Cache::delete('bhabinkamtibmasLokasiById'.$id);
        return $lokasi;
    }

    public function delete($id)
    {
        return $this->lokasiPenugasanRepository->delete($id);
    }

    public function getDatatable()
    {
        $query = $this->lokasiPenugasanRepository->getFilterWithQuery(request()->all());
        return DataTables::eloquent($query)
            ->addColumn('action', function ($collection) {
                $button = '<button data-id="' . $collection->id . '" class="btn btn-sm m-1 btn-warning btn-edit"><i class="far fa-edit"></i></button>';
                $button .= '<button href="#" data-id="' . $collection->id . '" class="btn btn-sm m-1 btn-danger btn-delete"><i class="far fa-trash-alt"></i></button>';
                return $button;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    private function saveNewDesa($district_code, $name)
    {
        return $this->desaRepository->create([
            'district_code' => $district_code,
            'name' => strtoupper($name)
        ]);
    }

    private function mapFormData(array $data)
    {
        $village_code = $data['village_code'];
        if ($data['village_code'] == 'lainnya'){
            $village_code = $this->saveNewDesa($data['district_code'], $data['desa_lainnya'])->code;
        }
        $formData = [
            'user_id' => auth()->user()->id,
            'jenis_lokasi' => $data['jenis_lokasi'],
            'province_code' => $data['province_code'] ?? null,
            'city_code' => $data['city_code'] ?? null
        ];

        if ($data['jenis_lokasi'] == 'kawasan'){
            $formData['kawasan'] = $data['kawasan'];
            if (auth()->user()->personel->polda === 'POLDA METRO JAYA'){
                $formData['province_code'] = Constants::idMetroJaya;
            }
        } else {
            $formData['district_code'] = $data['district_code'];
            $formData['village_code']  = $village_code;
        }
        return $formData;
    }
}
