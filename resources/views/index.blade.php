<!-- resources/views/orders/index.blade.php -->

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ваши заказы</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<a href="{{ route('product') }}" class="btn btn-secondary">Главная</a>
<div class="container">
    <h1>Ваши заказы</h1>

    @if ($orders->isEmpty())
        <p>У вас нет заказов.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Цена</th>
                    <th>Количество</th>
                    <th>Итого</th>
                    <th>Дата создания</th>
                    <th>Статус</th> <!-- Новый столбец для статуса -->
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->cost }}</td>
                        <td>{{ $order->amount }}</td>
                        <td>{{ $order->total_amount }}</td>
                        <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                        
                        <!-- Отображение статуса -->
                        <td>
                            <!-- Можно использовать различные классы Bootstrap для выделения статуса -->
                            @if($order->status == 'new')
                                <span class="badge bg-primary">Новый</span>
                            @elseif($order->status == 'approved')
                                <span class="badge bg-success">Одобрен</span>
                            @elseif($order->status == 'shipped')
                                <span class="badge bg-warning">Отправлен</span>
                            @elseif($order->status == 'delivered')
                                <span class="badge bg-info">Доставлен</span>
                            @else
                                <span class="badge bg-secondary">Неизвестно</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
