<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->create([
            'first_name'=>'qutaiba',
            'last_name'=>'tamim',
            'mobile'=>"0999",
            'password'=>bcrypt('1234'),
            'is_approved'=>false,
            'birth_date'=>'2000-01-01'
        ]);
        User::query()->create([
        'first_name'=>'moh',
        'last_name'=>'tamim',
        'mobile'=>"09991",
        'password'=>bcrypt('1234'),
        'is_approved'=>true,
        'birth_date'=>'2002-01-01'
    ]);
    }
}
