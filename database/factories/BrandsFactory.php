<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Brand::class, function (Faker $faker) {
    $title = ['Hp', 'Dell', 'Lenovo', 'Macbook', 'Compact', 'Toshiba'];
    return [
        'code' => $faker->unique()->numberBetween(111111, 999999),
        'title' => $faker->unique()->randomElement($title),
        'category_id' => function () {
            return Category::all()->random();
        },
        'created_by' => function () {
            return User::all()->random();
        },
        'updated_by' => function () {
            return User::all()->random();
        },
        'status' => $faker->randomElement(['active', 'inactive']),
    ];
});
