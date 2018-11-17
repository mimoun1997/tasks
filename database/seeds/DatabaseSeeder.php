<?php

namespace home\mimoun\Code\mimoun1997\tasks\database\seeds;

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
        // $this->call(UsersTableSeeder::class);
        create_primary_user();
        create_example_tasks();
        initialize_roles();
    }
}
