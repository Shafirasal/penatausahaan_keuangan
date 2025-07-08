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
            UserSeeder::class,
            PendidikanSeeder::class,
            RiwayatKepegawaianSeeder::class,
            JabatanFungsionalSeeder::class,
            JabatanStrukturalSeeder::class,
        ]);
    }
}
