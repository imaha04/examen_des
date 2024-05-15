<?php
// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "test";

// Создание соединения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получение данных из POST-запроса
$sellerAddress = $_POST['sellerAddress'];
$price = $_POST['price'];

// Подготовка и выполнение запроса на вставку данных в базу данных
$sql = "INSERT INTO myTable (seller_address, price) VALUES ('$sellerAddress', '$price')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Закрытие соединения с базой данных
$conn->close();
?>
