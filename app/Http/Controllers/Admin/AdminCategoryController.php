<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Category;

class AdminCategoryController
{
    public function getCategories(){
        $categories = Category::all();
        return $categories;
    }
    
    public function addCategory(Request $request){
        $name = $request->name;
        $image = $request->image;
        $existingCategory = Category::where('name', $name)->first();
        if($existingCategory){
            return ['error' => 'Danh mục đã tồn tại !'];
        }
        $category = Category::create(['name' => $name, 'image' => $image]);

        if($category){
            return ['success' => 'Thêm danh mục thành công !'];
        }
    }

}
