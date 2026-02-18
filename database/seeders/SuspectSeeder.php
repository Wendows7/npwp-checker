<?php

namespace Database\Seeders;

use App\Models\Suspect;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuspectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            Suspect::factory(20)->create();
    }
}
