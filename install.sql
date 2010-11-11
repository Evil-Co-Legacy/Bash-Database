DROP TABLE IF EXISTS `bash1_1_entry`;
CREATE TABLE `bash1_1_entry` (
	`entryID` INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
	`authorID` INT NOT NULL DEFAULT '0',
	`authorName` VARCHAR (255) NOT NULL,
	`serverID` INT NOT NULL DEFAULT '0',
	`serverName` VARCHAR (255) NOT NULL,
	`text` TEXT NOT NULL,
	`votes` INT NOT NULL DEFAULT '0',
	`timestamp` INT NOT NULL,
	`isDisabled` TINYINT (1) NOT NULL DEFAULT '1',
	`enableSmilies` TINYINT (1) NOT NULL DEFAULT '1',
	`enableHTML` TINYINT (1) NOT NULL DEFAULT '0',
	`enableBBCodes` TINYINT (1) NOT NULL DEFAULT '1'
);

DROP TABLE IF EXISTS `bash1_1_news`;
CREATE TABLE `bash1_1_news` (
	`entryID` INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
	`authorID` INT NOT NULL DEFAULT '0',
	`authorName` VARCHAR (255) NOT NULL,
	`subject` VARCHAR (255) NOT NULL,
	`text` TEXT NOT NULL,
	`timestamp` INT NOT NULL,
	`enableSmilies` TINYINT (1) NOT NULL DEFAULT '1',
	`enableHTML` TINYINT (1) NOT NULL DEFAULT '0',
	`enableBBCodes` TINYINT (1) NOT NULL DEFAULT '1'
);

DROP TABLE IF EXISTS `bash1_1_favorite`;
CREATE TABLE `bash1_1_favorite` (
	`entryID` INT NOT NULL,
	`userID` INT NOT NULL
);

DROP TABLE IF EXISTS `bash1_1_vote`;
CREATE TABLE `bash1_1_vote` (
	`entryID` INT NOT NULL,
	`userID` INT NOT NULL
);

DROP TABLE IF EXISTS `bash1_1_server`;
CREATE TABLE `bash1_1_server` (
	`serverID` INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
	`serverAddress` TEXT NOT NULL,
	`port` INT NOT NULL DEFAULT '6667',
	`description` TEXT NOT NULL
);

DROP TABLE IF EXISTS `bash1_1_server_comment`;
CREATE TABLE `bash1_1_server_comment` (
	`commentID` INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
	`serverID` INT NOT NULL,
	`authorID` INT NOT NULL,
	`authorName` VARCHAR (255) NOT NULL,
	`message` TEXT NOT NULL,
	`timestamp` INT NOT NULL,
	`enableSmilies` TINYINT (1) NOT NULL DEFAULT '1',
	`enableHtml` TINYINT (1) NOT NULL DEFAULT '0',
	`enableBBCodes` TINYINT (1) NOT NULL DEFAULT '1',
	`isDisabled` TINYINT (1) NOT NULL DEFAULT '1'
);