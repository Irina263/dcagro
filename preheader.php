<a class="p_a" href="/">Главная</a>
<a class="p_a" href="/news">Новости</a>
<?php if (isset($_SESSION['user'])) : ?>
    <a class="p_a" href="/lk?page=order_history">История заказов</a>
    <a class="p_a" href="/lk">Корзина</a>
    <a class="p_a" href="/lk?logout">Выход</a>
<?php else : ?>
    <a class="p_a" href="/lk/register">Регистрация</a>
    <a class="p_a" href="/lk">Вход</a>
<?php endif ?>