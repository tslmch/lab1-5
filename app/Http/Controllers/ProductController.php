<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('product', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'amount' => 'required|integer|min:0',
        ]);

        // Создание нового продукта
        Product::create([
            'name' => $validated['name'],
            'cost' => $validated['cost'],
            'amount' => $validated['amount'],
        ]);

    }
    public function show($id)
    {
        $product = Product::findOrFail($id);  // Находим товар по ID
        return view('show', compact('product'));  // Отправляем данные о товаре в представление
    }
}
