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
