<?php
    require '../orm/db.php';
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ДЦ Агро - новости</title>
        <link rel="stylesheet" href="../css/style.css">
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
                    <?php require '../preheader.php'; ?>
                </div>
            </div>
        </section>
        <section class="welcome_section ws_news">
            <div class="wrapper">
                <div class="welcome">
                    <div class="w_header">
                        <img class="wh_img" src="../img/logo.svg">
                        <div class="wh_form">
                            <input class="whf_button" type="submit" value="Каталог" onmouseover="menu_on()" onmouseout="menu_off()">
                            <input id="search" class="whf_input" type="text" placeholder="Поиск продуктов">
                            <input class="whf_button" type="submit" value="Найти" onclick="href_search()">
                            <div class="whf_menu_catalog">
                                <div class="whfm_catalog">
                                    <!-- AJAX ответ -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w_text">
                        <h1 class="wt_h1">Новости</h1>
                        <p class="wt_p">Мы публикуем только достоверную информацию.</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="news_section">
            <div class="wrapper">
                <div class="news">
                    <!-- AJAX ответ -->
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
                        $('.whfm_catalog').append('<a class="whfmc_a" href="/catalog?search=' + data['categories'][i]['name'] + '">' + data['categories'][i]['name'] + '</a>');
                    }
                }
            });

            $.ajax({
                url: '/api/',
                method: 'get',
                dataType: 'json',
                data: {query: 'news'},
                success: function(data) {
                    $('.news').empty();
                    var i = 0;
                    for (i in data['news']) {
                        $('.news').append('<a href="/news/new?page=' + data['news'][i]['id'] + '" class="n_item"><div class="ni_text"><h3>' + data['news'][i]['title'] + '</h3><div class="nit_vi"><img class="nit_vi_img" src="../img/views.svg"><p>' + data['news'][i]['views'] + '</p></div></div><img class="ni_img" src="../img/news/' + data['news'][i]['photo'] + '"></a>');
                    }
                }
            });

            function menu_on() {
                $('.whf_menu_catalog').addClass('whf_menu_catalog_on');
            }
            function menu_off() {
                $('.whf_menu_catalog').removeClass('whf_menu_catalog_on');
            }

            function href_search() {
                var search = document.querySelector('#search').value;
                $(location).attr('href', '/catalog?search='+search);
            }
        </script>
    </body>
</html>