<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Barry',
            'surname' => 'White',
            'phone' => '87772224455',
            'email' => 'b.white@gmail.com',
            'password' => password_hash('123456', PASSWORD_DEFAULT),
        ]);

        DB::table('contacts')->insert([
            'user_id' => '1',
            'name' => 'Elvis',
            'phone' => '87026668899',
        ]);
        DB::table('contacts')->insert([
            'user_id' => '1',
            'name' => 'Frank',
            'phone' => '87054446677',
        ]);
        DB::table('contacts')->insert([
            'user_id' => '1',
            'name' => 'Dean',
            'phone' => '87089991122',
        ]);
    }
}
