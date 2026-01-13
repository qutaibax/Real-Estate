<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{

    protected $fillable = [
        'renter_id', 'apartment_id',
        'start_date', 'end_date', 'site',
        'transaction', 'is_approved', 'status'
    ];

    public static function rules()
    {
        return [

            'apartment_id' => 'required',
            'site' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'transaction' => 'nullable|string',

        ];
    }


    //FK
    public function renter()
    {
        return $this->belongsTo(User::class, 'renter_id');
    }

    public function apartment()
    {
        return $this->belongsTo(Apartment::class, 'apartment_id');
    }

    //PK
    public function modification()
    {
        return $this->hasMany(Modification::class, 'book_id');
    }


}
