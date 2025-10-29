<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem; 
use App\Models\Order; 
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = CartItem::with('product')->where('user_id', Auth::id())->get();
        return response()->json(['cart'=>$cart]);
    }

    public function add(Request $request)
{
    try {
        $product = Product::findOrFail($request->product_id);

        // firstOrCreate with default qty
        $cart = CartItem::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $product->id
            ],
            [
                'qty' => 0 // default value for new cart item
            ]
        );

        $cart->qty += 1;
        $cart->save();

        $cart_count = CartItem::where('user_id', Auth::id())->sum('qty');

        return response()->json(['cart_count' => $cart_count]);
    } catch (\Throwable $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}



    public function remove(Request $request)
    {
        CartItem::where('user_id', Auth::id())->where('product_id', $request->product_id)->delete();
        $cart_count = CartItem::where('user_id', Auth::id())->sum('qty');
        return response()->json(['cart_count'=>$cart_count]);
    }

    public function update(Request $request)
    {
        $cart = CartItem::where('user_id', Auth::id())->where('product_id', $request->product_id)->first();
        if($cart){
            $cart->qty = $request->quantity;
            $cart->save();
        }
        $cart_count = CartItem::where('user_id', Auth::id())->sum('qty');
        return response()->json(['cart_count'=>$cart_count]);
    }

     public function checkout()
{
    $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();

    if($cartItems->isEmpty()) {
        return response()->json(['success'=>false,'error'=>'Cart is empty']);
    }

    // Calculate total amount
    $totalAmount = $cartItems->sum(function($item){
        return $item->qty * $item->product->price; // use product price
    });


    $lastOrder = Order::latest()->first();
    $order_no = $lastOrder ? 'ORD-' . str_pad($lastOrder->id + 1, 5, '0', STR_PAD_LEFT) : 'ORD-00001';

    $order = Order::create([
        'order_no' => $order_no,
        'user_id' => Auth::id(),
        'outlet_id' => Auth::user()->outlet_id ?? 1,
        'status' => 'pending',
        'total_amount' => $totalAmount,
    ]);

    // Create order_items
    foreach($cartItems as $item){
        $order->items()->create([
            'product_id' => $item->product_id,
            'qty' => $item->qty,
            'unit_price' => $item->product->price,
        ]);
    }

    CartItem::where('user_id', Auth::id())->delete();

    return response()->json([
        'success' => true,
        'message' => 'Order placed successfully',
        'order_no' => $order_no,
        'order_id' => $order->id
    ]);
}

    public function cartCount()
{
    $count = CartItem::where('user_id', Auth::id())->sum('qty');
    return response()->json(['cart_count' => $count], 200, [], JSON_UNESCAPED_UNICODE);
}

}
