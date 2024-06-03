<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultProjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'name' => 'Матрёшка',
                'description' => 'Проект с открытым исходным кодом для автоматизации развертывания приложений в виде переносимых автономных контейнеров, выполняемых в облаке или локальной среде.',
            ],
            [
                'name' => 'Арт-косалтинг',
                'description' => 'Помощь профессионального консультанта в поиске, выборе, покупке и продаже произведений искусства и осуществлении всех сопутствующих операций: документооборот, экспертиза и оценка.',
            ],
            [
                'name' => 'mosmetro.ru',
                'description' => 'На сайте можно оставить заявку на поиск утерянной вещи и посмотреть актуальные экскурсии в метро. Для партнёров заработал раздел с правилами торговли в метро. Чат-бот Александра теперь и в веб-версии. Но это ещё не конец — скоро нас ждут другие обновления.',
            ],
        ];

        $tasks = [
            [
                'tasks' => [
                    [
                        'name' => 'Матрёшка: Задача 1',
                        'description' => 'Пустое описание задачи',
                    ],
                    [
                        'name' => 'Матрёшка: Задача 2',
                        'description' => 'Пустое описание задачи',
                    ],
                    [
                        'name' => 'Матрёшка: Задача 3',
                        'description' => 'Пустое описание задачи',
                    ],
                    [
                        'name' => 'Матрёшка: Задача 4',
                        'description' => 'Пустое описание задачи',
                    ],
                    [
                        'name' => 'Матрёшка: Задача 5',
                        'description' => 'Пустое описание задачи',
                    ],
                    [
                        'name' => 'Матрёшка: Задача 6',
                        'description' => 'Пустое описание задачи',
                    ],
                    [
                        'name' => 'Матрёшка: Задача 7',
                        'description' => 'Пустое описание задачи',
                    ],
                    [
                        'name' => 'Матрёшка: Задача 8',
                        'description' => 'Пустое описание задачи',
                    ],
                    [
                        'name' => 'Матрёшка: Задача 9',
                        'description' => 'Пустое описание задачи',
                    ]
                ],
                'users' => User::query()->where('rules', '=','["worker"]')->get()
            ],
            [
                'tasks' => [
                    [
                        'name' => 'Арт-косалтинг: задача 1',
                        'description' => 'Пустое описание задачи',
                    ],
                    [
                        'name' => 'Арт-косалтинг: задача 2',
                        'description' => 'Пустое описание задачи',
                    ],
                    [
                        'name' => 'Арт-косалтинг: задача 3',
                        'description' => 'Пустое описание задачи',
                    ],
                    [
                        'name' => 'Арт-косалтинг: задача 4',
                        'description' => 'Пустое описание задачи',
                    ],
                    [
                        'name' => 'Арт-косалтинг: задача 5',
                        'description' => 'Пустое описание задачи',
                    ],
                    [
                        'name' => 'Арт-косалтинг: задача 6',
                        'description' => 'Пустое описание задачи',
                    ],
                    [
                        'name' => 'Арт-косалтинг: задача 7',
                        'description' => 'Пустое описание задачи',
                    ],
                ],
                'users' => User::query()->where('rules', '=','["worker"]')->get()
            ],
            [
                'tasks' => [
                    [
                        'name' => 'mosmetro.ru: Задача 1',
                        'description' => 'Пустое описание задачи',
                    ],
                    [
                        'name' => 'mosmetro.ru: Задача 2',
                        'description' => 'Пустое описание задачи',
                    ],
                    [
                        'name' => 'mosmetro.ru: Задача 3',
                        'description' => 'Пустое описание задачи',
                    ],
                    [
                        'name' => 'mosmetro.ru: Задача 4',
                        'description' => 'Пустое описание задачи',
                    ],
                    [
                        'name' => 'mosmetro.ru: Задача 5',
                        'description' => 'Пустое описание задачи',
                    ],
                    [
                        'name' => 'mosmetro.ru: Задача 6',
                        'description' => 'Пустое описание задачи',
                    ],
                    [
                        'name' => 'mosmetro.ru: Задача 7',
                        'description' => 'Пустое описание задачи',
                    ],
                    [
                        'name' => 'mosmetro.ru: Задача 8',
                        'description' => 'Пустое описание задачи',
                    ],
                ],
                'users' => User::query()->where('rules', '=','["worker"]')->get()
            ]
        ];



        foreach ($items as $key => $item) {
            /** @var Project $projectItem */
            $projectItem = Project::query()->firstOrCreate(['name' => $item['name']], $item);
            $projectItem->tasks()->detach();
            foreach ($tasks[$key]['tasks'] as $task) {
                /** @var Task $taskItem */
                $taskItem = Task::query()->firstOrCreate(['name' => $task['name']], array_merge($task));
                $taskItem->user_id = $tasks[$key]['users'][rand(0, count($tasks[$key]['users']) - 1)]->id;
                $taskItem->save();
                $projectItem->tasks()->attach($taskItem);
            }
        }
    }
}
