<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Максим',
                'email' => 'maks1mkrasyuk@yandex.ru',
                'password' => bcrypt('root'),
            ]
        ];

        foreach ($data as $user) {
            User::query()->firstOrCreate($user);
        }
    }
}
