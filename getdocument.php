<?php
    header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог товаров</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: rgba(244, 244, 244, 0.7); /* Прозрачный серый фон */
        }

        .container {
            display: flex;
            justify-content: space-around;
            align-items: flex-start;
            margin-top: 50px;
        }

        .product {
            width: 30%;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9); /* Еще более прозрачный белый цвет */
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
            height: 500px; /* Увеличение высоты блока */
            position: relative; /* Добавление позиционирования */
        }

        .product img {
            width: 100%;
            height: 300px; /* Высота изображения */
            object-fit: cover; /* Растягивание изображения на весь блок */
            border-radius: 8px; /* Закругление углов */
            margin-bottom: 10px; /* Отступ между изображением и текстом */
        }

        .product h2 {
            color: #333;
            margin-top: 10px; /* Дополнительный отступ для заголовка */
        }

        .product p {
            color: #666;
        }

        .buy-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: transform 0.3s ease; /* Добавление анимации */
            position: absolute; /* Позиционирование кнопки */
            bottom: 30px; /* Отступ от нижнего края */
            left: 50%; /* Центрирование по горизонтали */
            transform: translateX(-50%); /* Смещение влево на 50% ширины */
        }

        .buy-button:hover {
            background-color: #0056b3;
            transform: translateX(-50%) translateY(-5px); /* Смещение влево и вверх при наведении */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="product">
            <img src="zhelti.jpg" alt="Товар 1">
            <h2>Товар 1</h2>
            <p>Описание товара 1.</p>
            <p>Цена: $10</p>
            <a href="payment.php" class="buy-button">Buy</a>
        </div>
        <div class="product">
            <img src="zeleni.jpg" alt="Товар 2">
            <h2>Товар 2</h2>
            <p>Описание товара 2.</p>
            <p>Цена: $20</p>
            <a href="payment.php" class="buy-button">Buy</a>
        </div>
        <div class="product">
            <img src="krasni.jpg" alt="Товар 3">
            <h2>Товар 3</h2>
            <p>Описание товара 3.</p>
            <p>Цена: $30</p>
            <a href="payment.php" class="buy-button">Buy</a>
        </div>
    </div>
</body>
</html>
