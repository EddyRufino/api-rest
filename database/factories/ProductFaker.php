<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Seller;
use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
        'quantity' => $faker->numberBetween(1, 10),
        'status' => $faker->randomElement([Product::PRODUCTO_DISPONIBLE, Product::PRODUCTO_NO_DISPONIBLE]),
        'image' => \Faker\Provider\Image::image(storage_path() . '/app/public/products', 600, 350, 'technics', false),
        'seller_id' => Seller::all()->random()->id
    ];
});
