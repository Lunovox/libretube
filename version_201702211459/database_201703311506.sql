CREATE DATABASE IF NOT EXISTS libretube DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE libretube;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS libretube_comments (
  ID bigint(20) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
  VideoID bigint(20) unsigned NOT NULL,
  UserID bigint(20) unsigned NOT NULL,
  timePublish timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Comment` longtext NOT NULL
) CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS libretube_config (
  ID smallint(2) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  ChannelName varchar(50) NOT NULL,
  urlBanner longtext,
  Logotipo longtext,
  ChannelDescription longtext,
  `Language` enum('de','en','eo','es','fr','ja','ko','pt','pt-br','ru','zh') NOT NULL DEFAULT 'pt-br' COMMENT 'Codificação https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes'
) CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS libretube_playlist_head (
  ID bigint(5) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
  Title varchar(100) NOT NULL,
  Description longtext,
  timeRegistration timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  timeUpdate timestamp NULL DEFAULT NULL,
  timePublish timestamp NULL DEFAULT NULL
) CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS libretube_playlist_videos (
  ID bigint(10) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
  idPlaylist bigint(5) unsigned NOT NULL,
  idVideo bigint(20) unsigned NOT NULL
) CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS libretube_users (
  ID bigint(20) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
  Username varchar(50) NOT NULL,
  Email varchar(50) NOT NULL,
  Senha varchar(50) NOT NULL,
  SenhaAuth varchar(50) DEFAULT NULL,
  urlAvatar longtext,
  Created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  LastLogin timestamp NULL DEFAULT NULL,
  NivelDeAcesso enum('none','user','moderator','owner') NOT NULL DEFAULT 'user'
) CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS libretube_videos (
  ID bigint(20) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
  urlVideo longtext NOT NULL,
  videoTypeLink enum('remote','local','redirect') NOT NULL DEFAULT 'remote',
  urlPoster longtext NOT NULL,
  posterTypeLink set('auto','local','remote') NOT NULL DEFAULT 'auto',
  urlSubtitle longtext NOT NULL,
  subtitleTypeLink enum('none','remote','local') NOT NULL DEFAULT 'none',
  Title varchar(100) NOT NULL,
  Description longtext NOT NULL,
  timeRegistration timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  timeUpdate timestamp NULL DEFAULT NULL,
  timePublish timestamp NULL DEFAULT NULL,
  views bigint(20) NOT NULL DEFAULT '0',
  shared int(11) NOT NULL DEFAULT '0',
  shareIDs longtext NOT NULL
) CHARSET=utf8;


