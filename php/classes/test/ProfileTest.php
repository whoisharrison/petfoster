<?php
/**
 * User: @mharrison13
 * Date: 5/5/17
 * Time: 10:25 PM
 **/
namespace Edu\Cnm\Petfoster\Profile;

require_once(dirname(__DIR__) . "/autoload.php");

/**
 * Full PHPUnit Test for Profile class
 *
 * This is the complete PHPUnit test of the Profile class. mySQL/PDO enabled methods will be tested for both valid and invalid inputs.
 *
 * @see profile
 * @author Michael Harrison <mharrison13@cnm.edu>
 */
class ProfileTest extends PetRescueAbqTest {
	/**
	 * placeholder until account activation is created
	 * @var string $VALID_ACTIVATION
	 **/
	protected $VALID_ACTIVATION;

	/**
	 *valid at handle to use
	 * @var string @VALID_ATHANDLE
	 **/
	protected $VALID_ATHANDLE = "phpunit";

	/**
	 * valid second at handle to use
	 * @var string $VALID_ATHANDLE2
	 **/
	protected $VALID_ATHANDLE2 = "@passingtest";

	/**
	 * valid email to use
	 * @var string $VALID_EMAIL
	 **/
	protected $VALID_EMAIL = "test@phpunit.com";

	/**
	 * valid hash to use
	 * @var $VALID_HASH
	 **/
	protected $VALID_HASH;

	/**
	 * valid name to use
	 * @var string $VALID_NAME
	 **/
	protected $VALID_NAME;

	/**
	 * valid salt to use
	 * @var string $VALID_SALT
	 **/
	protected $VALID_SALT;

	/**
	 * run default setup to operation to create salt and hash
	 **/
	public final function setUp() : void {
		parent::setUp();

		//
		$password = "123456";
		$this->VALID_SALT = bin2hex(random_bytes(32));
		$this->VALID_HASH = hash_pbkdf2("sha512", $password, $this->VALID_SALT, 262144);
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));
	}

	/**
	 * test inserting a valid Profile and the mySQL data matches
	 **/
	public function testInsertValidProfile() : void {
		// count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert in mySQL
		$profile = new Profile(null, $this->VALID_ACTIVATION, $this->VALID_ATHANDLE, $this->Valid_Email, $this->VALID_HASH, $this->VALID_NAME, $this->VALID_SALT);

		//var_dump($profile);

		$profile->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertSame($numRows + 1, $this->getConnecion()->getPDO(), $profile->getProfileID());
		$this->assertSame($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertSame($pdoProfile->getProfileAtHandle(), $this->VALID_ATHANDLE);
		$this->assertSame($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertSame($pdoProfile->getProfileHash(), $this->VALID_HASH);
		$this->assertSame($pdoProfile->getProfileName(), $this->VALID_NAME);
		$this->assertSame($pdoProfile->getProfileSale(), $this->VALID_SALT);
	}

	/**
	 * test inserting a Profile that already exists
	 *
	 * @expectedException \PDOException
	 **/
	public function testInsertInvalidProfile() : void {
		// create a profile with a non null profileId and it will fail
		$profile = new Profile(PetRescueAbqTest::INVALID_KEY, $this->VALID_ACTIVATION, $this->VALID_ATHANDLE, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_NAME, $this->VALID_SALT);
		$profile->insert($this->getPDO());
	}

	/**
	 * test inserting a Profile, editing and then updating it
	 **/
	public function testUpdateValidProfile() {
		// count the number of rows and save if for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create a new Profile and insert into mySQL
		$profile = new Profile(null, $this->VALID_ACTIVATION, $this->VALID_ATHANDLE, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_NAME, $this->VALID_SALT);
		$profile->insert($this->getPDO());

		//edit the Profile AtHandle and update it in mySQL
		$profile->setProfileAtHandle($this->VALID_ATHANDLE2);
		$profile->update($this->getPDO());

		// grab data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfilebyProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertSame($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertSame($pdoProfile->getProfileAtHandle(), $this->VALID_ATHANDLE2);
		$this->assertSame($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertSame($pdoProfile->getProfileHash(), $this->VALID_HASH);
		$this->assertSame($pdoProfile->getProfileName(), $this->VALID_NAME);
		$this->assertSame($pdoProfile->getProfileSale(), $this->VALID_SALT);
	}

	/**
	 * test updating a Profile that does not exist
	 *
	 * @expectedException \PDOException
	 **/
	public function testUpdateInvalidProfile() {
		// create a Profile and try to update it without actually inserting it
		$profile = new Profile(null, $this->VALID_ACTIVATION, $this->VALID_ATHANDLE, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_NAME, $this->VALID_SALT);
		$profile->update($this->getPFO());
	}

	/**
	 * test creating a Profile and deleting it
	 **/
	public function testDeleteValidProfile() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert into mySQL
		$profile = new Profile(null, $this->VALID_ACTIVATION, $this->VALID_ATHANDLE, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_NAME, $this->VALID_SALT):
		$profile->insert($this->getPDO());

		// delete Profile from mySQL
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$profile->delete($this->getPDO());

		// grab data from mySQL and enforce the Profile does not exist
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertNull($pdoProfile);
		$this->assertSame($numRows, $this->getConnection()->getRowCount("profile"));
	}

	/**
	 * test deleting a Profile that does not exist
	 *
	 * #expectedException \PDOException
	 **/
	public function testDeleteInvalidProfile() : void {
		// create a Profile and try to delete it without actually inserting it
		$profile = new Profile(null, $this->VALID_ACTIVATION, $this->VALID_ATHANDLE, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_NAME, $this->VALID_SALT);
		$profile->delete($this->getPDO());
	}

	/**
	 * test inserting a Profile and re-grabbing it from mySQL
	 **/
	public function testGetValidProfileByProfileId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create a new Profile and insert into mySQL
		$profile = new Profile(null, $this->VALID_ACTIVATION, $this->VALID_ATHANDLE, $this->VALID_EMAIL,
			$this->VALID_HASH, $this->VALID_NAME, $this->VALID_SALT);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertSame($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertSame($pdoProfile->getProfileAtHandle(), $this->VALID_ATHANDLE);
		$this->assertSame($pdoProfile->getProfileEmail(), $this->VALID_HASH);
		$this->assertSame($pdoProfile->getProfileName(), $this->VALID_NAME);
		$this->assertSame($pdoProfile->getProfileSalt(), $this->VALID_SALT);
	}

	/**
	 * test grabbing a Profile that does not exist
	 **/
	public function testGetInvalidProfileByProfileId() : void {
		// grab a profile id that exceed the maximum allowable profile id
		$profile = Profile::getProfileByProfileId($this->getPDO(), PetRescueAbqTest::INVALID_KEY);
		$this->assertNull($profile);
	}

	/**
	 * test grabbing a profile by email
	 **/
	public function testGetValidProfileByEmail() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new profile and insert into mySQL
		$profile = new Profile(null, $this->VALID_ACTIVATION, $this->VALID_ATHANDLE, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_NAME, $this->VALID_SALT);
		$profile->insert($this->getPDO());

		//grab data from mySQL
		$pdoProfile = Profile::getProfileByProfileEmail($this->getPDO(), $profile->getProfileMEail());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertSame($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertSame($pdoProfile->getProfileAtHandle(), $this->VALID_ATHANDLE);
		$this->assertSame($pdoProfile->getProfileEmail(), $this->VALID_HASH);
		$this->assertSame($pdoProfile->getProfileName(), $this->VALID_NAME);
		$this->assertSame($pdoProfile->getProfileSalt(), $this->VALID_SALT);
	}

	/**
	 * test grabbing a Profile by email that does n0t exist
	 */
	public function testGetInvalidProfileActivation() : void {
		// grab an email that does not exist
		$profile = Profile::getProfileByProfileByProfileEmail($this->getPDO(), "mharrison@cnm.edu");
		$this->assetNull($profile);
	}

}


