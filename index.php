<?php
    require 'orm/db.php';
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ДЦ Агро - фермерский интернет-магазин</title>
        <link rel="stylesheet" href="css/style.css">
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php if (isset($_SESSION['user_admin'])) : ?>
            <section class="header_admin_section">
                <div class="wrapper">
                    <div class="header_admin">
                        <a class="ha_a" href="/admin">Перейти в панель управления сайтом</a>
                        <div class="ha_admin_info">
                            <p class="hai_name">Администратор: <?php echo $_SESSION['user_admin']->surname ?> <?php echo $_SESSION['user_admin']->name ?></p>
                            <a class="hai_a" href="/admin?logout">Выйти</a>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif ?>
        <section class="preheader_section">
            <div class="wrapper">
                <div class="preheader">
                    <?php require 'preheader.php'; ?>
                </div>
            </div>
        </section>
        <section class="welcome_section">
            <div class="wrapper">
                <div class="welcome">
                    <div class="w_header">
                        <img class="wh_img" src="img/logo.svg">
                        <div class="wh_form">
                            <input class="whf_button" type="submit" value="Каталог" onmouseover="menu_on()" onmouseout="menu_off()">
                            <input class="whf_input" type="text" placeholder="Поиск продуктов">
                            <input class="whf_button" type="submit" value="Найти">
                            <div class="whf_menu_catalog">
                                <div class="whfm_catalog">
                                    <!-- AJAX ответ -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w_text">
                        <h1 class="wt_h1">Натуральные продукты от местных фермеров</h1>
                        <p class="wt_p">Залог качественных и свежих деревенских продуктов на Вашем столе.</p>
                        <a id="button-info" class="wt_a" href="#">Подробнее</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="current_products_section">
            <div class="wrapper">
                <div class="current_products">
                    <!-- AJAX ответ -->
                </div>
            </div>
        </section>
        <section class="info_site_section">
            <div class="wrapper">
                <div class="info_site">
                    <h2 class="is_h2">Фермерские продукты с доставкой на дом</h2>
                    <p class="is_p">Маркетплейс фермерских продуктов dcagro.ru – залог качественных и свежих деревенских продуктов на Вашем столе.</br></br>Свежие овощи и фрукты, парное мясо и молочная продукция от проверенных фермерских хозяйств Вашего региона – все это Вы сможете найти в нашем каталоге.</p></br>
                    <h4>Крафтовые фермерские продукты</h4></br>
                    <p>Предлагаемые Вам деревенские продукты отличаются от масс-маркета свежестью, использованием натуральных ингредиентов и отсутствием в составе консервантов или химических усилителей вкуса.</br></br>Благодаря тому, что продукция изготавливается не в массовом порядке, а часто под конкретный заказ, Вы можете быть уверены в высоком качестве.</br></br>Использование каждым фермером «секретных» рецептов позволяет с новой стороны открыть для себя привычные продукты и блюда.</p>
                </div>
            </div>
        </section>
        <section class="footer_section">
            <div class="wrapper">
                <div class="footer">
                    <p class="f_p">ДЦ Агро - натуральные продукты от местных фермеров</br>г. Пенза, Московская 122Б оф. 304</br>+7 (495) 352-45-54</p>
                </div>
            </div>
        </section>
        <script>
            $.ajax({
                url: '/api/',
                method: 'get',
                dataType: 'json',
                data: {query: 'categories'},
                success: function(data) {
                    $('.whfm_catalog').empty();
                    var i = 0;
                    for (i in data['categories']) {
                        $('.whfm_catalog').append('<a class="whfmc_a" href="/categories?search=' + data['categories'][i]['name'] + '">' + data['categories'][i]['name'] + '</a>');
                    }
                }
            });

            function ajax_products() {
                console.log('[ПК -> Сервер] Запрос продуктов (с лимитом)...');
                $.ajax({
                    url: '/api/',
                    method: 'get',
                    dataType: 'json',
                    data: {query: 'products', limit: 4},
                    success: function(data) {
                        $('.current_products').empty();
                        console.log('[Сервер -> ПК] Продукты получены');
                        var i = 0;
                        for (i in data['products']) {
                            console.log('[ПК -> ПК] Вывод продукта (карточка)');
                            $('.current_products').append('<div class="current_product"><img class="cp_img" src="img/products/' + data['products'][i]['photo'] + '"><div class="cp_info"><div class="cpi_text"><h3 class="cpit_h3">' + data['products'][i]['name'] + '</h3><p class="cpit_p">' + data['products'][i]['fermer'] + '</p></div><div id="div_' + data['products'][i]['id'] + '" class="cpi_price"><div class="cpip_info"><h2 class="cpipi_h2">' + data['products'][i]['price'] + ' ₽</h2><p class="cpipi_p">' + data['products'][i]['size'] + '</p></div><button id="button_' + data['products'][i]['id'] + '" class="cpip_add_cart" onclick="add_cart(' + data['products'][i]['id'] + ')">Добавить в корзину</button></div></div></div>');
                            console.log('[ПК -> Сервер] Проверка на наличие товара в корзине...');
                            $.ajax({
                                url: '/api/',
                                method: 'get',
                                dataType: 'json',
                                data: {query: 'check_add_products_cart', id_product: data['products'][i]['id']},
                                success: function(data) {
                                    console.log('[Сервер -> ПК] ' + data['status']);
                                    if (data['status'] == true) {
                                        console.log('[ПК -> ПК] Удаление кнопки');
                                        $('#button_' + data['id_product'] +'').remove();
                                        console.log('[ПК -> ПК] Добавление кнопки');
                                        $('#div_' + data['id_product'] +'').append('<button class="cpip_href_cart" onclick="href_cart()">Перейти к корзине</button>');
                                    }
                                }
                            });
                        }
                    }
                });
            }

            function add_cart(id_product) {
                console.log('[ПК -> ПК] Запрос на добавление: ' + id_product);
                console.log('[ПК -> Сервер] Проверка авторизации пользователя...');
                $.ajax({
                    url: '/api/',
                    method: 'get',
                    dataType: 'json',
                    data: {query: 'check_auch_user'},
                    success: function(data) {
                        console.log('[Сервер -> ПК] ' + data['status']);
                        if (data['status'] == true) {
                            console.log('[ПК -> Сервер] Добавление в корзину...');
                            $.ajax({
                                url: '/api/',
                                method: 'get',
                                dataType: 'json',
                                data: {query: 'add_products_cart', id_product: id_product},
                                success: function(data) {
                                    console.log('[Сервер -> ПК] ' + data['status']);
                                    if (data['status'] == 'ok') {
                                        console.log('[ПК -> Сервер] Товар добавлен');
                                        ajax_products();
                                    }
                                }
                            });
                        } else {
                            $(location).attr('href', '/lk');
                        }
                    }
                });
            }

            function menu_on() {
                $('.whf_menu_catalog').addClass('whf_menu_catalog_on');
            }
            function menu_off() {
                $('.whf_menu_catalog').removeClass('whf_menu_catalog_on');
            }

            function href_cart() {
                $(location).attr('href', '/lk');
            }

            $('#button-info').click(function () {
                $('body,html').animate({
                    scrollTop: 800
                }, 2000);
                return false;
            });

            ajax_products();
        </script>
    </body>
</html>