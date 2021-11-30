-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Час створення: Лис 30 2021 р., 10:00
-- Версія сервера: 5.5.39
-- Версія PHP: 5.4.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База даних: `skud.mk.v2`
--

--
-- Дамп даних таблиці `SKUD_MODE_SENSOR`
--

INSERT INTO `SKUD_MODE_SENSOR` (`ID`, `NAME`) VALUES
(1, 'Реєстраційний'),
(2, 'Прохідний');

--
-- Дамп даних таблиці `SKUD_OTDEL`
--

INSERT INTO `SKUD_OTDEL` (`ID`, `NAME`, `P_KEY`) VALUES
(1, 'Керівництво', 37),
(2, 'Гостьові', 37);

--
-- Дамп даних таблиці `SKUD_SENSOR`
--

INSERT INTO `SKUD_SENSOR` (`ID`, `ID_NOMER`, `ID_TIP`, `ID_MODE`, `DESCRIPTION`, `CAT_ACCESS`, `ID_AREA`) VALUES
(2, '002', 2, 1, 'Вхід постовий', 1, 0),
(3, '003', 2, 2, 'Вхід турнікет постовий', 1, 0),
(4, '004', 1, 2, 'Вихід турнікет постовий.', 1, 0),
(10, '001', 1, 1, 'Вихід постовий', 0, 0),
(11, '005', 1, 1, 'АРЗ СП вихід', 0, 1),
(12, '006', 2, 1, 'АРЗ СП вхід', 0, 1),
(13, '007', 2, 1, 'АРЧ вхід', 0, 1),
(14, '008', 1, 1, 'АРЧ вихід', 0, 1);

--
-- Дамп даних таблиці `SKUD_SPR_PEOPLE`
--

INSERT INTO `SKUD_SPR_PEOPLE` (`ID`, `ID_KART`, `NAME1`, `NAME2`, `NAME3`, `ID_OTDEL`, `LEVEL_ACCESS`, `SORT`) VALUES
(1, 3686146223, 'Бойко', 'Леонід', 'Миколайович', 5, 1, 0),
(2, 2348802205, '№1', 'Гостьова ', 'Перепустка', 36, 3, 0),
(3, 2617237661, '№2', 'Гостьова ', 'Перепустка', 36, 3, 0),
(4, 2885673117, '№3', 'Гостьова ', 'Перепустка', 36, 3, 0),
(5, 3154108573, '№4', 'Гостьова ', 'Перепустка', 36, 3, 0),
;

--
-- Дамп даних таблиці `SKUD_TEMP`
--

INSERT INTO `SKUD_TEMP` (`ID`, `S_DATE`, `S_TIME`, `ID_SENSOR`, `ID_PEOPLE`) VALUES
(1, '2020-09-11', '07:57:07', 2, 1);

--
-- Дамп даних таблиці `SKUD_TIME`
--

INSERT INTO `SKUD_TIME` (`ID`, `S_DATE`, `S_TIME`, `ID_SENSOR`, `ID_PEOPLE`) VALUES
(650045, '2020-10-01', '05:03:16', 2, 1);

--
-- Дамп даних таблиці `SKUD_TIP_PR`
--

INSERT INTO `SKUD_TIP_PR` (`ID`, `NAME`) VALUES
(1, 'Вихід'),
(2, 'Вхід');

--
-- Дамп даних таблиці `SKUD_USER`
--

INSERT INTO `SKUD_USER` (`ID`, `LOGIN`, `PASSWORD`, `ID_USER`) VALUES
(1, 'admin', '55412675ad252ee8f600e3e84492f484', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
