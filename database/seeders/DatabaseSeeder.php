<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Http\Controllers\RiwayatPendidikanController;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            GolonganSeeder::class,
            JenisKenaikanPangkatSeeder::class,
            UnitKerjaSeeder::class,
            ProvinsiSeeder::class,
            KabupatenKotaSeeder::class,
            KecamatanSeeder::class,
            KelurahanSeeder::class,
            PegawaiSeeder::class,
            UserLoginSeeder::class,
            // UserSeeder::class,
            PendidikanSeeder::class,
            JabatanFungsionalSeeder::class,
            JabatanStrukturalSeeder::class,
            RiwayatKepegawaianSeeder::class,
            UserLoginSeeder::class,
            ProgramSeeder::class,
            KegiatanSeeder::class,
            MasterSubKegiatanSeeder::class,
        ]);
    }
}
