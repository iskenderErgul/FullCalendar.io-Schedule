<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Week;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WeekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('weeks')->insert([
            'start_date' => now(),
            'end_date' => now()->addDays(6), // 1 hafta boyunca
            'week' => 'Örnek Hafta 1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
