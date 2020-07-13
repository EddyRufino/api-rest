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



// Products
Route::resource('products', 'Product\ProductController')
	->only(['index', 'show']);



// Transactions
Route::resource('transactions', 'Transaction\TransactionController')
	->only(['index', 'show']);
Route::resource('transactions.categories', 'Transaction\TransactionCategoryController')->only(['index']);
Route::resource('transactions.sellers', 'Transaction\TransactionSellerController')->only(['index']);


// Sellers
Route::resource('sellers', 'Seller\SellerController')
	->only(['index', 'show']);



// Users
Route::resource('users', 'User\UserController')
	->except(['create', 'edit']);