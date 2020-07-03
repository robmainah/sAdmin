<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    public function products()
    {
        return $this->hasMany(Product::class);
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
