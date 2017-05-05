-- this is the ABQ-Adopt SQL

DROP TABLE IF EXISTS organization;
DROP TABLE IF EXISTS profile;
DROP TABLE IF EXISTS message;
DROP TABLE IF EXISTS image;
DROP TABLE IF EXISTS post;

-- create org profile entity
CREATE TABLE organization (
	organizationId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	organizationEmail VARCHAR(128) NOT NULL,
	organizationAtHandle VARCHAR(32) NOT NULL,
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
	organizationName VARCHAR(64),
	INDEX(organizationId),
	UNIQUE(organizationEmail),
	UNIQUE(organizationAtHandle),
	PRIMARY KEY(organizationId)
);

-- create user profile entity
CREATE TABLE profile (
	profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileEmail VARCHAR(128) NOT NULL,
	profileAtHandle VARCHAR(32) NOT NULL,
	profileName VARCHAR(32) NOT NULL,
	profileHash CHAR(128) NOT NULL,
	profileSalt CHAR(64) NOT NULL,
	profileActivationToken CHAR (32),
	INDEX(profileId),
	PRIMARY KEY(profileId)
);

-- create message entity
CREATE TABLE message (
	messageId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	messageProfileId INT UNSIGNED NOT NULL,
	messageOrganizationId INT UNSIGNED NOT NULL,
	messageContent VARCHAR(256),
	messageDateTime DATETIME NOT NULL,
	messageSubject VARCHAR (64),
	INDEX(messageOrganizationId),
	INDEX(messageProfileId),
	FOREIGN KEY (messageOrganizationId) REFERENCES organization(organizationId),
	FOREIGN KEY (messageProfileId) REFERENCES profile(profileId),
	PRIMARY KEY(messageId)
);

-- create post entity
CREATE TABLE post (
	postId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	postOrganizationId VARCHAR(128) NOT NULL,
	postBreed VARCHAR(32) NOT NULL,
	postSex VARCHAR(2) NOT NULL,
	postType VARCHAR(32) NOT NULL,
	postDescription VARCHAR(254) NOT NULL,
	INDEX(postOrganizationId),
	FOREIGN KEY (postOrganizationId) REFERENCES organization(organizationId),
	PRIMARY KEY(postId)
);

-- create image entity
CREATE TABLE image (
	imageId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	imagePostId VARCHAR(128) NOT NULL,
	imageCloudinaryId VARCHAR(32) NOT NULL,
	INDEX(imagePostId),
	FOREIGN KEY (imagePostId) REFERENCES organization(organizationId),
	PRIMARY KEY(postId)
);

