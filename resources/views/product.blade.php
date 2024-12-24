<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Продукты</title>
</head>
<body> 
<div class="container mt-5">
    <!-- Блок с кнопками входа и выхода -->
    <div class="mb-4">
        @auth
            <!-- Кнопка для выхода -->
            <a href="#" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выход</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

            <!-- Кнопка "Мои заказы" -->
            <a href="{{ route('index') }}" class="btn btn-secondary">Мои заказы</a>

            <!-- Кнопка "Админ панель", доступная только для администраторов -->
            @if(auth()->user()->is_admin) <!-- Проверяем, является ли пользователь администратором -->
                <a href="{{ route('admin') }}" class="btn btn-warning">Админ панель</a>
            @endif
        @else
            <!-- Кнопка для входа -->
            <a href="{{ route('login') }}" class="btn btn-primary">Вход</a>
        @endauth
    </div>


    <h1 class="mb-4">Список продуктов</h1>

    @if($products->isEmpty())
        <p>Продукты не найдены.</p>
    @else
        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">Цена: <strong>{{ number_format($product->cost, 2) }} руб.</strong></p>
                            <p class="card-text">Количество: {{ $product->amount }} шт.</p>
                            <a href="{{ route('show', $product->id) }}">Подробнее</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
