<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InitUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Project::all() as $project) {
            $usersIds = array_unique($project->tasks()->get()->pluck('user_id')->toArray());
            $project->users()->sync($usersIds);
        }
    }
}
