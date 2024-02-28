<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            'name' => 'Super Admin',
            'location' => 'DN',
            'phone' => '0123456789',
            'email' => 'admin@fakecgv.com',
            'role_id' => User::ROLE_ADMIN,
            'password' => Hash::make(12345678),
            'api_token' => Str::random(60),
            'email_verified_at' => now(),
            'remember_token' => '1234567890',
        ]);
        User::factory()
        ->count(50)
        ->has(Profile::factory()->count(1))
        ->create([
            'role_id' => User::ROLE_CUSTOMER,
        ]);
    }
}
