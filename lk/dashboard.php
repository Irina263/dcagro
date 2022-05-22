<?php
    //Проверка на авторизацию
    if (!isset($_SESSION['user'])) {
        header('Location: /lk');
    }
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Корзина</title>
        <link rel="stylesheet" href="../css/style.css">
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    </head>
    <body class="dash_b">
        <section class="preheader_section">
            <div class="wrapper">
                <div class="preheader">
                    <?php require '../preheader.php'; ?>
                </div>
            </div>
        </section>
        <section class="dashboard_section">
            <div class="wrapper">
                <div class="dashboard">
                    <div class="d_user">
                        <h2 class="du_h2">Информация заказчика</h2>
                        <input id="name" class="du_input" type="text" placeholder="Имя" onchange="ajax_change_name()">
                        <input id="surname" class="du_input" type="text" placeholder="Фамилия" onchange="ajax_change_surname()">
                        <input id="phone" class="du_input" type="text" placeholder="Телефон" onchange="ajax_change_phone()">
                        <input id="email" class="du_input" type="text" placeholder="Email" onchange="ajax_change_email()">
                        <h2 class="dui_h2" style="margin-top: 10px;">Куда доставить?</h2>
                        <input id="sity" class="du_input" type="text" placeholder="Населенный пункт">
                        <input id="street" class="du_input" type="text" placeholder="Улица, дом (, квартира)">
                        <input id="index" class="du_input" type="text" placeholder="Индекс">
                    </div>
                    <div class="d_items">
                        <div class="d_cart">
                            <h2 class="dc_h2">Корзина</h2>
                                <!-- AJAX ответ -->
                        </div>
                        <div class="d_itog">
                            <h2 class="di_h2">Итого: <span id="sum">0</span> ₽</h2>
                            <button class="di_button" onclick="ajax_order()">Заказать</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script>
            function ajax_cart() {
                console.log('[ПК -> Сервер] Проверка корзины на наличие товара...');
                $.ajax({
                    url: '/api/',
                    method: 'get',
                    dataType: 'json',
                    data: {query: 'cart'},
                    success: function(data) {
                        $('.d_cart').empty();
                        $('.d_cart').append('<h2 class="dc_h2">Корзина</h2>');
                        console.log('[Сервер -> ПК] Товары из корзины получены');
                        var i = 0;
                        for (i in data['cart']) {
                            console.log('[ПК -> ПК] Вывод товара из корзины (карточка)');
                            $('.d_cart').append('<div class="dc_product"><h3 class="dcp_h3">' + data['cart'][i]['name'] + '</h3><div class="dcp_count"><p class="dcpc_p">' + data['cart'][i]['price'] + ' ₽</p><button class="dcpc_button" onclick="button_minus(' + data['cart'][i]['id'] + ')">-</button><div class="dcpc_count">' + data['cart'][i]['count'] + '</div><button class="dcpc_button" onclick="button_plus(' + data['cart'][i]['id'] + ')">+</button></div></div>');
                        }
                    }
                });

                console.log('[ПК -> Сервер] Запрос на итогувую стоимость корзины...');
                $.ajax({
                    url: '/api/',
                    method: 'get',
                    dataType: 'json',
                    data: {query: 'sum_cart'},
                    success: function(data) {
                        console.log('[Сервер -> ПК] Итоговая сумма получена');
                        $('#sum').empty();
                        $('#sum').text(data['sum']);
                    }
                });
            }

            function button_minus(id_product) {
                console.log('[ПК -> Сервер] Запрос на -1 из количества товара...');
                $.ajax({
                    url: '/api/',
                    method: 'get',
                    dataType: 'json',
                    data: {query: 'minus_products_cart', id_product: id_product},
                    success: function(data) {
                        console.log('[Сервер -> ПК] Запрос обработан');
                        ajax_cart();
                    }
                });
            }
            function button_plus(id_product) {
                console.log('[ПК -> Сервер] Запрос на +1 из количества товара...');
                $.ajax({
                    url: '/api/',
                    method: 'get',
                    dataType: 'json',
                    data: {query: 'plus_products_cart', id_product: id_product},
                    success: function(data) {
                        console.log('[Сервер -> ПК] Запрос обработан');
                        ajax_cart();
                    }
                });
            }

            function ajax_userinfo() {
                console.log('[ПК -> Сервер] Запрос информации пользователя ...');
                $.ajax({
                    url: '/api/',
                    method: 'get',
                    dataType: 'json',
                    data: {query: 'user_info'},
                    success: function(data) {
                        console.log('[Сервер -> ПК] Данные пользователя получены');
                        $('#name').val(data['user']['name']);
                        $('#surname').val(data['user']['surname']);
                        $('#phone').val(data['user']['phone']);
                        $('#email').val(data['user']['email']);
                    }
                });
            } 

            function ajax_change_name() {
                console.log('[ПК -> Сервер] Запрос на сохранение нового имени ...');
                var error = '';
                var name = document.querySelector('#name').value;

                if (name == '') {
                    error = 'Поле Имя не должно быть пустым! Введите имя!';
                }

                if (error == '') {
                    $.ajax({
                        url: '/api/',
                        method: 'post',
                        dataType: 'json',
                        data: {query: 'change_name', name: name},
                        success: function(data) {
                            console.log('[Сервер -> ПК] Имя сохранено');
                            $('.du_h2').empty();
                            $('.du_h2').append('<span style="color: #31a92f">Сохранено</span>');
                            setTimeout(function() {
                                $('.du_h2').empty();
                                $('.du_h2').text('Информация заказчика');
                            }, 2000);
                            ajax_userinfo();
                        }
                    });
                } else {
                    alert(error);
                    ajax_userinfo();
                }
            }

            function ajax_change_surname() {
                console.log('[ПК -> Сервер] Запрос на сохранение новой фамилии ...');
                var error = '';
                var surname = document.querySelector('#surname').value;

                if (surname == '') {
                    error = 'Поле Фамилия не должно быть пустым! Введите фамилию!';
                }

                if (error == '') {
                    $.ajax({
                        url: '/api/',
                        method: 'post',
                        dataType: 'json',
                        data: {query: 'change_surname', surname: surname},
                        success: function(data) {
                            console.log('[Сервер -> ПК] Фамилия сохранена');
                            $('.du_h2').empty();
                            $('.du_h2').append('<span style="color: #31a92f">Сохранено</span>');
                            setTimeout(function() {
                                $('.du_h2').empty();
                                $('.du_h2').text('Информация заказчика');
                            }, 2000);
                            ajax_userinfo();
                        }
                    });
                } else {
                    alert(error);
                    ajax_userinfo();
                }
            }

            function ajax_change_phone() {
                console.log('[ПК -> Сервер] Запрос на сохранение нового телефона ...');
                var error = '';
                var phone = document.querySelector('#phone').value;

                if (phone == '') {
                    error = 'Поле Телефон не должно быть пустым! Введите телефон!';
                }

                if (error == '') {
                    $.ajax({
                        url: '/api/',
                        method: 'post',
                        dataType: 'json',
                        data: {query: 'change_phone', phone: phone},
                        success: function(data) {
                            console.log('[Сервер -> ПК] Телефон сохранен');
                            $('.du_h2').empty();
                            $('.du_h2').append('<span style="color: #31a92f">Сохранено</span>');
                            setTimeout(function() {
                                $('.du_h2').empty();
                                $('.du_h2').text('Информация заказчика');
                            }, 2000);
                            ajax_userinfo();
                        }
                    });
                } else {
                    alert(error);
                    ajax_userinfo();
                }
            }

            function ajax_change_email() {
                console.log('[ПК -> Сервер] Запрос на сохранение новой почты ...');
                var error = '';
                var email = document.querySelector('#email').value;

                if (email == '') {
                    error = 'Поле E-mail не должно быть пустым! Введите E-mail!';
                }

                if (error == '') {
                    $.ajax({
                        url: '/api/',
                        method: 'post',
                        dataType: 'json',
                        data: {query: 'change_email', email: email},
                        success: function(data) {
                            console.log('[Сервер -> ПК] Почта сохранена');
                            $('.du_h2').empty();
                            $('.du_h2').append('<span style="color: #31a92f">Сохранено</span>');
                            setTimeout(function() {
                                $('.du_h2').empty();
                                $('.du_h2').text('Информация заказчика');
                            }, 2000);
                            ajax_userinfo();
                        }
                    });
                } else {
                    alert(error);
                    ajax_userinfo();
                }
            }
            
            function ajax_order() {
                var error = '';
                var sity = document.querySelector('#sity').value;
                var street = document.querySelector('#street').value;
                var index = document.querySelector('#index').value;

                if (sity == '') {
                    error = 'Поле Город не должно быть пустым! Введите город!';
                }
                if (street == '') {
                    error = 'Поле Улица не должно быть пустым! Введите улицу!';
                }
                if (index == '') {
                    error = 'Поле Индекс не должно быть пустым! Введите индекс!';
                }


                if (error == '') {
                    console.log('[ПК -> Сервер] Проверка на наличие товара в корзине...');
                    $.ajax({
                        url: '/api/',
                        method: 'get',
                        dataType: 'json',
                        data: {query: 'cart'},
                        success: function(data) {
                            if (data['cart'].length <= 0) {
                                alert('Ошибка формирования заказа. Ваша корзина пустая!');
                                console.log('[Сервер -> ПК] Ошибка формирования заказа. Ваша корзина пустая!');
                            } else {
                                console.log('[ПК -> Сервер] Формирование заказа...');
                                $.ajax({
                                    url: '/api/',
                                    method: 'POST',
                                    dataType: 'json',
                                    data: {query: 'add_order', sity: sity, street: street, index: index},
                                    success: function(data) {
                                        $(location).attr('href', '/lk?page=order_history');
                                    }
                                });
                            }
                        }
                    });
                } else {
                    alert('Вы не указали адрес доставки: ' + error);
                }
            }

            ajax_cart();
            ajax_userinfo();
        </script>
    </body>
</html>