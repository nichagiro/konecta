<?php

namespace Database\Seeders;

use App\Models\client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        client::factory(100)->create();
    }
}
