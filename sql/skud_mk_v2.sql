-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Час створення: Лис 30 2021 р., 09:57
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

-- --------------------------------------------------------

--
-- Структура таблиці `SKUD_MODE_SENSOR`
--

CREATE TABLE IF NOT EXISTS `SKUD_MODE_SENSOR` (
`ID` int(11) NOT NULL,
  `NAME` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Хранения названия режимов сенсоров типа регистрационный, проходной и т.д.';

-- --------------------------------------------------------

--
-- Структура таблиці `SKUD_OTDEL`
--

CREATE TABLE IF NOT EXISTS `SKUD_OTDEL` (
`ID` int(10) unsigned NOT NULL,
  `NAME` varchar(255) NOT NULL,
  `P_KEY` int(3) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Структура таблиці `SKUD_SENSOR`
--

CREATE TABLE IF NOT EXISTS `SKUD_SENSOR` (
`ID` int(11) NOT NULL,
  `ID_NOMER` varchar(3) NOT NULL,
  `ID_TIP` int(11) NOT NULL,
  `ID_MODE` int(11) NOT NULL,
  `DESCRIPTION` varchar(255) NOT NULL,
  `CAT_ACCESS` int(11) NOT NULL,
  `ID_AREA` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `SKUD_SOST_PEOPLE`
--

CREATE TABLE IF NOT EXISTS `SKUD_SOST_PEOPLE` (
`ID` int(2) unsigned NOT NULL,
  `NAME` varchar(256) NOT NULL COMMENT 'встрою, отпуск, больндировка,учебаичній, коман'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Структура таблиці `SKUD_SPR_PEOPLE`
--

CREATE TABLE IF NOT EXISTS `SKUD_SPR_PEOPLE` (
`ID` int(10) unsigned NOT NULL,
  `ID_KART` int(10) unsigned NOT NULL,
  `NAME1` varchar(256) NOT NULL,
  `NAME2` varchar(256) NOT NULL,
  `NAME3` varchar(256) NOT NULL,
  `ID_OTDEL` int(3) unsigned NOT NULL,
  `LEVEL_ACCESS` int(1) unsigned NOT NULL,
  `SORT` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=721 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Структура таблиці `SKUD_SPR_SOST`
--

CREATE TABLE IF NOT EXISTS `SKUD_SPR_SOST` (
`ID` int(10) unsigned NOT NULL,
  `NAME` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Структура таблиці `SKUD_STROEVKA`
--

CREATE TABLE IF NOT EXISTS `SKUD_STROEVKA` (
`ID` int(10) unsigned NOT NULL,
  `ID_PEOPLE` int(10) unsigned NOT NULL,
  `ID_SOST_PEOPLE` int(10) unsigned NOT NULL,
  `STR_DATE` date NOT NULL DEFAULT '0000-00-00',
  `STR_TIME` time NOT NULL DEFAULT '00:00:00',
  `TIME_ZAP` time NOT NULL DEFAULT '00:00:00',
  `DATE_ZAp` date NOT NULL DEFAULT '0000-00-00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `SKUD_TEMP`
--

CREATE TABLE IF NOT EXISTS `SKUD_TEMP` (
`ID` int(10) unsigned NOT NULL,
  `S_DATE` date NOT NULL,
  `S_TIME` time NOT NULL,
  `ID_SENSOR` int(11) unsigned NOT NULL,
  `ID_PEOPLE` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2634 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `SKUD_TIME`
--

CREATE TABLE IF NOT EXISTS `SKUD_TIME` (
`ID` int(10) unsigned NOT NULL,
  `S_DATE` date NOT NULL DEFAULT '0000-00-00',
  `S_TIME` time NOT NULL DEFAULT '00:00:00',
  `ID_SENSOR` int(11) unsigned NOT NULL,
  `ID_PEOPLE` int(11) NOT NULL COMMENT 'Связка со справочником людей вместо связки по карточкам'
) ENGINE=InnoDB AUTO_INCREMENT=890723 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Структура таблиці `SKUD_TIP_PR`
--

CREATE TABLE IF NOT EXISTS `SKUD_TIP_PR` (
`ID` int(11) NOT NULL,
  `NAME` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Тип прохода';

-- --------------------------------------------------------

--
-- Структура таблиці `SKUD_USER`
--

CREATE TABLE IF NOT EXISTS `SKUD_USER` (
`ID` int(8) NOT NULL,
  `LOGIN` varchar(50) NOT NULL,
  `PASSWORD` varchar(50) NOT NULL,
  `ID_USER` int(5) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `SKUD_MODE_SENSOR`
--
ALTER TABLE `SKUD_MODE_SENSOR`
 ADD PRIMARY KEY (`ID`);

--
-- Індекси таблиці `SKUD_OTDEL`
--
ALTER TABLE `SKUD_OTDEL`
 ADD UNIQUE KEY `ID` (`ID`);

--
-- Індекси таблиці `SKUD_SENSOR`
--
ALTER TABLE `SKUD_SENSOR`
 ADD PRIMARY KEY (`ID`);

--
-- Індекси таблиці `SKUD_SOST_PEOPLE`
--
ALTER TABLE `SKUD_SOST_PEOPLE`
 ADD UNIQUE KEY `ID` (`ID`);

--
-- Індекси таблиці `SKUD_SPR_PEOPLE`
--
ALTER TABLE `SKUD_SPR_PEOPLE`
 ADD UNIQUE KEY `ID` (`ID`);

--
-- Індекси таблиці `SKUD_SPR_SOST`
--
ALTER TABLE `SKUD_SPR_SOST`
 ADD UNIQUE KEY `ID` (`ID`);

--
-- Індекси таблиці `SKUD_STROEVKA`
--
ALTER TABLE `SKUD_STROEVKA`
 ADD UNIQUE KEY `ID` (`ID`);

--
-- Індекси таблиці `SKUD_TEMP`
--
ALTER TABLE `SKUD_TEMP`
 ADD PRIMARY KEY (`ID`);

--
-- Індекси таблиці `SKUD_TIME`
--
ALTER TABLE `SKUD_TIME`
 ADD UNIQUE KEY `ID` (`ID`);

--
-- Індекси таблиці `SKUD_TIP_PR`
--
ALTER TABLE `SKUD_TIP_PR`
 ADD PRIMARY KEY (`ID`);

--
-- Індекси таблиці `SKUD_USER`
--
ALTER TABLE `SKUD_USER`
 ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `SKUD_MODE_SENSOR`
--
ALTER TABLE `SKUD_MODE_SENSOR`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблиці `SKUD_OTDEL`
--
ALTER TABLE `SKUD_OTDEL`
MODIFY `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=70;
--
-- AUTO_INCREMENT для таблиці `SKUD_SENSOR`
--
ALTER TABLE `SKUD_SENSOR`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT для таблиці `SKUD_SOST_PEOPLE`
--
ALTER TABLE `SKUD_SOST_PEOPLE`
MODIFY `ID` int(2) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `SKUD_SPR_PEOPLE`
--
ALTER TABLE `SKUD_SPR_PEOPLE`
MODIFY `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=721;
--
-- AUTO_INCREMENT для таблиці `SKUD_SPR_SOST`
--
ALTER TABLE `SKUD_SPR_SOST`
MODIFY `ID` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `SKUD_STROEVKA`
--
ALTER TABLE `SKUD_STROEVKA`
MODIFY `ID` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `SKUD_TEMP`
--
ALTER TABLE `SKUD_TEMP`
MODIFY `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2634;
--
-- AUTO_INCREMENT для таблиці `SKUD_TIME`
--
ALTER TABLE `SKUD_TIME`
MODIFY `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=890723;
--
-- AUTO_INCREMENT для таблиці `SKUD_TIP_PR`
--
ALTER TABLE `SKUD_TIP_PR`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблиці `SKUD_USER`
--
ALTER TABLE `SKUD_USER`
MODIFY `ID` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
