<?php

namespace App\Http\Controllers\Product;

use App\Transformers\TransactionTransformer;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Transaction;
use App\Product;
use App\User;

class ProductBuyerTransactionController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('transform.input:' . TransactionTransformer::class)->only(['store']);
        $this->middleware('scope:purchase-product')->only(['store']);
        // $this->middleware('can:purchase,buyer')->only('store');
    }

    public function store(Request $request, Product $product, User $buyer)
    {
        $rules = [
            'quantity' => 'required|integer|min:1'
        ];

        $this->validate($request, $rules);

        if ($buyer->id == $product->seller_id) {
            return $this->errorResponse('The buyer must be different from the seller', 409);
        }

        if (!$buyer->esVerificado()) {
            return $this->errorResponse('The buyer must be a verified user', 409);
        }

        if (!$product->seller->esVerificado()) {
            return $this->errorResponse('The seller must be a verified user', 409);
        }

        if (!$product->estaDisponible()) {
            return $this->errorResponse('The product is not available', 409);   
        }

        if ($product->quantity < $request->quantity) {
            return $this->errorResponse('The product does not have enough units for this transaction', 409);   
        }

        return DB::transaction(function() use ($request, $product, $buyer) {
            $product->quantity -= $request->quantity;
            $product->save();

            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'buyer_id' => $buyer->id,
                'product_id' => $product->id,
            ]);

            return $this->showOne($transaction, 201);
        });
    }
}
