<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TaskStatus;

class TaskStatusSeeder extends Seeder
{
    public function run()
    {
        // Определяем начальные значения статусов
        $statuses = [
            ['name' => 'новый'],
            ['name' => 'в работе'],
            ['name' => 'на тестировании'],
            ['name' => 'завершен'],
        ];
        // Вставляем статусы в базу данных, если они еще не существуют
        foreach ($statuses as $status) {
            TaskStatus::firstOrCreate(['name' => $status['name']]);
        }
    }
}