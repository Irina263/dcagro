-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 04 2022 г., 22:20
-- Версия сервера: 10.3.13-MariaDB-log
-- Версия PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `dcagro`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Мясо и птица'),
(2, 'Хлеб и выпечка'),
(3, 'Сыры'),
(4, 'Овощи и фрукты'),
(5, 'Подарки и сувениры');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `user_order` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `status` int(11) NOT NULL,
  `adress` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'NULL',
  `date_order` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `id_user`, `user_order`, `status`, `adress`, `date_order`) VALUES
(15, 1, '{\"3\":10}', 3, 'Пенза, ул.Измайлова д.70 кв.170, 12', '03.05.2022 19:55:07'),
(16, 1, '{\"4\":1}', 0, 'q2q, 123, 123', '03.05.2022 19:56:35'),
(17, 1, '{\"1\":7}', 0, 'Пенза, ул.Измайлова д.76 кв.170, 124', '03.05.2022 19:57:17'),
(21, 1, '{\"3\":1,\"2\":4}', 0, 'Пенза, ул.Измайлова д.70 кв.170, 12', '04.05.2022 13:18:52'),
(22, 1, '{\"2\":3}', 0, 'Пенза, ул.Измайлова д.70 кв.170, 12', '04.05.2022 14:28:00'),
(23, 1, '{\"1\":11}', 1, 'Пенза, ул.Антонова д.76 кв.170, 1234567', '04.05.2022 14:30:15'),
(24, 2, '{\"1\":2}', 4, 'Пенза, ул.Антонова д.76 кв.170, 123', '04.05.2022 15:33:14');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `categories` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fermer` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `size` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `categories`, `photo`, `name`, `fermer`, `price`, `size`) VALUES
(1, 'Мясо и птица', '257768-730x604.jpeg', 'Стейк на кости из молодой говядины', 'Состав: Говядина, приправа универсальная.', 700, 'за 1 кг'),
(2, 'Мясо и птица', 'img-20220309-wa0080-jpeg_1_16_.png', 'Печень говяжья', 'Состав: Печень говяжья, индийские специи.', 450, 'за 1 кг'),
(3, 'Хлеб и выпечка', 'hleb-s-izyumom-jpeg_3_.png', 'Хлеб с изюмом', 'Состав: Мука пшеничная, дрожжи, изюм.', 130, 'за 1 шт'),
(4, 'Сыры', 'french-soft-camembert-of-normandy-cheese-set-on-gray-table-top-view_249006-6254.png', 'Камамбер', 'Состав: молоко козье', 1600, 'за 1 кг');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cart` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `position` int(11) NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `phone`, `cart`, `position`, `email`, `password`) VALUES
(1, 'Андрей', 'Герасимов', '89521968636', '[]', 1, 'andrey.gerasimov2506@gmail.com', '202cb962ac59075b964b07152d234b70'),
(3, 'Ирина', 'Романова', '89063959103', '', 2, 'irinaromanova027@mail.ru', '63ce4263dcebcacfc577f11a1a34975b');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
