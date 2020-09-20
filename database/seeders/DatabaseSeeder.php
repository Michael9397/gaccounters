<?php

namespace Database\Seeders;

use App\Console\Commands\GetCharacterList;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();
        (new UserSeeder)->run();
        (new CreatorSeeder)->run();
        (new GetCharacterList)->handle();
    }
}
