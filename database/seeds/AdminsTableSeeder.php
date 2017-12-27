<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('admins')->insert([
            'username' => 'admin',
            'password' => password_hash('admin888', PASSWORD_DEFAULT, ['cost' => 12]),
            'email' => '2531072685@qq.com',
            'tel' => '1508272311',
            'status' => 1
        ]);
    }
}
