-- this is the ABQ-Adopt SQL

DROP TABLE IF EXISTS Organization;
DROP TABLE IF EXISTS Profile;
DROP TABLE IF EXISTS 'message';
DROP TABLE IF EXISTS image;
DROP TABLE IF EXISTS post;

-- create org profile entity
CREATE TABLE Organization entity (
	organizationId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	organizationEmail VARCHAR(128) NOT NULL,
	organizationATHandle VARCHAR(32) NOT NULL,
	organizationPhone VARCHAR(32) NOT NULL,
	organizationLicense VARCHAR(32) NOT NULL,
	organizationCity VARCHAR(32) NOT NULL,
	organizationZip CHAR(9) NOT NULL,
	organizationState CHAR(2) NOT NULL,
	organizationAddress1 VARCHAR(64) NOT NULL,
	organizationAddress2 VARCHAR(64) NOT NULL,
	organizationHash CHAR(128) NOT NULL,
	organizationSalt CHAR(64) NOT NULL,
	organizationActivationToken CHAR (32),
	OrganizationName VARCHAR(64),
	INDEX(organizationId),
	UNIQUE(organizationEmail),
	UNIQUE(organizationAtHandle),
	PRIMARY KEY(organizationId)
);

-- create user profile entity
CREATE TABLE Profile entity (
	profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileEmail VARCHAR(128) NOT NULL,
	profileATHandle VARCHAR(32) NOT NULL,
	profileName VARCHAR(32) NOT NULL,
	profileHash CHAR(128) NOT NULL,
	profileSalt CHAR(64) NOT NULL,
	profileActivationToken CHAR (32),
	INDEX(profileId),
	PRIMARY KEY(userId)
);

-- create message entity
CREATE TABLE 'message' entity (
	messageID INT UNSIGNED AUTO_INCREMENT NOT NULL,
	messageProfileId INT UNSIGNED NOT NULL,
	messageOrganizationId INT UNSIGNED NOT NULL,
	messageContent VARCHAR(256),
	messageDateTime DATETIME NOT NULL,
	messageSubject VARCHAR (64)
	INDEX(messageOrganizationId)
	INDEX(messageProfileId),
	FOREIGN KEY (messageOrganizationId),
	FOREIGN KEY (messageProfileId),
	PRIMARY KEY(messageId)
);

-- create post entity
CREATE TABLE Post entity (
	postId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	postOrganizationId VARCHAR(128) NOT NULL,
	postBreed VARCHAR(32) NOT NULL,
	PostSex VARCHAR(2) NOT NULL,
	PostType VARCHAR(32) NOT NULL,
	postDescription VARCHAR(254) NOT NULL,
INDEX(postOrganizationId),
PRIMARY KEY(userId)
);
