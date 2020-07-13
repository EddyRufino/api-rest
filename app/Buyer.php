<?php

namespace App;

use App\Scopes\BuyerScope;

class Buyer extends User
{
	// Se usa para construir i inicializar el modelo
	protected static function boot()
	{
		parent::boot();
		static::addGlobalScope(new BuyerScope);
	}

    public function transactions()
    {
    	return $this->hasMany(Transaction::class);
    }
}
