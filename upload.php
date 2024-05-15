<?php
// Проверяем, был ли запрос методом POST и был ли отправлен файл
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['file'])) {
    echo "Ошибка: Неверный метод запроса или файл не был отправлен.";
    exit;
}

// Проверяем, был ли загружен файл и загружен ли он успешно
if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    echo "Ошибка при загрузке файла.";
    exit;
}

// Указываем директорию для загрузки файлов
$uploadDirectory = "uploaded_files/";

// Создаем уникальное имя файла для сохранения
$fileName = uniqid() . '_' . $_FILES['file']['name'];
$filePath = $uploadDirectory . $fileName;

// Перемещаем загруженный файл из временной директории на сервер
if (!move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
    echo "Ошибка при перемещении файла на сервер.";
    exit;
}

// Файл успешно загружен, теперь можно сохранить информацию о файле в базе данных

// Подключаемся к базе данных
$pdo = new PDO('mysql:host=localhost;dbname=test', 'root', ''); // Укажите свои данные для подключения

// Переменные из формы
$sellerAddress = $_POST["seller"] ?? null;
$price = $_POST["price"] ?? null;
$description = $_POST["description"] ?? null;

// Генерируем уникальный идентификатор файла
$fileId = uniqid();

// Готовим SQL запрос для вставки данных
$sql = "INSERT INTO uploaded_files (id, seller_address, price, description, file_name, file_path) VALUES (:id, :sellerAddress, :price, :description, :fileName, :filePath)";

// Подготавливаем запрос к выполнению и выполняем его
$stmt = $pdo->prepare($sql);
$stmt->execute([
    'id' => $fileId,
    'sellerAddress' => $sellerAddress,
    'price' => $price,
    'description' => $description,
    'fileName' => $fileName,
    'filePath' => $filePath
]);

// Проверяем результат выполнения запроса
if ($stmt->rowCount() > 0) {
    echo "Файл успешно загружен и сохранен на сервере.";
} else {
    echo "Ошибка при сохранении информации о файле в базе данных.";
}
?>
