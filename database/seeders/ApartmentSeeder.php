<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\ApImage;
use Illuminate\Database\Seeder;

class ApartmentSeeder extends Seeder
{
    public function run(): void
    {
        $apartmentData = [
            'space' => 150,
            'price' => 1500,
            'country' => 'syria',
            'city' => 'Damascus',
            'description' => 'This apartment is near old city and convenient from many sides',
        ];

        $images = [
            'apartments/kitchen-1.jpg',
            'apartments/livingroom-1.jpg',
            'apartments/bedroom-1.jpg',
        ];


        $apartment = Apartment::create($apartmentData);


        foreach ($images as $image) {
            ApImage::create([
                'apartment_id' => $apartment->id,
                'image' => $image,
            ]);
        }
    }
}
