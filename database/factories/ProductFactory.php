<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        "name" => $faker->unique(false, 50000)->name,
        "weight" => $faker->height,
        "barcode" => $faker->unique(false, 50000)->regexify('[0-9]{13}'),
        "category_id" => rand(1, 5),
        "subcategory_id" => rand(1, 2),
        "brand_id" => rand(1, 2),

    ];
});
