<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $casts = [
        'active' => 'boolean',
    ];
    protected $dates = ['deleted_at'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function orders()
    {
        return $this->hasManyThrough(Order::class, Product::class);
    }
    public function getCreatedByAttribute($value)
    {
        return User::where('id', $value)->first()->user_name;
    }
    public function getUpdatedByAttribute($value)
    {
        return User::where('id', $value)->first()->user_name;
    }
    public function getCatNameAttribute($value)
    {
        return $this->attributes['cat_name'] = ucwords($value);
    }
    public function scopeGenerateCategoryCode($query)
    {
        $random_code = rand(1111111111, 9999999999);
        $value = $query->where('cat_code', $random_code)->get(); //Check if the generated code is taken
        if (count($value) > 0) {
            return Self::generateCategoryCode();
        }

        return $random_code;
    }
}
