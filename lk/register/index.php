<?php
    require '../../orm/db.php';
?>
<!DOCTYPE html>
<html lang="ru" class="auch_h">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Авторизация</title>
        <link rel="stylesheet" href="../../css/style.css">
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    </head>
    <body class="auch_h">
        <section class="auch_section">
            <div class="wrapper">
                <div class="auch">
                    <div class="a_form">
                    <input class="af_input" id="name" type="text" placeholder="Имя">
                    <input class="af_input" id="surname" type="text" placeholder="Фамилия">
                    <input class="af_input" id="email" type="text" placeholder="E-mail">
                    <input class="af_input" id="pass" type="password" placeholder="Пароль">
                    <input class="af_input" id="pass_two" type="password" placeholder="Повтор пароля">
                    <button class="af_button" onclick="reg_ajax()">Зарегистрироваться</button>
                        <div class="af_as">
                            <a class="afs_a" href="/">Вернуться на сайт</a>
                            <a class="afs_a" href="/lk">Войти</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script>
            function reg_ajax() {
                var error = '';
                var name = document.querySelector('#name').value;
                var surname = document.querySelector('#surname').value;
                var email = document.querySelector('#email').value;
                var password = document.querySelector('#pass').value;
                var password_two = document.querySelector('#pass_two').value;

                if (password_two == '') {
                    error = 'Введите повторный пароль!';
                }
                if (password == '') {
                    error = 'Введите пароль!';
                }
                if (email == '') {
                    error = 'Введите email!';
                }
                if (surname == '') {
                    error = 'Введите фамилию!';
                }
                if (name == '') {
                    error = 'Введите имя!';
                }
                if (password_two != password) {
                    error = 'Пароли не совпадают!';
                }

                if (error == '') {
                    $.ajax({
                        url: '/api/',
                        method: 'get',
                        dataType: 'json',
                        data: {query: 'email', email: email},
                        success: function(data) {
                            if (data['email'] == false) {
                                $.ajax({
                                    url: '/api/',
                                    method: 'post',
                                    dataType: 'json',
                                    data: {auch: 'reg', name: document.querySelector('#name').value, surname: document.querySelector('#surname').value, email: document.querySelector('#email').value, pass: document.querySelector('#pass_two').value},
                                    success: function(data) {
                                        $(location).attr('href', '/lk');
                                    }
                                });
                            } else {
                                alert('Пользователь уже существует!');
                            }
                        }
                    });
                } else {
                    alert(error);
                }
            }
        </script>
    </body>
</html>