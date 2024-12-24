<?php

namespace Database\Seeders;
use App\Models\User;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Найти или создать пользователя и назначить его администратором
        $user = User::where('email', 'a@a.com')->first();
        if ($user) {
            $user->is_admin = true;
            $user->save();
        }
}
//admin: login-elin@h.a   password-11111111
}
