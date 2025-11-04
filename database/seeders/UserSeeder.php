<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'employee_no' => '00001',
            'name' => 'José Ángel (Supervisor)',
            'email' => 'supervisor@example.com',
            'password' => Hash::make('123456'),
            'role' => 'supervisor',
            'is_active' => true,
        ]);

        User::create([
            'employee_no' => '00002',
            'name' => 'Líder Producción 1',
            'email' => 'leader1@example.com',
            'password' => Hash::make('123456'),
            'role' => 'leader',
            'is_active' => true,
        ]);
    }
}
