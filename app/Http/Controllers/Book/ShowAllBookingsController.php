<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Models\Book;
use PhpParser\Node\Expr\Cast\Bool_;

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

    public function cancel(Book $book)//model pinding
    {
       // Book::query()->where('id', $id)->first();
        $user_id = auth()->id();
        Book::query()->where('renter_id', $user_id)->first();
            $book->status='cancelled';
            $book->save();
            return response()->json([
                'message' => 'Book Cancelled Successfully'
            ],200);
    }
}
