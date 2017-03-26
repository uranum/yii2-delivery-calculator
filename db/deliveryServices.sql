-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 26 2017 г., 10:36
-- Версия сервера: 5.6.34-log
-- Версия PHP: 7.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `yii2_yiitest`
--

--
-- Дамп данных таблицы `deliveryServices`
--

INSERT INTO `deliveryServices` (`id`, `name`, `code`, `isActive`, `fixedCost`, `info`, `terms`, `serviceShownFor`, `dateDb`, `created_at`, `updated_at`) VALUES
(1, 'Курьер', 'courier', 1, 200, '', '1 день', 2, '2017-03-25 02:32:19', 1490259688, 1490383939),
(3, 'Почта России', 'post', 1, NULL, NULL, NULL, 3, '2017-03-23 18:04:06', 1490267046, 1490267046),
(4, 'Почта России наложенным', 'post_naloj', 1, NULL, '', '', 3, '2017-03-25 01:44:37', 1490267079, 1490381077),
(5, 'Самовывоз', 'pickup', 1, 0, 'Самостоятельно забираете в офисе.', NULL, 1, '2017-03-24 23:00:42', 1490267114, 1490371242),
(6, 'СДЭК', 'cdek', 1, NULL, NULL, NULL, 3, '2017-03-23 18:06:49', 1490267198, 1490267209);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
