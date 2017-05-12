<?php

namespace Edu\Cnm\PetRescueAbq;

require_once("autoload.php");


/**
 * Organization Class for PetRescueABQ
 *
 *
 *
 * @author Jeffrey Cooper <jcooper37@cnm.edu>
 * @version 0.1.0
 **/

	/**Class Organization
	 *@package Edu\Cnm\PetRescueAbq
	 **/
class Organization implements \JsonSerializable {
	/**
	 *id for this Organization; this is the primary key
	 * @var int $organizationId
	 **/
	private $organizationId;
	/*
	 * id of the Profile that administers the Organization; this is a foreign key.
	 * @var int $organizationProfileId
	 **/
	private $organizationProfileId;
	/*
	 * Token handed out to verify that the Organization is valid and not malicious.
	 * @var $organizationActivationToken
	 **/
	private $organizationActivationToken;
	/*
	 * Primary address line of the organization profile.
	 * @var string $organizationAddress1
	 **/
	private $organizationAddress1;
	/*
	 * Secondary address line of the organization profile. (optional)
	 * @var string $organizationAddress2
	 **/
	private $organizationAddress2;
	/*
	 * City for address of the organization profile.
	 * @var string $organizationCity
	 **/
	private $organizationCity;
	/*
	 * Email address of the organization profile.
	 * @var string $organizationEmail
	 **/
	private $organizationEmail;
	/*
	 * Official City License to operate of the organization. This is a unique index.
	 * @var string $organizationLicense
	 **/
	private $organizationLicense;
	/*
	 * Official name of the organization. This is a unique index.
	 * @var string $organizationName
	 **/
	private $organizationName;
	/*
	 * Phone number of the organization.
	 * @var string $organizationPhone
	 **/
	private $organizationPhone;
	/*
	 * State for address of the organization profile.
	 * @var string $organizationState
	 **/
	private $organizationState;
	/*
	 * Zip code for address of the organization profile.
	 * @var string $organizationZip
	 **/
	private $organizationZip;
	/*
	 * Constructor for this Organization
	 * @param int|null $newOrganizationId id of this Organization or null if a new Organization
	 * @param int $newOrganizationProfileId id of the Profile that administers the Organization's profile and posts.
	 * @param char|null $newOrganizationActivationToken activation token to authorize the use of the organization profile.
	 * @param string $newOrganizationAddress1 Primary address line of the Organization.
	 * @param string $newOrganizationAddress2 Secondary address line of the Organization.
	 * @param string $newOrganizationCity City for address of the Organization.
	 * @param string $newOrganizationEmail Email of the Organization.
	 * @param string $newOrganizationLicense License of the Organization.
	 * @param string $newOrganizationName Official name of the Organization.
	 * @param string $newOrganizationPhone Phone number of the Organization.
	 * @param char $newOrganizationState State for address of the Organization.
	 * @param char $newOrganizationZip Zip code for address of the Organization.
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 *@Documentation https://php.net/manual/en/language.oop5.decon.php
	 * */
	public function __construct(?int $newOrganizationId, ?string $newOrganizationActivationToken, string $newOrganizationAddress1, ?string $newOrganizationAddress2, string $newOrganizationCity, string $newOrganizationEmail, string $newOrganizationLicense, string $newOrganizationName, string $newOrganizationPhone, string $newOrganizationState, string $newOrganizationZip) {
		try {
			$this->setOrganizationId($newOrganizationId);
			$this->setOrganizationActivationToken($newOrganizationActivationToken);
			$this->setOrganizationAddress1($newOrganizationAddress1);
			$this->setOrganizationAddress2($newOrganizationAddress2);
			$this->setOrganizationCity($newOrganizationCity);
			$this->setOrganizationEmail($newOrganizationEmail);
			$this->setOrganizationLicense($newOrganizationLicense);
			$this->setOrganizationName($newOrganizationName);
			$this->setOrganizationPhone($newOrganizationPhone);
			$this->setOrganizationState($newOrganizationState);
			$this->setOrganizationZip($newOrganizationZip);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			//determine what exception type was thrown
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * accessor method for organization id
	 *
	 * @return int value of organization id (or null if new Organization)
	 **/
	public function getOrganizationId(): int {
		return ($this->organizationId);
	}
	/**
	 * mutator method for organization id
	 *
	 * @param int|null $newOrganizationId value of new organization id
	 * @throws \RangeException if $newOrganizationId is not positive
	 * @throws \TypeError if $newOrganizationId is not an integer
	 **/
	public function setOrganizationId(?int $newOrganizationId): void {
		if($newOrganizationId === null) {
			$this->organizationId = null;
			return;
		}
		// verify the organization id is positive
		if($newOrganizationId <= 0) {
			throw(new \RangeException("organization id is not positive"));
		}
		// convert and store the organization id
		$this->organizationId = $newOrganizationId;
	}

	/**
	 * accessor method for organization profile id
	 * @return int value of the organization profile id
	 **/
	public function getOrganizationProfileId(): int {
		return ($this->organizationProfileId);
	}

	/**
	 * mutator method for organization profile id
	 * @param int $newOrganizationProfileId new value of organization profile id
	 * @throws \RangeException is $newOrganizationProfileId is not positive
	 * @throws \TypeError if %newOrganizationProfileId is not an integer
	 */
	public function setMessageProfileId(int $newOrganizationProfileId) : void {

		//verify the organization profile id is positive
		if($newOrganizationProfileId <= 0) {
			throw(new \RangeException("organization profile id is not positive"));
		}

		//convert and store the organization profile id
		$this->organizationProfileId = $newOrganizationProfileId;
	}

	/**
	 * accessor method for account activation token
	 *
	 * @return string value of the activation token (or null if authenticated)
	 */
	public function getOrganizationActivationToken() : ?string {
		return ($this->organizationActivationToken);
	}
	/**
	 * mutator method for account activation token
	 *
	 * @param string $newOrganizationActivationToken
	 * @throws \InvalidArgumentException  if the token is not a string or insecure
	 * @throws \RangeException if the token is not exactly 32 characters
	 * @throws \TypeError if the activation token is not a string
	 */
	public function setOrganizationActivationToken(?string $newOrganizationActivationToken): void {
		if($newOrganizationActivationToken === null) {
			$this->organizationActivationToken = null;
			return;
		}
		$newOrganizationActivationToken = strtolower(trim($newOrganizationActivationToken));
		$newOrganizationActivationToken = filter_var($newOrganizationActivationToken, FILTER_SANITIZE_STRING);
		if(ctype_xdigit($newOrganizationActivationToken) === false) {
			throw(new\RangeException("user activation is not valid"));
		}
		//make sure user activation token is only 32 characters
		if(strlen($newOrganizationActivationToken) !== 32) {
			throw(new\RangeException("user activation token has to be 32"));
		}
		$this->organizationActivationToken = $newOrganizationActivationToken;
	}
	/**
	 * accessor method for organization address1
	 *
	 * @return string value of organization address1
	 **/
	public function getOrganizationAddress1() :string {
		return($this->organizationAddress1);
	}
	/**
	 * mutator method for organization address1
	 *
	 * @param string $newOrganizationAddress1 new value of organization address1
	 * @throws \InvalidArgumentException if $newOrganizationAddress1 is not a string or insecure
	 * @throws \RangeException if $newOrganizationAddress1 is > 64 characters
	 * @throws \TypeError if $newOrganizationAddress1 is not a string
	 **/
	public function setOrganizationAddress1(string $newOrganizationAddress1) : void {
		// verify the organization address1 is secure
		$newOrganizationAddress1 = trim($newOrganizationAddress1);
		$newOrganizationAddress1 = filter_var($newOrganizationAddress1, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newOrganizationAddress1) === true) {
			throw(new \InvalidArgumentException("organization address1 is empty or insecure"));
		}
		// verify the organization address1 will fit in the database
		if(strlen($newOrganizationAddress1) > 64) {
			throw(new \RangeException("organization address1 too large"));
		}
		// store the organization address1
		$this->organizationAddress1 = $newOrganizationAddress1;
	}
	/**
	 * accessor method for organization address2
	 *
	 * @return string value of organization address2
	 **/
	public function getOrganizationAddress2() :?string {
		return($this->organizationAddress2);
	}
	/**
	 * mutator method for organization address2
	 *
	 * @param string $newOrganizationAddress2 new value of organization address2
	 * @throws \InvalidArgumentException if $newOrganizationAddress2 is not a string or insecure
	 * @throws \RangeException if $newOrganizationAddress2 is > 64 characters
	 * @throws \TypeError if $newOrganizationAddress2 is not a string
	 **/
	//TODO: according to SQL this is not required so do not check on empty
	public function setOrganizationAddress2(?string $newOrganizationAddress2) : void {
		// verify the organization address2 is secure
		$newOrganizationAddress2 = trim($newOrganizationAddress2);
		$newOrganizationAddress2 = filter_var($newOrganizationAddress2, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		// remove the error msg if add2 is empty
/*		if(empty($newOrganizationAddress2) === true) {
			throw(new \InvalidArgumentException("organization address2 is empty or insecure"));
		}*/
		// verify the organization address2 will fit in the database
		if(strlen($newOrganizationAddress2) > 64) {
			throw(new \RangeException("organization address2 too large"));
		}
		// store the organization address2
		$this->organizationAddress2 = $newOrganizationAddress2;
	}
	/**
	 * accessor method for organization city
	 *
	 * @return string value of organization city
	 **/
	public function getOrganizationCity() :string {
		return($this->organizationCity);
	}
	/**
	 * mutator method for organization city
	 *
	 * @param string $newOrganizationCity new value of organization city
	 * @throws \InvalidArgumentException if $newOrganizationCity is not a string or insecure
	 * @throws \RangeException if $newOrganizationCity is > 32 characters
	 * @throws \TypeError if $newOrganizationCity is not a string
	 **/
	public function setOrganizationCity(string $newOrganizationCity) : void {
		// verify the organization city is secure
		$newOrganizationCity = trim($newOrganizationCity);
		$newOrganizationCity = filter_var($newOrganizationCity, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newOrganizationCity) === true) {
			throw(new \InvalidArgumentException("organization city is empty or insecure"));
		}
		// verify the organization city will fit in the database
		if(strlen($newOrganizationCity) > 32) {
			throw(new \RangeException("organization city too large"));
		}
		// store the organization city
		$this->organizationCity = $newOrganizationCity;
	}
	/**
	 * accessor method for email
	 *
	 * @return string value of email
	 **/
	public function getOrganizationEmail(): string {
		return $this->organizationEmail;
	}
	/**
	 * mutator method for email
	 *
	 * @param string $newOrganizationEmail new value of email
	 * @throws \InvalidArgumentException if $newEmail is not a valid email or insecure
	 * @throws \RangeException if $newEmail is > 128 characters
	 * @throws \TypeError if $newEmail is not a string
	 **/
	public function setOrganizationEmail(string $newOrganizationEmail): void {
		// verify the email is secure
		$newOrganizationEmail = trim($newOrganizationEmail);
		$newOrganizationEmail = filter_var($newOrganizationEmail, FILTER_VALIDATE_EMAIL);
		if(empty($newOrganizationEmail) === true) {
			throw(new \InvalidArgumentException("organization email is empty or insecure"));
		}
		// verify the email will fit in the database
		if(strlen($newOrganizationEmail) > 128) {
			throw(new \RangeException("organization email is too large"));
		}
		// store the email
		$this->organizationEmail = $newOrganizationEmail;
	}

	/**
	 * accessor method for organization license
	 *
	 * @return string value of organization license
	 **/
	public function getOrganizationLicense(): string {
		return ($this->organizationLicense);
	}
	/**
	 * mutator method for organization license
	 *
	 * @param string $newOrganizationLicense new value of license
	 * @throws \InvalidArgumentException if $newOrganizationLicense is not a string or insecure
	 * @throws \RangeException if $newOrganizationLicense is > 32 characters
	 * @throws \TypeError if $newOrganizationLicense is not a string
	 **/
	public function setOrganizationLicense(string $newOrganizationLicense) : void {
		// verify the license is secure
		$newOrganizationLicense = trim($newOrganizationLicense);
		$newOrganizationLicense = filter_var($newOrganizationLicense, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newOrganizationLicense) === true) {
			throw(new \InvalidArgumentException("organization license is empty or insecure"));
		}
		// verify the license will fit in the database
		if(strlen($newOrganizationLicense) > 32) {
			throw(new \RangeException("organization license is too large"));
		}
		// store the license
		$this->organizationLicense = $newOrganizationLicense;
	}
	/**
	 * accessor method for organization name
	 *
	 * @return string value of organization name
	 **/
	public function getOrganizationName(): string {
		return ($this->organizationName);
	}
	/**
	 * mutator method for organization name
	 *
	 * @param string $newOrganizationName new value of organization name
	 * @throws \InvalidArgumentException if $newOrganizationName is not a string or insecure
	 * @throws \RangeException if $newOrganizationName is > 64 characters
	 * @throws \TypeError if $newOrganizationName is not a string
	 **/
	public function setOrganizationName(string $newOrganizationName) : void {
		// verify the organization name is secure
		$newOrganizationName = trim($newOrganizationName);
		$newOrganizationName = filter_var($newOrganizationName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newOrganizationName) === true) {
			throw(new \InvalidArgumentException("organization name is empty or insecure"));
		}
		// verify the organization name will fit in the database
		if(strlen($newOrganizationName) > 64) {
			throw(new \RangeException("organization name is too large"));
		}
		// store the organization name
		$this->organizationName = $newOrganizationName;
	}
	/**
	 * accessor method for phone
	 *
	 * @return string value of phone
	 **/
	public function getOrganizationPhone(): string {
		return ($this->organizationPhone);
	}
	/**
	 * mutator method for phone
	 *
	 * @param string $newOrganizationPhone new value of phone
	 * @throws \InvalidArgumentException if $newPhone is not a string or insecure
	 * @throws \RangeException if $newPhone is > 32 characters
	 * @throws \TypeError if $newPhone is not a string
	 **/
	public function setOrganizationPhone(string $newOrganizationPhone): void {
		//if $organizationPhone is null return it right away
		if($newOrganizationPhone === null) {
			$this->organizationPhone = null;
			return;
		}
		// verify the phone is secure
		$newOrganizationPhone = trim($newOrganizationPhone);
		$newOrganizationPhone = filter_var($newOrganizationPhone, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newOrganizationPhone) === true) {
			throw(new \InvalidArgumentException("organization phone is empty or insecure"));
		}
		// verify the phone will fit in the database
		if(strlen($newOrganizationPhone) > 32) {
			throw(new \RangeException("organization phone is too large"));
		}
		// store the phone
		$this->organizationPhone = $newOrganizationPhone;
	}
	/**
	 * accessor method for state
	 *
	 * @return string value of state
	 **/
	public function getOrganizationState(): string {
		return ($this->organizationState);
	}
	/**
	 * mutator method for state
	 *
	 * @param string $newOrganizationState new value of state
	 * @throws \InvalidArgumentException if $newState is not a string or insecure
	 * @throws \RangeException if $newState is > 2 characters
	 * @throws \TypeError if $newState is not a string
	 **/
	public function setOrganizationState(string $newOrganizationState): void {
		//if $organizationState is null return it right away
		if($newOrganizationState === null) {
			$this->organizationState = null;
			return;
		}
		// verify the state is secure
		$newOrganizationState = trim($newOrganizationState);
		$newOrganizationState = filter_var($newOrganizationState, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newOrganizationState) === true) {
			throw(new \InvalidArgumentException("organization state is empty or insecure"));
		}
		// verify the state will fit in the database
		if(strlen($newOrganizationState) > 2) {
			throw(new \RangeException("organization state is too large"));
		}
		// store the state
		$this->organizationState = $newOrganizationState;
	}
	/**
	 * accessor method for zip
	 *
	 * @return string value of zip
	 **/
	public function getOrganizationZip(): string {
		return ($this->organizationZip);
	}
	/**
	 * mutator method for zip
	 *
	 * @param string $newOrganizationZip new value of zip
	 * @throws \InvalidArgumentException if $newZip is not a string or insecure
	 * @throws \RangeException if $newZip is > 10 characters
	 * @throws \TypeError if $newZip is not a string
	 **/
	public function setOrganizationZip(string $newOrganizationZip): void {
		//if $organizationZip is null return it right away
		if($newOrganizationZip === null) {
			$this->organizationZip = null;
			return;
		}
		// verify the zip is secure
		$newOrganizationZip = trim($newOrganizationZip);
		$newOrganizationZip = filter_var($newOrganizationZip, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newOrganizationZip) === true) {
			throw(new \InvalidArgumentException("organization zip is empty or insecure"));
		}
		// verify the zip will fit in the database
		if(strlen($newOrganizationZip) > 10) {
			throw(new \RangeException("organization zip is too large"));
		}
		// store the zip
		$this->organizationZip = $newOrganizationZip;
	}
	/**
	 * inserts this Organization into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {
		// enforce the organizationId is null (i.e., don't insert a organization that already exists)
		if($this->organizationId !== null) {
			throw(new \PDOException("not a new organization"));
		}
		// create query template
		$query = "INSERT INTO organization(organizationProfileId, organizationActivationToken, organizationAddress1, organizationAddress2, organizationCity, organizationEmail, organizationLicense, organizationName, organizationPhone, organizationState, organizationZip) VALUES(:organizationProfileId, :organizationActivationToken, :organizationAddress1, :organizationAddress2, :organizationCity, :organizationEmail, :organizationLicense, :organizationName, :organizationPhone, :organizationState, :organizationZip)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["organizationProfileId" => $this->organizationProfileId, "organizationActivationToken" => $this->organizationActivationToken, "organizationAddress1" => $this->organizationAddress1, "organizationAddress2" => $this->organizationAddress2, "organizationCity" => $this->organizationCity, "organizationEmail" => $this->organizationEmail, "organizationLicense" => $this->organizationLicense, "organizationName" => $this->organizationName, "organizationPhone" => $this->organizationPhone, "organizationState" => $this->organizationState, "organizationZip" => $this->organizationZip];
		$statement->execute($parameters);
		// update the null organizationId with what mySQL just gave us
		$this->organizationId = intval($pdo->lastInsertId());
	}

	/**
	 * deletes this Organization from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
		// enforce the organizationId is not null (i.e., don't delete a organization that hasn't been inserted)
		if($this->organizationId === null) {
			throw(new \PDOException("unable to delete an organization that does not exist"));
		}
		// create query template
		$query = "DELETE FROM organization WHERE organizationId = :organizationId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holder in the template
		$parameters = ["organizationId" => $this->organizationId];
		$statement->execute($parameters);
	}

	/**
	 * updates this Organization in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {
		// enforce the organizationId is not null (i.e., don't update a organization that hasn't been inserted)
		if($this->organizationId === null) {
			throw(new \PDOException("unable to update an organization that does not exist"));
		}
		// create query template
		$query = "UPDATE organization SET organizationProfileId = :organizationProfileId, organizationActivationToken = :organizationActivationToken, organizationAddress1 = :organizationAddress1, organizationAddress2 = :organizationAddress2, organizationCity = :organizationCity, organizationEmail = :organizationEmail, organizationLicense = :organizationLicense, organizationName = :organizationName, organizationPhone = :organizationPhone, organizationState = :organizationState, organizationZip = :organizationZip WHERE organizationId = :organizationId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["organizationProfileId" => $this->organizationProfileId, "organizationActivationToken" => $this->organizationActivationToken, "organizationAddress1" => $this->organizationAddress1, "organizationAddress2" => $this->organizationAddress2, "organizationCity" => $this->organizationCity, "organizationEmail" => $this->organizationEmail, "organizationLicense" => $this->organizationLicense, "organizationName" => $this->organizationName, "organizationPhone" => $this->organizationPhone, "organizationState" => $this->organizationState, "organizationZip" => $this->organizationZip, "organizationId" => $this->organizationId];
		$statement->execute($parameters);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return($fields);
	}
}
