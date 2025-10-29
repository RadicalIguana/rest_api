<?php

namespace Database\Seeders;

use App\Models\Building;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Building::create([
            'address'   => 'г. Москва, ул. Ленина 1, офис 3',
            'latitude'  => 55.7558,
            'longitude' => 37.6173,
        ]);

        Building::create([
            'address'   => 'ул. Блюхера, 32/1',
            'latitude'  => 56.8389,
            'longitude' => 60.6057,
        ]);

        Building::create([
            'address'   => 'г. Санкт-Петербург, Невский проспект, 100',
            'latitude'  => 59.9343,
            'longitude' => 30.3351,
        ]);
    }
}
