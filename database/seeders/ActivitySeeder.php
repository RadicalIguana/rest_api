<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Уровень 0
        $food = Activity::create(['name' => 'Еда', 'parent_id' => null, 'level' => 0]);
        $cars = Activity::create(['name' => 'Автомобили', 'parent_id' => null, 'level' => 0]);

        // Уровень 1 под "Еда"
        $meat = Activity::create(['name' => 'Мясная продукция', 'parent_id' => $food->id, 'level' => 1]);
        $dairy = Activity::create(['name' => 'Молочная продукция', 'parent_id' => $food->id, 'level' => 1]);

        // Уровень 1 под "Автомобили"
        $cargo = Activity::create(['name' => 'Грузовые', 'parent_id' => $cars->id, 'level' => 1]);
        $passenger = Activity::create(['name' => 'Легковые', 'parent_id' => $cars->id, 'level' => 1]);

        // Уровень 2 под "Легковые"
        $spare_parts = Activity::create(['name' => 'Запчасти', 'parent_id' => $passenger->id, 'level' => 2]);
        $accessories = Activity::create(['name' => 'Аксессуары', 'parent_id' => $passenger->id, 'level' => 2]);
    }
}
