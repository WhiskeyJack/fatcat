
-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 24, 2014 at 12:36 AM
-- Server version: 5.5.35-1ubuntu1
-- PHP Version: 5.5.9-1ubuntu4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `catfeeder`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `provider` varchar(255) NOT NULL,
  `client_id` varchar(255) NOT NULL,
  `attributes` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_unique` (`provider`,`client_id`),
  KEY `fk_user_account` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID and primary key',
  `event_type_id` int(10) unsigned NOT NULL COMMENT 'Corresponding event type',
  `name` varchar(50) NOT NULL COMMENT 'Name of this event',
  `quantity` decimal(4,2) unsigned NOT NULL COMMENT 'Quantity given',
  PRIMARY KEY (`id`),
  KEY `event_type_id` (`event_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Contains the defined events' AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `event_type`
--

CREATE TABLE IF NOT EXISTS `event_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID and primary key',
  `name` varchar(50) NOT NULL COMMENT 'Name',
  `description` varchar(254) NOT NULL DEFAULT '' COMMENT 'Description',
  `quantity` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Contains the different feeding event types ' AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `periodic_event`
--

CREATE TABLE IF NOT EXISTS `periodic_event` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID and primary key',
  `event_type_id` int(11) unsigned NOT NULL,
  `every_day` tinyint(1) NOT NULL,
  `monday` tinyint(1) NOT NULL,
  `tuesday` tinyint(1) NOT NULL,
  `wednesday` tinyint(1) NOT NULL,
  `thursday` tinyint(1) NOT NULL,
  `friday` tinyint(1) NOT NULL,
  `saturday` tinyint(1) NOT NULL,
  `sunday` tinyint(1) NOT NULL,
  `interval_in_sec` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `event_type_id` (`event_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE IF NOT EXISTS `profile` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `public_email` varchar(255) DEFAULT NULL,
  `gravatar_email` varchar(255) DEFAULT NULL,
  `gravatar_id` varchar(32) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `bio` text,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(60) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `confirmation_token` varchar(32) DEFAULT NULL,
  `confirmation_sent_at` int(11) DEFAULT NULL,
  `confirmed_at` int(11) DEFAULT NULL,
  `unconfirmed_email` varchar(255) DEFAULT NULL,
  `recovery_token` varchar(32) DEFAULT NULL,
  `recovery_sent_at` int(11) DEFAULT NULL,
  `blocked_at` int(11) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `registered_from` int(11) DEFAULT NULL,
  `logged_in_from` int(11) DEFAULT NULL,
  `logged_in_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_unique_username` (`username`),
  UNIQUE KEY `user_unique_email` (`email`),
  UNIQUE KEY `user_confirmation` (`id`,`confirmation_token`),
  UNIQUE KEY `user_recovery` (`id`,`recovery_token`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `fk_user_account` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`event_type_id`) REFERENCES `event_type` (`id`);

--
-- Constraints for table `periodic_event`
--
ALTER TABLE `periodic_event`
  ADD CONSTRAINT `periodic_event_event_type_id` FOREIGN KEY (`event_type_id`) REFERENCES `event_type` (`id`);

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `fk_user_profile` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
