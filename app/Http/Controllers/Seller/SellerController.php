<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Seller;

class SellerController extends ApiController
{

    public function index()
    {
        $sellers = Seller::has('products')->get();
        return $this->showAll($sellers);
    }

    public function show($id)
    {
        $seller = Seller::has('products')->findOrFail($id);
        return $this->showOne($seller);
    }
}
