<?php

namespace Database\Seeders;

use App\Models\Keyword;
use Illuminate\Database\Seeder;

class NormalizeJumlahKeyword extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $keywords = Keyword::get();
        foreach ($keywords as $keyword) {
            $keyword->update(['jumlah' => $keyword->laporanInformasis()->count()]);
        }
    }
}
