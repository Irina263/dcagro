<!DOCTYPE html>
<html lang="ru" class="auch_h">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Авторизация</title>
        <link rel="stylesheet" href="../css/style.css">
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    </head>
    <body class="auch_h">
        <section class="auch_section">
            <div class="wrapper">
                <div class="auch">
                    <div class="a_form">
                        <input id="login" class="af_input" type="text" placeholder="Email или телефон">
                        <input id="password" class="af_input" type="password" placeholder="Пароль">
                        <button class="af_button" onclick="ajax_login()">Войти</button>
                        <div class="af_as">
                            <a class="afs_a" href="/">Вернуться на сайт</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script>
            function ajax_login() {
                var error = '';
                var login = document.querySelector('#login').value;
                var password = document.querySelector('#password').value;
                    
                if (password == '') {
                    error = 'Введите пароль!';
                }
                if (login == '') {
                    error = 'Введите логин!';
                }

                if (error == '') {
                    $.ajax({
                        url: '/api/',
                        method: 'post',
                        dataType: 'json',
                        data: {query: 'login_admin', login: login, pass: password},
                        success: function(data) {
                            if (data['status'] == 'error') {
                                alert(data['message']);
                            }
                            if (data['status'] == 'successful') {
                                $(location).attr('href', '/admin')
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