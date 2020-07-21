<?php

namespace App\Models\Customer;

use App\Models\Customer\Customer;
use App\Traits\Orderable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use Orderable; use SoftDeletes;

    protected $fillable = [ "code", "body", "customer_id", "product_id" ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function scopeGenerateReviewCode() {
        $code = mt_rand(100000, 999999);
        $value = Review::whereCode($code)->exists();

        if ($value) {
            return Self::generateReviewCode();
        }

        return $code;
    }
}
