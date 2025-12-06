<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'renter_id', 'apartment_id',
        'start_date', 'end_date', 'site',
        'transaction', 'is_approved', 'status'
    ];


    //FK
    public function renter()
    {
        return $this->belongsTo(User::class);
    }

    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }



}
