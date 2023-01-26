<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => env('ADMIN_EMAIL'),
            'role_id' => Role::IS_ADMIN,
            'email_verified_at' => now(),
            'password' => bcrypt(env('ADMIN_PASSWORD')),
            'remember_token' => Str::random(10)
        ]);
    }
}
