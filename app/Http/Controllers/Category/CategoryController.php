<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Category;

class CategoryController extends ApiController
{

    public function index()
    {
        $categories = Category::all();
        return $this->showAll($categories);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
        ];

        $this->validate($request, $rules);

        $newCategory = Category::create($request->all());

        return $this->showOne($newCategory, 201);
    }

    public function show(Category $category)
    {
        return $this->showOne($category);
    }

    public function update(Request $request, Category $category)
    {
        $category->fill($request->only([
            'name',
            'description'
        ]));

        if ($category->isClean()) {
            return $this->errorResponse('You need to specify at any different value', 422);
        }

        $category->save();
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return $this->showOne($category);
    }
}
