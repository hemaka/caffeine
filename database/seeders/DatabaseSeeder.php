<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::create([
            'email' => 'hemaka@gmail.com',
            'name' => 'jim'
        ]);

        User::create([
            'email' => 'demo@jimhe.us',
            'name' => 'demo'
        ]);
    }
}
