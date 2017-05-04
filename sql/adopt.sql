-- this is the ABQ-Adopt SQL

DROP TABLE IF EXISTS orgProfile;
DROP TABLE IF EXISTS userProfile;
DROP TABLE IF EXISTS 'message';
DROP TABLE IF EXISTS image;
DROP TABLE IF EXISTS post;

-- create org profile entity
CREATE TABLE orgProfile (
	organizaionId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	organizaionEmail VARCHAR(128) NOT NULL,
	organizaionATHandle VARCHAR(32) NOT NULL,
	organizaionPhone VARCHAR(32) NOT NULL,
	organizaionLicense VARCHAR(32) NOT NULL,
	organizaionCity VARCHAR(32) NOT NULL,
	organizaionZip CHAR(9) NOT NULL,
	organizaionState CHAR(2) NOT NULL,
	organizaionAddress1 VARCHAR(64) NOT NULL,
	organizaionAddress2 VARCHAR(64) NOT NULL,
	organizaionHash CHAR(128) NOT NULL,
	organizaionSalt CHAR(64) NOT NULL,
	organizaionActivationToken CHAR (32),
	OrganizaionName VARCHAR(64),
	INDEX(organizaionId),
	UNIQUE(organizaionEmail),
	UNIQUE(organizaionAtHandle),
	PRIMARY KEY(organizaionId)
);

-- create user profile entity
CREATE TABLE userProfile (
	profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileEmail VARCHAR(128) NOT NULL,
	profileATHandle VARCHAR(32) NOT NULL,
	profileName VARCHAR(32) NOT NULL,
	profileHash CHAR(128) NOT NULL,
	profileSalt CHAR(64) NOT NULL,
	profileActivationToken CHAR (32),
	INDEX(userId),
	PRIMARY KEY(userId)
);

-- create message entity
CREATE TABLE 'message entity (
	msgID INT UNSIGNED AUTO_INCREMENT NOT NULL,

)
