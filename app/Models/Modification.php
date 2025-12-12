<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modification extends Model
{
    protected $fillable = [
        'book_id', 'new_start_date', 'new_end_date',
        'new_transaction', 'status'
    ];

    public function book(){
        return $this->belongsTo(Book::class);
    }

}
