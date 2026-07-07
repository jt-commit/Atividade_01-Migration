<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    User::create([
        'name' => 'Administrador',
        'email' => 'admin@admin.com',
        'password' => Hash::make('12345678'),
        'role' => 'admin',
    ]);
}

}