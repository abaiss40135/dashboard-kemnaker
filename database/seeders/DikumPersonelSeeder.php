<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DikumPersonelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\Models\User::with('personel:satuan1')
            ->isBhabinkamtibmas()
            ->has('lokasiPenugasans')
            ->whereDoesntHave('dikumPersonel')
            ->get();

        $num = 1;
        $chunkLen = 10;
        $userLen = $users->count();

        $chunks = $users->chunk($chunkLen);

        $chunks->map(function (&$chunk) use (&$num, $chunkLen, $userLen) {
            echo "Seeding dikum personel " . $num * $chunkLen . " of " . $userLen . "\n";

            $chunk->map(function (&$user) {
		        echo $user->nrp."\n";

                sleep(3);

                try {
                    $response = \App\Helpers\ApiHelper::getPersonelByNrp($user->nrp);
                    $dikum = &$response['data']['dikum'];

                    if (empty($dikum)) return;

                    for ($i = 0; $i < count($dikum); $i++) {
                        \App\Models\DikumPersonel::create([
                            'user_id' => $user->id,
                            'tingkat' => $dikum[$i]['tingkat'],
                            'nama_institusi' => $dikum[$i]['nama_institusi'],
                            'nilai_akhir' => $dikum[$i]['nilai_akhir'],
                            'dinas' => $dikum[$i]['dinas'],
                            'akreditasi' => $dikum[$i]['akreditasi'],
                            'tanggal_mulai' => $dikum[$i]['tanggal_mulai'],
                            'tanggal_lulus' => $dikum[$i]['tanggal_lulus'],
                            'jurusan' => $dikum[$i]['jurusan'],
                            'konsentrasi' => $dikum[$i]['konsentrasi'],
                            'ranking' => $dikum[$i]['ranking'],
                            'surat_kelulusan_nomor' => $dikum[$i]['surat_kelulusan_nomor']
                        ]);
                    }
                } catch (\Exception $ex) {
                    print_r($ex->getMessage());
                }
            });

            $num++;
        });
    }
}
