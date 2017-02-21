CREATE DATABASE IF NOT EXISTS opentube DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE opentube;

CREATE TABLE IF NOT EXISTS opentube_config (
  ID smallint(2) NOT NULL AUTO_INCREMENT,
  ChannelName text NOT NULL,
  urlBanner longtext,
  Logotipo text,
  ChannelDescription longtext,
  PRIMARY KEY (ID)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS opentube_users (
  ID bigint(20) NOT NULL AUTO_INCREMENT,
  Username varchar(50) NOT NULL,
  Email varchar(50) NOT NULL,
  Senha varchar(50) NOT NULL,
  SenhaAuth varchar(50) DEFAULT NULL,
  urlAvatar longtext,
  Created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  LastLogin timestamp NULL DEFAULT NULL,
  NivelDeAcesso enum('none','user','moderator','owner') NOT NULL DEFAULT 'user',
  PRIMARY KEY (ID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS opentube_videos (
  ID bigint(20) NOT NULL AUTO_INCREMENT,
  urlVideo text NOT NULL,
  videoTypeLink enum('remote','local','redirect') NOT NULL DEFAULT 'remote',
  urlPoster text,
  posterTypeLink enum('remote','local') NOT NULL DEFAULT 'remote',
  Title varchar(100) NOT NULL,
  Description longtext NOT NULL,
  timeRegistration timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  timeUpdate timestamp NULL DEFAULT NULL,
  timePublish timestamp NULL DEFAULT NULL,
  views bigint(20) NOT NULL DEFAULT '0',
  shared int(11) NOT NULL DEFAULT '0',
  shareIDs longtext NOT NULL,
  PRIMARY KEY (ID)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
