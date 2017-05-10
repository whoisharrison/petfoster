<?php
namespace Edu\Cnm\Petfoster;
require("autoload.php");
/**
 * Profile Class for Petfoster
 *
 * This class is a collection of profile data collected by users of Pet Rescue ABQ.
 *
 * @author Michael Harrison <mharrison13@cnm.edu>
 * @version 0.0.1
 **/
class Profile implements \JsonSerializable {
	/**
	 * id for this Profile; this is the primary key
	 * @var int $profileId
	 **/
	private $profileId;
	/**
	 * this is the Profile Activation Token for profileId
	 * @var string $profileActivationToken
	 */
	private $profileActivationToken;
	/**
	 * this is the AtHandle for the user profile
	 * @var profileAtHandle
	 **/
	private $profileAtHandle;
	/**
	 * this is the email for the user profile
	 * @var string $profileEmail
	 */
	private $profileEmail;
	/**
	 * this is the hash for the hash for the users profile
	 * @var string $profileHash
	 **/
	private $profileHash;
	/**
	 * this is the name for the profile
	 * @var string $profileName
	 **/
	private $profileName;
	/**
	 * this is the salt for the users profile
	 * @var string $profileSalt
	 **/
	private $profileSalt;

	/**
	 * constructor for profile
	 *
	 * @param int|null $newProfileId of this profile or null if its a new profile
	 * @param string $newProfileActivationToken activation token for the new profile
	 * @param string $newProfileAtHandle for the profile that was created
	 * @param string $newProfileEmail for the profile that was created
	 * @param string $newProfileHash string containing password hash
	 * @param string $newProfileName for the profile that was created
	 * @param string $newProfileSalt string containing password salt
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @documentation https://php.net/manual/en/language.oop5.decon.php
	 **/

	public function __construct(?int $newProfileId, ?string $newProfileActivationToken, string $newProfileAtHandle, string $newProfileEmail, string $newProfileHash, string $newProfileName, string $newProfileSalt) {
		try{
			$this->setProfileId($newProfileId);
			$this->setProfileActivationToken($newProfileActivationToken);
			$this->setProfileAtHandle($newProfileAtHandle);
			$this->setProfileEmail($newProfileEmail);
			$this->setProfileHash($newProfileHash);
			$this->setProfileName($newProfileName);
			$this->setProfileSalt($newProfileSalt);
		} catch(\InvalidArgumentException | \Exception | \TypeError $exception) {
			//determine what exception was thrown
			$exceptionType = get_class ($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for profile id
	 *
	 * @return int value of profile id (or null if new profile)
	 **/
	public function getProfileId(): ?int {
		return ($this->profileId);
}

	/**
	 * mutator method for profile id
	 *
	 * @param int|null $newProfileId value of new profile id
	 * @throws \RangeException if $newProfileId is not a positive int
	 * @throws \TypeError if $newProfileId is not an int
	 **/
	public function setProfileId(?int $newProfileId): void {
		if($newProfileId === null) {
			return;
		}

		// verify the profile id is positive
		if($newProfileId <= 0) {
			throw(new \RangeException("the profile id is not positive"));
		}

		// convert and store the profile id
		$this->profileId = $newProfileId;
	}

	/** accessor method for account activation token
	 *
	 *@return string value of the activation token
	 **/
	public function getProfileActivationToken() : ?string {
		return ($this->profileActivationToken);
	}

	/**
	 * mutator method for account activation token
	 *
	 * @param string $newProfileActivationToken
	 * @throws \InvalidArgumentException if the token is not a string or is insecure
	 * @throws \RangeException if the token is not exactly 32 characters
	 * @throws \TypeError if the activation token is not a string
	 **/
	public function setProfileActivationToken(?string $newProfileActivationToken): void {
		if($newProfileActivationToken === null) {
			$this->profileActivationToken = null;
			return;
		}

		$newProfileActivationToken = strtolower(trim($newProfileActivationToken));
		if(ctype_xdigit($newProfileActivationToken) === false) {
			throw(new\RangeException("user activation is not valid"));
		}

		//make sure user activation token is only 32 char
		if(strlen($newProfileActivationToken) !== 32) {
			throw(new\RangeException("user activation token has to be 32"));
		}
		$this->profileActivationToken = $newProfileActivationToken;
	}

	/**
	 * accessor method for at handle
	 *
	 * @return string value of at handle
	 **/
	public function getProfileAtHandle(): string {
		return ($this->profileAtHandle);
	}

	/**
	 * mutator method for the at handle
	 *
	 * @param string $newProfileAtHandle new value of at handle
	 * @throws \InvalidArgumentException if $newAtHandle is not a string or insecure
	 * @throws \RangeException if $newAtHandle is >32 characters
	 * @throws \TypeError if $newAtHandle is not a string
	 **/
	public function setProfileAtHandle(string $newProfileAtHandle) : void {
		//verify the at handle is secure
		$newProfileAtHandle = trim($newProfileAtHandle);
		$newProfileAtHandle = filer_var($newProfileAtHandle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileAtHandle) === true) {
			throw(new \InvalidArgumentException("profile at handle is empty or insecure"));
		}

		// verify the at handle will fit in the database
		if(strlen($newProfileAtHandle) > 32) {
			throw(new \RangeException("profile at handle is too long"));
		}

		// store the at handle
		$this->profileAtHandle = $newProfileAtHandle;
	}

	/**
	 * accessor method for email
	 *
	 * @return string value of email
	 **/
	public function getProfileEmail(): string {
		return $this->profileEmail;
	}

	/**
	 * mutator method for email
	 *
	 * @param string $newProfileEmail new value of email
	 * @throws \InvalidArgumentException if $newEmail is not a valid email or insecure
	 * @throws \RangeException if $newProfileEmail is >128 characters
	 * @throws \TypeError if $newProfileEmail is not a string
	 **/
	public function setProfileEmail(string $newProfileEmail) : void {
		// verify the email is secure
		$newProfileEmail = trim($newProfileEmail);
		$newProfileEmail = filter_var($newProfileEmail, FILTER_VALIDATE_EMAIL);
		if(empty($newProfileEmail) === true) {
			throw(new \InvalidArgumentException("Email empty or insecure"));
		}

		// verify the email will fit in the database
		if(strlen($newProfileEmail) > 128) {
			throw(new \RangeException("Email is too large"));
		}

		// store the email
		$this->profileEmail = $newProfileEmail;
	}

	/**
	 * accessor method for profileHash
	 *
	 * @return string value of hash
	 **/
	public function getProfileHash(): string {
		return $this->profileHash;
	}

	/**
	 * mutator method for profile hash password
	 *
	 * @param string $newProfileHash
	 * @throws \InvalidArgumentException if hash is not secure
	 * @throws \RangeException if hash is not 128 characters
	 * @throws \TypeError if the profile hash is not a string
	 **/
	public function  setProfileHash(string $newProfileHash): void {
		//enforce that the hash is properly formatted
		$newProfileHash = trim($newProfileHash);
		$newProfileHash - strtolower($newProfileHash);
		if(empty($newProfileHash) === true) {
			throw(new \InvalidArgumentException("profile password hash is empty or insecure"));
		}

		//enforce that the hash is a sting representation of a hexadecimal
		if(!ctype_xdigit($newProfileHash)) {
			throw(new \InvalidArgumentException("profile password hash is empty or insecure"));
		}

		//enforce that the hash is exactly 128 characters
		if(strlen($newProfileHash) !== 128) {
			throw(new \RangeException("hash must be 128 characters"));
		}

		//store the hash
		$this->profileHash = $newProfileHash;

	}

	/**
	 * accessor method for name
	 *
	 * @return string value of profile name
	 **/
	public function getProfileName() : string {
		return ($this->profileName);
	}

	/**
	 * mutator method for profile name
	 *
	 * @param string $newProfileName new value for profile name
	 * @throws \InvalidArgumentException if $newProfileName is not a string or insecure
	 * @throws \RangeException if $newProfileName is > 32 characters
	 * @throws \TypeError if $newProfileName is not a string
	 **/

	public function getProfileName(string $newProfileName): void {
		// verify the email is secure
		$newProfileName = trim($newProfileName);
		$newProfileName = filter_var($newProfileName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileName) === true) {
			throw(new \InvalidArgumentException("Profile name is empty"));
		}

		//verity the email will will fit in database
		if(strlen($newProfileName) > 32) {
			throw(new \RangeException("Profile name is too large"));
		}

		//store profile name
		$this->profileName = $newProfileName;
	}

	/**
	 * accessor method for Salt
	 *
	 *@return string value for Salt hexadecimal
	 **/
	public function getProfileSalt(): string {
		return $this->profileSalt;
	}
	/**
	 * mutator method for Salt
	 *
	 * @param string $newProfileSalt
	 * @throws \InvalidArgumentException if salt is not insecure
	 * @throws \RangeException if salt is not 64 characters
	 * @throws \TypeError if profile salt is not a string
	 **/
	public function setProfileSalt(string $newProfileSalt) : void {
		$newProfileSalt = trim(@$newProfileSalt);
		$newProfileSalt = strtolower($newProfileSalt);

		//enforce the salt is a string representation of a hexadecimal
		if(!ctype_xdigit($newProfileSalt)) {
			throw (new \InvalidArgumentException("profile password hash is empty or insecure"));
		}

		//enforce that the salt is 64 characters
		if(strlen($newProfileSalt) !== 64) {
			throw(new \RangeException("profile password much be 128 characters"));
		}

		//store hash
		$this->profileSalt = $newProfileSalt;
	}
	/**
	 * inserts profile in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {
		//enforce the profileID is null (do not insert profile that already exists)
		if($this->profileId !== null) {
			throw(new \PDOException("not a new profile"));
		}

		// create query template
		$query = "INSERT INTO profile(profileActivationToken, profileAtHandle, profileEmail, ProfileHash, ProfileName, ProfileSalt) VALUES (:profileActivationToken, :profileAtHandle, :profileEmail, :profileHash, :profileName, :profileSalt)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the placeholders in the template
		$parameters = ["profileActivationToken" => $this->profileActivationToken, "profileAtHandle" => $this->profileAtHandle, "profileEmail" => $this->profileEmail, "profileHash" => $this->profileHash, "profileName" => $this->profileName, "profileSalt" => $this->profileSalt];

		// update the null profileId with what mySQL just gave
		$this->profileId = intval($pdo->lastInsertId());
	}

	/**
	 * deleted profile from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function delete(\PDO $pdo): void {
		//enforce the profileId is not null (i.e., don't delete a profile that does not exist)
	}


}
