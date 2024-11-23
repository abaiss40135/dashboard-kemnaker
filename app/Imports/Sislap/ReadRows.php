<?php

namespace App\Imports\Sislap;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ReadRows implements ToCollection
{
    public function collection(Collection $rows)
    {
        return $rows;
    }
}
