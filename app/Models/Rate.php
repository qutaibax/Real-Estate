<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $fillable=[
        'user_id',
        'apartment_id',
        'rating',
        'comment',
    ];


    public function apartment(){
        return $this->belongsTo(Apartment::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
