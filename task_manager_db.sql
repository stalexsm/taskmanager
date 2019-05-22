-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 29 2015 г., 23:56
-- Версия сервера: 5.5.41-log
-- Версия PHP: 5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `task_manager_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `files_data` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `parameters`
--

CREATE TABLE IF NOT EXISTS `parameters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `parameters`
--

INSERT INTO `parameters` (`id`, `title`, `value`) VALUES
(1, 'title', 'Freelance task manager'),
(2, 'copyright', 'Все права защищены &copy Разработчик: StAlex67'),
(3, 'ver', '0.15_230815(beta)');

-- --------------------------------------------------------

--
-- Структура таблицы `priority`
--

CREATE TABLE IF NOT EXISTS `priority` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `priority`
--

INSERT INTO `priority` (`id`, `name`) VALUES
(1, 'Нормальный'),
(2, 'Второстепенная'),
(3, 'Первоочередная'),
(4, 'Критическая');

-- --------------------------------------------------------

--
-- Структура таблицы `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `status`
--

INSERT INTO `status` (`id`, `name`) VALUES
(1, 'Новая'),
(2, 'Вопрос клиенту'),
(3, 'Отказ'),
(4, 'Согласование'),
(5, 'На выполнение'),
(6, 'В работе'),
(7, 'Решена'),
(8, 'Закрыта');

-- --------------------------------------------------------

--
-- Структура таблицы `task`
--

CREATE TABLE IF NOT EXISTS `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `status_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `type_id` int(11) NOT NULL,
  `priority_id` int(11) NOT NULL,
  `assessment` int(11) NOT NULL,
  `lead_time` int(11) NOT NULL,
  `links_fl` varchar(255) NOT NULL,
  `correspondence_fl` varchar(255) NOT NULL,
  `test_platform` varchar(255) NOT NULL,
  `links_backup` varchar(255) NOT NULL,
  `links_project` varchar(255) NOT NULL,
  `performer` int(11) NOT NULL DEFAULT '0',
  `manager` int(11) NOT NULL,
  `closed` enum('0','1') NOT NULL DEFAULT '0',
  `begin_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `task`
--

INSERT INTO `task` (`id`, `title`, `status_id`, `description`, `type_id`, `priority_id`, `assessment`, `lead_time`, `links_fl`, `correspondence_fl`, `test_platform`, `links_backup`, `links_project`, `performer`, `manager`, `closed`, `begin_date`, `end_date`) VALUES
(1, 'Сделать сайт', 1, '<p>Вот я создаю в стрижки собак по породам рубрики , Пудель, Шитцу,Йорк И в них по одной записи. И получается что они все отображаются вместе в альбоме Стрижки собак по породам, соответственно добавляя дальше это все будет в перемешку в одном альбоме , а должно быть что бы йорки были в йорках, а шитцу в шитцу. То есть визуально так получается Галерея\\Стрижка собак по породам . То есть у каждой породы как бы отдельный альбом а там уже те записи которые я добавляю. http://jaysee.ru/category/галерея/ http://jaysee.ru/category/галерея/стрижка-собак-по-по.. Вот тут должны быть альбомы как бы а не сразу фото, то есть альбомы с подрубриками которые я создал в Стрижки собак по породам. Есть ли время этим заняться? Сколько будет стоить?</p>\r\n', 2, 2, 18, 0, '', '', '', '', '', 1, 1, '0', '2015-06-22 15:30:00', '0000-00-00 00:00:00'),
(2, 'Сделать сайт', 8, '<p>Вот я создаю в стрижки собак по породам рубрики , Пудель, Шитцу,Йорк И в них по одной записи. И получается что они все отображаются вместе в альбоме Стрижки собак по породам, соответственно добавляя дальше это все будет в перемешку в одном альбоме , а должно быть что бы йорки были в йорках, а шитцу в шитцу. То есть визуально так получается Галерея\\Стрижка собак по породам . То есть у каждой породы как бы отдельный альбом а там уже те записи которые я добавляю. http://jaysee.ru/category/галерея/ http://jaysee.ru/category/галерея/стрижка-собак-по-по.. Вот тут должны быть альбомы как бы а не сразу фото, то есть альбомы с подрубриками которые я создал в Стрижки собак по породам. Есть ли время этим заняться? Сколько будет стоить?</p>\r\n', 2, 2, 15, 0, 'http://www.fl.ru', 'http://www.fl.ru', 'сайт развернет менеджер', 'http://', '', 0, 1, '1', '2015-06-22 21:00:00', '2015-08-23 22:50:49'),
(3, 'Поправить сайт 2', 1, '<p>Вот я создаю в стрижки собак по породам рубрики , Пудель, Шитцу,Йорк И в них по одной записи. И получается что они все отображаются вместе в альбоме Стрижки собак по породам, соответственно добавляя дальше это все будет в перемешку в одном альбоме , а должно быть что бы йорки были в йорках, а шитцу в шитцу. То есть визуально так получается Галерея\\Стрижка собак по породам . То есть у каждой породы как бы отдельный альбом а там уже те записи которые я добавляю. http://jaysee.ru/category/галерея/ http://jaysee.ru/category/галерея/стрижка-собак-по-по.. Вот тут должны быть альбомы как бы а не сразу фото, то есть альбомы с подрубриками которые я создал в Стрижки собак по породам. Есть ли время этим заняться? Сколько будет стоить?</p>\r\n', 3, 2, 40, 43, 'http://www.fl.ru', '', 'сайт развернет менеджер', 'http://', 'http://www.fl.ru', 0, 1, '0', '2015-06-22 12:00:00', '0000-00-00 00:00:00'),
(4, 'Поправить сайт 3', 1, ' Вот я создаю в стрижки собак по породам рубрики , Пудель, Шитцу,Йорк И в них по одной записи. И получается что они все отображаются вместе в альбоме Стрижки собак по породам, соответственно добавляя дальше это все будет в перемешку в одном альбоме , а должно быть что бы йорки были в йорках, а шитцу в шитцу. То есть визуально так получается Галерея\\Стрижка собак по породам . То есть у каждой породы как бы отдельный альбом а там уже те записи которые я добавляю. http://jaysee.ru/category/галерея/ http://jaysee.ru/category/галерея/стрижка-собак-по-по.. Вот тут должны быть альбомы как бы а не сразу фото, то есть альбомы с подрубриками которые я создал в Стрижки собак по породам. Есть ли время этим заняться? Сколько будет стоить?  ', 3, 3, 15, 43, 'http://www.fl.ru', 'http://www.fl.ru', 'сайт развернет менеджер', 'http://', '', 1, 1, '0', '2015-06-22 18:00:00', '0000-00-00 00:00:00'),
(5, 'Поправить сайт 4', 1, 'Вот я создаю в стрижки собак по породам рубрики , Пудель, Шитцу,Йорк И в них по одной записи. И получается что они все отображаются вместе в альбоме Стрижки собак по породам, соответственно добавляя дальше это все будет в перемешку в одном альбоме , а должно быть что бы йорки были в йорках, а шитцу в шитцу. То есть визуально так получается Галерея\\Стрижка собак по породам . То есть у каждой породы как бы отдельный альбом а там уже те записи которые я добавляю. http://jaysee.ru/category/галерея/ http://jaysee.ru/category/галерея/стрижка-собак-по-по.. Вот тут должны быть альбомы как бы а не сразу фото, то есть альбомы с подрубриками которые я создал в Стрижки собак по породам. Есть ли время этим заняться? Сколько будет стоить? ', 3, 2, 15, 0, 'http://www.fl.ru', 'http://www.fl.ru', 'сайт развернет менеджер', 'http://', '', 0, 1, '0', '2015-06-22 23:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `token`
--

CREATE TABLE IF NOT EXISTS `token` (
  `token` varchar(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`token`),
  UNIQUE KEY `token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `type`
--

CREATE TABLE IF NOT EXISTS `type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `type`
--

INSERT INTO `type` (`id`, `name`) VALUES
(1, 'Администрирование'),
(2, 'Верстка'),
(3, 'Программирование'),
(4, 'Дизайн'),
(5, 'Контент'),
(6, 'Продвижение');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `username` varchar(255) NOT NULL,
  `group_policy` int(11) NOT NULL DEFAULT '100',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `username`, `group_policy`) VALUES
(1, 'starovoitov85@yandex.ru', '746587291fc43a0f140ff69b2007d023', 'Александр Старовойтов', 1009),
(2, 'dalirion@yandex.ru', '93f7b8b640a9d849b294bc04053b108a', 'Андрей Игнатов', 301),
(3, 'dk-1312@mail.ru', '1521099854bd188c9bd551ec997c1bdd', 'Дмитрий Команов', 301);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
