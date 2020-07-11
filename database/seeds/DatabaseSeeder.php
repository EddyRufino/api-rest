<?php

use Illuminate\Database\Seeder;
use App\Transaction;
use App\Category;
use App\Product;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Storage::deleteDirectory('products');
        Storage::makeDirectory('products');

        factory(Category::class, 15)->create();
        factory(User::class, 25)->create();

        factory(Product::class, 110)->create()
        	->each(function(Product $product) {
        		$categorias = Category::all()->random(mt_rand(1, 3))->pluck('id');
        		$product->categories()->attach($categorias);
        	});

        factory(Transaction::class, 100)->create();
    }
}
