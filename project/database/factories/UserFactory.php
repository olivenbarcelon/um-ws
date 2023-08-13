<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

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
    $email = $faker->unique()->safeEmail;
    return [
        'email' => $email,
        'password' => Hash::make('PASSWORD'),
        'mobile_number' => $faker->e164PhoneNumber(),
        'role' => $faker->randomElement(User::ROLE),
        'last_name' => $faker->lastName(),
        'first_name' => $faker->firstName(),
        'remember_token' => Str::random(10),
        'created_by' => $email
    ];
});
