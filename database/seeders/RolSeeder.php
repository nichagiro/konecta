<?php

namespace Database\Seeders;

use App\Models\rol;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // los dos roles para la prueba 
        rol::create([
            "name" => "admin"
        ]);

        rol::create([
            "name" => "vendedor"
        ]);
    }
}
