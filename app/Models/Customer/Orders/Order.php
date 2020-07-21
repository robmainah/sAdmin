<?php

namespace App\Models\Customer\Orders;

// use App\Models\Customer\Customer;

use App\Models\Customer\Customer;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = ['status'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderProduct()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function scopeGenerateOrderCode() {
        $code = mt_rand(100000000, 999999999);

        if (Customer::whereCode($code)->exists()) {
            return $this->generateOrderCode();
        }

        return $code;
    }

    protected function customerCodeExists($code) {
        return Customer::whereCode($code)->exists();
    }
}
