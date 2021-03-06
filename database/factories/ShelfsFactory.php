<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use App\Shelfs;
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

$factory->define(Shelfs::class, function (Faker $faker) {
    return [
        'nomor' => $faker->randomDigitNotNull,
        'kode' => $faker->secondaryAddress
    ];
});
