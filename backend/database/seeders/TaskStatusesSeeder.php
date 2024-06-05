<?php

namespace Database\Seeders;

use App\Enums\TaskStatus;
use App\Models\Task;
use Carbon\Carbon;
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
            $task->start_at = $statuses[$index]['start_at'] ? $minDateTime->addHours(rand(1, 24 * 30 * 6)) : null;
            /** @var \DateTime $startAt */
            $task->end_at = $statuses[$index]['end_at'] ? $task->start_at->addHours(rand(1, 24 * 8)) : null;

            if (!empty($task->end_at) && Carbon::now()->lt(Carbon::parse($task->end_at->format('Y-m-d H:i:s')))) {
                $task->end_at = Carbon::now();
            }
            $task->status = $statuses[$index]['status'];
            $task->save();
        }
    }
}
