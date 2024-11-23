<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Problem_solving;
use App\Dds_warga;
use App\Deteksi_dini;
use App\Link;
use App\Paparan;
use App\User;

class ExampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'nama' => 'bujp',
                'bujp' => 1,
                'password' => Hash::make('bujp')
            ], [
                'nama' => 'bhabin',
                'password' => Hash::make('bhabin')
            ], [
                'nama' => 'admin',
                'administrator' => 1,
                'password' => Hash::make('admin')
            ],

        ];

        foreach($user as $key => $value){
            User::create($value);
        }
    }
}
