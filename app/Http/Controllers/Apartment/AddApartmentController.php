<?php

namespace App\Http\Controllers\Apartment;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\ApImage;
use App\Traits\Image;
use App\Traits\sendWhatsAppMessage;
use Illuminate\Http\Request;

class AddApartmentController extends Controller
{

    public function add(Request $request)
    {
        $validate = $request->validate(Apartment::rules());
        $validate['owner_id'] = auth()->id();


        $apartment = Apartment::query()->create($validate);
        return response()->json([
            'message' => 'Successfully created apartment,Wait for the admin to accept',
            'apartment' => $apartment
        ]);

    }
    public function addImages(Request $request, $id)
    {

        $apartment = Apartment::query()->findOrFail($id);

        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);
        $uploadedImages = [];
        foreach ($request->file('images') as $image) {
            $path = $image->store('apartments', 'public');

            $newImage = $apartment->images()->create([
                'image' => $path
            ]);
            $uploadedImages[] = $newImage;
        }
        return response()->json([
            'message' => 'Images uploaded successfully',
            'images' => $uploadedImages
        ]);
    }




}
