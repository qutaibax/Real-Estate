<?php

namespace App\Http\Controllers\Modification;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Modification;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\AssignOp\Mod;

class ModificationController extends Controller
{

    public function edit(Request $request)
    {
        $new_data = $request->validate([
            'new_start_date' => 'nullable|date',
            'new_end_date' => 'nullable|date',
            'transaction' => 'nullable|string',
        ]);
        Modification::query()->create($request->all());
        return response()->json([
            'message' => 'Modification modified successfully,Wait response’s owner.',
            'your_data' => $new_data,
        ]);
    }


    public function index()
    {
        $owner_id = auth()->id();
        $modifications = Modification::query()->whereHas('book.apartment', function ($query) use ($owner_id) {
            $query->where('owner_id', $owner_id);
        })//->with('book.apartment')
        ->get();

        return response()->json([
            'modifications' => $modifications
        ]);
    }

    public function acceptEdit($id)
    {
        $modification = Modification::query()->where('id', $id)->first();
        $modification->update(['status' => 'approved']);
        $book = Book::query()->where('id', $modification->book_id)->first();
        if ($modification->new_end_date) {
            $book->update(['end_date' => $modification->new_end_date]);
        }
        if ($modification->new_start_date) {
            $book->update(['start_date' => $modification->new_start_date]);
        }
        if ($modification->transaction) {
            $book->update(['transaction' => $modification->transaction]);
        }
        return response()->json([
            'message' => 'Modification approved successfully.'
        ], 200);
    }

    public function rejectEdit($id)
    {

        Modification::query()->where('id', $id)
            ->update(['status' => 'rejected']);

        return response()->json([
            'message' => 'Modification rejected successfully.'
        ], 200);

    }


//    use Illuminate\Support\Facades\DB;
//
//    public function acceptEdit($id)
//    {
//        $modification = Modification::with('book.apartment')->findOrFail($id);
//
//        // تحقق من أن المستخدم هو المالك
//        if ($modification->book->apartment->owner_id !== auth()->id()) {
//            return response()->json([
//                'message' => 'Unauthorized'
//            ], 403);
//        }
//
//        DB::transaction(function () use ($modification) {
//
//            $modification->update([
//                'status' => 'approved'
//            ]);
//
//            $data = array_filter([
//                'start_date' => $modification->new_start_date,
//                'end_date'   => $modification->new_end_date,
//                'transaction'=> $modification->transaction,
//            ]);
//
//            if (!empty($data)) {
//                $modification->book->update($data);
//            }
//        });
//
//        return response()->json([
//            'message' => 'Modification approved successfully.'
//        ], 200);
//    }

}
