<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Outlet;

class OutletController extends Controller
{
        public function orders()
    {
        $orders = Order::with('items')
                        ->where('outlet_id', auth()->user()->outlet_id)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('outlet.orders', compact('orders'));
    }


   public function acceptOrder(Request $request)
{
    try {
        $order = Order::where('id', $request->order_id)
                      ->where('outlet_id', auth()->user()->outlet_id)
                      ->firstOrFail();

        $order->status = 'processing'; 
        $order->save();

        return response()->json(['success' => true, 'message' => 'Order accepted', 'order' => $order]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}


    public function transferOrder(Request $request)
    {
        $order = Order::where('id', $request->order_id)
                      ->where('outlet_id', auth()->user()->outlet_id)
                      ->firstOrFail();
        $order->outlet_id = $request->new_outlet_id;
        $order->status='transfered';
        $order->save();

        return response()->json(['success' => true, 'message' => 'Order transferred']);
    }

    public function cancelOrder(Request $request)
    {
        $order=Order::find($request->order_id);
        $order->status='cancelled';
        $order->save();
         return response()->json(['success' => true, 'message' => 'Order Cancelled']);
    }
}
