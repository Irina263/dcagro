<?php
    // Подключение к БД
    require '../orm/db.php';

    if (isset($_GET['logout'])) {
        unset($_SESSION['user_admin']);
        header('Location: /admin');
    }

    //Отображение страниц
    if (isset($_SESSION['user_admin'])) {
        switch ($_GET['page']) {
            case 'orders': include 'content.php';
            break;
            default: include 'dashboard.php';
        }
    } else {
        include 'login.php';
    }