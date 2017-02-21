-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Tempo de geração: 19/04/2016 às 12:49
-- Versão do servidor: 5.5.44-0+deb8u1
-- Versão do PHP: 5.6.14-0+deb8u1

-- --------------------------------------------------------

CREATE DATABASE IF NOT EXISTS libretube DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE libretube;

CREATE TABLE IF NOT EXISTS libretube_config (
  ID smallint(2) NOT NULL AUTO_INCREMENT,
  ChannelName varchar(50) NOT NULL,
  urlBanner longtext,
  Logotipo text,
  ChannelDescription longtext,
  `Language` enum('de','en','eo','es','fr','ja','ko','pt','pt-br','ru','zh') NOT NULL DEFAULT 'pt-br' COMMENT 'Codificação https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes',
  PRIMARY KEY (ID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS libretube_playlist_head (
  ID bigint(5) NOT NULL AUTO_INCREMENT,
  Title varchar(100) NOT NULL,
  Description text,
  timeRegistration timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  timeUpdate timestamp NULL DEFAULT NULL,
  timePublish timestamp NULL DEFAULT NULL,
  PRIMARY KEY (ID)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS libretube_playlist_videos (
  ID bigint(10) unsigned NOT NULL AUTO_INCREMENT,
  idPlaylist bigint(5) unsigned NOT NULL,
  idVideo bigint(20) unsigned NOT NULL,
  PRIMARY KEY (ID)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS libretube_users (
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

CREATE TABLE IF NOT EXISTS libretube_videos (
  ID bigint(20) NOT NULL AUTO_INCREMENT,
  urlVideo text NOT NULL,
  videoTypeLink enum('remote','local','redirect') NOT NULL DEFAULT 'remote',
  urlPoster text,
  posterTypeLink enum('remote','local') NOT NULL DEFAULT 'remote',
  urlSubtitle text,
  subtitleTypeLink enum('none','remote','local') NOT NULL DEFAULT 'none',
  Title varchar(100) NOT NULL,
  Description longtext NOT NULL,
  timeRegistration timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  timeUpdate timestamp NULL DEFAULT NULL,
  timePublish timestamp NULL DEFAULT NULL,
  views bigint(20) NOT NULL DEFAULT '0',
  shared int(11) NOT NULL DEFAULT '0',
  shareIDs longtext NOT NULL,
  PRIMARY KEY (ID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;