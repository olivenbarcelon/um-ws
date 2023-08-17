<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

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
    return [
        'email' => $faker->unique()->safeEmail,
        'password' => $this->faker->regexify('[A-Z]{5}[0-4]{3}'),
        'mobile_number' => $faker->e164PhoneNumber(),
        'role' => $faker->randomElement(User::ROLE),
        'last_name' => $faker->lastName(),
        'first_name' => $faker->firstName(),
        'remember_token' => Str::random(10),
    ];
});
