-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 22-06-2021 a las 12:03:25
-- Versión del servidor: 10.5.10-MariaDB
-- Versión de PHP: 7.4.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `afigest`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afi_attachments`
--

CREATE TABLE IF NOT EXISTS `afi_attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `incidencia_id` int(11) NOT NULL,
  `image` varchar(150) NOT NULL,
  `path` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afi_comments`
--

CREATE TABLE IF NOT EXISTS `afi_comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_txt` longtext NOT NULL,
  `comment_data` datetime NOT NULL,
  `comment_user` int(11) NOT NULL,
  `comment_issue` int(11) NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afi_comments_notices`
--

CREATE TABLE IF NOT EXISTS `afi_comments_notices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_id` int(11) NOT NULL,
  `issue_id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afi_config`
--

CREATE TABLE IF NOT EXISTS `afi_config` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `site` varchar(50) NOT NULL,
  `offline` tinyint(1) NOT NULL DEFAULT 0,
  `log` varchar(50) NOT NULL,
  `sitename` varchar(50) NOT NULL DEFAULT 'Foxy',
  `description` varchar(150) NOT NULL,
  `email` varchar(50) NOT NULL,
  `debug` tinyint(1) NOT NULL DEFAULT 0,
  `token_time` int(4) NOT NULL DEFAULT 300,
  `template` varchar(50) NOT NULL,
  `cookie` int(4) NOT NULL DEFAULT 300,
  `admin_mails` tinyint(1) NOT NULL DEFAULT 0,
  `inactive` int(5) NOT NULL DEFAULT 1000,
  `login_redirect` varchar(150) NOT NULL,
  `show_register` tinyint(1) NOT NULL DEFAULT 0,
  `show_coins` tinyint(1) NOT NULL DEFAULT 0,
  `show_quotes` tinyint(1) NOT NULL DEFAULT 0,
  `pagination` int(5) NOT NULL DEFAULT 20,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afi_hores`
--

CREATE TABLE IF NOT EXISTS `afi_hores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 entrada; 0 sortida',
  `registre` datetime NOT NULL,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afi_incidencies`
--

CREATE TABLE IF NOT EXISTS `afi_incidencies` (
  `incidencia_id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `tipus` tinyint(1) DEFAULT NULL COMMENT '1-nova funcio;2-error;3-millora ',
  `estat` tinyint(1) DEFAULT NULL COMMENT '1-pendent;2-progres;3-resolt;4-descartat ',
  `parentId` int(11) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `projecteId` int(11) DEFAULT NULL,
  `usergroup` int(11) NOT NULL DEFAULT 2,
  `num_incidencia` int(11) NOT NULL,
  `prioritat` tinyint(1) DEFAULT NULL COMMENT '1-normal;2-urgent;3-panic',
  `usuari` int(11) DEFAULT NULL,
  `altres_usuaris` varchar(50) DEFAULT NULL,
  `tags` varchar(150) NOT NULL,
  `temps_previst` int(5) DEFAULT NULL,
  `data_incidencia` datetime DEFAULT NULL,
  `data_limit` date DEFAULT NULL,
  `data_actualitzacio` datetime DEFAULT NULL,
  `data_resolucio` datetime DEFAULT NULL,
  `data_factura` datetime NOT NULL,
  `facturat` tinyint(1) NOT NULL DEFAULT 0,
  `descripcio` text DEFAULT NULL,
  `temps_invertit` int(10) DEFAULT NULL,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`incidencia_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afi_languages`
--

CREATE TABLE IF NOT EXISTS `afi_languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `code` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 no;1 yes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afi_menu`
--

CREATE TABLE IF NOT EXISTS `afi_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `translation` varchar(150) NOT NULL,
  `url` varchar(150) NOT NULL,
  `auth` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 no login;1login',
  `type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 Link;1 modal',
  `module` varchar(150) NOT NULL,
  `template` varchar(50) NOT NULL,
  `inMenu` tinyint(1) NOT NULL DEFAULT 0,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afi_messages`
--

CREATE TABLE IF NOT EXISTS `afi_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `titol` varchar(255) NOT NULL,
  `incidencia_id` int(11) NOT NULL,
  `estat` tinyint(1) NOT NULL DEFAULT 0,
  `estatMobil` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afi_projectes`
--

CREATE TABLE IF NOT EXISTS `afi_projectes` (
  `projecte_id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(150) NOT NULL,
  `abreujatura` varchar(5) DEFAULT NULL,
  `observacions` text NOT NULL,
  `slack_channel` varchar(150) NOT NULL,
  `ref_externa` varchar(20) NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`projecte_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afi_sessions`
--

CREATE TABLE IF NOT EXISTS `afi_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `ssid` varchar(150) NOT NULL,
  `lastvisitDate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afi_settings`
--

CREATE TABLE IF NOT EXISTS `afi_settings` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `site` varchar(50) NOT NULL,
  `offline` tinyint(1) NOT NULL DEFAULT 0,
  `log` varchar(50) NOT NULL,
  `sitename` varchar(50) NOT NULL DEFAULT 'Foxy',
  `description` varchar(150) NOT NULL,
  `email` varchar(50) NOT NULL,
  `debug` tinyint(1) NOT NULL DEFAULT 0,
  `token_time` int(4) NOT NULL DEFAULT 300,
  `template` varchar(50) NOT NULL,
  `cookie` int(4) NOT NULL DEFAULT 300,
  `admin_mails` tinyint(1) NOT NULL DEFAULT 0,
  `inactive` int(5) NOT NULL DEFAULT 1000,
  `login_redirect` varchar(150) NOT NULL,
  `show_register` tinyint(1) NOT NULL DEFAULT 0,
  `pagination` int(5) NOT NULL DEFAULT 20,
  `analytics` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afi_tipus_incidencia`
--

CREATE TABLE IF NOT EXISTS `afi_tipus_incidencia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(150) NOT NULL,
  `bg_color` varchar(50) NOT NULL,
  `txt_color` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afi_usergroups`
--

CREATE TABLE IF NOT EXISTS `afi_usergroups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `usergroup` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afi_usergroups_map`
--

CREATE TABLE IF NOT EXISTS `afi_usergroups_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupId` int(11) NOT NULL DEFAULT 0,
  `params` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afi_users`
--

CREATE TABLE IF NOT EXISTS `afi_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(150) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `registerDate` datetime NOT NULL,
  `lastvisitDate` datetime NOT NULL DEFAULT current_timestamp(),
  `level` smallint(1) NOT NULL,
  `language` varchar(50) NOT NULL,
  `token` varchar(150) NOT NULL,
  `block` smallint(1) NOT NULL DEFAULT 1,
  `image` varchar(150) NOT NULL DEFAULT 'nouser.png',
  `cargo` varchar(150) NOT NULL DEFAULT '',
  `bio` text NOT NULL DEFAULT '',
  `address` varchar(150) NOT NULL DEFAULT '',
  `cp` varchar(50) NOT NULL DEFAULT '',
  `poblacio` varchar(100) NOT NULL DEFAULT '',
  `template` varchar(50) NOT NULL DEFAULT '',
  `apikey` varchar(150) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
