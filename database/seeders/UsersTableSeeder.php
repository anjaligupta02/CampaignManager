<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create([
           'name' => 'Anjali Gupta',
           'email' => 'anjaliguptaag0505@email.com',
        ]);

        User::factory(5)->create();
    }
}
