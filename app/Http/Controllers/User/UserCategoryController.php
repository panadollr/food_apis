<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Models\Category;

class UserCategoryController
{
    public function getCategories(){
        $categories = Category::all();
        return $categories;
    }
}
