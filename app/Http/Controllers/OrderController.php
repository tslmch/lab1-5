<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  // Для работы с авторизацией

class OrderController extends Controller
{
    // Метод для создания заказа
    public function store(Request $request)
    {
        // Проверка, авторизован ли пользователь
        if (!Auth::check()) {
            // Если пользователь не авторизован, перенаправляем на страницу логина с сообщением
            return redirect()->route('login')->with('error', 'Для создания заказа нужно войти в систему.');
        }

        // Валидация входящих данных
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'amount' => 'required|integer|min:1',
        ]);

        // Получаем продукт по его ID
        $product = Product::find($validated['product_id']);

        // Вычисляем общую стоимость
        $totalAmount = $product->cost * $validated['amount'];

        // Создаем новый заказ и связываем его с текущим пользователем
        $order = new Order();
        $order->name = $product->name;  // Название товара
        $order->cost = $product->cost;  // Цена товара
        $order->amount = $validated['amount'];  // Количество товара
        $order->total_amount = $totalAmount;  // Общая сумма
        $order->user_id = Auth::id();  // Связываем заказ с текущим авторизованным пользователем
        $order->save();  // Сохраняем заказ в базе данных

        // Возвращаем пользователя на страницу с сообщением о добавлении товара в корзину
        return redirect()->route('sucsses')->with('sucsses', 'Товар добавлен в корзину');
    }

    // Метод для отображения заказов текущего пользователя
    public function index()
    {
        // Проверка, авторизован ли пользователь
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Пожалуйста, войдите в систему, чтобы увидеть свои заказы.');
        }

        // Получаем все заказы текущего пользователя
        $orders = Order::where('user_id', Auth::id())->latest()->get();

        // Возвращаем представление и передаем туда заказы
        return view('index', compact('orders'));

        
    }


    
}
