<?php

namespace App\Models\Customer\Orders;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProduct extends Model
{
    use SoftDeletes;

    protected $table = "order_product";

    /* public function product()
    {
        return $this->belongsTo(Product::class);
    } */

    /* public function order()
    {
        return $this->belongsTo(Order::class);
    } */
}
