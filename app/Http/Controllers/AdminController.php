<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;  // Подключаем модель Product для получения данных о товаре
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    // Метод для отображения страницы администратора и всех заказов
    public function index()
    {
        // Проверка, является ли пользователь администратором
        if (!Auth::user()->is_admin) {
            return redirect('/')->with('error', 'У вас нет прав доступа к этой странице.');
        }

        // Получаем все заказы
        $orders = Order::all();
        return view('admin', compact('orders'));
    }

    // Метод для обновления статуса заказа
    public function updateStatus(Request $request, Order $order)
    {
        // Валидация входных данных
        $validated = $request->validate([
            'status' => 'required|in:new,approved,delivered',
        ]);

        // Логирование запроса для отслеживания изменений
        \Log::info('Attempting to update order status', [
            'order_id' => $order->id,
            'new_status' => $request->status,
            'current_status' => $order->status
        ]);

        // Логика проверки наличия товара на складе
        if ($request->status == 'approved' && $order->status == 'new') {
            // Проверка наличия товара на складе
            if ($order->quantity <= $this->getStockQuantity($order->product_name)) {
                // Изменение статуса на "approved"
                $order->status = 'approved';
                \Log::info('Order status updated to approved', ['order_id' => $order->id]);
            } else {
                // Если товара недостаточно на складе
                \Log::warning('Insufficient stock for order approval', ['order_id' => $order->id, 'required_quantity' => $order->quantity]);
                return back()->with('error', 'На складе недостаточно товара.');
            }
        } elseif ($request->status == 'delivered' && $order->status == 'approved') {
            // Изменение статуса на "delivered"
            $order->status = 'delivered';
            \Log::info('Order status updated to delivered', ['order_id' => $order->id]);
        } else {
            // Если статус заказа не соответствует допустимым изменениям
            \Log::warning('Invalid status change attempt', ['order_id' => $order->id, 'requested_status' => $request->status]);
            return back()->with('error', 'Статус заказа не может быть изменен.');
        }

        // Сохраняем изменения
        try {
            $order->save();
            \Log::info('Order status successfully saved', ['order_id' => $order->id]);
        } catch (\Exception $e) {
            // Логирование ошибок при сохранении
            \Log::error('Error saving order status', ['order_id' => $order->id, 'error' => $e->getMessage()]);
            return back()->with('error', 'Ошибка при сохранении изменений.');
        }

        // Возвращаемся с сообщением об успехе
        return back()->with('success', 'Статус заказа изменен.');
    }

    // Метод для получения количества товара на складе по имени продукта
    public function getStockQuantity($productName)
    {
        // Ищем продукт по имени
        $product = Product::where('name', $productName)->first();

        // Если продукт найден, возвращаем его количество на складе
        if ($product) {
            return $product->stock_quantity;
        }

        // Если продукт не найден, возвращаем 0 или другую логику
        return 0;
    }
}
