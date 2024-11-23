<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ApplicationStarterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ProvincesSeeder::class);
        $this->call(CitiesSeeder::class);
        $this->call(DistrictsSeeder::class);
        $this->call(VillagesSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(UserRelationSeeder::class);
        $this->call(BujpSeeder::class);
        $this->call(LinkSatkerSeeder::class);
        $this->call(KategoriInformasiSeeder::class);
        /**
         * SISLAP
         */
        $this->call(JenisGiatPascaGempaSeeder::class);
    }
}
