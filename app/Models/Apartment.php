<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apartment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'owner_id', 'country', 'city', 'space',
        'rooms', 'price', 'description', 'rate',

    ];

    public static function rules()
    {
        return [
            'country' => 'required|string',
            'city' => 'required|string',
            'space' => 'required|integer',
            'price' => 'required|integer',
            'description' => 'nullable|string',
            'rooms' => 'nullable|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function scopeFilters(Builder $builder, $filter)
    {
        if ($filter['city'] ?? false) {
            $builder->where('city', 'LIKE', "%{$filter['city']}%");
        }
        if ($filter['country'] ?? false) {
            $builder->where('country', 'LIKE', "%{$filter['country']}%");
        }
        if ($filter['price'] ?? false) {
            $builder->where('price', '=', $filter['price']);
        }

        return $builder;
    }

    //Fk
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    //Pk
    public function book()
    {
        return $this->hasMany(Book::class);
    }

    public function images(){
        return $this->hasMany(ApImage::class);
    }
}
