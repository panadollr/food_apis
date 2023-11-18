<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Models\Order;

class AdminOrderController
{
    public function getOrders(Request $request){
        $status = $request->status;
        $offset = $request->offset ?? 0;
        $limit = $request->limit ?? 12;
        $query = Order::query()->orderBy('order_id','desc');

         if($status){
            $orders = $query->where('status', $status)->skip($offset)->take($limit)->get();;
        } else {
            $orders = $query->paginate($limit);
        }
           
        return $orders;
    }

    public function updateOrderStatus(Request $request){
        $order_id = $request->order_id;
        $query = Order::query()->where('order_id', $order_id);
        $order = $query->first();
        $order_status = $order->order_status;
        
        if ($order_status >= 0 && $order_status < 2) {
            $result = $query->update(['order_status' => $order_status + 1]);
    
            if ($result) {
                return ['success' => "Cập nhật tình trạng đơn hàng thành công!"];
            } else {
                return ['error' => "Không thể cập nhật tình trạng đơn hàng."];
            }
        } else {
            return ['error' => "Không thể cập nhật tình trạng đơn hàng."];
        }
    }

}
