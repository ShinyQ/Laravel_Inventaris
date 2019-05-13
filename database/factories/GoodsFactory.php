<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use App\Goods;
use App\Categories;
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

$factory->define(Goods::class, function (Faker $faker) {
    return [
      'name' => $faker->safeColorName,
      'stock' => rand(1,99),
      'categories_id'=>function(){
          return Categories::all()->random();
      },
      'shelfs_id'=>function(){
          return Shelfs::all()->random();
      },
      'status'=>1

    ];
});
