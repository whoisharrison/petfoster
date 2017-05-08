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

	public function __construct(?int $newProfileId, ?string $newProfileActivationToken, ?string $newProfileAtHandle, ?string $newProfileEmail, ?string $newProfileHash, ?string $newProfileName, ?string $newProfileSalt) {
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
	public function getProfileId(): int {
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

	/


}
