<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "rols_id" => 1,
            "name" => "master",
            "email" => "master@master.com",
            "profile_photo_path" => null,
            "password" => Hash::make('konecta123')
        ]);
    }
}
