<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name'     => 'admin',
            'email'    => 'admin@gmail.com',
            'mobile'    => '01976009329',
            'Password' => Hash::make('123456')
        ]);

        User::create([
            'name'     => 'user',
            'email'    => 'user@gmail.com',
            'mobile'   => '01976009329',
            'status'   => 0,
            'Password' => Hash::make('123456')
        ]);
    }
}
