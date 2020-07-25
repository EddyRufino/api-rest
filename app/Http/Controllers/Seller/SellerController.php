<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Transformers\ProductTransformer;
use Illuminate\Http\Request;
use App\Seller;

class SellerController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('transform.input:' . ProductTransformer::class)->only(['store', 'update']);
        // $this->middleware('scope:manage-products')->except('index');

        // $this->middleware('can:view,seller')->only('index');
        // $this->middleware('can:sale,seller')->only('store');
        // $this->middleware('can:edit-product,seller')->only('update');
        // $this->middleware('can:delete-product,seller')->only('destroy');
    }

    public function index()
    {
        $sellers = Seller::has('products')->get();
        return $this->showAll($sellers);
    }

    public function show(Seller $seller)
    {
        return $this->showOne($seller);
    }
}
