-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 31, 2020 at 02:11 AM
-- Server version: 5.6.38
-- PHP Version: 7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `konk`
--

-- --------------------------------------------------------

--
-- Table structure for table `deck`
--

CREATE TABLE `deck` (
  `suit_order` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `card` text NOT NULL,
  `draw` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deck`
--

INSERT INTO `deck` (`suit_order`, `order`, `card`, `draw`) VALUES
(3, 1, 'H1', '0'),
(3, 2, 'H2', '0'),
(3, 3, 'H3', '1'),
(3, 4, 'H4', '0'),
(3, 5, 'H5', '1'),
(3, 6, 'H6', '0'),
(3, 7, 'H7', '0'),
(3, 8, 'H8', '0'),
(3, 9, 'H9', '0'),
(3, 10, 'H10', '0'),
(3, 11, 'HJ', '0'),
(3, 12, 'HQ', '0'),
(3, 13, 'HK', '0'),
(1, 1, 'C1', '0'),
(1, 2, 'C2', '0'),
(1, 3, 'C3', '0'),
(1, 4, 'C4', '1'),
(1, 5, 'C5', '0'),
(1, 6, 'C6', '0'),
(1, 7, 'C7', '0'),
(1, 8, 'C8', '0'),
(1, 9, 'C9', '0'),
(1, 10, 'C10', '0'),
(1, 11, 'CJ', '0'),
(1, 12, 'CQ', '0'),
(1, 13, 'CK', '0'),
(4, 1, 'S1', '0'),
(4, 2, 'S2', '0'),
(4, 3, 'S3', '1'),
(4, 4, 'S4', '0'),
(4, 5, 'S5', '0'),
(4, 6, 'S6', '1'),
(4, 7, 'S7', '0'),
(4, 8, 'S8', '0'),
(4, 9, 'S9', '0'),
(4, 10, 'S10', '0'),
(4, 11, 'SJ', '0'),
(4, 12, 'SQ', '0'),
(4, 13, 'SK', '0'),
(2, 1, 'D1', '0'),
(2, 2, 'D2', '0'),
(2, 3, 'D3', '0'),
(2, 4, 'D4', '0'),
(2, 5, 'D5', '0'),
(2, 6, 'D6', '1'),
(2, 7, 'D7', '1'),
(2, 8, 'D8', '0'),
(2, 9, 'D9', '0'),
(2, 10, 'D10', '0'),
(2, 11, 'DJ', '0'),
(2, 12, 'DQ', '0'),
(2, 13, 'DK', '0');

-- --------------------------------------------------------

--
-- Table structure for table `hand`
--

CREATE TABLE `hand` (
  `player` text NOT NULL,
  `card_delt` text NOT NULL,
  `card_picked` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hand`
--

INSERT INTO `hand` (`player`, `card_delt`, `card_picked`) VALUES
('host', 'H5', 0),
('host', 'D7', 0),
('host', 'H3', 0),
('guest', 'C4', 0),
('host', 'S3', 0),
('guest', 'D6', 0),
('guest', 'S6', 0);

-- --------------------------------------------------------

--
-- Table structure for table `konk_log`
--

CREATE TABLE `konk_log` (
  `date_played` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `player1_name` text NOT NULL,
  `player2_name` text NOT NULL,
  `score1` int(11) NOT NULL,
  `score2` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `konk_log`
--

INSERT INTO `konk_log` (`date_played`, `player1_name`, `player2_name`, `score1`, `score2`) VALUES
('2020-03-22 02:05:57', 'Richard', 'Don Andres', 113, 71),
('2020-03-22 14:13:25', 'Richard', 'Tio Willie', 103, 65),
('2020-03-22 22:36:47', 'Richard', 'Don Andres', 0, 105),
('2020-03-22 23:30:26', 'Richard', 'Don Andres', 107, 83),
('2020-03-23 22:19:07', 'Joel', 'Abuelo', 56, 109),
('2020-03-23 23:03:08', 'Joel', 'Abuelo', 116, 80),
('2020-03-24 21:34:34', 'Richard', 'Don Andres', 104, 64),
('2020-03-24 23:56:38', 'Richard', 'Tio Willie', 94, 114),
('2020-03-25 01:19:46', 'Richard', 'Tio Willie', 60, 102),
('2020-03-25 22:42:54', 'Don Andres', 'Tio Willie', 115, 65),
('2020-03-25 23:21:06', 'Richard', 'Tio Willie', 104, 20),
('2020-03-25 23:21:15', 'Richard', 'Tio Willie', 104, 20),
('2020-03-26 00:02:17', 'Richard', 'Tio Willie', 112, 72),
('2020-03-26 00:28:09', 'Richard', 'Tio Willie', 69, 111),
('2020-03-27 00:35:03', 'Richard', 'Tio Willie', 114, 42),
('2020-03-27 01:12:50', 'Richard', 'Tio Willie', 102, 84),
('2020-03-27 12:41:17', 'Richard', 'Tio Willie', 117, 21),
('2020-03-27 19:36:33', 'Richard', 'Thomas', 51, 118),
('2020-03-27 23:37:10', 'Richard', 'Tio Willie', 60, 115),
('2020-03-28 00:40:36', 'Joel', 'Tio Willie', 105, 83),
('2020-03-28 01:12:00', 'Joel', 'Tio Willie', 101, 71),
('2020-03-28 01:47:28', 'Joel', 'Tio Willie', 75, 104),
('2020-03-29 01:14:37', 'Winner', 'Loser', 99, 101),
('2020-03-29 01:14:52', 'Winner', 'Loser', 98, 102),
('2020-03-29 01:15:10', 'Winner', 'Loser', 97, 103),
('2020-03-29 01:15:23', 'Winner', 'Loser', 96, 104);

--
-- Triggers `konk_log`
--
DELIMITER $$
CREATE TRIGGER `TRG_INS_INTO_PLAYER_LEVEL` AFTER INSERT ON `konk_log` FOR EACH ROW BEGIN
DECLARE num_rec, num_rec1 integer;
SELECT COUNT(*) INTO num_rec FROM player_level where player_name = new.player1_name;

SELECT COUNT(*) INTO num_rec1 FROM player_level where player_name = new.player2_name;



if (num_rec = 0) THEN

INSERT INTO player_level (player_name) values (new.player1_name);

ELSEIF (num_rec1 = 0) THEN

INSERT INTO player_level (player_name) values (new.player2_name);

end if;




END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `played`
--

CREATE TABLE `played` (
  `time_card_played` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `card_played` text NOT NULL,
  `player` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `player` text NOT NULL,
  `player_name` text NOT NULL,
  `player_just_played` text NOT NULL,
  `dealer` text NOT NULL,
  `score` int(11) NOT NULL,
  `knocked` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`player`, `player_name`, `player_just_played`, `dealer`, `score`, `knocked`) VALUES
('host', 'Richard', '0', '1', 54, 0),
('guest', 'Tio WIllie', '1', '0', 59, 0);

-- --------------------------------------------------------

--
-- Table structure for table `player_level`
--

CREATE TABLE `player_level` (
  `player_name` text NOT NULL,
  `player_lvl` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `player_level`
--

INSERT INTO `player_level` (`player_name`, `player_lvl`) VALUES
('Richard Thomas', 0),
('Richard Thomas1', 0),
('Richard', 0),
('Tio Willie', 0),
('Don Andres', 0),
('Joel', 0),
('Abuelo', 0),
('Thomas', 0),
('Winner', 0),
('Loser', 0);

-- --------------------------------------------------------

--
-- Table structure for table `scoreboard`
--

CREATE TABLE `scoreboard` (
  `player` text NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
