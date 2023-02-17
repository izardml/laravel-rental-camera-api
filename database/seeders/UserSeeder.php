<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Nizar',
            'email' => 'nizar@gmail.com',
            'password' => Hash::make('123456'),
            'alamat' => 'Kembaran',
        ]);

        User::create([
            'name' => 'Daffa',
            'email' => 'daffa@gmail.com',
            'password' => Hash::make('123456'),
            'alamat' => 'Wetan',
        ]);

        User::create([
            'name' => 'Maulana',
            'email' => 'maulana@gmail.com',
            'password' => Hash::make('123456'),
            'alamat' => 'Purbalingga',
        ]);
    }
}
