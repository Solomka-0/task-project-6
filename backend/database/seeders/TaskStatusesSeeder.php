<?php

namespace Database\Seeders;

use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            0 => [
                'status' => TaskStatus::NOT_STARTED->value,
                'start_at' => false,
                'end_at' => false,
            ],
            [
                'status' => TaskStatus::IN_PROCESS->value,
                'start_at' => true,
                'end_at' => false,
            ],
            [
                'status' => TaskStatus::COMPLETE->value,
                'start_at' => true,
                'end_at' => true,
            ],
        ];

        foreach (Task::all() as $task) {
            $minDateTime = $task->minCreatedTime();
            $index = rand(0, count($statuses) - 1);
            $task->start_at = $statuses[$index]['start_at'] ? $minDateTime->addHours(rand(1, 24 * 10))->toDateTime() : null;
            $task->end_at = $statuses[$index]['end_at'] ? $task->start_at->addHours(rand(1, 24 * 8))->toDateTime() : null;
            $task->status = $statuses[$index]['status'];
            $task->save();
        }
    }
}
