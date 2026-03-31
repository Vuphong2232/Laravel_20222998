<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(5);
        return view('products.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category' => 'required'
        ]);

        Product::create($request->all());

        return back()->with('success', 'Thêm sản phẩm thành công');
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        $product->update([
            'quantity' => $request->quantity
        ]);

        return back()->with('success', 'Cập nhật tồn kho');
    }

    public function destroy($id)
    {
        Product::destroy($id);
        return back()->with('success', 'Đã xóa');
    }
}