<?php
    // Подключение к БД
    require '../orm/db.php';

    if (isset($_GET['logout'])) {
        unset($_SESSION['user']);
        header('Location: /lk');
    }

    //Отображение страниц
    if (isset($_SESSION['user'])) {
        switch ($_GET['page']) {
            case 'order_history': include 'content.php';
            break;
            default: include 'dashboard.php';
        }
    } else {
        include 'login.php';
    }