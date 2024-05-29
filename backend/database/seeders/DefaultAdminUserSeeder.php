<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $admin = User::query()->firstOrCreate([
                'name' => 'Максим',
                'email' => 'admin@yandex.ru',
                'password' => bcrypt('root')
            ]);
        } catch (\Exception $e) {
            $admin = User::query()->firstWhere([
                'name' => 'Максим',
                'email' => 'admin@yandex.ru',
            ]);
        }

        $admin->rules = [Role::ADMIN];
        $admin->save();

    }
}
