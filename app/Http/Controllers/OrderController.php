<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class OrderController extends Controller
{
    public function index()
{
    $orders = Order::latest()->paginate(5);
    $orders = Order::with('items.product')->paginate(5);
    $products = Product::all(); 

    return view('orders.index', compact('orders', 'products'));
}

    public function create()
    {
        $products = Product::all();
        return view('orders.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'products' => 'required'
        ]);

        if (count($request->products) == 0) {
            return back()->with('error', 'Đơn hàng không được rỗng');
        }

        $order = Order::create([
            'customer_name' => $request->customer_name,
            'status' => 'pending',
            'total' => 0
        ]);

        $total = 0;

        foreach ($request->products as $id => $qty) {
            if ($qty > 0) {
                $product = Product::find($id);

                $subtotal = $product->price * $qty;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $qty,
                    'price' => $product->price
                ]);

                $total += $subtotal;
            }
        }

        // ❌ nếu không có sản phẩm nào
        if ($total == 0) {
            $order->delete();
            return back()->with('error', 'Đơn hàng rỗng');
        }

        $order->update(['total' => $total]);

        return redirect()->route('orders.index')->with('success', 'Tạo đơn thành công');
    }

    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    public function updateStatus($id, $status)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => $status]);

        return back();
    }
}