<?php

namespace Database\Seeders;

use App\Models\Unity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Unity::factory(20)->create();
    }
}
