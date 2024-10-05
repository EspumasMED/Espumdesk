<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'area' => 'Administración',
            'sede' => 'Medellin',
            'telefono' => '3239199677',
            'cargo' => 'Administrador del Sistema',
            'estado' => 'activo',
        ]);
    }
}