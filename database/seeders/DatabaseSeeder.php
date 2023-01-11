<?php

namespace Database\Seeders;

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
        $this->call([
            MicroservicesSeeder::class,
            ModulesTableSeeder::class,
            TenantsTableSeeder::class,
            SignUpJobsSeeder::class,
            SignUpWorkAreasSeeder::class,
            SignUpQuestionsSeeder::class,
        ]);
    }
}
