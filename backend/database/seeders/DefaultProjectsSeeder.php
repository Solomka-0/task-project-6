<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
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

        $users = User::query()->where('rules', '=','["worker"]')->get();



        foreach ($items as $key => $item) {
            $projectUsers = $users->random(4);
            /** @var Project $projectItem */
            $projectItem = Project::query()->firstOrCreate(['name' => $item['name']], $item);
            $projectItem->tasks()->detach();
            foreach (range(1, 60 * 6) as $index) {
                /** @var Task $taskItem */
                $taskItem = Task::query()->firstOrCreate(['name' => "{$item['name']}: Задача $index"],
                    array_merge(['description' => 'Пустое описание задачи']));
                $taskItem->user_id = $projectUsers[rand(0, count($projectUsers) - 1)]->id;
                $taskItem->created_at = Carbon::now()->subMonths(6);
                $taskItem->save();
                $projectItem->tasks()->attach($taskItem);
            }
            $projectItem->created_at = Carbon::now()->subMonths(6);
            $projectItem->save();
        }
    }
}
