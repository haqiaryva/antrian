<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Staff;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Staff::create(['name' => 'Petugas A']);
        Staff::create(['name' => 'Petugas B']);
        Staff::create(['name' => 'Petugas C']);
    }
}
