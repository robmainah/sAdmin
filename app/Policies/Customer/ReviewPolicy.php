<?php

namespace App\Policies\Customer;

use App\Models\Customer\Review;
use App\Models\Customer\Customer;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function owner(Customer $customer, Review $review)
    {
        return $customer->id === $review->customer->id;
    }
}
