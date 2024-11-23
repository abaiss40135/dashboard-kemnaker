<?php

namespace Database\Seeders;

use App\Helpers\CsvtoArray;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SatuanSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();
        $csv = new CsvtoArray();
        $header = ['satuan_id', 'nama_satuan', 'kode_satuan'];
        $data_polres = $csv->csv_to_array(__DIR__.'/../../resources/csv/satuan-polres.csv', $header);
        $data_polda = $csv->csv_to_array(__DIR__.'/../../resources/csv/satuan-polda.csv', $header);

        array_shift($data_polres); // skip first row
        array_shift($data_polda); // skip first row
        $data = array_map(function ($arr) use ($now) {
            return $arr + ['created_at' => $now, 'updated_at' => $now];
        }, array_merge($data_polres, $data_polda));

        DB::transaction(function () use ($data) {
            DB::table('sipp_satuan')->truncate();
            DB::table('sipp_satuan')->insert($data);
        });
    }
}
