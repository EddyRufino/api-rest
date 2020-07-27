<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Buyer
Route::resource('buyers', 'Buyer\BuyerController')
	->only(['index', 'show']);
Route::resource('buyers.transactions', 'Buyer\BuyerTransactionController')
	->only(['index']);
Route::resource('buyers.products', 'Buyer\BuyerProductController')
	->only(['index']);
Route::resource('buyers.sellers', 'Buyer\BuyerSellerController')
	->only(['index']);
Route::resource('buyers.categories', 'Buyer\BuyerCategoryController')
	->only(['index']);



// Category
Route::resource('categories', 'Category\CategoryController')
	->except(['create', 'edit']);
Route::resource('categories.products', 'Category\CategoryProductController')
	->only(['index']);
Route::resource('categories.sellers', 'Category\CategorySellerController')
	->only(['index']);
Route::resource('categories.transactions', 'Category\CategoryTransactionController')
	->only(['index']);
Route::resource('categories.buyers', 'Category\CategoryBuyerController')
	->only(['index']);



// Products
Route::resource('products', 'Product\ProductController')
	->only(['index', 'show']);
Route::resource('products.transactions', 'Product\ProductTransactionController')
	->only(['index']);
Route::resource('products.buyers', 'Product\ProductBuyerController')
	->only(['index']);
Route::resource('products.categories', 'Product\ProductCategoryController')
	->only(['index', 'update', 'destroy']);
Route::resource('products.buyers.transactions', 'Product\ProductBuyerTransactionController')
	->only(['store']);



// Transactions
Route::resource('transactions', 'Transaction\TransactionController')
	->only(['index', 'show']);
Route::resource('transactions.categories', 'Transaction\TransactionCategoryController')->only(['index']);
Route::resource('transactions.sellers', 'Transaction\TransactionSellerController')->only(['index']);


// Sellers
Route::resource('sellers', 'Seller\SellerController')
	->only(['index', 'show']);
Route::resource('sellers.transactions', 'Seller\SellerTransactionController')
	->only(['index']);
Route::resource('sellers.categories', 'Seller\SellerCategoryController')
	->only(['index']);
Route::resource('sellers.buyers', 'Seller\SellerBuyerController')
	->only(['index']);
Route::resource('sellers.products', 'Seller\SellerProductController')
	->except(['create', 'show', 'edit']);



// Users
Route::resource('users', 'User\UserController')
	->except(['create', 'edit']);
Route::name('verify')->get('users/verify/{token}', 'User\UserController@verify');
Route::name('resend')->get('users/{user}/resend', 'User\UserController@resend');

Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');

Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');