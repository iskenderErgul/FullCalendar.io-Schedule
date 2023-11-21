<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Week;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $week = Week::create([
            'start_date' => now(),
            'end_date' => now()->addDays(6),
            'week' => 'Sample Week',
        ]);

        // Örnek görevler ekleyelim
        Task::create([
            'day_number' => '1',
            'week_id' => $week->id,
            'title' => 'Sample Task 1',
            'description' => 'Description for Sample Task 1',
            'start_time' => '08:00',
            'end_time' => '09:00'
        ]);

        Task::create([
            'day_number' => '3',
            'week_id' => $week->id,
            'title' => 'Sample Task 2',
            'description' => 'Description for Sample Task 2',
            'start_time' => '08:00',
            'end_time' => '09:00'
        ]);
    }
}
