CREATE DATABASE IF NOT EXISTS libretube DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE libretube;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS libretube_config (
  ID smallint(2) NOT NULL,
  ChannelName varchar(50) NOT NULL,
  urlBanner longtext,
  Logotipo longtext,
  ChannelDescription longtext,
  `Language` enum('de','en','eo','es','fr','ja','ko','pt','pt-br','ru','zh') NOT NULL DEFAULT 'pt-br' COMMENT 'Codificação https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS libretube_playlist_head (
  ID bigint(5) unsigned NOT NULL,
  Title varchar(100) NOT NULL,
  Description longtext,
  timeRegistration timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  timeUpdate timestamp NULL DEFAULT NULL,
  timePublish timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS libretube_playlist_videos (
  ID bigint(10) unsigned NOT NULL,
  idPlaylist bigint(5) unsigned NOT NULL,
  idVideo bigint(20) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS libretube_users (
  ID bigint(20) unsigned NOT NULL,
  Username varchar(50) NOT NULL,
  Email varchar(50) NOT NULL,
  Senha varchar(50) NOT NULL,
  SenhaAuth varchar(50) DEFAULT NULL,
  urlAvatar longtext,
  Created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  LastLogin timestamp NULL DEFAULT NULL,
  NivelDeAcesso enum('none','user','moderator','owner') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS libretube_videos (
  ID bigint(20) unsigned NOT NULL,
  urlVideo longtext NOT NULL,
  videoTypeLink enum('remote','local','redirect') NOT NULL DEFAULT 'remote',
  urlPoster longtext NOT NULL,
  posterTypeLink enum('remote','local') NOT NULL DEFAULT 'remote',
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE libretube_config
  ADD PRIMARY KEY (ID);

ALTER TABLE libretube_playlist_head
  ADD PRIMARY KEY (ID);

ALTER TABLE libretube_playlist_videos
  ADD PRIMARY KEY (ID);

ALTER TABLE libretube_users
  ADD PRIMARY KEY (ID);

ALTER TABLE libretube_videos
  ADD PRIMARY KEY (ID);


ALTER TABLE libretube_config
  MODIFY ID smallint(2) NOT NULL AUTO_INCREMENT;

ALTER TABLE libretube_playlist_head
  MODIFY ID bigint(5) unsigned NOT NULL AUTO_INCREMENT;

ALTER TABLE libretube_playlist_videos
  MODIFY ID bigint(10) unsigned NOT NULL AUTO_INCREMENT;

ALTER TABLE libretube_users
  MODIFY ID bigint(20) unsigned NOT NULL AUTO_INCREMENT;

ALTER TABLE libretube_videos
  MODIFY ID bigint(20) unsigned NOT NULL AUTO_INCREMENT;
