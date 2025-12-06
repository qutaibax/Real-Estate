<?php

namespace Database\Seeders;

use App\Models\Apartment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arr=[
            ['space'=>'150 m','price'=>1500,'country'=>'syria','city'=>'Damascus'],
            ['space'=>'200 m','price'=>1000,'country'=>'syria','city'=>'Aleppo'],
            ['space'=>'200 m','price'=>3000,'country'=>'palestine','city'=>'gaza'],
        ];

foreach ($arr as $key => $value) {
    Apartment::create([
        'space'=>$value['space'],
        'price'=>$value['price'],
        'country'=>$value['country'],
        'city'=>$value['city'],

    ]);
}

    }
}
