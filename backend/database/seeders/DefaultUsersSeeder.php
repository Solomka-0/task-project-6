<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Петр Савельев',
                'email' => 'manager1@yandex.ru',
                'password' => bcrypt('default'),
                'rules' => [Role::MANAGER],
            ],
            [
                'name' => 'Виктор Стрельников',
                'email' => 'manager2@yandex.ru',
                'password' => bcrypt('default'),
                'rules' => [Role::MANAGER],
            ],
            [
                'name' => 'Дмитрий Ходырев',
                'email' => 'manager3@yandex.ru',
                'password' => bcrypt('default'),
                'rules' => [Role::MANAGER],
            ],
            [
                'name' => 'Иванов Иван',
                'email' => 'worker@yandex.ru',
                'password' => bcrypt('default'),
                'rules' => [Role::WORKER],
            ],
            [
                'name' => 'Владимир Небоков',
                'email' => 'worker1@yandex.ru',
                'password' => bcrypt('default'),
                'rules' => [Role::WORKER],
            ],
            [
                'name' => 'Федор Поляков',
                'email' => 'worker2@yandex.ru',
                'password' => bcrypt('default'),
                'rules' => [Role::WORKER],
            ],
            [
                'name' => 'Федор Поляков',
                'email' => 'worker3@yandex.ru',
                'password' => bcrypt('default'),
                'rules' => [Role::WORKER],
            ],
            [
                'name' => 'Петр Грачечв',
                'email' => 'worker4@yandex.ru',
                'password' => bcrypt('default'),
                'rules' => [Role::WORKER],
            ],
            [
                'name' => 'Андрей Рыбалкин',
                'email' => 'worker5@yandex.ru',
                'password' => bcrypt('default'),
                'rules' => [Role::WORKER],
            ],
            [
                'name' => 'Екатерина Фомина',
                'email' => 'worker6@yandex.ru',
                'password' => bcrypt('default'),
                'rules' => [Role::WORKER],
            ],
            [
                'name' => 'Тихон Кузьмин',
                'email' => 'worker7@yandex.ru',
                'password' => bcrypt('default'),
                'rules' => [Role::WORKER],
            ],
            [
                'name' => 'Давид Киселев',
                'email' => 'worker8@yandex.ru',
                'password' => bcrypt('default'),
                'rules' => [Role::WORKER],
            ],
            [
                'name' => 'Глеб Гуров',
                'email' => 'worker9@yandex.ru',
                'password' => bcrypt('default'),
                'rules' => [Role::WORKER],
            ],
            [
                'name' => 'Александр Мальцев',
                'email' => 'worker10@yandex.ru',
                'password' => bcrypt('default'),
                'rules' => [Role::WORKER],
            ],
            [
                'name' => 'Виталий Герасимов',
                'email' => 'worker11@yandex.ru',
                'password' => bcrypt('default'),
                'rules' => [Role::WORKER],
            ],
            [
                'name' => 'Николай Покровский',
                'email' => 'worker12@yandex.ru',
                'password' => bcrypt('default'),
                'rules' => [Role::WORKER],
            ],
            [
                'name' => 'Иван Поляков',
                'email' => 'worker13@yandex.ru',
                'password' => bcrypt('default'),
                'rules' => [Role::WORKER],
            ],
            [
                'name' => 'Матвей Колесников',
                'email' => 'worker14@yandex.ru',
                'password' => bcrypt('default'),
                'rules' => [Role::WORKER],
            ],
            [
                'name' => 'Соколов Артём',
                'email' => 'worker15@yandex.ru',
                'password' => bcrypt('default'),
                'rules' => [Role::WORKER],
            ],
            [
                'name' => 'Лазарев Фёдор',
                'email' => 'worker16@yandex.ru',
                'password' => bcrypt('default'),
                'rules' => [Role::WORKER],
            ],
            [
                'name' => 'Романов Гордей',
                'email' => 'worker17@yandex.ru',
                'password' => bcrypt('default'),
                'rules' => [Role::WORKER],
            ],
            [
                'name' => 'Никольский Дамир',
                'email' => 'worker18@yandex.ru',
                'password' => bcrypt('default'),
                'rules' => [Role::WORKER],
            ],
        ];

        foreach ($users as $user) {
            try {
                $user = User::query()->firstOrCreate(
                    $user
                );
            } catch (\Exception $e) {
                $user = User::query()->firstWhere([
                    'name' => $user['name'],
                    'email' => $user['email'],
                ]);
            }

            $user->rules = $user->rules ?? [];
            $user->save();
        }
    }
}
