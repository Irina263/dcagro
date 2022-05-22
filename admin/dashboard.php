<?php
    //Проверка на авторизацию
    if (!isset($_SESSION['user_admin'])) {
        header('Location: /admin');
    }
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Панель управления</title>
        <link rel="stylesheet" href="../css/style.css">
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    </head>
    <body class="dash_b">
        <section class="header_admin_section">
            <div class="wrapper">
                <div class="header_admin">
                    <a class="ha_a" href="/">Перейти на сайт</a>
                    <div class="ha_admin_info">
                        <p class="hai_name">Администратор: <?php echo $_SESSION['user_admin']->surname ?> <?php echo $_SESSION['user_admin']->name ?></p>
                        <a class="hai_a" href="/admin?logout">Выйти</a>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>