-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Мар 25 2013 г., 12:15
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- База данных: `db_takzdorovo`
--

-- --------------------------------------------------------

--
-- Структура таблицы `prefix_consultingroom`
--

CREATE TABLE IF NOT EXISTS `prefix_consultingroom` (
  `consultingroom_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(128) NOT NULL COMMENT 'Название кабинета',
  `description_short` varchar(256) DEFAULT NULL COMMENT 'Краткое описание специалиста/кабинета',
  `published` int(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`consultingroom_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Специалисты констультаций' AUTO_INCREMENT=2 ;

--
-- Структура таблицы `prefix_consultingroom_communication`
--

CREATE TABLE IF NOT EXISTS `prefix_consultingroom_communication` (
  `communication_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `consultingroom_id` int(10) unsigned NOT NULL,
  `communication_question_date` int(11) NOT NULL COMMENT 'Дата и время, когда был задан вопрос',
  `communication_enquirer` varchar(128) NOT NULL COMMENT 'Задавший вопрос: ФИО, имя, ник...',
  `communication_enquirer_mail` varchar(128) NOT NULL DEFAULT '' COMMENT 'Почта задавшего вопрос',
  `communication_published` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Опубликовано для посетителей',
  `communication_answer_date` int(11) DEFAULT '0' COMMENT 'Дата и время ответа',
  `communication_question` text NOT NULL COMMENT 'Вопрос',
  `communication_answer` text COMMENT 'Ответ',
  PRIMARY KEY (`communication_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Общение со специалистом в режиме вопрос-ответ' AUTO_INCREMENT=6 ;

--
-- Структура таблицы `prefix_consultingroom_news`
--

CREATE TABLE IF NOT EXISTS `prefix_consultingroom_news` (
  `news_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `consultingroom_id` int(10) unsigned NOT NULL,
  `news_date_created` int(11) NOT NULL COMMENT 'Дата создания новости',
  `news_date_edited` int(11) NOT NULL COMMENT 'Дата последнего редактирования новости',
  `news_date` int(11) NOT NULL COMMENT 'Дата новости',
  `news_published` tinyint(1) NOT NULL DEFAULT '0',
  `news_text` text NOT NULL COMMENT 'Текст новости',
  PRIMARY KEY (`news_id`),
  KEY `news_date` (`news_date`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Новости кабинета консультаций' AUTO_INCREMENT=7 ;
