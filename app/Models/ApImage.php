<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApImage extends Model
{
    protected $fillable=[
        'apartment_id','image'
    ];

    public function apartment(){
        return $this->belongsTo(Apartment::class);
    }
}
