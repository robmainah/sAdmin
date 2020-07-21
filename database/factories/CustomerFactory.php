<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    static $password;
    $regex = "/(\+254|0){1}[7]{1}([0-2]{1}[0-9]{1}|[9]{1}[0-2]{1})[0-9]{6}/";
    $gender = $faker->randomElement(['Male', 'Female']);
    $active = $faker->randomElement(['1', '0']);

    return [
        'name' => $faker->name($gender),
        'customer_code' => $faker->unique()->numberBetween(111111, 999999),
        'email' => 'customer@customer.com',
        // 'email' => $faker->unique()->safeEmail,
        'email_verified_at' => null,
        'phone_number' => $faker->regexify($regex),
        'id_number' => rand(1111111111, 9999999999),
        'address' => $faker->address,
        'gender' => $gender,
        'password' => $password ?: $password = bcrypt('1234'),
        'is_active' => $active,
        'remember_token' => null,
    ];
});
