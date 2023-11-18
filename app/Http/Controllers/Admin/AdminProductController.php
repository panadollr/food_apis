<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

use App\Models\Product;
use App\Models\OrderDetail;

class AdminProductController
{

    public function getProducts(){
        $products = Product::all();
        $products->each(function ($product) {
            $product->images = json_decode($product->images);
        });
        return $products;
    }
    
    public function addProduct(Request $request){
        $name = $request->name;
        $existingProduct = Product::where('name', $name)->first();
        if($existingProduct){
            return ['error' => 'Tên sản phẩm đã tồn tại !'];
        }
        $newProduct = Product::create([
            'name' => $name,
            'description' => $request->description,
            'image' => $request->image,
            'old_price' => $request->old_price,
            'new_price' => $request->new_price,
            'category_id' => $request->category_id
        ]);

        if($newProduct){
            return response()->json(['success' => 'Thêm sản phẩm thành công !']);
        }else {
            return response()->json(['error' => 'Lỗi !']);
        }
        
    }

    public function deleteProduct($product_id){
        $product = Product::find($product_id);
        $order_detail = OrderDetail::where('product_id', $product_id);
        
        if(!$product){
            return response()->json(['error' => "Sản phẩm không tồn tại !"], 200); 
        }
        
        $product->delete();
        if($order_detail){
            $order_detail->delete();
        }
       
        return response()->json(['success' => "Xóa sản phẩm thành công!"], 200);
    }
   
}
