<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProduct extends Pivot
{
    // extends Pivot
    use SoftDeletes;
    // protected $table = 'order_products';

    public function orders()
    {
        return
            $this->belongsToMany('App\Order', 'order_products', 'id')
            ->select('orders.id', 'orders.status', 'comments', 'shippingDate');
    }

    public function products()
    {
        return
            $this->belongsToMany('App\Product', 'order_products', 'id')
            ->select('products.id', 'title', 'image');
    }
}
