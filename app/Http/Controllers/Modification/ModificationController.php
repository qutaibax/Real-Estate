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
       Modification::query()->where('id', $id)
            ->update(['status' => 'approved']);
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

}
