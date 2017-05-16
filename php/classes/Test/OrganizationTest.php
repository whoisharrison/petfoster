<?php
namespace Edu\Cnm\PetRescueAbq\Test;

//grab the encrypted property files

use Edu\Cnm\PetRescueAbq\ {Profile, Organization};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");
/**
 * Full PHPUnit test for the Organization class
 *
 * This is a complete PHPUnit test of the Organization class. It is complete because *ALL* mySQL/PDO enabled methods are tested for both invalid and valid inputs.
 *
 * @see Organization
 * @author Jeffrey COoper <jcooper37@cnm.edu>
 **/
class OrganizationTest extends PetRescueAbqTest {
	/**
	 * placeholder until account activation is created
	 * @var string $VALID_ACTIVATION
	 */
	protected $VALID_ACTIVATION;
	/**
	 * Profile that created the Organization; this is for foreign key relations
	 * @var Profile profile
	 **/
	protected $profile = null;
	/**
	 * valid profile hash to create the profile object to own the test
	 * @var $VALID_HASH
	 */
	protected $VALID_PROFILE_HASH;
	/**
	 * valid salt to use to create the profile object to own the test
	 * @var string $VALID_SALT
	 */
	protected $VALID_PROFILE_SALT;
	/**
	 * content of the Organization
	 * @var string $VALID_ADDRESS1
	 **/
	protected $VALID_ADDRESS1 = "123 Fourth Street NW";
	/**
	 * content of the Organization
	 * @var string $VALID_ADDRESS2
	 **/
	protected $VALID_ADDRESS2 = "2nd Floor, Suite 789";
	/**
	 * content of the updated Tweet
	 * @var string $VALID_CITY
	 **/
	protected $VALID_CITY = "Albuquerque";
	/**
	 * valid email to use
	 * @var string $VALID_EMAIL
	 **/
	protected $VALID_EMAIL = "test@phpunit.com";
	/**
	 * valid email to use
	 * @var string $VALID_EMAIL2
	 */
	protected $VALID_EMAIL2 = "testtest@cnm.edu";
	/**
	 * valid License to use
	 * @var string $VALID_LICENSE
	 **/
	protected $VALID_LICENSE = "00941657";
	/**
	 * valid organization name to use
	 * @var string $VALID_NAME
	 **/
	protected $VALID_NAME = "ABQ Pet Rescue Club";
	/**
	 * valid phone number to use
	 * @var string $VALID_PHONE
	 **/
	protected $VALID_PHONE = "+12125551212";
	/**
	 * valid state to use
	 * @var string $VALID_STATE
	 **/
	protected $VALID_STATE = "NM";
	/**
	 * valid zip code to use
	 * @var string $VALID_ZIP
	 **/
	protected $VALID_ZIP = "87101-4567";
	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp()  : void {
		// run the default setUp() method first
		parent::setUp();
		$password = "A1b2c3";
		$profileActivationToken = bin2hex(random_bytes(16));
		$this->VALID_PROFILE_SALT = bin2hex(random_bytes(32));
		$this->VALID_PROFILE_HASH = hash_pbkdf2("sha512", $password, $this->VALID_PROFILE_SALT, 262144);
		// create and insert a Profile to own the test Organization
		$this->profile = new Profile(null, $profileActivationToken,"@testOrgHandle", "tester@phpunit.com", $this->VALID_PROFILE_HASH, "Don One", $this->VALID_PROFILE_SALT);
		$this->profile->insert($this->getPDO());
		$this->VALID_ACTIVATION = $profileActivationToken;
	}
	/**
	 * test inserting a valid Organization and verify that the actual mySQL data matches
	 **/
	public function testInsertValidOrganization() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("organization");
		// create a new Organization and insert to into mySQL

		var_dump($this->profile->getProfileId());

		$organization = new Organization(null, $this->profile->getProfileId(), $this->VALID_ACTIVATION, $this->VALID_ADDRESS1, $this->VALID_ADDRESS2, $this->VALID_CITY, $this->VALID_EMAIL, $this->VALID_LICENSE, $this->VALID_NAME, $this->VALID_PHONE, $this->VALID_STATE, $this->VALID_ZIP);
		//var_dump($organization);
		$organization->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoOrganization = Organization::getOrganizationByOrganizationId($this->getPDO(), $organization->getOrganizationId());
		$this->assertEquals($pdoOrganization->getOrganizationProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoOrganization->getOrganizationActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoOrganization->getOrganizationAddress1(), $this->VALID_ADDRESS1);
		$this->assertEquals($pdoOrganization->getOrganizationAddress2(), $this->VALID_ADDRESS2);
		$this->assertEquals($pdoOrganization->getOrganizationCity(), $this->VALID_CITY);
		$this->assertEquals($pdoOrganization->getOrganizationEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoOrganization->getOrganizationLicense(), $this->VALID_LICENSE);
		$this->assertEquals($pdoOrganization->getOrganizationName(), $this->VALID_NAME);
		$this->assertEquals($pdoOrganization->getOrganizationPhone(), $this->VALID_PHONE);
		$this->assertEquals($pdoOrganization->getOrganizationState(), $this->VALID_STATE);
		$this->assertEquals($pdoOrganization->getOrganizationZip(), $this->VALID_ZIP);
	}

	/**
	 * test inserting an Organization that already exists
	 *
	 * @expectedException \PDOException
	 **/
	public function testInsertInvalidOrganization() : void {
		// create an Organization with a non null organization id and watch it fail
			$organization = new Organization(PetRescueAbqTest::INVALID_KEY, $this->profile->getProfileId(), $this->VALID_ACTIVATION, $this->VALID_ADDRESS1, $this->VALID_ADDRESS2, $this->VALID_CITY, $this->VALID_EMAIL, $this->VALID_LICENSE, $this->VALID_NAME, $this->VALID_PHONE, $this->VALID_STATE, $this->VALID_ZIP);
			$organization->insert($this->getPDO());
	}
	/**
	 * test inserting an Organization, editing it, and then updating it
	 **/
	public function testUpdateValidOrganization() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("organization");
		// create a new Organization and insert it into mySQL
		$organization = new Organization(null, $this->profile->getProfileId(), $this->VALID_ACTIVATION, $this->VALID_ADDRESS1, $this->VALID_ADDRESS2, $this->VALID_CITY, $this->VALID_EMAIL, $this->VALID_LICENSE, $this->VALID_NAME, $this->VALID_PHONE, $this->VALID_STATE, $this->VALID_ZIP);
		$organization->insert($this->getPDO());
		// edit the Organization and update it in mySQL
		$organization->setOrganizationEmail($this->VALID_EMAIL2);
		$organization->update($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoOrganization = Organization::getOrganizationByOrganizationId($this->getPDO(), $organization->getOrganizationId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("organization"));
		// foreign key
		$this->assertEquals($pdoOrganization->getOrganizationProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoOrganization->getOrganizationActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoOrganization->getOrganizationAddress1(), $this->VALID_ADDRESS1);
		$this->assertEquals($pdoOrganization->getOrganizationAddress2(), $this->VALID_ADDRESS2);
		$this->assertEquals($pdoOrganization->getOrganizationCity(), $this->VALID_CITY);
		$this->assertEquals($pdoOrganization->getOrganizationEmail(), $this->VALID_EMAIL2);
		$this->assertEquals($pdoOrganization->getOrganizationLicense(), $this->VALID_LICENSE);
		$this->assertEquals($pdoOrganization->getOrganizationName(), $this->VALID_NAME);
		$this->assertEquals($pdoOrganization->getOrganizationPhone(), $this->VALID_PHONE);
		$this->assertEquals($pdoOrganization->getOrganizationState(), $this->VALID_STATE);
		$this->assertEquals($pdoOrganization->getOrganizationZip(), $this->VALID_ZIP);
	}
	/**
	 * test updating an Organization that does not exist
	 *
	 * @expectedException \PDOException
	 **/
	public function testUpdateInvalidOrganization() : void {
		// create an Organization with a non null Organization id and watch it fail
		$organization = new Organization(null, $this->profile->getProfileId(), $this->VALID_ACTIVATION, $this->VALID_ADDRESS1, $this->VALID_ADDRESS2, $this->VALID_CITY, $this->VALID_EMAIL, $this->VALID_LICENSE, $this->VALID_NAME, $this->VALID_PHONE, $this->VALID_STATE, $this->VALID_ZIP);
		$organization->update($this->getPDO());
	}
	/**
	 * test creating an Organization and then deleting it
	 **/
	public function testDeleteValidOrganization() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("organization");
		// create a new Organization and insert to into mySQL
		$organization = new Organization(null, $this->profile->getProfileId(), $this->VALID_ACTIVATION, $this->VALID_ADDRESS1, $this->VALID_ADDRESS2, $this->VALID_CITY, $this->VALID_EMAIL, $this->VALID_LICENSE, $this->VALID_NAME, $this->VALID_PHONE, $this->VALID_STATE, $this->VALID_ZIP);
		$organization->insert($this->getPDO());
		// delete the Tweet from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("organization"));
		$organization->delete($this->getPDO());
		// grab the data from mySQL and enforce the Tweet does not exist
		$pdoOrganization = Organization::getOrganizationByOrganizationId($this->getPDO(), $organization->getOrganizationId());
		$this->assertNull($pdoOrganization);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("organization"));
	}
	/**
	 * test deleting an Organization that does not exist
	 *
	 * @expectedException \PDOException
	 **/
	public function testDeleteInvalidOrganization() : void {
		// create an Organization and try to delete it without actually inserting it
		$organization = new Organization(null, $this->profile->getProfileId(), $this->VALID_ACTIVATION, $this->VALID_ADDRESS1, $this->VALID_ADDRESS2, $this->VALID_CITY, $this->VALID_EMAIL, $this->VALID_LICENSE, $this->VALID_NAME, $this->VALID_PHONE, $this->VALID_STATE, $this->VALID_ZIP);
		$organization->delete($this->getPDO());
	}
	/**
	 * test grabbing an Organization that does not exist
	 **/
	public function testGetInvalidOrganizationByOrganizationId() : void {
		// grab an Organization id that exceeds the maximum allowable Organization id
		$organization = Organization::getOrganizationByOrganizationId($this->getPDO(), PetRescueAbqTest::INVALID_KEY);
		$this->assertNull($organization);
	}
	/**
	 * test inserting an Organization and re-grabbing it from mySQL
	 **/
	public function testGetValidOrganizationByOrganizationProfileId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("organization");
		// create a new Organization and insert to into mySQL
		$organization = new Organization(null, $this->profile->getProfileId(), $this->VALID_ACTIVATION, $this->VALID_ADDRESS1, $this->VALID_ADDRESS2, $this->VALID_CITY, $this->VALID_EMAIL, $this->VALID_LICENSE, $this->VALID_NAME, $this->VALID_PHONE, $this->VALID_STATE, $this->VALID_ZIP);
		$organization->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = Organization::getOrganizationByOrganizationProfileId($this->getPDO(), $organization->getOrganizationProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("organization"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\PetRescueAbq\\Organization", $results);

		// grab the result from the array and validate it
		$pdoOrganization = $results[0];
		$this->assertEquals($pdoOrganization->getOrganizationProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoOrganization->getOrganizationActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoOrganization->getOrganizationAddress1(), $this->VALID_ADDRESS1);
		$this->assertEquals($pdoOrganization->getOrganizationAddress2(), $this->VALID_ADDRESS2);
		$this->assertEquals($pdoOrganization->getOrganizationCity(), $this->VALID_CITY);
		$this->assertEquals($pdoOrganization->getOrganizationEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoOrganization->getOrganizationLicense(), $this->VALID_LICENSE);
		$this->assertEquals($pdoOrganization->getOrganizationName(), $this->VALID_NAME);
		$this->assertEquals($pdoOrganization->getOrganizationPhone(), $this->VALID_PHONE);
		$this->assertEquals($pdoOrganization->getOrganizationState(), $this->VALID_STATE);
		$this->assertEquals($pdoOrganization->getOrganizationZip(), $this->VALID_ZIP);
	}
/**
	 * test grabbing an Organization that does not exist
	 **/
	public function testGetInvalidOrganizationByOrganizationProfileId() : void {
		// grab a profile id that exceeds the maximum allowable profile id
		$organization = Organization::getOrganizationByOrganizationProfileId($this->getPDO(), PetRescueAbqTest::INVALID_KEY);
		$this->assertCount(0, $organization);
	}
	/**
	 * test grabbing an Organization by organization email
	 **/
	public function testGetValidOrganizationByOrganizationEmail() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("organization");

		// create a new Organization and insert to into mySQL
		$organization = new Organization(null, $this->profile->getProfileId(), $this->VALID_ACTIVATION, $this->VALID_ADDRESS1, $this->VALID_ADDRESS2, $this->VALID_CITY, $this->VALID_EMAIL, $this->VALID_LICENSE, $this->VALID_NAME, $this->VALID_PHONE, $this->VALID_STATE, $this->VALID_ZIP);
		$organization->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Organization::getOrganizationByOrganizationEmail($this->getPDO(), $organization->getOrganizationEmail());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("organization"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test

		$this->assertEquals($pdoOrganization->getOrganizationProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoOrganization->getOrganizationActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoOrganization->getOrganizationAddress1(), $this->VALID_ADDRESS1);
		$this->assertEquals($pdoOrganization->getOrganizationAddress2(), $this->VALID_ADDRESS2);
		$this->assertEquals($pdoOrganization->getOrganizationCity(), $this->VALID_CITY);
		$this->assertEquals($pdoOrganization->getOrganizationEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoOrganization->getOrganizationLicense(), $this->VALID_LICENSE);
		$this->assertEquals($pdoOrganization->getOrganizationName(), $this->VALID_NAME);
		$this->assertEquals($pdoOrganization->getOrganizationPhone(), $this->VALID_PHONE);
		$this->assertEquals($pdoOrganization->getOrganizationState(), $this->VALID_STATE);
		$this->assertEquals($pdoOrganization->getOrganizationZip(), $this->VALID_ZIP);
	}
	/**
	 * test grabbing an Organization by email that does not exist
	 **/
	public function testGetInvalidOrganizationByEmail() : void {
		// grab an email that does not exist
		$organization = Organization::getOrganizationByOrganizationEmail($this->getPDO(), "does@not.exist");
		$this->assertNull($organization);
	}
	/**
	 * test grabbing an Organization by organization license
	 **/
	public function testGetValidOrganizationByOrganizationLicense() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("organization");

		// create a new Organization and insert to into mySQL
		$organization = new Organization(null, $this->profile->getProfileId(), $this->VALID_ACTIVATION, $this->VALID_ADDRESS1, $this->VALID_ADDRESS2, $this->VALID_CITY, $this->VALID_EMAIL, $this->VALID_LICENSE, $this->VALID_NAME, $this->VALID_PHONE, $this->VALID_STATE, $this->VALID_ZIP);
		$organization->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoOrganization = Organization::getOrganizationByOrganizationLicense($this->getPDO(), $organization->getOrganizationLicense());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("organization"));
		$this->assertEquals($pdoOrganization->getOrganizationProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoOrganization->getOrganizationActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoOrganization->getOrganizationAddress1(), $this->VALID_ADDRESS1);
		$this->assertEquals($pdoOrganization->getOrganizationAddress2(), $this->VALID_ADDRESS2);
		$this->assertEquals($pdoOrganization->getOrganizationCity(), $this->VALID_CITY);
		$this->assertEquals($pdoOrganization->getOrganizationEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoOrganization->getOrganizationLicense(), $this->VALID_LICENSE);
		$this->assertEquals($pdoOrganization->getOrganizationName(), $this->VALID_NAME);
		$this->assertEquals($pdoOrganization->getOrganizationPhone(), $this->VALID_PHONE);
		$this->assertEquals($pdoOrganization->getOrganizationState(), $this->VALID_STATE);
		$this->assertEquals($pdoOrganization->getOrganizationZip(), $this->VALID_ZIP);
	}
	/**
	 * test grabbing an Organization by license that does not exist
	 **/
	public function testGetInvalidOrganizationByLicense() : void {
		// grab a license that does not exist
		$organization = Organization::getOrganizationByOrganizationLicense($this->getPDO(), "10941658");
		$this->assertNull($organization);
	}
	/**
	 * test grabbing an Organization by organization name
	 **/
	public function testGetValidOrganizationByOrganizationName() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("organization");

		// create a new Organization and insert to into mySQL
		$organization = new Organization(null, $this->profile->getProfileId(), $this->VALID_ACTIVATION, $this->VALID_ADDRESS1, $this->VALID_ADDRESS2, $this->VALID_CITY, $this->VALID_EMAIL, $this->VALID_LICENSE, $this->VALID_NAME, $this->VALID_PHONE, $this->VALID_STATE, $this->VALID_ZIP);
		$organization->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoOrganization = Organization::getOrganizationByOrganizationName($this->getPDO(), $organization->getOrganizationLicense());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("organization"));
		$this->assertEquals($pdoOrganization->getOrganizationProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoOrganization->getOrganizationActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoOrganization->getOrganizationAddress1(), $this->VALID_ADDRESS1);
		$this->assertEquals($pdoOrganization->getOrganizationAddress2(), $this->VALID_ADDRESS2);
		$this->assertEquals($pdoOrganization->getOrganizationCity(), $this->VALID_CITY);
		$this->assertEquals($pdoOrganization->getOrganizationEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoOrganization->getOrganizationLicense(), $this->VALID_LICENSE);
		$this->assertEquals($pdoOrganization->getOrganizationName(), $this->VALID_NAME);
		$this->assertEquals($pdoOrganization->getOrganizationPhone(), $this->VALID_PHONE);
		$this->assertEquals($pdoOrganization->getOrganizationState(), $this->VALID_STATE);
		$this->assertEquals($pdoOrganization->getOrganizationZip(), $this->VALID_ZIP);
	}
	/**
	 * test grabbing an Organization by name that does not exist
	 **/
	public function testGetInvalidOrganizationByName() : void {
		// grab a name that does not exist
		$organization = Organization::getOrganizationByOrganizationName($this->getPDO(), "Fake Pet Company");
		$this->assertNull($organization);
	}
	/** test grabbing a organization by its activation
	 */
	public function testGetValidOrganizationByActivationToken() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("organization");
		// create a new Organization and insert to into mySQL
		$organization = new Organization(null, $this->profile->getProfileId(), $this->VALID_ACTIVATION, $this->VALID_ADDRESS1, $this->VALID_ADDRESS2, $this->VALID_CITY, $this->VALID_EMAIL, $this->VALID_LICENSE, $this->VALID_NAME, $this->VALID_PHONE, $this->VALID_STATE, $this->VALID_ZIP);
		$organization->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoOrganization = Organization::getOrganizationByOrganizationActivationToken($this->getPDO(), $organization->getOrganizationActivationToken());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("organization"));
		$this->assertEquals($pdoOrganization->getOrganizationProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoOrganization->getOrganizationActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoOrganization->getOrganizationAddress1(), $this->VALID_ADDRESS1);
		$this->assertEquals($pdoOrganization->getOrganizationAddress2(), $this->VALID_ADDRESS2);
		$this->assertEquals($pdoOrganization->getOrganizationCity(), $this->VALID_CITY);
		$this->assertEquals($pdoOrganization->getOrganizationEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoOrganization->getOrganizationLicense(), $this->VALID_LICENSE);
		$this->assertEquals($pdoOrganization->getOrganizationName(), $this->VALID_NAME);
		$this->assertEquals($pdoOrganization->getOrganizationPhone(), $this->VALID_PHONE);
		$this->assertEquals($pdoOrganization->getOrganizationState(), $this->VALID_STATE);
		$this->assertEquals($pdoOrganization->getOrganizationZip(), $this->VALID_ZIP);
	}
	/**
	 * test grabbing an Organization by an activation that does not exist
	 **/
	public function testGetInvalidOrganizationActivation() : void {
		// grab an Activation Token that does not exist
		$organization = Organization::getOrganizationByOrganizationActivationToken($this->getPDO(), "5ebc7867885cb8dd25af05b991dd5609");
		$this->assertNull($organization);
	}
	/**
	 * test grabbing all Organizations
	 **/
	public function testGetAllValidOrganizations() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("organization");
		// create a new Organization and insert to into mySQL
		$organization = new Organization(null, $this->profile->getProfileId(), $this->VALID_ACTIVATION, $this->VALID_ADDRESS1, $this->VALID_ADDRESS2, $this->VALID_CITY, $this->VALID_EMAIL, $this->VALID_LICENSE, $this->VALID_NAME, $this->VALID_PHONE, $this->VALID_STATE, $this->VALID_ZIP);
		$organization->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = Organization::getAllOrganizations($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("organization"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DataDesign\\Organization", $results);
		// grab the result from the array and validate it
		$pdoOrganization = $results[0];
		$this->assertEquals($pdoOrganization->getOrganizationProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoOrganization->getOrganizationActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoOrganization->getOrganizationAddress1(), $this->VALID_ADDRESS1);
		$this->assertEquals($pdoOrganization->getOrganizationAddress2(), $this->VALID_ADDRESS2);
		$this->assertEquals($pdoOrganization->getOrganizationCity(), $this->VALID_CITY);
		$this->assertEquals($pdoOrganization->getOrganizationEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoOrganization->getOrganizationLicense(), $this->VALID_LICENSE);
		$this->assertEquals($pdoOrganization->getOrganizationName(), $this->VALID_NAME);
		$this->assertEquals($pdoOrganization->getOrganizationPhone(), $this->VALID_PHONE);
		$this->assertEquals($pdoOrganization->getOrganizationState(), $this->VALID_STATE);
		$this->assertEquals($pdoOrganization->getOrganizationZip(), $this->VALID_ZIP);
	}
}