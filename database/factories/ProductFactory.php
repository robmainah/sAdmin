<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

// use Str;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    $title = Str::words($faker->paragraph(), 3);

    return [
        'prod_code' => $faker->unique()->numberBetween(111111, 999999),
        'category_id' => function () {
            return Category::all()->random();
        },
        'title' => $title,
        'slug' => Str::slug($title),
        'description' => $faker->paragraph,
        'price' => rand(111, 5010),
        'quantity' => rand(5, 20),
        'image' => "images/546819.jpeg",
        'created_by' => function () {
            return User::all()->random();
        },
        'updated_by' => function () {
            return User::all()->random();
        },
    ];
});
