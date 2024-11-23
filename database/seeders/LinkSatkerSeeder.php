<?php

namespace Database\Seeders;

use App\Models\Link;
use Illuminate\Database\Seeder;

class LinkSatkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $linkSatker = [
            [
                'nama_satker' => 'Kepolisian Negara RI',
                'link_satker' => 'https://polri.go.id'
            ],
            [
                'nama_satker' => 'Lembaga Pendidikan Polri',
                'link_satker' => 'http://lemdik.polri.go.id/'
            ],
            [
                'nama_satker' => 'Divisi Humas Polri',
                'link_satker' => 'https://humas.polri.go.id/'
            ],
            [
                'nama_satker' => 'Divisi Propam Polri',
                'link_satker' => 'http://propam.polri.go.id/pol/'
            ],
            [
                'nama_satker' => 'Korps Lalu Lintas Polri',
                'link_satker' => 'https://korlantas.polri.go.id/'
            ],
            [
                'nama_satker' => 'Puslitbang Polri',
                'link_satker' => 'http://puslitbang.polri.go.id/'
            ],
            [
                'nama_satker' => 'Pusat Keuangan Polri',
                'link_satker' => 'http://puskeu.polri.go.id/'
            ],
            [
                'nama_satker' => 'NCB-Interpol Indonesia',
                'link_satker' => 'http://interpol.go.id/'
            ],
            [
                'nama_satker' => 'Direktorat Polisi Air Polri',
                'link_satker' => 'http://polair.polri.go.id/'
            ],
            [
                'nama_satker' => 'Museum Polri',
                'link_satker' => 'https://museumpolri.org/'
            ],
            [
                'nama_satker' => 'Direktorat Tindak Pidana Siber (Dittipidsiber)',
                'link_satker' => 'https://patrolisiber.id/home'
            ],
            [
                'nama_satker' => 'Perguruan Tinggi Ilmu Kepolisian (PTIK)',
                'link_satker' => 'https://ptik.lemdiklat.polri.go.id/'
            ],
            [
                'nama_satker' => 'Pencarian Anti Hoax',
                'link_satker' => 'https://search.turnbackhoax.id/'
            ],
        ];

        foreach($linkSatker as $data){
            Link::updateOrCreate([
                'nama_satker' => $data['nama_satker']
            ], [
                'link_satker' => $data['link_satker']
            ]);
        }
    }
}
