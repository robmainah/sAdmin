<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'updated_by');
    }
    public function getTitleAttribute($value)
    {
        return $this->attributes['title'] = ucwords($value);
    }
    public function getCreatedByAttribute($value)
    {
        return User::where('id', $value)->first()->user_name;
    }
    public function getUpdatedByAttribute($value)
    {
        return User::where('id', $value)->first()->user_name;
    }
    public function scopeGenerateProductCode($query)
    {
        $random_code = rand(1111111111, 9999999999);
        $value = $query->where('prod_code', $random_code)->get();
        if (count($value) > 0) {
            return Self::generateProductNumber();
        }

        return $random_code;
    }
}
