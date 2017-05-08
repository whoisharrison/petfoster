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
	 * @param string $newProfileAtHandle for the profile that was created
	 * @param string $newProfileEmail for the profile that was created
	 * @param string $newProfileName for the profile that was created
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @documentation https://php.net/manual/en/language.oop5.decon.php
	 **/

	public function __construct(?int $newProfileId, int $newProfileAtHandle, string $newProfileEmail, string $newProfileName) {
		try{
			$this->setProfileId($newProfileId);
			$this->setProfileAtHandle($newProfileAtHandle);
			$this->setProfileEmail($newProfileEmail);
			$this->setProfileName($newProfileName);
		}
			//determine what exception was thrown
		catch(\InvalidArgumentException | \TypeError | \Exception) {
			$exceptionType = get_class ($exception);
			throw(new $excpetionType($exception->getMessage(), 0, $exception));
		}
	}


}
