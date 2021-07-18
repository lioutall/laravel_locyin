<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Dynamic::factory(100)->create();
        \App\Models\Vlog::factory(100)->create();
        $user = User::first();
        $user->username = "luoxun";
        $user->nickname = "小寻";
        $user->phone = "18404300662";
        $user->email = "geekadpt@163.com";
        $user->save();
    }
}
