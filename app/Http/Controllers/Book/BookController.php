<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function books(Request $request)
    {

        $validate = $request->validate(Book::rules());
        $validate['renter_id'] = auth()->id();


        //check if the apartment exist in apartments table
        $apartment = Apartment::query()->find($validate['apartment_id']);
        if (!$apartment) {
            return response()->json([
                'message' => 'apartment not found'
            ], 404);
        }
        if ($apartment->owner_id == auth()->id()) {
            return response()->json([
                'status' => false,
                'message' => 'You cannot book an own apartment',
            ], 400);
        }
        //check if the apartment has a book and if the date is active
        $Check = Book::query()->where('apartment_id', $apartment->id)
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
            'message' => ' Book added successfully,Waiting for approving',
        ], 201);
    }

    public function myApartmentRequests(Request $request)
    {
        $ownerId = auth()->id();

        $books = Book::query()->with('renter:id,first_name', 'apartment:id,city')
            ->whereHas('apartment', function ($query) use ($ownerId) {
                $query->where('owner_id', $ownerId);
            })
            ->where('is_approved', 'pending')
            ->get();

        return response()->json([
            'data' => $books
        ], 200);
    }


    public function acceptOffer($id)
    {

        $book = Book::query()->with('renter:id,first_name')->where('id', $id)->first();
        $book->is_approved = 'approved';
        $book->status = 'current';
        $book->save();
        return response()->json([
            'message' => ' Book accepted successfully',
            'data' => $book
        ], 200);

    }

    public function rejectOffer($id)
    {
        $ownerId = auth()->id();
        $book = Book::query()->with('renter:id,first_name')
            ->where('id', $id)->first();
        $book->is_approved = 'rejected';
        $book->status = 'cancelled';
        $book->save();

        return response()->json([
            'message' => ' Book rejected successfully',
            'data' => $book
        ], 200);

    }

}
