<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'code', 'category_id', 'status'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function admin()
    {
        return $this->belongsTo('App\Models\Admin');
    }

    public function scopeGenerateCode() {
        $code = mt_rand(100000, 999999);
        $value = Brand::whereCode($code)->exists();

        if ($value) {
            return Self::generateCode();
        }

        return $code;
    }
}
