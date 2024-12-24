<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<a href="{{ route('product') }}" class="btn btn-secondary">Главная</a>
<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ $product->name }}</h5>
        <p class="card-text">Доступно на складе: {{ $product->amount }}</p>
        <h3 class="card-text text-success">{{ $product->cost }} руб.</h3>

        <!-- Форма заказа -->
        <form action="{{ route('store') }}" method="POST">
            @csrf
            <!-- Передача id продукта -->
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <div class="form-group">
                <label for="amount">Количество:</label>
                <input type="number" name="amount" id="amount" class="form-control" value="1" min="1" max="{{ $product->amount }}" required>
            </div>

            <div class="form-group mt-3">
                <label for="total_amount">Общая стоимость:</label>
                <input type="text" id="total_amount" class="form-control" value="{{ $product->cost }}" disabled>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Добавить в корзину</button>
        </form>
    </div>
</div>

<!-- Скрипт для вычисления общей стоимости -->
<script>
    document.getElementById('amount').addEventListener('input', function () {
        const price = parseFloat("{{ $product->cost }}"); // Парсим цену как число с плавающей точкой
        const amount = parseInt(this.value, 10); // Преобразуем введенное количество в целое число

        // Проверка на правильность ввода количества
        if (!isNaN(amount) && amount > 0) {
            const totalAmount = price * amount;
            document.getElementById('total_amount').value = totalAmount.toFixed(2); // Форматируем с двумя знаками после запятой
        } else {
            document.getElementById('total_amount').value = '0.00'; // Если введено некорректное количество, показываем 0
        }
    });
</script>

</body>
</html>
