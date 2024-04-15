<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Калькулятор кредита и каталог товаров</title>
    <!-- Подключение Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* CSS */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }

        .container {
            margin-top: 20px;
        }

        .product {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 10px;
            text-align: center;
            background-color: #fff;
        }

        .product h2 {
            color: #007bff;
        }

        .product p {
            font-size: 16px;
        }

        .cart {
            margin-top: 20px;
        }

        .cart h2 {
            color: #007bff;
        }

        .cart ul {
            list-style: none;
            padding: 0;
        }

        .cart li {
            margin-bottom: 10px;
        }

        .cart-total {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Каталог товаров Apple и калькулятор кредита</h1>
        <div class="row">
            <div class="col-md-3">
                <div class="product">
                    <h2>iPhone 13 Pro Max</h2>
                    <p>Цена: 474 370 ₸</p>
                    <button class="btn btn-primary add-to-cart" data-name="iPhone 13 Pro Max" data-price="474370">Добавить в корзину</button>
                </div>
            </div>
            <div class="col-md-3">
                <div class="product">
                    <h2>AirPods Pro</h2>
                    <p>Цена: 107 170 ₸</p>
                    <button class="btn btn-primary add-to-cart" data-name="AirPods Pro" data-price="107170">Добавить в корзину</button>
                </div>
            </div>
            <div class="col-md-3">
                <div class="product">
                    <h2>MacBook Pro</h2>
                    <p>Цена: 558 870 ₸</p>
                    <button class="btn btn-primary add-to-cart" data-name="MacBook Pro" data-price="558870">Добавить в корзину</button>
                </div>
            </div>
            <div class="col-md-3">
                <div class="product">
                    <h2>iPad Air</h2>
                    <p>Цена: 257 170 ₸</p>
                    <button class="btn btn-primary add-to-cart" data-name="iPad Air" data-price="257170">Добавить в корзину</button>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-6">
                <div class="cart">
                    <h2 class="text-center mb-4">Корзина</h2>
                    <ul id="cart-items"></ul>
                    <div class="cart-total">Общая стоимость: <span id="cart-total">0</span> ₸</div>
                </div>
            </div>
            <div class="col-md-6">
                <h1 class="text-center mb-4">Калькулятор кредита</h1>
                <form id="creditCalculator">
                    <div class="form-group">
                        <label for="totalPrice">Общая стоимость товаров:</label>
                        <input type="text" id="totalPrice" name="totalPrice" class="form-control" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="discount">Скидка (%):</label>
                        <input type="text" id="discount" name="discount" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="term">Срок кредита (в месяцах):</label>
                        <input type="text" id="term" name="term" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="interestRate">Процентная ставка (%):</label>
                        <input type="text" id="interestRate" name="interestRate" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Рассчитать</button>
                    <button type="button" id="resetButton" class="btn btn-secondary ml-2">Сбросить результаты</button>
                </form>

                <div class="result mt-4">
                    <h2>Результаты расчета:</h2>
                    <div id="loanAmount"></div>
                    <div id="monthlyPayment"></div>
                    <div id="overpayment"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Подключение Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Функция для обновления общей стоимости товаров
        function updateTotalPrice() {
            var total = 0;
            $('.cart-item').each(function() {
                total += parseFloat($(this).data('price'));
            });
            $('#totalPrice').val(total.toFixed(2)); // Обновляем значение поля "Общая стоимость товаров"
        }

        // Функция для обновления общей стоимости товаров в корзине
        function updateCartTotal() {
            var total = 0;
            $('.cart-item').each(function() {
                total += parseFloat($(this).data('price'));
            });
            $('#cart-total').text(total.toFixed(2));
        }

        // Добавляем функционал для добавления товаров в корзину
        $('.add-to-cart').click(function() {
            var itemName = $(this).data('name');
            var itemPrice = parseFloat($(this).data('price'));
            var li = $('<li class="cart-item">').text(itemName + ': ' + itemPrice.toLocaleString('ru-RU') + ' ₸');
            li.data('price', itemPrice);
            li.append('<button class="btn btn-danger btn-sm ml-2 remove-from-cart">Удалить</button>');
            $('#cart-items').append(li);
            updateCartTotal();
            updateTotalPrice(); // Обновляем общую стоимость товаров
        });

        // Обработчик события для кнопки удаления товара из корзины
        $('#cart-items').on('click', '.remove-from-cart', function() {
            $(this).parent().remove();
            updateCartTotal();
            updateTotalPrice(); // Обновляем общую стоимость товаров при удалении товара из корзины
        });

        // Обработчик события для кнопки сброса результатов
        $('#resetButton').click(function() {
            $('#loanAmount').text('');
            $('#monthlyPayment').text('');
            $('#overpayment').text('');
        });

        // Обработчик отправки формы калькулятора
        $('#creditCalculator').submit(function(event) {
            event.preventDefault(); // Отменяем стандартное поведение формы

            // Получаем значения из формы
            var totalPrice = parseFloat($('#totalPrice').val());
            var discount = parseFloat($('#discount').val()) || 0;
            var term = parseInt($('#term').val());
            var interestRate = parseFloat($('#interestRate').val());

            // Выполняем вычисления
            var loanAmount = totalPrice * (1 - discount / 100);
            var monthlyRate = interestRate / 100 / 12;
            var monthlyPayment = loanAmount * monthlyRate / (1 - Math.pow(1 + monthlyRate, -term));
            var overpayment = monthlyPayment * term - loanAmount;

            // Отображаем результаты на странице
            $('#loanAmount').text('Сумма кредита после учета скидки: ' + loanAmount.toLocaleString('ru-RU') + ' ₸');
            $('#monthlyPayment').text('Ежемесячный платеж: ' + monthlyPayment.toLocaleString('ru-RU') + ' ₸');
            $('#overpayment').text('Переплата: ' + overpayment.toLocaleString('ru-RU') + ' ₸');
        });
    </script>
</body>
</html>
