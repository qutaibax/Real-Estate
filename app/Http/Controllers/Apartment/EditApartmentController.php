<?php

namespace App\Http\Controllers\Apartment;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;

class EditApartmentController extends Controller
{
    public function BrowseOwnerApartment(){
         $owner_id=auth()->id();
         $apartments=Apartment::query()->where('owner_id',$owner_id)->get();
         if($apartments->isEmpty()){
             return response()->json([
                 'message'=>'There are no apartments yet'
             ],200);
         }
         return response()->json([
             'apartments'=>$apartments
         ],200);
    }
    public function EditApartment(Request $request,Apartment $apartment){
      $new_data= $request->validate([
            'images.*'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description'=>'nullable|string',
            'price'=>'nullable|string',
        ]);

       if($request->filled('description')){
          $apartment->description=$new_data['description'];
          $apartment->save();
       }
       if($request->filled('price')){
           $apartment->price=$new_data['price'];
           $apartment->save();
       }

       return response()->json([
           'message'=>'Apartment updated successfully',
       ],200);

    }
}
