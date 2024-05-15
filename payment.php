<!DOCTYPE html>
<html>
<head>
    <title>Payment</title>
    <!-- Подключение стилей CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url("fon.jpg");
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            background-color: rgba(255, 255, 255, 0.8); /* Прозрачный белый фон */
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        button[type="submit"],
        button[type="button"] {
            padding: 15px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button[type="submit"] {
            background-color: #ff4d4d; /* Красный цвет */
            color: #fff;
            box-shadow: 0 4px #ff3333;
        }

        button[type="submit"]:hover {
            background-color: #ff3333; /* Более темный красный цвет при наведении */
            box-shadow: 0 2px #ff1a1a;
        }

        button[type="button"] {
            background-color: #4CAF50; /* Зеленый цвет */
            color: #fff;
            box-shadow: 0 4px #339933;
        }

        button[type="button"]:hover {
            background-color: #45a049; /* Более темный зеленый цвет при наведении */
            box-shadow: 0 2px #3c763d;
        }
    </style>
    <link rel="shortcut icon" href="block.png" type="image/x-icon">
    <!-- Подключение библиотеки Web3.js -->
    <script src="https://cdn.jsdelivr.net/npm/web3@1.5.3/dist/web3.min.js"></script>
    <script>
        // Адрес получателя
        var recipient = "0x8dadDF5A2BF8bcCbb0E82BE83f81DaA72E54d985";

        // Функция для отправки транзакции через MetaMask и Binance Smart Chain
        async function sendTransaction() {
            var amount = document.getElementById("amount").value;

            // Проверка, подключен ли MetaMask
            if (typeof window.ethereum === 'undefined') {
                alert("MetaMask не обнаружен. Пожалуйста, установите MetaMask и подключитесь к Binance Smart Chain.");
                return;
            }

            // Запрос разрешения на доступ к аккаунту пользователя
            try {
                const accounts = await window.ethereum.request({ method: 'eth_requestAccounts' });
                const sender = accounts[0]; // Получаем первый адрес аккаунта пользователя
                // Подключение к сети Binance Smart Chain через MetaMask
                const provider = new Web3(window.ethereum);
                window.web3 = new Web3(provider);

                // Конвертация суммы в wei
                var amountWei = window.web3.utils.toWei(amount, 'ether');

                // Отправка транзакции
                try {
                    await window.web3.eth.sendTransaction({
                        from: sender, // Указываем адрес отправителя
                        to: recipient,
                        value: amountWei
                    });
                    alert("Транзакция успешно отправлена.");
                    // Показать кнопку для скачивания документа
                    document.getElementById("downloadButton").style.display = "inline";
                } catch (error) {
                    alert("Ошибка отправки транзакции: " + error.message);
                }
            } catch (error) {
                alert("Не удалось получить доступ к аккаунту MetaMask: " + error.message);
                return;
            }
        }

        // Функция для скачивания документа
        function downloadDocument() {
            // Создание ссылки на скачивание документа
            var link = document.createElement("a");
            link.href = "http://project.local/uploaded_files/6640d2f8d9eb9_СРС 2.docx"; // Абсолютный путь к файлу на сервере
            link.download = "СРС 2.docx"; // Имя файла при скачивании
            document.body.appendChild(link);
            link.click(); // Запуск скачивания
        }
    </script>
</head>
<body>
    <div class="container">
        <!-- Форма для отправки транзакции -->
        <form id="sendTransactionForm" onsubmit="event.preventDefault(); sendTransaction();" enctype="multipart/form-data">
            <label for="amount">Amount:</label>
            <br>
            <input type="text" name="amount" id="amount">
            <br><br>
            <!-- Кнопка для отправки транзакции -->
            <button type="submit">Pay</button>
        </form>
        <!-- Кнопка для скачивания документа -->
        <button id="downloadButton" type="button" onclick="downloadDocument()" style="display: none;">Скачать</button>
    </div>
</body>
</html>
