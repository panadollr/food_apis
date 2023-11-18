<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Shipping;
use App\Models\AtmPayment;
use App\Models\Product;

class UserOrderController
{
    
    public function submitReferralCode(Request $request){
        $referralCode = $request->referral_code;
        $existingUser = User::where('referral_code', $referralCode)->first();
        if($existingUser){
            return ['success' => "Mã giới thiệu của tài khoản có số điện thoại: 0$existingUser->phone" ];
        }else {
            return ['error' => "Mã giới thiệu không tồn tại !"];
        }
    }
    

    public function order(Request $request){
        $customMessages = [
            'required' => ':attribute là bắt buộc, không được để trống !',
            'regex' => ':attribute không hợp lệ.',
            'unique' => ':attribute đã tồn tại trong hệ thống.',
            'min' => ':attribute phải có ít nhất :min ký tự.',
        ];

        $customAttributes = [
            'shipping_name' => 'Họ và tên',
            'shipping_phone' => 'Số điện thoại',
            'shipping_address' => 'Địa chỉ giao hàng',
            'shipping_note' => 'Ghi chú đơn hàng'
        ];
        
        $validator = Validator::make($request->all(), [
            'shipping_name' => 'required|string',
            'shipping_phone' => ['required', 'regex:/^(\+84|0)[3|5|7|8|9][0-9]{8}$/'],
            'shipping_address' => 'required|string',
            'shipping_note' => 'required|string',
        ], $customMessages, $customAttributes);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Order
        $payment_method_id = $request->payment_method_id;
    
        if ($payment_method_id == 2) {
            $newAtmPayment = AtmPayment::create([
                'card_holder_name' => $request->card_holder_name,
                'card_number' => $request->card_number,
                'expiration_date' => $request->expiration_date,
                'security_code' => $request->security_code
            ]);
     
        } else {
            $newOrder = Order::create([
            'payment_method_id' => $payment_method_id,
            'order_total' => $request->order_total,
            'order_status' => 1,
            ]);
            $newOrderId = $newOrder->order_id;
    
            // Order Detail
            $carts = [
                ['id' => 1, 'quantity' => 20],
                ['id' => 2, 'quantity' => 3],
                ['id' => 3, 'quantity' => 10],
                ['id' => 4, 'quantity' => 6],
            ];
    
            $orderDetails = [];
            foreach ($carts as $cart) {
                $orderDetails[] = [
                    'order_id' => $newOrderId,
                    'product_id' => $cart['id'],
                    'product_quantity' => $cart['quantity'],
                ];
            }
            OrderDetail::insert($orderDetails);
    
            // Shipping
            $newShipping = Shipping::create([
                'order_id' => $newOrderId,
                'shipping_name' => $request->shipping_name,
                'shipping_phone' => $request->shipping_phone,
                'shipping_address' => $request->shipping_address,
                'shipping_note' => $request->shipping_note,
            ]);
    
                       
        }
    
        return ['success' => 'Đặt hàng thành công !'];
    }
    
}
