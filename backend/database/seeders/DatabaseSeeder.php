<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            DefaultAdminUserSeeder::class,
            DefaultUsersSeeder::class,
            DefaultProjectsSeeder::class,
            InitUsersSeeder::class,
            TaskStatusesSeeder::class
        ]);
    }
}
