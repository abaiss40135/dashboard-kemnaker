<?php

namespace App\Repositories\Export\MasterSatpam;

use App\Models\Satpam;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExcelSatpam implements FromView
{

    private $provinsi;
    private $words;
    private $bujp_id;

    public function __construct($provinsi, $words, $bujp_id) 
    {   
        $this->provinsi = $provinsi;
        $this->words = $words;
        $this->bujp_id = $bujp_id;
    }

    public function collection()
    {
        $collection = Satpam::leftJoin('bujps', 'bujps.id', '=', 'satpams.bujp_id')
            ->where(function($query) {
                $query->where('satpams.no_kta', 'ilike', '%' . $this->words . '%')
                ->orWhere('satpams.nama', 'ilike', '%' . $this->words . '%')
                ->orWhere('satpams.tempat_tugas', 'ilike', '%' . $this->words . '%')
                ->orWhere('satpams.no_kta', 'ilike', '%' . $this->words . '%')
                ->orWhere('bujps.nama_badan_usaha', 'ilike', '%' . $this->words . '%');
            })->select([
                'satpams.*', 'bujps.nama_badan_usaha'
            ]);

        if ($this->bujp_id) $collection->where('bujps.id', $this->bujp_id);
        if ($this->provinsi) $collection->where('satpams.provinsi', $this->provinsi);

        return $collection->orderBy('satpams.created_at', 'DESC')->get();
    }


    public function view(): View
    {
        return view('excel.satpam', ['satpams' => $this->collection()]);
    }
}
