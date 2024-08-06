<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@oneui-template.test',
            'email_verified_at' => now(),
            'password' => Hash::make('00000000'),
            'remember_token' => Str::random(10),
        ]);

        $admin->assignRole('admin');
    }
}
