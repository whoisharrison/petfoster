<?php
namespace Edu\Cnm\DataDesign\Test;
use Edu\Cnm\Petfoster\Test\PetRescueAbqTest;
use Edu\Cnm\PetRescueAbq\{Profile, Organization};
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
	protected $VALID_EMAIL2 = "testtest@cnm.edu;"
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
		$this->VALID_PROFILE_SALT = bin2hex(random_bytes(32));
		$this->VALID_PROFILE_HASH = hash_pbkdf2("sha512", $password, $this->VALID_PROFILE_SALT, 262144);
		// create and insert a Profile to own the test Organization
		$this->profile = new Profile(null, null,"@testOrgHandle", "tester@phpunit.com",$this->VALID_PROFILE_HASH, "Don One", $this->VALID_PROFILE_SALT);
		$this->profile->insert($this->getPDO());
	}
	/**
	 * test inserting a valid Organization and verify that the actual mySQL data matches
	 **/
	public function testInsertValidOrganization() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("organization");
		// create a new Organization and insert to into mySQL
		$organization = new Organization(null, null, $this->VALID_ADDRESS1, $this->VALID_ADDRESS2, $this->VALID_CITY, $this->VALID_EMAIL, $this->VALID_LICENSE, $this->VALID_NAME, $this->VALID_PHONE, $this->VALID_STATE, $this->VALID_ZIP);
		//var_dump($organization);
		$organization->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoOrganization = Organization::getOrganizationByOrganizationId($this->getPDO(), $organization->getOrganizationId());
		$this->assertEquals($pdoOrganization->getOrganizationProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoOrganization->getOrganizationAddress1(), $this->VALID_ORGANIZATIONADDRESS1);
		$this->assertEquals($pdoOrganization->getOrganizationAddress2(), $this->VALID_ORGANIZATIONADDRESS2);
		$this->assertEquals($pdoOrganization->getOrganizationCity(), $this->VALID_ORGANIZATIONCITY);
		$this->assertEquals($pdoOrganization->getOrganizationEmail(), $this->VALID_ORGANIZATIONEMAIL);
	}

	/**
	 * test inserting an Organization that already exists
	 *
	 * @expectedException \PDOException
	 **/
	public function testInsertInvalidOrganization() : void {
		// create an Organization with a non null organization id and watch it fail
			$organization = new Organization(PetRescueAbqTest::INVALID_KEY, $this->VALID_ACTIVATION, $this->VALID_ADDRESS1, $this->VALID_ADDRESS2, $this->VALID_CITY, $this->VALID_EMAIL, $this->VALID_LICENSE, $this->VALID_NAME, $this->VALID_PHONE, $this->VALID_STATE, $this->VALID_ZIP);
			$organization->insert($this->getPDO());
	}
	/**
	 * test inserting an Organization, editing it, and then updating it
	 **/
	public function testUpdateValidOrganization() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("organization");
		// create a new Organization and insert it into mySQL
		$organization = new Organization(null, $this->VALID_ACTIVATION, $this->VALID_ADDRESS1, $this->VALID_ADDRESS2, $this->VALID_CITY, $this->VALID_EMAIL, $this->VALID_LICENSE, $this->VALID_NAME, $this->VALID_PHONE, $this->VALID_STATE, $this->VALID_ZIP);
		// edit the Organization and update it in mySQL
		$organization->setOrganizationEmail($this->VALID_EMAIL2);
		$organization->update($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoOrganization = Organization::getOrganizationByOrganizationId($this->getPDO(), $organization->getOrganizationId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("organization"));

		// stop - return to work here

		$this->assertEquals($pdoOrganization->getOrganizationProfileId(), $this->profile->getOrganizationId());
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoTweet->getTweetContent(), $this->VALID_TWEETCONTENT2);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);




		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoTweet->getTweetDate()->getTimestamp(), $this->VALID_TWEETDATE->getTimestamp());
	}
	/**
	 * test updating a Tweet that does not exist
	 *
	 * @expectedException \PDOException
	 **/
	public function testUpdateInvalidTweet() : void {
		// create a Tweet with a non null tweet id and watch it fail
		$tweet = new Tweet(null, $this->profile->getProfileId(), $this->VALID_TWEETCONTENT, $this->VALID_TWEETDATE);
		$tweet->update($this->getPDO());
	}
	/**
	 * test creating a Tweet and then deleting it
	 **/
	public function testDeleteValidTweet() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tweet");
		// create a new Tweet and insert to into mySQL
		$tweet = new Tweet(null, $this->profile->getProfileId(), $this->VALID_TWEETCONTENT, $this->VALID_TWEETDATE);
		$tweet->insert($this->getPDO());
		// delete the Tweet from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tweet"));
		$tweet->delete($this->getPDO());
		// grab the data from mySQL and enforce the Tweet does not exist
		$pdoTweet = Tweet::getTweetByTweetId($this->getPDO(), $tweet->getTweetId());
		$this->assertNull($pdoTweet);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("tweet"));
	}
	/**
	 * test deleting a Tweet that does not exist
	 *
	 * @expectedException \PDOException
	 **/
	public function testDeleteInvalidTweet() : void {
		// create a Tweet and try to delete it without actually inserting it
		$tweet = new Tweet(null, $this->profile->getProfileId(), $this->VALID_TWEETCONTENT, $this->VALID_TWEETDATE);
		$tweet->delete($this->getPDO());
	}
	/**
	 * test grabbing a Tweet that does not exist
	 **/
	public function testGetInvalidTweetByTweetId() : void {
		// grab a profile id that exceeds the maximum allowable profile id
		$tweet = Tweet::getTweetByTweetId($this->getPDO(), DataDesignTest::INVALID_KEY);
		$this->assertNull($tweet);
	}
	/**
	 * test inserting a Tweet and regrabbing it from mySQL
	 **/
	public function testGetValidTweetByTweetProfileId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tweet");
		// create a new Tweet and insert to into mySQL
		$tweet = new Tweet(null, $this->profile->getProfileId(), $this->VALID_TWEETCONTENT, $this->VALID_TWEETDATE);
		$tweet->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = Tweet::getTweetByTweetProfileId($this->getPDO(), $tweet->getTweetProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tweet"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DataDesign\\Tweet", $results);
		// grab the result from the array and validate it
		$pdoTweet = $results[0];
		$this->assertEquals($pdoTweet->getTweetProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoTweet->getTweetContent(), $this->VALID_TWEETCONTENT);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoTweet->getTweetDate()->getTimestamp(), $this->VALID_TWEETDATE->getTimestamp());
	}
	/**
	 * test grabbing a Tweet that does not exist
	 **/
	public function testGetInvalidTweetByTweetProfileId() : void {
		// grab a profile id that exceeds the maximum allowable profile id
		$tweet = Tweet::getTweetByTweetProfileId($this->getPDO(), DataDesignTest::INVALID_KEY);
		$this->assertCount(0, $tweet);
	}
	/**
	 * test grabbing a Tweet by tweet content
	 **/
	public function testGetValidTweetByTweetContent() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tweet");
		// create a new Tweet and insert to into mySQL
		$tweet = new Tweet(null, $this->profile->getProfileId(), $this->VALID_TWEETCONTENT, $this->VALID_TWEETDATE);
		$tweet->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = Tweet::getTweetByTweetContent($this->getPDO(), $tweet->getTweetContent());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tweet"));
		$this->assertCount(1, $results);
		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DataDesign\\Tweet", $results);
		// grab the result from the array and validate it
		$pdoTweet = $results[0];
		$this->assertEquals($pdoTweet->getTweetProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoTweet->getTweetContent(), $this->VALID_TWEETCONTENT);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoTweet->getTweetDate()->getTimestamp(), $this->VALID_TWEETDATE->getTimestamp());
	}
	/**
	 * test grabbing a Tweet by content that does not exist
	 **/
	public function testGetInvalidTweetByTweetContent() : void {
		// grab a tweet by content that does not exist
		$tweet = Tweet::getTweetByTweetContent($this->getPDO(), "Comcast has the best service EVER #comcastLove");
		$this->assertCount(0, $tweet);
	}
	/**
	 * test grabbing a valid Tweet by sunset and sunrise date
	 *
	 */
	public function testGetValidTweetBySunDate() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tweet");
		//create a new Tweet and insert it into the database
		$tweet = new Tweet(null, $this->profile->getProfileId(), $this->VALID_TWEETCONTENT, $this->VALID_TWEETDATE);
		$tweet->insert($this->getPDO());
		// grab the tweet from the database and see if it matches expectations
		$results = Tweet::getTweetByTweetDate($this->getPDO(), $this->VALID_SUNRISEDATE, $this->VALID_SUNSETDATE);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tweet"));
		$this->assertCount(1,$results);
		//enforce that no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DataDesign\\Tweet", $results);
		//use the first result to make sure that the inserted tweet meets expectations
		$pdoTweet = $results[0];
		$this->assertEquals($pdoTweet->getTweetId(), $tweet->getTweetId());
		$this->assertEquals($pdoTweet->getTweetProfileId(), $tweet->getTweetProfileId());
		$this->assertEquals($pdoTweet->getTweetContent(), $tweet->getTweetContent());
		$this->assertEquals($pdoTweet->getTweetDate()->getTimestamp(), $this->VALID_TWEETDATE->getTimestamp());
	}
	/**
	 * test grabbing all Tweets
	 **/
	public function testGetAllValidTweets() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tweet");
		// create a new Tweet and insert to into mySQL
		$tweet = new Tweet(null, $this->profile->getProfileId(), $this->VALID_TWEETCONTENT, $this->VALID_TWEETDATE);
		$tweet->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = Tweet::getAllTweets($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tweet"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DataDesign\\Tweet", $results);
		// grab the result from the array and validate it
		$pdoTweet = $results[0];
		$this->assertEquals($pdoTweet->getTweetProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoTweet->getTweetContent(), $this->VALID_TWEETCONTENT);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoTweet->getTweetDate()->getTimestamp(), $this->VALID_TWEETDATE->getTimestamp());
	}
}