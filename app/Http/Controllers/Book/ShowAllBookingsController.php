<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Models\Book;

class ShowAllBookingsController extends Controller
{
    public function index()
    {
        $user_id = auth()->id();
        $bookings = Book::query()->where('renter_id', $user_id)->get();

        if ($bookings->isEmpty()) {
            return response()->json(['message' => 'No Bookings Found'], 404);
        }
        return response()->json(
            ['bookings' => $bookings]
            , 200);
    }
}
