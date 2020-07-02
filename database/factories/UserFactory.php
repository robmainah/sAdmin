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
    $regex = "/(\+254|0){1}[7]{1}([0-2]{1}[0-9]{1}|[9]{1}[0-2]{1})[0-9]{6}/";
    $gender = $faker->randomElement(['Male', 'Female']);
    $roles = $faker->randomElement([1, 2, 3, 4, 5]);

    return [
        'user_code' => $faker->unique()->numberBetween(111111, 999999),
        'user_name' => $faker->name($gender),
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => null,
        'phone_number' => $faker->regexify($regex),
        'gender' => $gender,
        'id_number' => rand(1111111, 9999999),
        'birth_date' => $faker->datetime,
        'active' => $faker->boolean,
        'roles' => $roles,
        'email_verified_at' => now(),
        'password' => $password ?: $password = bcrypt('1234'),
        // 'created_by' => function () {
        //     return User::all()->random();
        // },
        // 'updated_by' => function () {
        //     return User::all()->random();
        // },
        // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});
