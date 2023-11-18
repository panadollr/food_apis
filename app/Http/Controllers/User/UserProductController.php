<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

use App\Models\Product;
use App\Models\Category;

class UserProductController
{
    
    public function getProducts(Request $request){
        $category_id = $request->category_id;
        $type = $request->type;
        $offset = $request->offset ?? 0;
        $limit = $request->limit ?? 12;

        $query = Product::query();

        if ($category_id && Category::find($category_id)) {
            $products = $query->where('category_id', $category_id)->paginate($limit);
        } else if($type == "moi-nhat"){
            $products = $query->orderBy('id','desc')->skip($offset)->take($limit)->get();;
        } else if($type == "ban-chay"){
            $products = $query->join('order_details', 'order_details.product_id', 'products.id')
            ->orderBy('order_details.product_quantity', 'desc')
            ->select('products.id', 'products.name', 'products.images', 'products.old_price', 'products.new_price', 'products.description')
            ->selectRaw('SUM(order_details.product_quantity) as product_quantity')
            ->groupBy('products.id', 'products.name', 'products.images', 'products.old_price', 'products.new_price', 'products.description', 'product_quantity')
            ->skip($offset)->take($limit)->get();
        } else if($type == "sieu-giam-gia") {
            $products = $products->sortByDesc('percent_discount')->values();
        } else {
            $products = $query->paginate(12);
        }

        $newProducts = [];
        $products->each(function ($product) {
            $old_price = $product->old_price;
            $new_price = $product->new_price;
            if($new_price != 0 && $old_price != 0 && $old_price > $new_price){
                $product->percent_discount = strval(round((($old_price - $new_price) / $old_price) * 100)) . "%";
            }
            $product->old_price = number_format($product->old_price, 0, ',', '.') . ' đ';
            $product->new_price = number_format($product->new_price, 0, ',', '.') . ' đ';
        });
           
        return $products;
    }

    public function searchProducts(Request $request){
        $product_name = $request->product_name;
        $existingProducts = Product::where('name', 'LIKE', '%' . $product_name . '%')->get();

        if(count($existingProducts) > 0){
            return ['success' => $existingProducts];
        } else {
            return ['error' => 'Không tìm thấy sản phẩm !'];
        }
    }
  

   
}
