<?php

namespace App\Policies\Customer;

use App\Models\Customer\Customer;
use App\Models\Customer\Orders\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function owner(Customer $customer, Order $order)
    {
        return $customer->id === $order->customer->id;
    }
}
