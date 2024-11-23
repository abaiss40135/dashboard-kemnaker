<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Permission: Hak akses ke suatu modul
         * Level     : Memudahkan pencarian role berdasarkan hierarki jabatan
         * Alias     : Nama lain dari nama role.
         */
        $permission_map = [
            'm' => 'menu',
            'a' => 'access',
            'c' => 'create',
            'e' => 'edit',
            's' => 'show',
            'd' => 'destroy',
            'app' => 'approve',
            'dec' => 'decline',
        ];

        $role_structure = [
            "administrator" => [
                "id"    => User::ADMIN,
                "alias" => "Administrator",
                "level" => 10,
                "permission" => [
                    "dashboard"                         => "a,s",
                    "dashboard_map"                     => "a",
                    "dashboard_trending_keyword"        => "a,c,e,s,d",
                    "dashboard_situasi_kamtibmas"        => "a,c,e,s,d",
                    "atensi_pimpinan"                   => "m",
                    "atensi_pimpinan_bhabinkamtibmas"   => "a,c,e,s,d",
                    "atensi_pimpinan_satpam"            => "a,c,e,s,d",
                    "atensi_pimpinan_publik"            => "a,c,e,s,d",
                    "berita"                            => "a,c,e,s,d",
                    "pusat_informasi"                   => "m",
                    "jukrah"                            => "a,c,e,s,d",
                    "master_bhabin"                     => "a",
                    "master_bhabin_chart"               => "a,s",
                    "both"                              => "a",
                    "terobosan_kreatif"                 => "a",
                    "manajemen_bujp_satpam"             => "m",
                    "master_bujp"                       => "a,e,d",
                    "master_satpam"                     => "a,e,s,d",
                    "chart_laporan_bhabinkamtibmas"     => "a",
                    "manajemen_publik"                  => "a",
                    "foto_bhabinkamtibmas"              => "m,a,c,e,d",
                    "pengelolaan_akun"                  => "m,a,c,e,s,d",
                    "sio"                               => "a,e,s,d",
                    "sislap"                            => "m",
                    "lapbul"                            => "a,c,e,s,d",
                    "lapsubjar"                         => "a,c,e,s,d",
                    "nonlapbul"                         => "a,c,e,s,d",
                    "pemanfaatan_informasi"             => "a",
                    "register_polsus"                   => "c",
                    "sipolsus"                          => "a,c",
                    "binpolmas"                          => "a,c",
                    "bujp_ticketing"                    => "a,e,d",
                    "dashboard_lokasi_bhabinkamtibmas"  => "a",
                    'dashboard_pemungutan_capres_2024' => 'a',
                ],
            ],
            'operator_konten' => [
                'id' => User::OPERATOR_KONTEN,
                'alias' => 'Operator Back Office',
                'level' => 5,
                'permission' => [
                    'pusat_informasi' => 'm',
                    'both' => 'a',
                    'terobosan_kreatif' => 'a',
                    'berita' => 'a,c,e,s,d',
                    'jukrah' => 'a,c,e,s,d',
                    'foto_bhabinkamtibmas' => 'm,a,c,e,d',
                    'master_bhabin' => 'a',
                    'master_bhabin_chart' => 'a,s',
                    'pemanfaatan_informasi' => 'a',
                    'dashboard_lokasi_bhabinkamtibmas' => 'a',
                ],
            ],
            "operator_mabes" => [
                "id"    => User::OPERATOR_MABES,
                "level" => 5,
                "alias" => "Operator Mabes Pengelola SIO BUJP Level II",
                "permission" => [
                    "manajemen_bujp_satpam"             => "m",
                    "sio"                               => "a,e,s",
                    "master_bujp"                       => "a,e,d",
                    "master_satpam"                     => "a,e,s,d",
                    "pemanfaatan_informasi"             => "a",
                    "bujp_ticketing"                    => "a,e",
                    "dashboard_lokasi_bhabinkamtibmas"  => "a",
                    "laporan_semester_bujp"             => "a,app,dec",
                ],
            ],
            'operator_polda' => [
                'id' => User::OPERATOR_POLDA,
                'level' => 4,
                'alias' => 'Operator Polda Pengelola SIO BUJP',
                'permission' => [
                    'manajemen_bujp_satpam' => 'm',
                    'master_bujp' => 'a,e,d',
                    'master_satpam' => 'a,e,s,d',
                    'sio' => 'a,e,s',
                    'penjadwalan_audit' => 'c',
                ],
            ],
            'bhabinkamtibmas' => [
                'id' => User::BHABIN,
                'level' => 1,
                'alias' => 'Bhabinkamtibmas',
                'permission' => [
                    'lokasi_penugasan' => 'a,c,e,s,d',
                ],
            ],
            'bujp' => [
                'id' => User::BUJP,
                'level' => 1,
                'alias' => 'Badan Usaha Jasa Pengamanan',
                'permission' => [],
            ],
            'satpam' => [
                'id' => User::SATPAM,
                'level' => 1,
                'alias' => 'Satpam',
                'permission' => [],
            ],
            'publik' => [
                'id' => User::PUBLIK,
                'level' => 1,
                'alias' => 'Pengguna Publik',
                'permission' => [
                    'laporan_publik' => 'a,c,e,s,d',
                ],
            ],
            "pimpinan_polri" => [
                "id"    => User::PIMPINAN_POLRI,
                "level" => 5,
                "alias" => "Pimpinan Polri",
                "permission" => [
                    "dashboard"                         => "a,s",
                    "dashboard_map"                     => "a",
                    "atensi_pimpinan"                   => "m",
                    "atensi_pimpinan_bhabinkamtibmas"   => "a,c,e,s,d",
                    "atensi_pimpinan_satpam"            => "a,c,e,s,d",
                    "atensi_pimpinan_publik"            => "a,c,e,s,d",
                    "berita"                            => "a,c,e,s,d",
                    "pusat_informasi"                   => "m",
                    "jukrah"                            => "a,c,e,s,d",
                    "master_bhabin"                     => "a",
                    "master_bhabin_chart"               => "a,s",
                    "both"                              => "a",
                    "terobosan_kreatif"                 => "a",
                    "manajemen_bujp_satpam"             => "m",
                    "master_bujp"                       => "a",
                    "master_satpam"                     => "a",
                    "chart_laporan_bhabinkamtibmas"     => "a",
                    "manajemen_publik"                  => "a",
                    "sislap"                            => "m",
                    "lapbul"                            => "a",
                    "lapsubjar"                         => "a",
                    "nonlapbul"                         => "a",
                    "sipolsus"                          => "a,c",
                    "binpolmas"                          => "a,c",
                    "dashboard_lokasi_bhabinkamtibmas"  => "a",
                ],
            ],
            'bhabinkamtibmas_pensiun' => [
                'id' => User::BHABINKAMTIBMAS_PENSIUN,
                'level' => 1,
                'alias' => 'Bhabinkamtibmas Pensiun',
                'permission' => [],
            ],
            "operator_divhumas" => [
                "id"    => User::OPERATOR_DIVHUMAS,
                "level" => 5,
                "alias" => "Operator Divhumas",
                "permission" => [
                    "both"                              => "a",
                    "terobosan_kreatif"                 => "a"
                ]
            ],
            "operator_bhabinkamtibmas_polsek" => [
                "id"    => User::OPERATOR_BHABINKAMTIBMAS_POLSEK,
                "level" => 2,
                "alias" => "Operator Polsek Pengelola Bhabinkamtibmas",
                "permission" => [
                    "dashboard"                         => "a,s",
                    "dashboard_situasi_kamtibmas"       => "a,s",
                    "master_bhabin"                     => "a",
                    "chart_laporan_bhabinkamtibmas"     => "a",
                    "pengelolaan_akun"                  => "m,a,c,e",
                ]
            ],
            'operator_bhabinkamtibmas_polda' => [
                'id' => User::OPERATOR_BHABINKAMTIBMAS_POLDA,
                'level' => 4,
                'alias' => 'Operator Polda Pengelola Bhabinkamtibmas',
                'permission' => [
                    'dashboard' => 'a,s',
                    "dashboard_situasi_kamtibmas"       => "a,s",
                    'dashboard_map' => 'a',
                    'master_bhabin' => 'a',
                    'master_bhabin_chart' => 'a',
                    'chart_laporan_bhabinkamtibmas' => 'a',
                    'pengelolaan_akun' => 'm,a,c,e',
                    'both' => 'a',
                    'terobosan_kreatif' => 'a',
                    'manajemen_publik' => 'a',
                    'dashboard_lokasi_bhabinkamtibmas' => 'a',
                ],
            ],
            'operator_bhabinkamtibmas_polres' => [
                'id' => User::OPERATOR_BHABINKAMTIBMAS_POLRES,
                'level' => 3,
                'alias' => 'Operator Polres Pengelola Bhabinkamtibmas',
                'permission' => [
                    'dashboard' => 'a,s',
                    'master_bhabin' => 'a',
                    'chart_laporan_bhabinkamtibmas' => 'a',
                    'pengelolaan_akun' => 'm,a,c,e',
                    'both' => 'a',
                    'terobosan_kreatif' => 'a',
                    'manajemen_publik' => 'a',
                    'dashboard_lokasi_bhabinkamtibmas' => 'a',
                ],
            ],
            'operator_mabes_2' => [
                'id' => User::OPERATOR_MABES_2,
                'level' => 4,
                'alias' => 'Operator Mabes Pengelola SIO BUJP Level I',
                'permission' => [
                    'manajemen_bujp_satpam' => 'm',
                    'sio' => 'a,e,s',
                    'master_bujp' => 'a,e,d',
                    'master_satpam' => 'a,e,s,d',
                    'bujp_ticketing' => 'a,e',
                ],
            ],
            'bhabinkamtibmas_mutasi' => [
                'id' => User::BHABINKAMTIBMAS_MUTASI,
                'level' => 1,
                'alias' => 'Bhabinkamtibmas Mutasi',
                'permission' => [],
            ],
            "operator_binpolmas_polda" => [
                "id"    => User::BINPOLMAS_POLDA,
                "level" => 4,
                "alias" => "Operator Binpolmas Polda",
                "permission"                            => [
                    "dashboard"                         => "a,s",
                    "pengelolaan_akun"                  => "m,a,c,e",
                    "sislap"                            => "m",
                    "lapsubjar"                         => "a,c,e,s,d",
                    "binpolmas"                         => "a,c,e,s,d",
                    "sislap_approval"                   => "c,app,dec"
                ]
            ],
            "operator_binpolmas_polres" => [
                "id"    => User::BINPOLMAS_POLRES,
                "level" => 3,
                "alias" => "Operator Binpolmas Polres",
                "permission" => [
                    "dashboard"                         => "a,s",
                    "sislap"                            => "m",
                    "lapsubjar"                         => "a,c,e,s,d",
                    "binpolmas"                         => "a,c,e,s,d",
                    "sislap_approval"                   => "c"
                ]
            ],
            "polsus" => [
                "id"    => User::POLSUS,
                "level" => 1,
                "alias" => "Polsus",
                "permission" => []
            ],
            'operator_bagopsnalev_mabes' => [
                'id' => User::BAGOPSNALEV_MABES,
                'level' => 5,
                'alias' => 'Operator BagOpsnalev Mabes Polri',
                'permission' => [
                    'sislap' => 'm',
                    'lapbul' => 'a,c,e,s,d',
                    'lapsubjar' => 'a,c,e,s,d',
                    'nonlapbul' => 'a,c,e,s,d',
                    'sislap_approval' => 'c,app,dec',
                    'sipolsus' => 'a,c',
                ],
            ],
            'operator_bagopsnalev_polda' => [
                'id' => User::BAGOPSNALEV_POLDA,
                'level' => 4,
                'alias' => 'Operator BagOpsnalev Polda',
                'permission' => [
                    'sislap' => 'm',
                    'lapbul' => 'a,c,e,s,d',
                    'lapsubjar' => 'a,c,e,s,d',
                    'nonlapbul' => 'a,c,e,s,d',
                    'sislap_approval' => 'c,app,dec',
                ],
            ],
            'operator_bagopsnalev_polres' => [
                'id' => User::BAGOPSNALEV_POLRES,
                'level' => 3,
                'alias' => 'Operator BagOpsnalev Polres',
                'permission' => [
                    'sislap' => 'm',
                    'lapbul' => 'a,c,e,s,d',
                    'lapsubjar' => 'a,c,e,s,d',
                    'nonlapbul' => 'a,c,e,s,d',
                    'sislap_approval' => 'c',
                ],
            ],
            'polsus' => [
                'id' => User::POLSUS,
                'level' => 1,
                'alias' => 'Polsus',
                'permission' => [],
            ],
            'operator_polsus_polda' => [
                'id' => User::OPERATOR_POLSUS_POLDA,
                'level' => 4,
                'alias' => 'Operator Polda Pengelola Polsus',
                'permission' => [
                    'pengelolaan_akun' => 'm,a,e,s,d',
                    'sislap' => 'm',
                    'lapsubjar' => 'a,c,e,s,d',
                    'register_polsus' => 'c',
                    'sipolsus' => 'a,c',
                ],
            ],
            'operator_polsus_kl' => [
                'id' => User::OPERATOR_POLSUS_KL,
                'level' => 4,
                'alias' => 'Operator Polsus K/L Nasional',
                'permission' => [
                    'pengelolaan_akun' => 'm,a,e,s,d',
                    'sislap' => 'm',
                    'lapsubjar' => 'a,c,e,s,d',
                    'register_polsus' => 'c',
                    'sipolsus' => 'a,c',
                ],
            ],
            'operator_polsus_kl_provinsi' => [
                'id' => User::OPERATOR_POLSUS_KL_PROVINSI,
                'level' => 3,
                'alias' => 'Operator Polsus K/L Provinsi',
                'permission' => [
                    'pengelolaan_akun' => 'm,a,e,s,d',
                    'sislap' => 'm',
                    'lapsubjar' => 'a,c,e,s,d',
                    'register_polsus' => 'c',
                    'sipolsus' => 'a,c',
                ],
            ],
            'operator_polsus_kl_kota_kabupaten' => [
                'id' => User::OPERATOR_POLSUS_KL_KOTA_KABUPATEN,
                'level' => 2,
                'alias' => 'Operator Polsus K/L Kota Kabupaten',
                'permission' => [
                    'pengelolaan_akun' => 'm,a,e,s,d',
                    'sislap' => 'm',
                    'lapsubjar' => 'a,c,e,s,d',
                    'register_polsus' => 'c',
                    'sipolsus' => 'a,c',
                ],
            ],
            'polisi_rw' => [
                'id' => User::POLISI_RW,
                'level' => 1,
                'alias' => 'Polisi RW',
                'permission' => [
                    'lokasi_penugasan' => 'a,c,e,s,d',
                ],
            ],
        ];

        Permission::truncate();

        foreach ($role_structure as $roleName => $role) {
            $roleModel = Role::firstOrCreate(
                ['id' => $role['id']],
                [
                    'name' => $roleName,
                    'alias' => $role['alias'],
                    'level' => $role['level'],
                ]
            );
            $permissionId = [];
            foreach ($role['permission'] as $module => $permission) {
                $arrayPermission = explode(',', $permission);
                foreach ($arrayPermission as $key) {
                    $name = $module.'_'.$permission_map[$key];
                    $permission = Permission::firstOrCreate(['name' => $name]);
                    $permissionId[] = $permission->id;
                }
            }
            $roleModel->permissions()->sync($permissionId);
        }
    }
}
