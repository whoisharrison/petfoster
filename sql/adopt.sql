-- this is the ABQ-Adopt SQL

DROP TABLE IF EXISTS image;
DROP TABLE IF EXISTS post;
DROP TABLE IF EXISTS message;
DROP TABLE IF EXISTS organization;
DROP TABLE IF EXISTS profile;

-- create user profile entity
	CREATE TABLE profile (
	profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileActivationToken CHAR (32),
	profileAtHandle VARCHAR(32) NOT NULL,
	profileEmail VARCHAR(128) NOT NULL,
	profileHash CHAR(128) NOT NULL,
	profileName VARCHAR(32) NOT NULL,
	profileSalt CHAR(64) NOT NULL,
	UNIQUE(profileEmail),
	PRIMARY KEY(profileId)
);

-- create org profile entity
	CREATE TABLE organization (
	organizationId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	organizationProfileId INT UNSIGNED NOT NULL,
	organizationActivationToken CHAR (32),
	organizationAddress1 VARCHAR(64) NOT NULL,
	organizationAddress2 VARCHAR(64),
	organizationCity VARCHAR(32) NOT NULL,
	organizationEmail VARCHAR(128) NOT NULL,
	organizationLicense VARCHAR(32) NOT NULL,
	organizationName VARCHAR(64) NOT NULL,
	organizationPhone VARCHAR(32) NOT NULL,
	organizationState CHAR(2) NOT NULL,
	organizationZip VARCHAR(10) NOT NULL,
	INDEX(organizationProfileId),
	UNIQUE(organizationEmail),
	FOREIGN KEY (organizationProfileId) REFERENCES profile(profileId),
	PRIMARY KEY(organizationId)
);

-- create message entity
CREATE TABLE message (
	messageId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	messageProfileId INT UNSIGNED NOT NULL,
	messageOrganizationId INT UNSIGNED NOT NULL,
	messageContent VARCHAR(1024),
	messageDateTime DATETIME (6) NOT NULL,
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
	postOrganizationId INT UNSIGNED NOT NULL,
	postBreed VARCHAR(32) NOT NULL,
	postDescription VARCHAR(1024) NOT NULL,
	postSex CHAR(1) NOT NULL,
	postType CHAR(1) NOT NULL,
	INDEX(postOrganizationId),
	FOREIGN KEY (postOrganizationId) REFERENCES organization(organizationId),
	PRIMARY KEY(postId)
);

-- create image entity
CREATE TABLE image (
	imageId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	imagePostId INT UNSIGNED NOT NULL,
	imageCloudinaryId VARCHAR(32) NOT NULL,
	INDEX(imagePostId),
	FOREIGN KEY (imagePostId) REFERENCES post(postId),
	PRIMARY KEY(imageId)
);




























