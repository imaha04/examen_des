<?php
function checkErrors() {
    // Проверяем, был ли запрос методом POST и был ли отправлен файл
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['file'])) {
        echo "";
        return false;
    }

    // Подключаемся к базе данных
    $pdo = new PDO('mysql:host=localhost;dbname=test', 'root', ''); // Укажите свои данные для подключения
    if ($pdo === false) {
        echo "Ошибка подключения к базе данных: " . $pdo->errorInfo()[2];
        return false;
    }

    // Получаем данные из формы и экранируем их
    $sellerAddress = htmlspecialchars($_POST["seller"] ?? null);
    $price = htmlspecialchars($_POST["price"] ?? null);
    $description = htmlspecialchars($_POST["description"] ?? null);

    // Проверяем, все ли данные были переданы
    if ($sellerAddress === null || $price === null || $description === null) {
        echo "Ошибка: Не все данные были переданы.";
        return false;
    }

    // Проверяем, был ли загружен файл и загружен ли он успешно
    if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        echo "Ошибка при загрузке файла.";
        return false;
    }

    // Проверяем, существует ли директория для загрузки файлов
    $uploadDirectory = "uploaded_files/";
    if (!is_dir($uploadDirectory)) {
        echo "Ошибка: Директория для загрузки файлов не существует.";
        return false;
    }

    return true; // Если все проверки пройдены успешно
}

// Проверяем наличие ошибок после выполнения всего кода
if (checkErrors()) {
    echo "Все проверки выполнены успешно. Нет ошибок.";
}
?>


<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Service Marketplace</title>  
    <style>  
        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            padding: 0; 
            background-image: url('https://kartinki.pics/uploads/posts/2021-07/thumbs/1625211858_24-kartinkin-com-p-fon-ucheba-krasivie-foni-25.jpg'); 
            background-size: cover; 
            background-position: center; 
            height: 100vh; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
        } 
 
        .container { 
            width: 400px; 
            padding: 20px; 
            border-radius: 10px; 
            background-color: rgba(255, 255, 255, 0.8); 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); 
        } 
 
        h1 { 
            margin-top: 0; 
            text-align: center; 
            color: #333; 
            font-size: 32px; 
            text-shadow: 2px 2px 2px rgba(0, 0, 0, 0.1); 
        } 
 
        input[type="text"], 
        input[type="file"] { 
            width: 100%; 
            padding: 10px; 
            margin-top: 10px; 
            border: none; 
            border-radius: 5px; 
            box-sizing: border-box; 
            font-size: 16px; 
        } 
 
        input[type="text"]:focus, 
        input[type="file"]:focus { 
            outline: none; 
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2); 
        } 
 
        .file-input-container { 
            position: relative; 
            margin-top: 10px; 
        } 
 
        .file-input { 
            position: absolute; 
            left: 0; 
            top: 0; 
            opacity: 0; 
        } 
 
        .file-label { 
            background-color: #007bff; 
            color: #fff; 
            padding: 10px 15px; 
            border-radius: 5px; 
            cursor: pointer; 
            display: inline-block; 
        } 
 
        .file-label:hover { 
            background-color: #0056b3; 
        } 
 
        .upload-button { 
            background-color: #28a745; 
            color: #fff; 
            padding: 10px 15px; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            display: block; 
            width: 100%; 
            margin-top: 10px; 
            transition: background-color 0.3s ease; 
        } 
 
        .upload-button:hover { 
            background-color: #218838; 
        } 

        #output { 
            margin-top: 10px; 
            font-size: 16px; 
            color: #dc3545; 
        }
        #uploadProgress { 
            width: 50%; 
            height: 10px; 
            background-color: #007bff; 
            border-radius: 5px; 
            margin-top: 10px; 
            display: none; 
        }  
        #successMessage { 
            display: none; 
            margin-top: 10px; 
            padding: 10px; 
            border-radius: 5px; 
            background-color: #28a745; 
            color: #fff; 
            text-align: center; 
        }  
    </style>  
    <script src="https://cdn.jsdelivr.net/npm/web3@1.5.3/dist/web3.min.js"></script>  
</head>  
<body>
<div class="container"> <!-- Создаем контейнер для содержимого страницы --> 
    <h1>Service Marketplace</h1>  
    <form onsubmit="submitForm(event)" enctype="multipart/form-data" id="uploadForm">
        <input type="text" name="seller" id="sellerWallet" value="0x8dadDF5A2BF8bcCbb0E82BE83f81DaA72E54d985" placeholder="Seller's Wallet Address" readonly>
        <input type="text" name="price" id="price" value="0.001 BNB" placeholder="Price">
        <div class="file-input-container">
            <input type="file" name="file" id="fileInput" class="file-input" required onchange="showUploadProgress()">
            <label for="fileInput" class="file-label">Choose File</label>
        </div>
        <input type="text" name="description" id="description" placeholder="Description">
        <div id="uploadProgress"></div>
        <button type="submit" class="upload-button">Upload File</button>
        <div id="successMessage">File successfully uploaded to the database!</div>
    </form>
</div>

<script>
    async function submitForm(event) {
        event.preventDefault(); // Предотвращаем стандартное поведение отправки формы

        // Соединяемся с MetaMask
        await connectMetaMask();

        // Функция для подключения к MetaMask
        async function connectMetaMask() {  
            if (window.ethereum) {  
                window.web3 = new Web3(ethereum);  
                try {  
                    accounts = await ethereum.request({ method: 'eth_requestAccounts' });  
                    alert("MetaMask connected!");  
                } catch (error) {  
                    console.error("User denied account access");  
                }  
            } else {  
                console.log('Non-Ethereum browser detected. You should consider trying MetaMask!');  
            }  
        }

        // Получаем адрес продавца и цену
        const sellerAddress = document.getElementById("sellerWallet").value;
        const price = document.getElementById("price").value;

        // Функция для отправки транзакции
        async function sendTransaction(sellerAddress, price) { 
            try { 
                const priceInBNB = parseFloat(price); // Преобразуем строку в число
                const priceInWei = web3.utils.toWei((priceInBNB * Math.pow(10, 5)).toString(), 'wei'); // Преобразуем цену из BNB в wei

                const transactionParameters = { 
                    to: sellerAddress, 
                    from: accounts[0], 
                    value: priceInWei, // Указываем цену в wei
                }; 

                const transactionHash = await ethereum.request({ 
                    method: 'eth_sendTransaction', 
                    params: [transactionParameters], 
                }); 

                return transactionHash; 
            } catch (error) { 
                console.error('Transaction error:', error); 
                return null; 
            } 
        }

        // Отправляем транзакцию
        const transactionHash = await sendTransaction(sellerAddress, price);

        // Проверяем, успешно ли выполнена транзакция
        if (transactionHash !== null) { 
            // Если транзакция выполнена успешно, собираем данные формы для отправки
            const formData = new FormData(document.getElementById("uploadForm"));

            // Отправляем данные формы, включая файл, на сервер
            fetch('upload_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                // Обрабатываем ответ сервера
                console.log(data);
                // Показываем сообщение об успешной загрузке файла
                document.getElementById("successMessage").style.display = "block";
            })
            .catch(error => {
                console.error('Error:', error);
            });
        } else { 
            alert('Transaction failed.'); // В случае неудачи выводим сообщение об ошибке
        }
    }

    // Функция для отображения прогресса загрузки
    function showUploadProgress() {
        const progressBar = document.getElementById("uploadProgress");
        progressBar.style.display = "block";
    }  
</script>

</body>  
</html>

