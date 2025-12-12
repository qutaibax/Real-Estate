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
            ['owner_id'=>1,'space'=>150 ,'price'=>1500,'country'=>'syria','city'=>'Damascus'],
            ['owner_id'=>1,'space'=>200 ,'price'=>1000,'country'=>'syria','city'=>'Aleppo'],
            ['owner_id'=>1,'space'=>200 ,'price'=>3000,'country'=>'palestine','city'=>'gaza'],
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
