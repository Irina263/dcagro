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
        <title>История заказов</title>
        <link rel="stylesheet" href="../css/style.css">
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    </head>
    <body class="cont_b">
        <section class="preheader_section">
            <div class="wrapper">
                <div class="preheader">
                    <?php require '../preheader.php'; ?>
                </div>
            </div>
        </section>
        <?php if ($_GET['page'] == 'order_history') : ?>
            <section class="order_history_section">
                <div class="wrapper" style="width: 800px;">
                    <div class="order_history">
                        <h2 class="oh_h2">История заказов</h2>
                        <!-- AJAX ответ -->
                    </div>
                </div>
            </section>
            <script>
                function ajax_orders() {
                    console.log('[ПК -> Сервер] Проверка списка заказов...');
                    $.ajax({
                        url: '/api/',
                        method: 'get',
                        dataType: 'json',
                        data: {query: 'orders'},
                        success: function(data) {
                            $('.order_history').empty();
                            $('.order_history').append('<h2 class="oh_h2">История заказов</h2>');
                            console.log('[Сервер -> ПК] Список заказов получен');
                            var i = 0;
                            for (i in data['orders']) {
                                console.log('[ПК -> ПК] Вывод заказа (карточка)');
                                $('.order_history').append('<div class="oh_order"><div class="oho_title"><h2 class="ohot_h2">Заказ № ' + data['orders'][i]['id'] + '</h2><p class="ohot_p ohot_p_' + data['orders'][i]['id'] + '"></p></div><p class="oho_p">Список продуктов:</p><div id="user_order_' + data['orders'][i]['id'] + '" class="oho_products"></div><div class="oho_buttons oho_buttons_' + data['orders'][i]['id'] + '"><button class="oho_button ohob_del" onclick="ajax_status_order(' + data['orders'][i]['id'] + ')">Отменить заказ</button></div></div>');
                                var a = 0;
                                for (a in data['orders'][i]['user_order']) {
                                    console.log('[ПК -> ПК] Вывод продуктов (в карточку)');
                                    $('#user_order_' + data['orders'][i]['id']).append('<div class="oho_product"><h3 class="ohop_h3">' + data['orders'][i]['user_order'][a]['name'] + '</h3><p class="ohop_p">' + data['orders'][i]['user_order'][a]['price'] + ' ₽ <span>x ' + data['orders'][i]['user_order'][a]['count'] + '</span></p></div>');
                                }
                                console.log('[ПК -> ПК] Проверка на статус заказа');
                                if (data['orders'][i]['status'] == 0) {
                                    $('.ohot_p_' + data['orders'][i]['id']).text('Отменённый');
                                    $('.ohot_p_' + data['orders'][i]['id']).addClass('ohot_p_del');
                                    $('.oho_buttons_' + data['orders'][i]['id']).remove();
                                }
                                if (data['orders'][i]['status'] == 1) {
                                    $('.ohot_p_' + data['orders'][i]['id']).text('Новый');
                                    $('.ohot_p_' + data['orders'][i]['id']).addClass('ohot_p_new');
                                }
                                if (data['orders'][i]['status'] == 2) {
                                    $('.ohot_p_' + data['orders'][i]['id']).text('Собирается');
                                    $('.ohot_p_' + data['orders'][i]['id']).addClass('ohot_p_proc');
                                }
                                if (data['orders'][i]['status'] == 3) {
                                    $('.ohot_p_' + data['orders'][i]['id']).text('Передан на доставку');
                                    $('.ohot_p_' + data['orders'][i]['id']).addClass('ohot_p_proc');
                                    $('.oho_buttons_' + data['orders'][i]['id']).remove();
                                }
                                if (data['orders'][i]['status'] == 4) {
                                    $('.ohot_p_' + data['orders'][i]['id']).text('Ожидает в пункте выдачи');
                                    $('.ohot_p_' + data['orders'][i]['id']).addClass('ohot_p_got');
                                    $('.oho_buttons_' + data['orders'][i]['id']).remove();
                                }
                                if (data['orders'][i]['status'] == 5) {
                                    $('.ohot_p_' + data['orders'][i]['id']).text('Завершённый');
                                    $('.ohot_p_' + data['orders'][i]['id']).addClass('ohot_p_gotov');
                                    $('.oho_buttons_' + data['orders'][i]['id']).remove();
                                }
                            }
                        }
                    });
                }

                function ajax_status_order(id_order) {
                    console.log('[ПК -> Сервер] Изменение статуса заказа...');
                    $.ajax({
                        url: '/api/',
                        method: 'get',
                        dataType: 'json',
                        data: {query: 'order_status', id_order: id_order},
                        success: function(data) {
                            console.log('[Сервер -> ПК] Статус изменён');
                            ajax_orders();
                        }
                    });
                }

                ajax_orders();
            </script>
        <?php else : ?>
        <?php endif ?>
    </body>
</html>