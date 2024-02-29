<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

require_once 'vendor/autoload.php';

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'name' => 'Flavio Caetano',
            'email' => 'flavio@mail.com',
            'password' => bcrypt('123456')
        ]);
    }
}
