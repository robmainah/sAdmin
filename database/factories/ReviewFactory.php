<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Customer\Review;
use App\Models\Customer\Customer;
use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Review::class, function (Faker $faker) {
    return [
        "code" => $faker->unique()->numberBetween(111111, 999999),
        "body" => $faker->paragraph,
        'product_id' => function () {
            return Product::all()->random();
        },
        'customer_id' => function () {
            return Customer::all()->random();
        },
    ];
});
