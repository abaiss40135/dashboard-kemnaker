<?php

namespace Database\Seeders;

use App\Helpers\ApiHelper;
use App\Models\User;
use Illuminate\Database\Seeder;

class NormalizePersonelDataBhabinkamtibmasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $query = User::hasNrp()->isBhabinkamtibmas()->doesntHave('personel');
        $this->command->getOutput()->progressStart($query->count());
        $query->chunk(10, function ($users){
            foreach ($users as $user){
                $personel = ApiHelper::getPersonelSingkatByNrp($user->nrp);
                if (!empty($personel)) {
                    $user->personel()->updateOrCreate([
                        'personel_id' => $personel['personel_id'],
                    ], [
                        'nama' => $personel['nama'],
                        'pangkat' => $personel['pangkat'],
                        'jabatan' => $personel['jabatan'],
                        'keterangan_tambahan' => $personel['keterangan_tambahan'],
                        'tmt_jabatan' => $personel['tmt_jabatan'],
                        'lama_jabatan' => $personel['lama_jabatan'],
                        'satuan' => $personel['satuan'],
                        'handphone' => $personel['handphone'],
                        'jenis_kelamin' => $personel['jenis_kelamin'],
                        'tanggal_lahir' => $personel['tanggal_lahir'],
                        'email' => $personel['email'],
                        'satuan1' => $personel['satuan1'],
                        'satuan2' => $personel['satuan2'],
                        'satuan3' => $personel['satuan3'],
                        'satuan4' => $personel['satuan4'],
                        'satuan5' => $personel['satuan5'],
                        'satuan6' => $personel['satuan6'],
                        'satuan7' => $personel['satuan7'],
                    ]);
                }
                sleep(10);
            }
            $this->command->getOutput()->progressAdvance(10);
        });
        $this->command->getOutput()->progressFinish();
    }
}
