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
        $existingCategory = Category::where('name', $name)->first();
        
        if($existingCategory){
            return ['error' => 'Danh mục đã tồn tại !'];
        }

        $category = Category::create(['name' => $name, 'image' => 'public/category_images/' . $new_image,]);

        if($category){
            return ['success' => 'Thêm danh mục thành công !'];
        }
        // }
    }

    public function updateCategory(Request $request){
        $id = $request->id;
        $name = $request->name;
        $image = $request->image;
        $existingCategory = Category::find($id);
        
        $oldImagePath = public_path($existingCategory->image);
        if (file_exists($oldImagePath)) {
        unlink($oldImagePath);
        }

        $get_image= $request-> file('image');
        $new_image =rand(0,99).'.'.$get_image->getClientOriginalExtension();
        $get_image->move('category_images/',$new_image);

        $existingCategory::update(['name' => $name, 'image' => 'category_images/' . $new_image,]);

        if($category){
            return ['success' => 'Thêm danh mục thành công !'];
        }
    }

    public function deleteCategory($id){
        Category::find($id)->delete();
        return response()->json(['success' => "Xóa danh mục thành công"], 200);
    }

}
