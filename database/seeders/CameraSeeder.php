<?php

namespace Database\Seeders;

use App\Models\Camera;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CameraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Camera::create([
            'name' => 'Canon 1',
            'stock' => 4,
            'tarif' => 20000,
        ]);

        Camera::create([
            'name' => 'Canon 2',
            'stock' => 3,
            'tarif' => 40000,
        ]);

        Camera::create([
            'name' => 'Sony',
            'stock' => 2,
            'tarif' => 15000,
        ]);
    }
}
