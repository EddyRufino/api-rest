<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Transformers\CategoryTransformer;

class Category extends Model
{
	use SoftDeletes;

    protected $fillable = [
    	'name',
    	'description'
    ];

    public $transformer = CategoryTransformer::class;

    protected $hidden = [
        'pivot'
    ];

    protected $date = ['deleted_at'];

    public function products()
    {
    	return $this->belongsToMany(Product::class);
    }
}
