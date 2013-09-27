SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE `xmle_dev` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `xmle_dev`;

-- --------------------------------------------------------

DELIMITER $$
--
-- Procedures
--
CREATE PROCEDURE `SearchMetadata`(IN searchText VARCHAR(256))
SELECT processes.* 
	FROM processes
	LEFT JOIN bundles on bundles.id = processes.bundleId
	LEFT JOIN videos on videos.id = bundles.videoId
	LEFT JOIN metadata on metadata.id = videos.metadataId
	WHERE 	metadata.seriesName LIKE searchText OR 
			metadata.network LIKE searchText  OR 
			metadata.seasonName LIKE searchText  OR 
			metadata.dTOSeasonName LIKE searchText  OR 
			metadata.episodeName LIKE searchText  OR 
			metadata.dTOEpisodeName LIKE searchText  OR 
			metadata.genre LIKE searchText  OR 
			metadata.dTOGenre LIKE searchText$$

DELIMITER ;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `bundles` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`videoId` int(11) NOT NULL,
	`languageCode` varchar(3) NOT NULL,
	`regionCode` varchar(2) NOT NULL,
	`partnerId` int(11) NOT NULL,
	`entityId` varchar(255) DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `videoId` (`videoId`),
	KEY `languageCode` (`languageCode`),
	KEY `regionCode` (`regionCode`),
	KEY `partnerId` (`partnerId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO `bundles` (`id`, `videoId`, `languageCode`, `regionCode`, `partnerId`, `entityId`) VALUES
	('1', '1', 'ENG', 'UK', '1', NULL),
	('2', '2', 'ENG', 'UK', '1', NULL),
	('3', '3', 'ENG', 'UK', '1', NULL);

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `languages` (
	`code` varchar(3) NOT NULL,
	`alt` varchar(2) NOT NULL,
	`name` varchar(255) NOT NULL,
	PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `languages` (`code`, `alt`, `name`) VALUES
	('DEU', 'DE', 'GERMAN'),
	('ENG', 'EN', 'ENGLISH'),
	('FRE', 'FR', 'FRENCH'),
	('ITA', 'IT', 'ITALIAN'),
	('JPN', 'JP', 'JAPANESE'),
	('SPA', 'ES', 'SPANISH');

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `logs` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`processId` int(11) NOT NULL,
	`description` varchar(1023) NOT NULL,
	`isError` tinyint(1) NOT NULL,
	PRIMARY KEY (`id`),
	KEY `processId` (`processId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO `logs` (`id`, `processId`, `description`, `isError`) VALUES
	('1', '1', '"checksum" required for iTunes', '0'),
	('2', '1', '"copyright_cline" required for iTunes', '0'),
	('3', '3', 'The given md5 value was wrong. Real value: 96bc60f1d5dd14342dc220cdad8dc7d9', '1');

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `metadata` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`airDate` varchar(255) DEFAULT NULL,
	`archiveStatus` varchar(255) DEFAULT NULL,
	`assetGUID` varchar(255) DEFAULT NULL,
	`assetID` int(11) DEFAULT NULL,
	`author` varchar(255) DEFAULT NULL,
	`category` varchar(255) DEFAULT NULL,
	`copyrightHolder` varchar(255) DEFAULT NULL,
	`description` text DEFAULT NULL,
	`dTOAssetXMLExportstage1` tinyint(1) DEFAULT NULL,
	`dTOContainerPosition` varchar(255) DEFAULT NULL,
	`dTOCopyrightHolder` varchar(255) DEFAULT NULL,
	`dTOEpisodeID` varchar(255) NOT NULL,
	`dTOEpisodeName` varchar(255) DEFAULT NULL,
	`dTOGenre` varchar(255) DEFAULT NULL,
	`dTOLongDescription` text DEFAULT NULL,
	`dTOLongEpisodeDescription` text DEFAULT NULL,
	`dTORatings` varchar(255) DEFAULT NULL,
	`dTOReleaseDate` varchar(255) DEFAULT NULL,
	`dTOSalesPrice` varchar(255) DEFAULT NULL,
	`dTOSeasonID` varchar(255) NOT NULL,
	`dTOSeasonName` varchar(255) DEFAULT NULL,
	`dTOSeriesDescription` text DEFAULT NULL,
	`dTOSeriesID` varchar(255) NOT NULL,
	`dTOShortEpisodeDescription` text DEFAULT NULL,
	`dTOShortDescription` text DEFAULT NULL,
	`eMDeliveryAsset` tinyint(1) DEFAULT NULL,
	`episodeName` varchar(255) DEFAULT NULL,
	`episodeNumber` int(11) NOT NULL,
	`forceDTOexportXML` tinyint(1) DEFAULT NULL,
	`forceDTOproxyAsset` tinyint(1) DEFAULT NULL,
	`genre` varchar(255) DEFAULT NULL,
	`keywords` varchar(255) DEFAULT NULL,
	`licenseStartDate` varchar(255) DEFAULT NULL,
	`localEntity` tinyint(1) DEFAULT NULL,
	`location` varchar(255) DEFAULT NULL,
	`mediaType` varchar(255) DEFAULT NULL,
	`metadataSet` varchar(255) DEFAULT NULL,
	`network` varchar(255) NOT NULL,
	`owner` varchar(255) DEFAULT NULL,
	`ratingsOverride` varchar(255) DEFAULT NULL,
	`ratingSystem` varchar(255) DEFAULT NULL,
	`releaseYear` varchar(255) DEFAULT NULL,
	`seasonDescription` text DEFAULT NULL,
	`seasonLanguage` varchar(255) DEFAULT NULL,
	`seasonName` varchar(255) DEFAULT NULL,
	`seasonNumber` varchar(255) DEFAULT NULL,
	`seasonOverride` varchar(255) DEFAULT NULL,
	`seriesDescription` text DEFAULT NULL,
	`seriesName` varchar(255) NOT NULL,
	`status` varchar(255) DEFAULT NULL,
	`storeandtrackversionsofthisasset` tinyint(1) DEFAULT NULL,
	`syndicationPartnerDelivery` varchar(255) DEFAULT NULL,
	`title` varchar(255) DEFAULT NULL,
	`tVRating` varchar(255) DEFAULT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO `metadata` (`id`, `airDate`, `archiveStatus`, `assetGUID`, `assetID`, `author`, `category`, `copyrightHolder`, `description`, `dTOAssetXMLExportstage1`, `dTOContainerPosition`, `dTOCopyrightHolder`, `dTOEpisodeID`, `dTOEpisodeName`, `dTOGenre`, `dTOLongDescription`, `dTOLongEpisodeDescription`, `dTORatings`, `dTOReleaseDate`, `dTOSalesPrice`, `dTOSeasonID`, `dTOSeasonName`, `dTOSeriesDescription`, `dTOSeriesID`, `dTOShortEpisodeDescription`, `dTOShortDescription`, `eMDeliveryAsset`, `episodeName`, `episodeNumber`, `forceDTOexportXML`, `forceDTOproxyAsset`, `genre`, `keywords`, `licenseStartDate`, `localEntity`, `location`, `mediaType`, `metadataSet`, `network`, `owner`, `ratingsOverride`, `ratingSystem`, `releaseYear`, `seasonDescription`, `seasonLanguage`, `seasonName`, `seasonNumber`, `seasonOverride`, `seriesDescription`, `seriesName`, `status`, `storeandtrackversionsofthisasset`, `syndicationPartnerDelivery`, `title`, `tVRating`) VALUES
	('1', '2011-08-02', NULL, NULL, NULL, NULL, NULL, '2011 Viacom Inc.', NULL, '0', '1', '2011 Viacom Inc.', 'UK_NICKELODEON_WINXCLUB_101', 'Winx Club', NULL, 'Embark on a fantasy adventure with Bloom, Stella, Flora, Musa, Tecna and Aisha, the Winx Club! a special group of friends with strength, beauty, and magic in their wings! In this feature-length special, join Bloom, Stella and the fairies of Alfea College as they learn to use their powers to battle evil and save the world! The Winx Club takes the girl power to new heights, with six great friends who not only do good, but they look great!', 'Embark on a fantasy adventure with Bloom, Stella, Flora, Musa, Tecna and Aisha, the Winx Club! a special group of friends with strength, beauty, and magic in their wings! In this feature-length special, join Bloom, Stella and the fairies of Alfea College as they learn to use their powers to battle evil and save the world! The Winx Club takes the girl power to new heights, with six great friends who not only do good, but they look great!', NULL, '2011-08-02', NULL, 'UK_NICKELODEON_WINXCLUB_1', NULL, NULL, 'UK_NICKELODEON_WINXCLUB', 'Embark on a fantasy adventure with Bloom, Stella, Flora, Musa, Tecna and Aisha, the Winx Club! a special group of friends with strength, beauty, and magic in their wings! In this feature-length special, join Bloom, Stella and the fairies of Alfea College as they learn to use their powers to battle evil and save the world! The Winx Club takes the girl power to new heights, with six great friends who not only do good, but they look great!', 'Embark on a fantasy adventure with Bloom, Stella, Flora, Musa, Tecna and Aisha, the Winx Club! a special group of friends with strength, beauty, and magic in their wings! In this feature-length special, join Bloom, Stella and the fairies of Alfea College as they learn to use their powers to battle evil and save the world! The Winx Club takes the girl power to new heights, with six great friends who not only do good, but they look great!', '0', 'Winx Club', '1', '0', '0', NULL, NULL, '2011-08-02', '0', NULL, NULL, NULL, 'NICKELODEON', NULL, NULL, NULL, '2011-08-02', NULL, 'en-GB', NULL, '1', NULL, NULL, 'WINXCLUB', NULL, '0', NULL, NULL, ''),
	('2', '2011-08-02', NULL, NULL, NULL, NULL, NULL, '2011 Viacom Inc.', NULL, '0', '2', '2011 Viacom Inc.', 'UK_NICKELODEON_WINXCLUB_102', 'Winx Club: Revenge of the Trix', NULL, 'Bloom, Stella, Flora, Musa and Tecna are back with more otherworldy adventures in Winx Club: Revenge of the Trix! Bloom?s home on her first school break, but the weird dreams she was having back at Alfea have come with her. And these dreams are trying to tell her something important! Good thing her fellow Winx have vowed to help Bloom learn what they mean. In the meantime, Bloom is learning about her home planet, her birth parents and her powers; Sky and Bloom are falling for each other, but Sky is supposed to marry Princess Diaspro; the evil Trix want something only Bloom has, so they follow her to Gardenia and will not leave without it! Will there be a showdown between Bloom and Diaspro? What will the other Winx find out about Bloom? Will the Trix finally get what they?re after? So hang on, because it?s all revealed here, in the magical, fantastical Winx Club: Revenge of the Trix!', 'Bloom, Stella, Flora, Musa and Tecna are back with more otherworldy adventures in Winx Club: Revenge of the Trix! Bloom?s home on her first school break, but the weird dreams she was having back at Alfea have come with her. And these dreams are trying to tell her something important! Good thing her fellow Winx have vowed to help Bloom learn what they mean. In the meantime, Bloom is learning about her home planet, her birth parents and her powers; Sky and Bloom are falling for each other, but Sky is supposed to marry Princess Diaspro; the evil Trix want something only Bloom has, so they follow her to Gardenia and will not leave without it! Will there be a showdown between Bloom and Diaspro? What will the other Winx find out about Bloom? Will the Trix finally get what they?re after? So hang on, because it?s all revealed here, in the magical, fantastical Winx Club: Revenge of the Trix!', NULL, '2011-08-02', NULL, 'UK_NICKELODEON_WINXCLUB_1', NULL, NULL, 'UK_NICKELODEON_WINXCLUB', 'Bloom, Stella, Flora, Musa and Tecna are back with more otherworldy adventures in Winx Club: Revenge of the Trix! Bloom?s home on her first school break, but the weird dreams she was having back at Alfea have come with her. And these dreams are trying to tell her something important! Good thing her fellow Winx have vowed to help Bloom learn what they mean. In the meantime, Bloom is learning about her home planet, her birth parents and her powers; Sky and Bloom are falling for each other, but Sky is supposed to marry Princess Diaspro; the evil Trix want something only Bloom has, so they follow her to Gardenia and will not leave without it! Will there be a showdown between Bloom and Diaspro? What will the other Winx find out about Bloom? Will the Trix finally get what they?re after? So hang on, because it?s all revealed here, in the magical, fantastical Winx Club: Revenge of the Trix!', 'Bloom, Stella, Flora, Musa and Tecna are back with more otherworldy adventures in Winx Club: Revenge of the Trix! Bloom?s home on her first school break, but the weird dreams she was having back at Alfea have come with her. And these dreams are trying to tell her something important! Good thing her fellow Winx have vowed to help Bloom learn what they mean. In the meantime, Bloom is learning about her home planet, her birth parents and her powers; Sky and Bloom are falling for each other, but Sky is supposed to marry Princess Diaspro; the evil Trix want something only Bloom has, so they follow her to Gardenia and will not leave without it! Will there be a showdown between Bloom and Diaspro? What will the other Winx find out about Bloom? Will the Trix finally get what they?re after? So hang on, because it?s all revealed here, in the magical, fantastical Winx Club: Revenge of the Trix!', '0', 'Winx Club: Revenge of the Trix', '2', '0', '0', NULL, NULL, '2011-08-02', '0', NULL, NULL, NULL, 'NICKELODEON', NULL, NULL, NULL, '2011-08-02', NULL, 'en-GB', NULL, '1', NULL, NULL, 'WINXCLUB', NULL, '0', NULL, NULL, ''),
	('3', '2011-09-19', NULL, NULL, NULL, NULL, NULL, '2011 Viacom Inc.', NULL, '0', '1', '2011 Viacom Inc.', 'UK_NICKELODEON_WINXCLUB_201', 'Winx Club: The Battle for Magix', NULL, 'It?s good versus evil and finding the power within in this action-packed third special, Winx Club: The Battle for Magix. Having taken Bloom?s Dragon Flame, the most powerful force there is, the Trix will stop at nothing to take over all of Magix! The evil witches being their quest by taking over their own school, Cloudtower. They then build an army of villains to help them take over Redfountain, the school of the Specialists. It?s battle ON as those not aligned with the Trix retreat to Alfea and join forces to save the Magix realm. As the conflict rages on, Bloom finds herself drawn to the spirit of Daphne, who reveals a secret Bloom never imagined! And thanks to Daphne, Bloom learns that the power of the dragon flame is still inside her. But can Bloom connect to the force and reawaken its spirit to help her defeat her evil enemies in time? Or will evil reign? All the action and the answers are ready to be revealed, here, in Winx Club: The Battle for Magix!', 'It?s good versus evil and finding the power within in this action-packed third special, Winx Club: The Battle for Magix. Having taken Bloom?s Dragon Flame, the most powerful force there is, the Trix will stop at nothing to take over all of Magix! The evil witches being their quest by taking over their own school, Cloudtower. They then build an army of villains to help them take over Redfountain, the school of the Specialists. It?s battle ON as those not aligned with the Trix retreat to Alfea and join forces to save the Magix realm. As the conflict rages on, Bloom finds herself drawn to the spirit of Daphne, who reveals a secret Bloom never imagined! And thanks to Daphne, Bloom learns that the power of the dragon flame is still inside her. But can Bloom connect to the force and reawaken its spirit to help her defeat her evil enemies in time? Or will evil reign? All the action and the answers are ready to be revealed, here, in Winx Club: The Battle for Magix!', NULL, '2011-08-02', NULL, 'UK_NICKELODEON_WINXCLUB_2', NULL, NULL, 'UK_NICKELODEON_WINXCLUB', 'It?s good versus evil and finding the power within in this action-packed third special, Winx Club: The Battle for Magix. Having taken Bloom?s Dragon Flame, the most powerful force there is, the Trix will stop at nothing to take over all of Magix! The evil witches being their quest by taking over their own school, Cloudtower. They then build an army of villains to help them take over Redfountain, the school of the Specialists. It?s battle ON as those not aligned with the Trix retreat to Alfea and join forces to save the Magix realm. As the conflict rages on, Bloom finds herself drawn to the spirit of Daphne, who reveals a secret Bloom never imagined! And thanks to Daphne, Bloom learns that the power of the dragon flame is still inside her. But can Bloom connect to the force and reawaken its spirit to help her defeat her evil enemies in time? Or will evil reign? All the action and the answers are ready to be revealed, here, in Winx Club: The Battle for Magix!', 'It?s good versus evil and finding the power within in this action-packed third special, Winx Club: The Battle for Magix. Having taken Bloom?s Dragon Flame, the most powerful force there is, the Trix will stop at nothing to take over all of Magix! The evil witches being their quest by taking over their own school, Cloudtower. They then build an army of villains to help them take over Redfountain, the school of the Specialists. It?s battle ON as those not aligned with the Trix retreat to Alfea and join forces to save the Magix realm. As the conflict rages on, Bloom finds herself drawn to the spirit of Daphne, who reveals a secret Bloom never imagined! And thanks to Daphne, Bloom learns that the power of the dragon flame is still inside her. But can Bloom connect to the force and reawaken its spirit to help her defeat her evil enemies in time? Or will evil reign? All the action and the answers are ready to be revealed, here, in Winx Club: The Battle for Magix!', '0', 'Winx Club: The Battle for Magix', '1', '0', '0', NULL, NULL, '2011-09-19', '0', NULL, NULL, NULL, 'NICKELODEON', NULL, NULL, NULL, '2011-08-02', NULL, 'en-GB', NULL, '2', NULL, NULL, 'WINXCLUB', NULL, '0', NULL, NULL, '');

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `partners` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO `partners` (`id`, `name`) VALUES
	('1', 'iTunes'),
	('2', 'Sony'),
	('3', 'Xbox'),
	('4', 'StarHub');

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `processes` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`typeId` int(11) NOT NULL,
	`stateId` int(11) NOT NULL,
	`processDate` datetime NOT NULL,
	`bundleId` int(11) DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `typeId` (`typeId`),
	KEY `stateId` (`stateId`),
	KEY `bundleId` (`bundleId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO `processes` (`id`, `typeId`, `stateId`, `processDate`, `bundleId`) VALUES
	('1', '3', '2', '2012-06-22 15:06:30', '1'),
	('2', '3', '1', '2012-06-22 15:06:27', NULL),
	('3', '3', '5', '2012-06-22 15:06:47', '2');

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `regions` (
	`code` varchar(2) NOT NULL,
	`country` varchar(255) NOT NULL,
	`languageCode` varchar(3) NOT NULL,
	PRIMARY KEY (`code`),
	KEY `languageCode` (`languageCode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `regions` (`code`, `country`, `languageCode`) VALUES
	('AU', 'AUSTRALIA', 'ENG'),
	('CA', 'CANADA', 'FRE'),
	('DE', 'GERMANY', 'DEU'),
	('ES', 'SPAIN', 'SPA'),
	('FR', 'FRANCE', 'FRE'),
	('GB', 'UNITED KINGDOM', 'ENG'),
	('IT', 'ITALY', 'ITA'),
	('JP', 'JAPAN', 'JPN'),
	('MX', 'MEXICO', 'SPA'),
	('UK', 'UNITED KINGDOM', 'ENG'),
	('US', 'USA', 'ENG');

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `roles` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO `roles` (`id`, `name`) VALUES
	('1', 'Admin'),
	('2', 'User');

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `states` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO `states` (`id`, `name`) VALUES
	('1', 'NONSTARTED'),
	('2', 'STARTED'),
	('3', 'INCOMPLETE'),
	('4', 'SUCCESS'),
	('5', 'FAILED');

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `types` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO `types` (`id`, `name`) VALUES
	('1', 'MERGE'),
	('2', 'CONVERSION'),
	('3', 'TRANSPORTATION');

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `users` (
	`id` varchar(32) NOT NULL,
	`password` varchar(32) NOT NULL,
	`name` varchar(255) NOT NULL,
	`lastActionDate` datetime NOT NULL,
	`roleId` int(11) NOT NULL,
	`active` tinyint(1) NOT NULL,
	PRIMARY KEY (`id`),
	KEY `roleId` (`roleId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `password`, `name`, `lastActionDate`, `roleId`, `active`) VALUES
	('idmoadmin', '051970c8c8dfa6ca9821b289b14704ab', 'IDMO Admin', '2012-05-30 00:00:00', '1', '1');

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `videos` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`metadataId` int(11) NOT NULL,
	`audioCodec` varchar(255) DEFAULT NULL,
	`createdBy` varchar(255) DEFAULT NULL,
	`creationDate` datetime DEFAULT NULL,
	`dTOVideoType` varchar(255) DEFAULT NULL,
	`duration` varchar(255) DEFAULT NULL,
	`fileCreateDate` datetime DEFAULT NULL,
	`fileModificationDate` datetime DEFAULT NULL,
	`fileName` varchar(255) NOT NULL,
	`imageSize` varchar(255) DEFAULT NULL,
	`lastAccessed` datetime DEFAULT NULL,
	`lastModified` datetime DEFAULT NULL,
	`mD5Hash` varchar(255) NOT NULL,
	`mD5HashRecal` tinyint(1) DEFAULT NULL,
	`mimeType` varchar(255) DEFAULT NULL,
	`size` varchar(255) NOT NULL,
	`storedOn` varchar(255) DEFAULT NULL,
	`timecodeOffset` varchar(255) DEFAULT NULL,
	`videoBitrate` varchar(255) DEFAULT NULL,
	`videoCodec` varchar(255) DEFAULT NULL,
	`videoElements` varchar(255) DEFAULT NULL,
	`videoFrameRate` varchar(255) DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `metadataId` (`metadataId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO `videos` (`id`, `metadataId`, `audioCodec`, `createdBy`, `creationDate`, `dTOVideoType`, `duration`, `fileCreateDate`, `fileModificationDate`, `fileName`, `imageSize`, `lastAccessed`, `lastModified`, `mD5Hash`, `mD5HashRecal`, `mimeType`, `size`, `storedOn`, `timecodeOffset`, `videoBitrate`, `videoCodec`, `videoElements`, `videoFrameRate`) VALUES
	('1', '1', NULL, NULL, '2012-06-22 15:25:42', 'tv', NULL, '2012-07-03 13:07:32', '2012-06-22 11:06:01', 'UK_NICKELODEON_WINXCLUB_101.mpg', NULL, '2012-07-02 15:07:34', '2012-06-22 15:25:42', '6afc2bb87e05e81092ccd5d73bb2008c', '0', NULL, '5705905513', NULL, NULL, NULL, NULL, NULL, ''),
	('2', '2', NULL, NULL, '2012-06-22 15:57:10', 'tv', NULL, '2012-07-03 13:07:00', '2012-06-22 11:06:44', 'UK_NICKELODEON_WINXCLUB_102.mpg', NULL, '2012-07-02 15:07:09', '2012-06-22 15:57:10', 'ff4e0dd77aa71deca160e3bb66178c78', '0', NULL, '5719354361', NULL, NULL, NULL, NULL, NULL, ''),
	('3', '3', NULL, NULL, '2012-06-22 16:00:34', 'tv', NULL, '2012-07-03 13:07:32', '2012-06-22 11:06:34', 'UK_NICKELODEON_WINXCLUB_201.mpg', NULL, '2012-07-02 15:07:45', '2012-06-22 16:00:34', 'b4ff0ed2c4c4f8d623958deec5982ed7', '0', NULL, '5721140444', NULL, NULL, NULL, NULL, NULL, '');

-- --------------------------------------------------------

ALTER TABLE `bundles`
	ADD CONSTRAINT `bundles_ibfk_1` FOREIGN KEY (`videoId`) REFERENCES `videos` (`id`),
	ADD CONSTRAINT `bundles_ibfk_2` FOREIGN KEY (`languageCode`) REFERENCES `languages` (`code`),
	ADD CONSTRAINT `bundles_ibfk_3` FOREIGN KEY (`regionCode`) REFERENCES `regions` (`code`),
	ADD CONSTRAINT `bundles_ibfk_4` FOREIGN KEY (`partnerId`) REFERENCES `partners` (`id`);

ALTER TABLE `logs`
	ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`processId`) REFERENCES `processes` (`id`);

ALTER TABLE `processes`
	ADD CONSTRAINT `processes_ibfk_1` FOREIGN KEY (`typeId`) REFERENCES `types` (`id`),
	ADD CONSTRAINT `processes_ibfk_2` FOREIGN KEY (`stateId`) REFERENCES `states` (`id`),
	ADD CONSTRAINT `processes_ibfk_3` FOREIGN KEY (`bundleId`) REFERENCES `bundles` (`id`);

ALTER TABLE `regions`
	ADD CONSTRAINT `regions_ibfk_1` FOREIGN KEY (`languageCode`) REFERENCES `languages` (`code`);

ALTER TABLE `users`
	ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`roleId`) REFERENCES `roles` (`id`);

ALTER TABLE `videos`
	ADD CONSTRAINT `videos_ibfk_1` FOREIGN KEY (`metadataId`) REFERENCES `metadata` (`id`);

