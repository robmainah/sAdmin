<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\False_;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    static $password;

    return [
        'user_code' => $faker->unique()->numberBetween(1111111111, 9999999999),
        'user_name' => 'January February',
        'email' => 'january@gmail.com',
        'email_verified_at' => null,
        'phone_number' => '254703249349',
        'gender' => 'Male',
        'id_number' => rand(1111111, 9999999),
        'birth_date' => $faker->datetime,
        'is_active' => True,
        'roles' => 1,
        'email_verified_at' => now(),
        'password' => $password ?: $password = bcrypt('1234'),
        'created_by' => 1,
        'updated_by' => 1,
        'remember_token' => Str::random(10),
    ];
});
