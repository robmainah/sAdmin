<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function getCreatedByAttribute($value)
    {
        return User::where('id', $value)->first()->user_name;
    }
    public function getUpdatedByAttribute($value)
    {
        return User::where('id', $value)->first()->user_name;
    }
}
