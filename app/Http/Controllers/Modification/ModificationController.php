<?php

namespace App\Http\Controllers\Modification;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Modification;
use Illuminate\Http\Request;

class ModificationController extends Controller
{

    public function edit(Request $request)
    {
        $new_data=$request->validate([
            'new_start_date'=>'nullable|date',
            'new_end_date'=>'nullable|date',
            'transaction'=>'nullable|string',
        ]);
        Modification::query()->create($request->all());
        return response()->json([
            'message' => 'Modification modified successfully,Wait response’s owner.',
            'your_data'=>$new_data,
        ]);
    }



    public function index()
    {
        $owner_id = auth()->id();

        $modifications = Modification::query()->whereHas('book.apartment', function ($q) use ($owner_id) {
            $q->where('owner_id', $owner_id);
        })->with('book.apartment')
            ->get();

      return response()->json([
          'modifications' => $modifications
      ]);

    }
    public function acceptOffer(Request $request)
    {



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
