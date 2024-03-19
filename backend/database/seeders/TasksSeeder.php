<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 10) as $i) {
            $task = Task::query()->firstOrCreate([
                'name' => 'Задача ' . $i,
                'description' => 'Описание задачи ' . $i,
            ]);
            $task->save();
        }
    }
}
