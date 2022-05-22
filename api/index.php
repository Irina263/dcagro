<?php
    require '../orm/db.php';

    if ($_GET['query'] == 'categories') {
        $categories = R::findAll('categories');
        $categories_arr = array();
        foreach ($categories as $c) {
            array_push($categories_arr, ['id'=>$c['id'], 'name'=>$c['name']]);
        }
        $arr = ['status'=>'ok', 'categories'=>$categories_arr];
        $json = json_encode($arr);
        echo $json;
    }

    if ($_GET['query'] == 'products') {
        if (isset($_GET['limit'])) {
            $products = R::findAll('products', 'LIMIT '.$_GET['limit']);
            $products_arr = array();
            foreach ($products as $p) {
                array_push($products_arr, ['id'=>$p['id'], 'photo'=>$p['photo'], 'name'=>$p['name'], 'fermer'=>$p['fermer'], 'price'=>$p['price'], 'size'=>$p['size']]);
            }
            $arr = ['status'=>'ok', 'products'=>$products_arr];
            $json = json_encode($arr);
            echo $json;
        } else {
            $products = R::findAll('products');
            $products_arr = array();
            foreach ($products as $p) {
                array_push($products_arr, ['id'=>$p['id'], 'photo'=>$p['photo'], 'name'=>$p['name'], 'fermer'=>$p['fermer'], 'price'=>$p['price'], 'size'=>$p['size']]);
            }
            $arr = ['status'=>'ok', 'products'=>$products_arr];
            $json = json_encode($arr);
            echo $json;
        }
    }

    if ($_GET['query'] == 'check_auch_user') {
        if (isset($_SESSION['user'])) {
            $arr = ['status'=>true];
            $json = json_encode($arr);
            echo $json;
        } else {
            $arr = ['status'=>false];
            $json = json_encode($arr);
            echo $json;
        }
    }

    if ($_GET['query'] == 'check_add_products_cart') {
        $cart_json = $_SESSION['user']->cart;
        $cart = json_decode($cart_json, true);
        if (isset($cart[$_GET['id_product']])) {
            $arr = ['status'=>true, 'id_product'=>$_GET['id_product'], 'count'=>$cart[$_GET['id_product']]];
            $json = json_encode($arr);
            echo $json;
        } else {
            $arr = ['status'=>false];
            $json = json_encode($arr);
            echo $json;
        }
    }

    if ($_GET['query'] == 'add_products_cart') {
        $cart_json = $_SESSION['user']->cart;
        $cart = json_decode($cart_json, true);
        $cart[$_GET['id_product']] = 1;
        $_SESSION['user']->cart = json_encode($cart);
        $user = R::load('users', $_SESSION['user']->id);
        $user->cart = $_SESSION['user']->cart;
        R::store($user);
        $arr = ['status'=>'ok', 'cart'=>$cart];
        $json = json_encode($arr);
        echo $json;
    }

    if ($_GET['query'] == 'plus_products_cart') {
        $cart_json = $_SESSION['user']->cart;
        $cart = json_decode($cart_json, true);
        $count = $cart[$_GET['id_product']];
        $count++;
        $cart[$_GET['id_product']] = $count;
        $_SESSION['user']->cart = json_encode($cart);
        $user = R::load('users', $_SESSION['user']->id);
        $user->cart = $_SESSION['user']->cart;
        R::store($user);
        $arr = ['status'=>'ok', 'cart'=>$cart];
        $json = json_encode($arr);
        echo $json;
    }

    if ($_GET['query'] == 'minus_products_cart') {
        $cart_json = $_SESSION['user']->cart;
        $cart = json_decode($cart_json, true);
        $count = $cart[$_GET['id_product']];
        if ($count == 1) {
            unset($cart[$_GET['id_product']]);
            $_SESSION['user']->cart = json_encode($cart);
            $user = R::load('users', $_SESSION['user']->id);
            $user->cart = $_SESSION['user']->cart;
            R::store($user);
            $arr = ['status'=>'ok', 'cart'=>$cart];
            $json = json_encode($arr);
            echo $json;
        } else {
            $count--;
            $cart[$_GET['id_product']] = $count;
            $_SESSION['user']->cart = json_encode($cart);
            $user = R::load('users', $_SESSION['user']->id);
            $user->cart = $_SESSION['user']->cart;
            R::store($user);
            $arr = ['status'=>'ok', 'cart'=>$cart];
            $json = json_encode($arr);
            echo $json;
        }
    }

    if ($_GET['query'] == 'cart') {
        $cart_json = $_SESSION['user']->cart;
        $cart_arr = json_decode($cart_json, true);
        $cart = array();
        foreach ($cart_arr as $cak => $c) {
            $products = R::findOne('products', 'WHERE id = "'.$cak.'"');
            array_push($cart, ['id'=>$products['id'], 'photo'=>$products['photo'], 'name'=>$products['name'], 'fermer'=>$products['fermer'], 'price'=>$products['price'], 'size'=>$products['size'], 'count'=>$c]);
        }
        $arr = ['status'=>'ok', 'cart'=>$cart];
        $json = json_encode($arr);
        echo $json;
    }

    if ($_GET['query'] == 'sum_cart') {
        $cart_json = $_SESSION['user']->cart;
        $cart_arr = json_decode($cart_json, true);
        $cart = array();
        foreach ($cart_arr as $cak => $c) {
            $products = R::findOne('products', 'WHERE id = "'.$cak.'"');
            array_push($cart, ['id'=>$products['id'], 'price'=>$products['price'], 'count'=>$c]);
        }
        $sum = 0;
        $sum_arr = array();
        for ($i = 0; $i < count($cart); $i++) {
            $sum = $cart[$i]['price'] * $cart[$i]['count'];
            $sum_arr[$i] = $sum;
        }
        $arr = ['status'=>'ok', 'sum'=>array_sum($sum_arr)];
        $json = json_encode($arr);
        echo $json;
    }

    if ($_POST['query'] == 'login') {
        $user = R::findOne('users', 'WHERE `email` = "'.$_POST['login'].'" OR `phone` = "'.$_POST['login'].'"');
        if ($user) {
            if (md5($_POST['pass']) == $user->password) {
                $_SESSION['user'] = $user;
                $arr = ['status'=>'successful'];
                $json = json_encode($arr);
                echo $json;
            } else {
                $arr = ['status'=>'error', 'message'=>'Неверно введен пароль!'];
                $json = json_encode($arr);
                echo $json;
            }
        } else {
            $arr = ['status'=>'error', 'message'=>'Пользователь не найден!'];
            $json = json_encode($arr);
            echo $json;
        }
    }

    if ($_GET['query'] == 'email') {
        $user = R::findOne('users', 'WHERE `email` = "'.$_GET['email'].'"');
        if ($user) {
            $arr = ['status'=>'ok', 'email'=>true];
            $json = json_encode($arr);
            echo $json;
        } else {
            $arr = ['status'=>'ok', 'email'=>false];
            $json = json_encode($arr);
            echo $json;
        }
    }

    if ($_POST['auch'] == 'reg') {
        $user = R::dispense('users');
        $user->name = $_POST['name'];
        $user->surname = $_POST['surname'];
        $user->phone = '';
        $user->cart = '';
        $user->position = '1';
        $user->email = $_POST['email'];
        $user->password = md5($_POST['pass']);
        R::store($user);
        $arr = ['status'=>'successful'];
        $json = json_encode($arr);
        echo $json;
    }

    if ($_GET['query'] == 'user_info') {
        $arr = ['status'=>'ok', 'user'=>['id'=>$_SESSION['user']->id, 'name'=>$_SESSION['user']->name, 'surname'=>$_SESSION['user']->surname, 'phone'=>$_SESSION['user']->phone, 'email'=>$_SESSION['user']->email]];
        $json = json_encode($arr);
        echo $json;
    }

    if ($_POST['query'] == 'change_name') {
        $_SESSION['user']->name = $_POST['name'];
        $user = R::load('users', $_SESSION['user']->id);
        $user->name = $_SESSION['user']->name;
        R::store($user);
        $arr = ['status'=>'successful'];
        $json = json_encode($arr);
        echo $json;
    }

    if ($_POST['query'] == 'change_surname') {
        $_SESSION['user']->surname = $_POST['surname'];
        $user = R::load('users', $_SESSION['user']->id);
        $user->surname = $_SESSION['user']->surname;
        R::store($user);
        $arr = ['status'=>'successful'];
        $json = json_encode($arr);
        echo $json;
    }

    if ($_POST['query'] == 'change_phone') {
        $_SESSION['user']->phone = $_POST['phone'];
        $user = R::load('users', $_SESSION['user']->id);
        $user->phone = $_SESSION['user']->phone;
        R::store($user);
        $arr = ['status'=>'successful'];
        $json = json_encode($arr);
        echo $json;
    }

    if ($_POST['query'] == 'change_email') {
        $_SESSION['user']->email = $_POST['email'];
        $user = R::load('users', $_SESSION['user']->id);
        $user->email = $_SESSION['user']->email;
        R::store($user);
        $arr = ['status'=>'successful'];
        $json = json_encode($arr);
        echo $json;
    }

    if ($_GET['query'] == 'orders') {
        $orders_user = R::findAll('orders', 'WHERE id_user = "'.$_SESSION['user']->id.'" ORDER BY id DESC');
        $orders = array();
        foreach ($orders_user as $ou) {
            $order_products = json_decode($ou['user_order'], true);
            $products_arr = array();
            foreach ($order_products as $op => $p) {
                $products = R::findOne('products', 'WHERE id = "'.$op.'"');
                array_push($products_arr, ['id'=>$products['id'], 'photo'=>$products['photo'], 'name'=>$products['name'], 'fermer'=>$products['fermer'], 'price'=>$products['price'], 'size'=>$products['size'], 'count'=>$p]);
            }
            array_push($orders, ['id'=>$ou['id'], 'user_order'=>$products_arr, 'status'=>$ou['status'], 'adress'=>$ou['adress'], 'date_order'=>$ou['date_order']]);
        }
        $arr = ['status'=>'ok', 'orders'=>$orders];
        $json = json_encode($arr);
        echo $json;
    }

    if ($_GET['query'] == 'order_status') {
        $order = R::load('orders', $_GET['id_order']);
        $order->status = 0;
        R::store($order);
        $arr = ['status'=>'ok'];
        $json = json_encode($arr);
        echo $json;
    }

    if ($_POST['query'] == 'add_order') {
        $order = R::dispense('orders');
        $order->id_user = $_SESSION['user']->id;
        $order->user_order = $_SESSION['user']->cart;
        $order->status = 1;
        $order->adress = $_POST['sity'].', '.$_POST['street'].', '.$_POST['index'];
        $order->date_order = date("d.m.Y H:i:s");
        R::store($order);
        $cart_arr = [];
        $_SESSION['user']->cart = json_encode($cart_arr);
        $user = R::load('users', $_SESSION['user']->id);
        $user->cart = $_SESSION['user']->cart;
        R::store($user);
        $arr = ['status'=>'successful'];
        $json = json_encode($arr);
        echo $json;
    }

    if ($_POST['query'] == 'login_admin') {
        $user = R::findOne('users', 'WHERE `email` = "'.$_POST['login'].'" OR `phone` = "'.$_POST['login'].'"');
        if ($user) {
            if ($user->position == 2) {
                if (md5($_POST['pass']) == $user->password) {
                    $_SESSION['user_admin'] = $user;
                    $arr = ['status'=>'successful'];
                    $json = json_encode($arr);
                    echo $json;
                } else {
                    $arr = ['status'=>'error', 'message'=>'Неверно введен пароль!'];
                    $json = json_encode($arr);
                    echo $json;
                }
            } else {
                $arr = ['status'=>'error', 'message'=>'Уровень вашей учётной записи не соответствует требованиям! В доступе отказано!'];
                $json = json_encode($arr);
                echo $json;
            }
        } else {
            $arr = ['status'=>'error', 'message'=>'Пользователь не найден!'];
            $json = json_encode($arr);
            echo $json;
        }
    }