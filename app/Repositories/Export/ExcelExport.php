<?php

namespace App\Repositories\Export;

use App\Models\Satpam;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExcelExport implements FromCollection {
   
    public function collection(){
        return Satpam::all();
   }
}