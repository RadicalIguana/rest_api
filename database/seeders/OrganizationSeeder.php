<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Building;
use App\Models\Organization;
use App\Models\OrganizationPhone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $building1 = Building::where('address', 'г. Москва, ул. Ленина 1, офис 3')->first();
        $building2 = Building::where('address', 'ул. Блюхера, 32/1')->first();
        $building3 = Building::where('address', 'г. Санкт-Петербург, Невский проспект, 100')->first();

        $meatActivity = Activity::where('name', 'Мясная продукция')->first();
        $dairyActivity = Activity::where('name', 'Молочная продукция')->first();
        $cargoActivity = Activity::where('name', 'Грузовые')->first();
        $sparePartsActivity = Activity::where('name', 'Запчасти')->first();

        $org1 = Organization::create([
            'name' => 'ООО "Рога и Копыта"',
            'building_id' => $building1->id,
        ]);

        OrganizationPhone::create(['organization_id' => $org1->id, 'phone' => '2-222-222']);
        OrganizationPhone::create(['organization_id' => $org1->id, 'phone' => '3-333-333']);
        OrganizationPhone::create(['organization_id' => $org1->id, 'phone' => '8-923-666-13-13']);

        $org1->activities()->attach([$meatActivity->id, $dairyActivity->id]);

        $org2 = Organization::create([
            'name' => 'ООО "Грузовики Роста"',
            'building_id' => $building2->id,
        ]);

        OrganizationPhone::create(['organization_id' => $org2->id, 'phone' => '8-800-555-35-35']);
        $org2->activities()->attach([$cargoActivity->id]);

        $org3 = Organization::create([
            'name' => 'ООО "АвтоЗапчасть"',
            'building_id' => $building3->id,
        ]);

        OrganizationPhone::create(['organization_id' => $org3->id, 'phone' => '8-911-123-45-67']);
        $org3->activities()->attach([$sparePartsActivity->id]);

        $org4 = Organization::create([
            'name' => 'ООО "Молочный край"',
            'building_id' => $building1->id,
        ]);

        OrganizationPhone::create(['organization_id' => $org4->id, 'phone' => '8-495-100-20-30']);
        $org4->activities()->attach([$dairyActivity->id]);
    }
}
