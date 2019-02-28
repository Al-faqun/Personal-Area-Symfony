-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Фев 28 2019 г., 20:10
-- Версия сервера: 5.7.23-0ubuntu0.16.04.1-log
-- Версия PHP: 7.2.9-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `symfony_test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cargo`
--

CREATE TABLE `cargo` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `manager_id` int(11) DEFAULT NULL,
  `container` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_arrival` datetime DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `cargo`
--

INSERT INTO `cargo` (`id`, `client_id`, `manager_id`, `container`, `date_arrival`, `status`) VALUES
(1, 1, 1, 'First cargo', '2019-02-23 04:15:00', 'finished'),
(2, 1, NULL, 'gdf', '2019-02-27 23:26:48', 'finished'),
(3, 1, NULL, 'gdfd', '2019-02-27 23:28:22', 'finished'),
(4, 1, 1, 'new cargo', '2019-02-28 04:04:00', 'on_board'),
(5, NULL, NULL, '358c0a3', '2019-02-28 20:06:34', 'on_board'),
(6, NULL, NULL, 'fd577bb28', '2019-02-28 20:06:35', 'on_board'),
(7, NULL, NULL, '476503f8', '2019-02-28 20:06:35', 'on_board'),
(8, NULL, NULL, '4d86', '2019-02-28 20:06:35', 'on_board'),
(9, NULL, NULL, 'd925faa0dc5', '2019-02-28 20:06:35', 'on_board'),
(10, NULL, NULL, '6ee2', '2019-02-28 20:06:35', 'on_board'),
(11, NULL, NULL, '48dc99a72', '2019-02-28 20:06:35', 'on_board'),
(12, NULL, NULL, '8807134e47', '2019-02-28 20:06:35', 'on_board'),
(13, NULL, NULL, '140b1b', '2019-02-28 20:06:35', 'on_board'),
(14, NULL, NULL, 'b11ac48eb', '2019-02-28 20:06:35', 'on_board'),
(15, NULL, NULL, 'ea278fa97', '2019-02-28 20:06:35', 'on_board'),
(16, NULL, NULL, '8483b1868d1', '2019-02-28 20:06:35', 'on_board'),
(17, NULL, NULL, 'a646', '2019-02-28 20:06:35', 'on_board'),
(18, NULL, NULL, '467dba', '2019-02-28 20:06:35', 'on_board'),
(19, NULL, NULL, '55aa16c10', '2019-02-28 20:06:35', 'on_board'),
(20, NULL, NULL, '2509f25', '2019-02-28 20:06:35', 'on_board'),
(21, NULL, NULL, '3f7db0', '2019-02-28 20:06:35', 'on_board'),
(22, NULL, NULL, '6216', '2019-02-28 20:06:35', 'on_board'),
(23, NULL, NULL, '5f8694', '2019-02-28 20:06:35', 'on_board'),
(24, NULL, NULL, '49d4', '2019-02-28 20:06:35', 'on_board'),
(25, 1, NULL, '519240', '2019-02-28 20:06:35', 'on_board'),
(26, 1, NULL, '1a1df49d0', '2019-02-28 20:06:35', 'on_board'),
(27, 1, 1, '3283375ee63', '2019-02-28 20:06:35', 'on_board'),
(28, 1, NULL, '095a2eeba', '2019-02-28 20:06:35', 'on_board'),
(29, 1, NULL, '380b', '2019-02-28 20:06:35', 'on_board'),
(30, 1, NULL, 'f4904fb27', '2019-02-28 20:06:35', 'on_board'),
(31, 1, NULL, '941a3511f22', '2019-02-28 20:06:35', 'on_board');

-- --------------------------------------------------------

--
-- Структура таблицы `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inn` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `client`
--

INSERT INTO `client` (`id`, `user_id`, `company_name`, `inn`, `address`, `email`, `tel`) VALUES
(1, 1, 'Some company name', '123456', 'haha', 'something@somemail.com', '123456'),
(3, 4, '123456', '123456', '123456', 'some@mail.com', '123456');

-- --------------------------------------------------------

--
-- Структура таблицы `manager`
--

CREATE TABLE `manager` (
  `id` int(11) NOT NULL,
  `surname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `manager`
--

INSERT INTO `manager` (`id`, `surname`, `name`, `email`, `tel`, `user_id`) VALUES
(1, 'Romulus', 'Titus', 'tit@rome.org', '1234567', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `migration_versions`
--

INSERT INTO `migration_versions` (`version`) VALUES
('20181223101123'),
('20190219183849'),
('20190220171547'),
('20190222112647'),
('20190223123702'),
('20190223124258'),
('20190224183046');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usergroup` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`, `usergroup`) VALUES
(1, 'First user', '[\"ROLE_CLIENT\"]', '$2y$13$LEGEwJluYeIAO4LwVZJtleK4Vg9SLaEZDawXPdoGt/EOUxhPbzqY.', 'client'),
(2, 'First manager', '[\"ROLE_MANAGER\"]', '$2y$13$UmpTqgfMTkqYSDsSJgW9rO.GmNdv6/WGAbNrxSaHOY5XV23K6bqLu', 'manager'),
(3, 'Admin', '[\"ROLE_ADMIN\"]', '$2y$13$IWt5SHestStPXycKxQy9kObmT60jCDiAyrYcswfKOGgj7dRK7qh0K', 'admin'),
(4, 'Second client', '[\"ROLE_CLIENT\"]', '$2y$13$YP.SjiPN1TBFVU1BVgmWA.S5SfR1BTeGE.7wJLPUAeRF73nSCZDCO', 'client');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_3BEE577119EB6921` (`client_id`),
  ADD KEY `IDX_3BEE5771783E3463` (`manager_id`);

--
-- Индексы таблицы `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_C7440455A76ED395` (`user_id`);

--
-- Индексы таблицы `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_FA2425B9A76ED395` (`user_id`);

--
-- Индексы таблицы `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT для таблицы `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `manager`
--
ALTER TABLE `manager`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cargo`
--
ALTER TABLE `cargo`
  ADD CONSTRAINT `FK_3BEE577119EB6921` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `FK_3BEE5771783E3463` FOREIGN KEY (`manager_id`) REFERENCES `manager` (`id`);

--
-- Ограничения внешнего ключа таблицы `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `FK_C7440455A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `manager`
--
ALTER TABLE `manager`
  ADD CONSTRAINT `FK_FA2425B9A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
