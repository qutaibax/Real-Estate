<?php

namespace App\Http\Controllers\Apartment;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function books(Request $request)
    {

        $validate = $request->validate(Book::rules());
        //$validate['renter_id'] = auth()->id();

        $book = Book::query()->find($validate['apartment_id']);
            $Check = Book::query()->where('apartment_id', $book->id)
                ->where(function ($query) use ($validate) {
                    $query->whereBetween('start_date', [$validate['start_date'], $validate['end_date']])
                        ->orWhereBetween('end_date', [$validate['start_date'], $validate['end_date']]);
                })->first();

        if ($Check) {
            return response()->json([
                'status' => false,
                'message' => 'The apartment is already booked in this period',
            ], 400);
        }
        Book::query()->create($validate);
        return response()->json([
            'message' => ' Book added successfully,Waiting for approval',
        ], 201);
    }

    public function myApartmentRequests(Request $request)
    {
        $ownerId = auth()->id();

        $books = Book::with('renter:id,first_name', 'apartment:id,city')
            ->whereHas('apartment', function ($q) use ($ownerId) {
                $q->where('owner_id', $ownerId);
            })
            ->where('is_approved', 'pending')
            ->get();

        return response()->json([
            'data' => $books
        ], 200);
    }


    public function acceptOffer(Request $request)
    {

        $book = Book::query()->with('renter:id,first_name')->where('id', $request->id)->first();
        $book->is_approved = 'approved';
        $book->status = 'current';
        $book->save();
        return response()->json([
            'message' => ' Book accepted successfully',
            'data' => $book
        ],200);

    }

    public function rejectOffer(Request $request)
    {

        $book = Book::query()->with('renter:id,first_name')->where('id', $request->id)->first();
        $book->is_approved = 'rejected';
        $book->status = 'cancelled';
        $book->save();
        return response()->json([
            'message' => ' Book rejected successfully',
            'data' => $book
        ],200);

    }

}
