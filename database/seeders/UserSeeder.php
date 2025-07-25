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
            'name' => 'Administrator',
            'email' => 'admin@panensawit.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Manager Kebun',
            'email' => 'manager@panensawit.com',
            'password' => Hash::make('manager123'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Operator',
            'email' => 'operator@panensawit.com',
            'password' => Hash::make('operator123'),
            'email_verified_at' => now(),
        ]);
    }
}
