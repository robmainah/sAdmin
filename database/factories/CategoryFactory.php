<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    $cat = ['Computers', 'Mobiles', 'Printers', 'Networks', 'Softwares'];

    return [
        'cat_code' => $faker->unique()->numberBetween(111111, 999999),
        'cat_name' => $faker->randomElement($cat),
        'active' => $faker->boolean,
        'created_by' => function () {
            return User::all()->random();
        },
        'updated_by' => function () {
            return User::all()->random();
        },
    ];
});
