-- this is the ABQ-Adopt SQL

DROP TABLE IF EXISTS orgProfile;
DROP TABLE IF EXISTS userProfile;
DROP TABLE IF EXISTS 'message';
DROP TABLE IF EXISTS image;
DROP TABLE IF EXISTS post;

-- create org profile entity
CREATE TABLE orgProfile (
	orgId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	orgEmail VARCHAR(128) NOT NULL,
	orgATHandle VARCHAR(32) NOT NULL,
	orgPhone VARCHAR(32) NOT NULL,
	orgLicense VARCHAR(32) NOT NULL,
	orgCity VARCHAR(32) NOT NULL,
	orgZip CHAR(9) NOT NULL,
	orgState CHAR(2) NOT NULL,
	orgAddress1 VARCHAR(64) NOT NULL,
	orgAddress2 VARCHAR(64) NOT NULL,
	orgHash CHAR(128) NOT NULL,
	orgSalt CHAR(64) NOT NULL,
	orgActivationToken CHAR (32),
	OrgName VARCHAR(64),
	UNIQUE(orgEmail),
	UNIQUE(orgAtHandle),
	PRIMARY KEY(orgId)
);

-- create user profile entity
CREATE TABLE userProfile (
	userId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	userEmail VARCHAR(128) NOT NULL,
	userATHandle VARCHAR(32) NOT NULL,
	userName VARCHAR(32) NOT NULL,
	UserHash CHAR(128) NOT NULL,
	userSalt CHAR(64) NOT NULL,
	userActivationToken CHAR (32),
	PRIMARY KEY(userId)
);

-- create message entity
CREATE TABLE 'message entity (
	msgID INT UNSIGNED AUTO_INCREMENT NOT NULL,

)
