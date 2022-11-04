-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 09, 2020 at 10:37 AM
-- Server version: 5.7.30-0ubuntu0.16.04.1
-- PHP Version: 7.2.30-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mqttdata`
--

-- --------------------------------------------------------

--
-- Table structure for table `algorithm`
--

CREATE TABLE `algorithm` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `push_message` text,
  `hour` int(11) DEFAULT NULL,
  `minute` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `readflag` int(11) NOT NULL,
  `readflaguserid` int(11) NOT NULL,
  `moreconditionflag` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `algorithm_sensor`
--

CREATE TABLE `algorithm_sensor` (
  `id` int(10) UNSIGNED NOT NULL,
  `algorithm_id` int(11) NOT NULL,
  `groupid` int(11) DEFAULT NULL,
  `hub` int(11) DEFAULT NULL,
  `sensor` int(11) DEFAULT NULL,
  `choose` tinyint(4) DEFAULT NULL,
  `condition1` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `condition2` varchar(20) DEFAULT NULL,
  `min_value` varchar(20) DEFAULT NULL,
  `max_value` varchar(20) DEFAULT NULL,
  `noneflag` int(11) NOT NULL,
  `condition1values` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `algotemp`
--

CREATE TABLE `algotemp` (
  `id` int(11) NOT NULL,
  `utc` varchar(200) DEFAULT NULL,
  `hub` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sensor_id` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `sensor_type` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `unit` text CHARACTER SET utf8,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `processedflag` int(11) DEFAULT '0',
  `processedflagall` int(5) DEFAULT '0',
  `loginid` int(11) DEFAULT NULL,
  `agentname` varchar(255) DEFAULT NULL,
  `gatewaygrp` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `chart`
--

CREATE TABLE `chart` (
  `id` int(15) NOT NULL,
  `unit` varchar(55) CHARACTER SET utf8 NOT NULL,
  `name` varchar(55) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dbo_payloader`
--

CREATE TABLE `dbo_payloader` (
  `id` int(11) NOT NULL,
  `utc` varchar(200) DEFAULT NULL,
  `hub` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sensor_id` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `sensor_type` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `unit` text CHARACTER SET utf8,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `processedflag` int(11) DEFAULT '0',
  `processedflagall` int(5) DEFAULT '0',
  `agent` varchar(255) DEFAULT NULL,
  `group_id` varchar(255) DEFAULT NULL,
  `hubflag` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dbo_payloaderalgorithmtemp`
--

CREATE TABLE `dbo_payloaderalgorithmtemp` (
  `id` int(11) NOT NULL,
  `utc` varchar(200) DEFAULT NULL,
  `hub` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sensor_id` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `sensor_type` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `unit` text CHARACTER SET utf8,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `processedflag` int(11) DEFAULT '0',
  `processedflagall` int(5) DEFAULT '0',
  `loginid` int(11) DEFAULT NULL,
  `agentname` varchar(255) DEFAULT NULL,
  `gatewaygrp` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dbo_payloaderalgorithmtemp298`
--

CREATE TABLE `dbo_payloaderalgorithmtemp298` (
  `id` int(11) NOT NULL,
  `utc` varchar(200) DEFAULT NULL,
  `hub` varchar(255) DEFAULT NULL,
  `sensor_id` varchar(200) DEFAULT NULL,
  `sensor_type` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `unit` text,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `processedflag` int(11) DEFAULT NULL,
  `processedflagall` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dbo_payloaderalgorithmtemp314`
--

CREATE TABLE `dbo_payloaderalgorithmtemp314` (
  `id` int(11) NOT NULL,
  `utc` varchar(200) DEFAULT NULL,
  `hub` varchar(255) DEFAULT NULL,
  `sensor_id` varchar(200) DEFAULT NULL,
  `sensor_type` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `unit` text,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `processedflag` int(11) DEFAULT NULL,
  `processedflagall` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dbo_payloaderalgorithmtemp318`
--

CREATE TABLE `dbo_payloaderalgorithmtemp318` (
  `id` int(11) NOT NULL,
  `utc` varchar(200) DEFAULT NULL,
  `hub` varchar(255) DEFAULT NULL,
  `sensor_id` varchar(200) DEFAULT NULL,
  `sensor_type` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `unit` text,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `processedflag` int(11) DEFAULT NULL,
  `processedflagall` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dbo_payloaderalgorithmtemp319`
--

CREATE TABLE `dbo_payloaderalgorithmtemp319` (
  `id` int(11) NOT NULL,
  `utc` varchar(200) DEFAULT NULL,
  `hub` varchar(255) DEFAULT NULL,
  `sensor_id` varchar(200) DEFAULT NULL,
  `sensor_type` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `unit` text,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `processedflag` int(11) DEFAULT NULL,
  `processedflagall` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dbo_payloaderalgorithmtemp323`
--

CREATE TABLE `dbo_payloaderalgorithmtemp323` (
  `id` int(11) NOT NULL,
  `utc` varchar(200) DEFAULT NULL,
  `hub` varchar(255) DEFAULT NULL,
  `sensor_id` varchar(200) DEFAULT NULL,
  `sensor_type` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `unit` text,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `processedflag` int(11) DEFAULT NULL,
  `processedflagall` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dbo_payloaderalgorithmtemp325`
--

CREATE TABLE `dbo_payloaderalgorithmtemp325` (
  `id` int(11) NOT NULL,
  `utc` varchar(200) DEFAULT NULL,
  `hub` varchar(255) DEFAULT NULL,
  `sensor_id` varchar(200) DEFAULT NULL,
  `sensor_type` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `unit` text,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `processedflag` int(11) DEFAULT NULL,
  `processedflagall` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dbo_payloaderalgorithmtemp340`
--

CREATE TABLE `dbo_payloaderalgorithmtemp340` (
  `id` int(11) NOT NULL,
  `utc` varchar(200) DEFAULT NULL,
  `hub` varchar(255) DEFAULT NULL,
  `sensor_id` varchar(200) DEFAULT NULL,
  `sensor_type` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `unit` text,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `processedflag` int(11) DEFAULT NULL,
  `processedflagall` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dbo_payloaderalgorithmtemp341`
--

CREATE TABLE `dbo_payloaderalgorithmtemp341` (
  `id` int(11) NOT NULL,
  `utc` varchar(200) DEFAULT NULL,
  `hub` varchar(255) DEFAULT NULL,
  `sensor_id` varchar(200) DEFAULT NULL,
  `sensor_type` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `unit` text,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `processedflag` int(11) DEFAULT NULL,
  `processedflagall` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dbo_payloaderalgorithmtemp342`
--

CREATE TABLE `dbo_payloaderalgorithmtemp342` (
  `id` int(11) NOT NULL,
  `utc` varchar(200) DEFAULT NULL,
  `hub` varchar(255) DEFAULT NULL,
  `sensor_id` varchar(200) DEFAULT NULL,
  `sensor_type` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `unit` text,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `processedflag` int(11) DEFAULT NULL,
  `processedflagall` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dbo_payloaderalgorithmtemp343`
--

CREATE TABLE `dbo_payloaderalgorithmtemp343` (
  `id` int(11) NOT NULL,
  `utc` varchar(200) DEFAULT NULL,
  `hub` varchar(255) DEFAULT NULL,
  `sensor_id` varchar(200) DEFAULT NULL,
  `sensor_type` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `unit` text,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `processedflag` int(11) DEFAULT NULL,
  `processedflagall` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dbo_payloaderalgorithmtempandor`
--

CREATE TABLE `dbo_payloaderalgorithmtempandor` (
  `id` int(11) NOT NULL,
  `utc` varchar(200) DEFAULT NULL,
  `hub` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sensor_id` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `sensor_type` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `unit` text CHARACTER SET utf8,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `processedflag` int(11) DEFAULT '0',
  `processedflagall` int(5) DEFAULT '0',
  `loginid` int(11) DEFAULT NULL,
  `agentname` varchar(255) DEFAULT NULL,
  `gatewaygrp` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dbo_payloaderalgorithmtempandor298`
--

CREATE TABLE `dbo_payloaderalgorithmtempandor298` (
  `id` int(11) NOT NULL,
  `utc` varchar(200) DEFAULT NULL,
  `hub` varchar(255) DEFAULT NULL,
  `sensor_id` varchar(200) DEFAULT NULL,
  `sensor_type` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `unit` text,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `processedflag` int(11) DEFAULT NULL,
  `processedflagall` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dbo_payloaderalgorithmtempandor314`
--

CREATE TABLE `dbo_payloaderalgorithmtempandor314` (
  `id` int(11) NOT NULL,
  `utc` varchar(200) DEFAULT NULL,
  `hub` varchar(255) DEFAULT NULL,
  `sensor_id` varchar(200) DEFAULT NULL,
  `sensor_type` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `unit` text,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `processedflag` int(11) DEFAULT NULL,
  `processedflagall` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dbo_payloaderalgorithmtempandor318`
--

CREATE TABLE `dbo_payloaderalgorithmtempandor318` (
  `id` int(11) NOT NULL,
  `utc` varchar(200) DEFAULT NULL,
  `hub` varchar(255) DEFAULT NULL,
  `sensor_id` varchar(200) DEFAULT NULL,
  `sensor_type` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `unit` text,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `processedflag` int(11) DEFAULT NULL,
  `processedflagall` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dbo_payloaderalgorithmtempandor319`
--

CREATE TABLE `dbo_payloaderalgorithmtempandor319` (
  `id` int(11) NOT NULL,
  `utc` varchar(200) DEFAULT NULL,
  `hub` varchar(255) DEFAULT NULL,
  `sensor_id` varchar(200) DEFAULT NULL,
  `sensor_type` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `unit` text,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `processedflag` int(11) DEFAULT NULL,
  `processedflagall` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dbo_payloaderalgorithmtempandor323`
--

CREATE TABLE `dbo_payloaderalgorithmtempandor323` (
  `id` int(11) NOT NULL,
  `utc` varchar(200) DEFAULT NULL,
  `hub` varchar(255) DEFAULT NULL,
  `sensor_id` varchar(200) DEFAULT NULL,
  `sensor_type` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `unit` text,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `processedflag` int(11) DEFAULT NULL,
  `processedflagall` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dbo_payloaderalgorithmtempandor325`
--

CREATE TABLE `dbo_payloaderalgorithmtempandor325` (
  `id` int(11) NOT NULL,
  `utc` varchar(200) DEFAULT NULL,
  `hub` varchar(255) DEFAULT NULL,
  `sensor_id` varchar(200) DEFAULT NULL,
  `sensor_type` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `unit` text,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `processedflag` int(11) DEFAULT NULL,
  `processedflagall` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dbo_payloaderalgorithmtempandor340`
--

CREATE TABLE `dbo_payloaderalgorithmtempandor340` (
  `id` int(11) NOT NULL,
  `utc` varchar(200) DEFAULT NULL,
  `hub` varchar(255) DEFAULT NULL,
  `sensor_id` varchar(200) DEFAULT NULL,
  `sensor_type` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `unit` text,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `processedflag` int(11) DEFAULT NULL,
  `processedflagall` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dbo_payloaderalgorithmtempandor341`
--

CREATE TABLE `dbo_payloaderalgorithmtempandor341` (
  `id` int(11) NOT NULL,
  `utc` varchar(200) DEFAULT NULL,
  `hub` varchar(255) DEFAULT NULL,
  `sensor_id` varchar(200) DEFAULT NULL,
  `sensor_type` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `unit` text,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `processedflag` int(11) DEFAULT NULL,
  `processedflagall` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dbo_payloaderalgorithmtempandor342`
--

CREATE TABLE `dbo_payloaderalgorithmtempandor342` (
  `id` int(11) NOT NULL,
  `utc` varchar(200) DEFAULT NULL,
  `hub` varchar(255) DEFAULT NULL,
  `sensor_id` varchar(200) DEFAULT NULL,
  `sensor_type` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `unit` text,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `processedflag` int(11) DEFAULT NULL,
  `processedflagall` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dbo_payloaderalgorithmtempandor343`
--

CREATE TABLE `dbo_payloaderalgorithmtempandor343` (
  `id` int(11) NOT NULL,
  `utc` varchar(200) DEFAULT NULL,
  `hub` varchar(255) DEFAULT NULL,
  `sensor_id` varchar(200) DEFAULT NULL,
  `sensor_type` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `unit` text,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `processedflag` int(11) DEFAULT NULL,
  `processedflagall` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dbo_payloadercharttemp`
--

CREATE TABLE `dbo_payloadercharttemp` (
  `id` int(11) NOT NULL,
  `utc` varchar(200) DEFAULT NULL,
  `hub` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sensor_id` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `sensor_type` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `unit` text CHARACTER SET utf8,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `processedflag` int(11) DEFAULT '0',
  `processedflagall` int(5) DEFAULT '0',
  `loginid` int(11) NOT NULL,
  `agentname` varchar(255) NOT NULL,
  `gatewaygrp` varchar(255) DEFAULT NULL,
  `hub_sensorid` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dbo_payloadercharttemphub`
--

CREATE TABLE `dbo_payloadercharttemphub` (
  `id` int(11) NOT NULL,
  `utc` varchar(200) DEFAULT NULL,
  `hub` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sensor_id` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `sensor_type` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `unit` text CHARACTER SET utf8,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `processedflag` int(11) DEFAULT '0',
  `processedflagall` int(5) DEFAULT '0',
  `loginid` int(11) NOT NULL DEFAULT '0',
  `agentname` varchar(255) DEFAULT NULL,
  `gatewaygrp` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dbo_payloaderremovedup`
--

CREATE TABLE `dbo_payloaderremovedup` (
  `id` int(11) NOT NULL,
  `utc` varchar(200) DEFAULT NULL,
  `hub` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sensor_id` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `sensor_type` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `unit` text CHARACTER SET utf8,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `processedflag` int(11) DEFAULT '0',
  `processedflagall` int(5) DEFAULT '0',
  `agent` varchar(255) DEFAULT NULL,
  `group_id` varchar(255) DEFAULT NULL,
  `hubflag` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dbo_payloadertempalg`
--

CREATE TABLE `dbo_payloadertempalg` (
  `id` int(11) NOT NULL,
  `utc` varchar(200) DEFAULT NULL,
  `hub` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sensor_id` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `sensor_type` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `unit` text CHARACTER SET utf8,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `processedflag` int(11) DEFAULT '0',
  `processedflagall` int(5) DEFAULT '0',
  `agent` varchar(255) DEFAULT NULL,
  `group_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `demo`
--

CREATE TABLE `demo` (
  `id` int(11) NOT NULL,
  `utc` varchar(200) DEFAULT NULL,
  `hub` varchar(255) DEFAULT NULL,
  `sensor_id` varchar(200) DEFAULT NULL,
  `sensor_type` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `unit` text,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `processedflag` int(11) DEFAULT NULL,
  `processedflagall` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gateway_groups`
--

CREATE TABLE `gateway_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `group_id` varchar(255) DEFAULT NULL,
  `agent` int(11) DEFAULT NULL,
  `sensor_group_id` int(11) DEFAULT NULL,
  `sim_no` varchar(255) DEFAULT NULL,
  `router_sensor_no` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `sensor_information` text,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `added_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `hubcharttemp`
--

CREATE TABLE `hubcharttemp` (
  `id` int(11) NOT NULL,
  `value1` int(11) NOT NULL,
  `value2` int(11) NOT NULL,
  `value3` int(11) NOT NULL,
  `value4` int(11) NOT NULL,
  `value5` int(11) NOT NULL,
  `value6` int(11) NOT NULL,
  `value7` int(11) NOT NULL,
  `value8` int(11) NOT NULL,
  `value9` int(11) NOT NULL,
  `value10` int(11) NOT NULL,
  `value11` int(11) NOT NULL,
  `value12` int(11) NOT NULL,
  `value13` int(11) NOT NULL,
  `value14` int(11) NOT NULL,
  `value15` int(11) NOT NULL,
  `value16` int(11) NOT NULL,
  `value17` int(11) NOT NULL,
  `value18` int(11) NOT NULL,
  `value19` int(11) NOT NULL,
  `value20` int(11) NOT NULL,
  `value21` int(11) NOT NULL,
  `value22` int(11) NOT NULL,
  `value23` int(11) NOT NULL,
  `value24` int(11) NOT NULL,
  `value25` int(11) NOT NULL,
  `time1` int(11) NOT NULL,
  `time2` int(11) NOT NULL,
  `time3` int(11) NOT NULL,
  `time4` int(11) NOT NULL,
  `time5` int(11) NOT NULL,
  `time6` int(11) NOT NULL,
  `time7` int(11) NOT NULL,
  `time8` int(11) NOT NULL,
  `time9` int(11) NOT NULL,
  `time10` int(11) NOT NULL,
  `time11` int(11) NOT NULL,
  `time12` int(11) NOT NULL,
  `time13` int(11) NOT NULL,
  `time14` int(11) NOT NULL,
  `time15` int(11) NOT NULL,
  `time16` int(11) NOT NULL,
  `time17` int(11) NOT NULL,
  `time18` int(11) NOT NULL,
  `time19` int(11) NOT NULL,
  `time20` int(11) NOT NULL,
  `time21` int(11) NOT NULL,
  `time22` int(11) NOT NULL,
  `time23` int(11) NOT NULL,
  `time24` int(11) NOT NULL,
  `time25` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hubdata`
--

CREATE TABLE `hubdata` (
  `id` int(15) NOT NULL,
  `hub` text CHARACTER SET utf8,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hubs`
--

CREATE TABLE `hubs` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `hubstore`
--

CREATE TABLE `hubstore` (
  `id` int(15) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loc`
--

CREATE TABLE `loc` (
  `id` int(10) NOT NULL,
  `loc` varchar(255) DEFAULT NULL,
  `template` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `log_details`
--

CREATE TABLE `log_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(11) NOT NULL,
  `login_status` int(11) NOT NULL,
  `logout_status` int(11) DEFAULT NULL,
  `created_at` varchar(55) DEFAULT NULL,
  `updated_at` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `measurement_units`
--

CREATE TABLE `measurement_units` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` int(255) NOT NULL,
  `minimum` varchar(255) DEFAULT NULL,
  `maximum` varchar(255) DEFAULT NULL,
  `unit` varchar(55) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `permission_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `price` decimal(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pushmessages`
--

CREATE TABLE `pushmessages` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `sensor_type` int(11) NOT NULL,
  `sensor_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sensordata`
--

CREATE TABLE `sensordata` (
  `id` int(15) NOT NULL,
  `hub` text CHARACTER SET utf8,
  `sensor_id` text CHARACTER SET utf8,
  `sensor_type` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `unit` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `value` varchar(255) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sensors`
--

CREATE TABLE `sensors` (
  `id` int(10) UNSIGNED NOT NULL,
  `agent` int(55) DEFAULT NULL,
  `group_id` int(55) DEFAULT NULL,
  `sensor_group_id` int(55) DEFAULT NULL,
  `hub_id` int(11) DEFAULT NULL,
  `sensor_id` text CHARACTER SET utf8,
  `type` int(11) DEFAULT NULL,
  `sensor_type` varchar(555) DEFAULT NULL,
  `unit` varchar(55) DEFAULT NULL,
  `value` varchar(55) DEFAULT '0',
  `sensor_inform` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sensorvalues`
--

CREATE TABLE `sensorvalues` (
  `dataid` int(11) NOT NULL,
  `sensvalues` text,
  `time` text,
  `sensorname` text,
  `loginid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sensorvaluessensors`
--

CREATE TABLE `sensorvaluessensors` (
  `dataid` int(11) NOT NULL,
  `sensvalues` text,
  `time` text,
  `sensorname` text,
  `loginid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sensor_graph`
--

CREATE TABLE `sensor_graph` (
  `id` int(15) NOT NULL,
  `agent` int(15) NOT NULL,
  `sensor_id` int(15) NOT NULL,
  `type` varchar(55) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `yaxis` varchar(55) NOT NULL,
  `min` varchar(255) DEFAULT NULL,
  `max` varchar(255) DEFAULT NULL,
  `fake` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sensor_groups`
--

CREATE TABLE `sensor_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sensor_hubs`
--

CREATE TABLE `sensor_hubs` (
  `id` int(10) UNSIGNED NOT NULL,
  `sensor_hub_id` varchar(255) DEFAULT NULL,
  `agent` int(11) DEFAULT NULL,
  `group_id` int(10) DEFAULT NULL,
  `sensor_group_id` int(11) DEFAULT NULL,
  `hub_id` varchar(255) DEFAULT NULL,
  `hub` varchar(255) DEFAULT NULL,
  `mac_id` varchar(255) DEFAULT NULL,
  `hub_inform` text,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `added_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `admin_email` text,
  `agent_email` text,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payloader`
--

CREATE TABLE `tbl_payloader` (
  `id` int(11) NOT NULL DEFAULT '0',
  `utc` varchar(200) DEFAULT NULL,
  `hub` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sensor_id` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `sensor_type` varchar(200) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `unit` text CHARACTER SET utf8,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `processedflag` int(11) DEFAULT '0',
  `processedflagall` int(5) DEFAULT '0',
  `agent` varchar(255) DEFAULT NULL,
  `group_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `sname` varchar(255) DEFAULT NULL,
  `modal` varchar(255) DEFAULT NULL,
  `min` varchar(55) DEFAULT NULL,
  `max` varchar(55) DEFAULT NULL,
  `remark` text,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `userdatamessages`
--

CREATE TABLE `userdatamessages` (
  `userdatamsgid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `algorithmid` int(11) NOT NULL,
  `algorithm_sensorlist` varchar(255) DEFAULT NULL,
  `payloaderid` int(11) NOT NULL,
  `readflag` int(11) NOT NULL DEFAULT '0',
  `readflaguserid` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `firstcondor` int(11) NOT NULL DEFAULT '0',
  `seccondor` int(11) NOT NULL DEFAULT '0',
  `thirdcondor` int(11) NOT NULL DEFAULT '0',
  `orflag` int(11) NOT NULL DEFAULT '0',
  `noofcond` int(11) NOT NULL DEFAULT '0',
  `fcondgrp` int(11) NOT NULL DEFAULT '0',
  `fcondhub` int(11) NOT NULL DEFAULT '0',
  `fcondsens` int(11) NOT NULL DEFAULT '0',
  `scondgrp` int(11) NOT NULL DEFAULT '0',
  `scondhub` int(11) NOT NULL DEFAULT '0',
  `scondsens` int(11) NOT NULL DEFAULT '0',
  `sensreading` varchar(255) NOT NULL DEFAULT '0',
  `formula` varchar(50) NOT NULL,
  `tcondgrp` int(11) NOT NULL DEFAULT '0',
  `tcondhub` int(11) NOT NULL DEFAULT '0',
  `tcondsens` int(11) NOT NULL DEFAULT '0',
  `user_sensor_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `userdatamessagesagent`
--

CREATE TABLE `userdatamessagesagent` (
  `userdatamsgid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `algorithmid` int(11) NOT NULL,
  `algorithm_sensorlist` varchar(255) DEFAULT NULL,
  `payloaderid` int(11) NOT NULL,
  `readflag` int(11) NOT NULL DEFAULT '0',
  `readflaguserid` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `firstcondor` int(11) NOT NULL DEFAULT '0',
  `seccondor` int(11) NOT NULL DEFAULT '0',
  `thirdcondor` int(11) NOT NULL DEFAULT '0',
  `orflag` int(11) NOT NULL DEFAULT '0',
  `noofcond` int(11) NOT NULL DEFAULT '0',
  `fcondgrp` int(11) NOT NULL DEFAULT '0',
  `fcondhub` int(11) NOT NULL DEFAULT '0',
  `fcondsens` int(11) NOT NULL DEFAULT '0',
  `scondgrp` int(11) NOT NULL DEFAULT '0',
  `scondhub` int(11) NOT NULL DEFAULT '0',
  `scondsens` int(11) NOT NULL DEFAULT '0',
  `sensreading` varchar(255) NOT NULL DEFAULT '0',
  `formula` varchar(50) NOT NULL,
  `tcondgrp` int(11) NOT NULL DEFAULT '0',
  `tcondhub` int(11) NOT NULL DEFAULT '0',
  `tcondsens` int(11) NOT NULL DEFAULT '0',
  `user_sensor_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `fname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `corporate_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_start` varchar(55) CHARACTER SET utf8 DEFAULT NULL,
  `service_expiry` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci,
  `email_template` text COLLATE utf8mb4_unicode_ci,
  `email_verified_at` datetime DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `original` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `log_status` tinyint(4) NOT NULL DEFAULT '0',
  `logintoken` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `weather`
--

CREATE TABLE `weather` (
  `id` int(10) NOT NULL,
  `userid` int(15) DEFAULT NULL,
  `locid` int(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `algorithm`
--
ALTER TABLE `algorithm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `algorithm_sensor`
--
ALTER TABLE `algorithm_sensor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `algotemp`
--
ALTER TABLE `algotemp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unitbb_INDEX` (`unit`(255)) USING BTREE;

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chart`
--
ALTER TABLE `chart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbo_payloader`
--
ALTER TABLE `dbo_payloader`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unit_INDEX` (`unit`(255)),
  ADD KEY `hubindex` (`hub`),
  ADD KEY `sensorindextempdb` (`sensor_id`),
  ADD KEY `timeindexdb` (`time`),
  ADD KEY `valueindex` (`value`);

--
-- Indexes for table `dbo_payloaderalgorithmtemp`
--
ALTER TABLE `dbo_payloaderalgorithmtemp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unit_INDEX4` (`unit`(255)) USING BTREE;

--
-- Indexes for table `dbo_payloaderalgorithmtemp298`
--
ALTER TABLE `dbo_payloaderalgorithmtemp298`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbo_payloaderalgorithmtemp314`
--
ALTER TABLE `dbo_payloaderalgorithmtemp314`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbo_payloaderalgorithmtemp318`
--
ALTER TABLE `dbo_payloaderalgorithmtemp318`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbo_payloaderalgorithmtemp319`
--
ALTER TABLE `dbo_payloaderalgorithmtemp319`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbo_payloaderalgorithmtemp323`
--
ALTER TABLE `dbo_payloaderalgorithmtemp323`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbo_payloaderalgorithmtemp325`
--
ALTER TABLE `dbo_payloaderalgorithmtemp325`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbo_payloaderalgorithmtemp340`
--
ALTER TABLE `dbo_payloaderalgorithmtemp340`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbo_payloaderalgorithmtemp341`
--
ALTER TABLE `dbo_payloaderalgorithmtemp341`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbo_payloaderalgorithmtemp342`
--
ALTER TABLE `dbo_payloaderalgorithmtemp342`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbo_payloaderalgorithmtemp343`
--
ALTER TABLE `dbo_payloaderalgorithmtemp343`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbo_payloaderalgorithmtempandor`
--
ALTER TABLE `dbo_payloaderalgorithmtempandor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unit_INDEX5` (`unit`(255)) USING BTREE;

--
-- Indexes for table `dbo_payloaderalgorithmtempandor298`
--
ALTER TABLE `dbo_payloaderalgorithmtempandor298`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbo_payloaderalgorithmtempandor314`
--
ALTER TABLE `dbo_payloaderalgorithmtempandor314`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbo_payloaderalgorithmtempandor318`
--
ALTER TABLE `dbo_payloaderalgorithmtempandor318`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbo_payloaderalgorithmtempandor319`
--
ALTER TABLE `dbo_payloaderalgorithmtempandor319`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbo_payloaderalgorithmtempandor323`
--
ALTER TABLE `dbo_payloaderalgorithmtempandor323`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbo_payloaderalgorithmtempandor325`
--
ALTER TABLE `dbo_payloaderalgorithmtempandor325`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbo_payloaderalgorithmtempandor340`
--
ALTER TABLE `dbo_payloaderalgorithmtempandor340`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbo_payloaderalgorithmtempandor341`
--
ALTER TABLE `dbo_payloaderalgorithmtempandor341`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbo_payloaderalgorithmtempandor342`
--
ALTER TABLE `dbo_payloaderalgorithmtempandor342`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbo_payloaderalgorithmtempandor343`
--
ALTER TABLE `dbo_payloaderalgorithmtempandor343`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbo_payloadercharttemp`
--
ALTER TABLE `dbo_payloadercharttemp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hubindextemp` (`hub`),
  ADD KEY `timeindextemp` (`time`),
  ADD KEY `valueindextemp` (`value`),
  ADD KEY `sensorindextemp` (`sensor_id`),
  ADD KEY `unit_INDEX2` (`unit`(255)) USING BTREE;

--
-- Indexes for table `dbo_payloadercharttemphub`
--
ALTER TABLE `dbo_payloadercharttemphub`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sensid` (`sensor_id`),
  ADD KEY `timeindexid` (`time`),
  ADD KEY `valueindexid` (`value`),
  ADD KEY `unit_INDEX1` (`unit`(255)) USING BTREE,
  ADD KEY `hubindex_hub` (`hub`) USING BTREE;

--
-- Indexes for table `dbo_payloaderremovedup`
--
ALTER TABLE `dbo_payloaderremovedup`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unit_INDEXdup` (`unit`(255)) USING BTREE,
  ADD KEY `valueindexdup` (`value`) USING BTREE,
  ADD KEY `timeindexdbdup` (`time`) USING BTREE,
  ADD KEY `sensorindextempdbdup` (`sensor_id`) USING BTREE,
  ADD KEY `hubindexdup` (`hub`) USING BTREE;

--
-- Indexes for table `dbo_payloadertempalg`
--
ALTER TABLE `dbo_payloadertempalg`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unit_INDEX7` (`unit`(255)) USING BTREE;

--
-- Indexes for table `demo`
--
ALTER TABLE `demo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gateway_groups`
--
ALTER TABLE `gateway_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hubcharttemp`
--
ALTER TABLE `hubcharttemp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hubdata`
--
ALTER TABLE `hubdata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hubs`
--
ALTER TABLE `hubs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hubstore`
--
ALTER TABLE `hubstore`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loc`
--
ALTER TABLE `loc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_details`
--
ALTER TABLE `log_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `measurement_units`
--
ALTER TABLE `measurement_units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD KEY `permission_role_role_id_foreign` (`role_id`),
  ADD KEY `permission_role_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pushmessages`
--
ALTER TABLE `pushmessages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `role_user_user_id_foreign` (`user_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `sensordata`
--
ALTER TABLE `sensordata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sensors`
--
ALTER TABLE `sensors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sensorvalues`
--
ALTER TABLE `sensorvalues`
  ADD PRIMARY KEY (`dataid`);

--
-- Indexes for table `sensorvaluessensors`
--
ALTER TABLE `sensorvaluessensors`
  ADD PRIMARY KEY (`dataid`);

--
-- Indexes for table `sensor_graph`
--
ALTER TABLE `sensor_graph`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sensor_groups`
--
ALTER TABLE `sensor_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sensor_hubs`
--
ALTER TABLE `sensor_hubs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userdatamessages`
--
ALTER TABLE `userdatamessages`
  ADD PRIMARY KEY (`userdatamsgid`),
  ADD KEY `rf` (`readflag`);

--
-- Indexes for table `userdatamessagesagent`
--
ALTER TABLE `userdatamessagesagent`
  ADD PRIMARY KEY (`userdatamsgid`),
  ADD KEY `rf` (`readflag`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `weather`
--
ALTER TABLE `weather`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `algorithm`
--
ALTER TABLE `algorithm`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `algorithm_sensor`
--
ALTER TABLE `algorithm_sensor`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `algotemp`
--
ALTER TABLE `algotemp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chart`
--
ALTER TABLE `chart`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbo_payloader`
--
ALTER TABLE `dbo_payloader`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbo_payloaderalgorithmtemp`
--
ALTER TABLE `dbo_payloaderalgorithmtemp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbo_payloaderalgorithmtemp298`
--
ALTER TABLE `dbo_payloaderalgorithmtemp298`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbo_payloaderalgorithmtemp314`
--
ALTER TABLE `dbo_payloaderalgorithmtemp314`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbo_payloaderalgorithmtemp318`
--
ALTER TABLE `dbo_payloaderalgorithmtemp318`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbo_payloaderalgorithmtemp319`
--
ALTER TABLE `dbo_payloaderalgorithmtemp319`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbo_payloaderalgorithmtemp323`
--
ALTER TABLE `dbo_payloaderalgorithmtemp323`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbo_payloaderalgorithmtemp325`
--
ALTER TABLE `dbo_payloaderalgorithmtemp325`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbo_payloaderalgorithmtemp340`
--
ALTER TABLE `dbo_payloaderalgorithmtemp340`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbo_payloaderalgorithmtemp341`
--
ALTER TABLE `dbo_payloaderalgorithmtemp341`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbo_payloaderalgorithmtemp342`
--
ALTER TABLE `dbo_payloaderalgorithmtemp342`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbo_payloaderalgorithmtemp343`
--
ALTER TABLE `dbo_payloaderalgorithmtemp343`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbo_payloaderalgorithmtempandor`
--
ALTER TABLE `dbo_payloaderalgorithmtempandor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbo_payloaderalgorithmtempandor298`
--
ALTER TABLE `dbo_payloaderalgorithmtempandor298`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbo_payloaderalgorithmtempandor314`
--
ALTER TABLE `dbo_payloaderalgorithmtempandor314`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbo_payloaderalgorithmtempandor318`
--
ALTER TABLE `dbo_payloaderalgorithmtempandor318`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbo_payloaderalgorithmtempandor319`
--
ALTER TABLE `dbo_payloaderalgorithmtempandor319`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbo_payloaderalgorithmtempandor323`
--
ALTER TABLE `dbo_payloaderalgorithmtempandor323`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbo_payloaderalgorithmtempandor325`
--
ALTER TABLE `dbo_payloaderalgorithmtempandor325`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbo_payloaderalgorithmtempandor340`
--
ALTER TABLE `dbo_payloaderalgorithmtempandor340`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbo_payloaderalgorithmtempandor341`
--
ALTER TABLE `dbo_payloaderalgorithmtempandor341`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbo_payloaderalgorithmtempandor342`
--
ALTER TABLE `dbo_payloaderalgorithmtempandor342`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbo_payloaderalgorithmtempandor343`
--
ALTER TABLE `dbo_payloaderalgorithmtempandor343`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbo_payloadercharttemp`
--
ALTER TABLE `dbo_payloadercharttemp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbo_payloadercharttemphub`
--
ALTER TABLE `dbo_payloadercharttemphub`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbo_payloaderremovedup`
--
ALTER TABLE `dbo_payloaderremovedup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbo_payloadertempalg`
--
ALTER TABLE `dbo_payloadertempalg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `demo`
--
ALTER TABLE `demo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gateway_groups`
--
ALTER TABLE `gateway_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hubcharttemp`
--
ALTER TABLE `hubcharttemp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hubdata`
--
ALTER TABLE `hubdata`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hubs`
--
ALTER TABLE `hubs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hubstore`
--
ALTER TABLE `hubstore`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loc`
--
ALTER TABLE `loc`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_details`
--
ALTER TABLE `log_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `measurement_units`
--
ALTER TABLE `measurement_units`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pushmessages`
--
ALTER TABLE `pushmessages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sensordata`
--
ALTER TABLE `sensordata`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sensors`
--
ALTER TABLE `sensors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sensorvalues`
--
ALTER TABLE `sensorvalues`
  MODIFY `dataid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sensorvaluessensors`
--
ALTER TABLE `sensorvaluessensors`
  MODIFY `dataid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sensor_graph`
--
ALTER TABLE `sensor_graph`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sensor_groups`
--
ALTER TABLE `sensor_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sensor_hubs`
--
ALTER TABLE `sensor_hubs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userdatamessages`
--
ALTER TABLE `userdatamessages`
  MODIFY `userdatamsgid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userdatamessagesagent`
--
ALTER TABLE `userdatamessagesagent`
  MODIFY `userdatamsgid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `weather`
--
ALTER TABLE `weather`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`),
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
