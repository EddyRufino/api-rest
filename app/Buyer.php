<?php

namespace App;

use App\Scopes\BuyerScope;
use App\Transformers\BuyerTransformer;

class Buyer extends User
{
	// Se usa para construir i inicializar el modelo
	protected static function boot()
	{
		parent::boot();
		static::addGlobalScope(new BuyerScope);
	}

	public $transformer = BuyerTransformer::class;

    public function transactions()
    {
    	return $this->hasMany(Transaction::class);
    }
}
