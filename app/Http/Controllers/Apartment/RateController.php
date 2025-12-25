<?php

namespace App\Http\Controllers\Apartment;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Book;
use App\Models\Rate;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function rate(Request $request, Apartment $apartment)
    {
        $userId = auth()->id();

        $hasBook = Book::query()
            ->where('renter_id', $userId)
            ->where('apartment_id', $apartment->id)
            ->where('status','=','ended')
            ->exists();

        if (!$hasBook) {
            return response()->json([
                'message' => 'you cannot rate this apartment',
            ], 403);
        }

        $request->validate([
            'rate' => 'required|integer|between:1,5',
        ]);

        Rate::query()->create([
            'apartment_id' => $apartment->id,
            'user_id' => $userId,
            'rating' => $request->rate,
        ]);

        return response()->json([
            'message' => 'Thank you for sharing us your opinion',
        ], 200);
    }

}
