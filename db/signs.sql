-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Erstellungszeit: 23. Mai 2022 um 15:36
-- Server-Version: 5.7.34
-- PHP-Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `db_lukesucks`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `signs`
--

CREATE TABLE `signs` (
  `sign_ID` int(11) NOT NULL,
  `sign_UUID` varchar(255) NOT NULL,
  `sign_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sign_fname` varchar(255) NOT NULL,
  `sign_lname` varchar(255) NOT NULL,
  `sign_email` varchar(255) NOT NULL,
  `sign_orga` varchar(255) NOT NULL,
  `sign_plz` varchar(10) NOT NULL,
  `sign_ort` varchar(255) NOT NULL,
  `sign_data` json NOT NULL,
  `sign_optin` tinyint(1) NOT NULL DEFAULT '1',
  `sign_public` tinyint(1) NOT NULL DEFAULT '1',
  `sign_status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `signs`
--
ALTER TABLE `signs`
  ADD PRIMARY KEY (`sign_ID`),
  ADD UNIQUE KEY `sign_email` (`sign_email`),
  ADD UNIQUE KEY `sign_UUID` (`sign_UUID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `signs`
--
ALTER TABLE `signs`
  MODIFY `sign_ID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
