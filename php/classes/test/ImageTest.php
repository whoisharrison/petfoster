<?php

namespace Edu\Cnm\PetRescueAbq\Test;

use Edu\Cnm\PetRescueAbq\ {
	 Profile, Organization, Post, Image
};


// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

/**
 * Full PHPUnit test for the Image class
 *
 * This is a complete PHPUnit test of the Image Class. It will be complete as all methods will be tested for valid and invalid inputs.
 *
 * @see Image
 * @author Amy Skidmore <askidmore1@cnm.edu>
 */

class ImageTest extends PetRescueAbqTest {

	/**
	 * Profile that created the Post which posted the image; this is for foreign key relations
	 * @var Profile $profile
	 */
	protected $profile;
	/**
	 * Organization that created the image post, this is for foreign key relations..don't understand, ask? org/ image not foreign key
	 * @var Organization $organization ;
	 */
	protected $organization;
	/**
	 * Post that created the Image; this is for foreign key relations
	 * @var Post $post
	 *
	 */
	protected $post = null;
	/**
	 * Account that uploaded and saved image
	 * @var
	 */
	 protected $VALID_CLOUD_ID = "1234567890123456789012345678";
	/**
	 * valid hash to use
	 * @var $VALID_HASH
	 *
	 */
	protected $VALID_HASH;
	/**
	 * valid salt to use to create the profile object to own the test
	 * @var string $VALID_SALT
	 */
	protected $VALID_SALT;

	/**
	 *
	 * /**
	 * set up create dependent objects before running each test
	 *
	 */
	public final function setUp(): void {
		//run the default setUp() method first
		parent::setUp();

		//create a salt and hash for the mocked profile
		$password = "abc123";
		$this->VALID_SALT = bin2hex(random_bytes(32));
		$this->VALID_HASH = hash_pbkdf2("sha512", $password, $this->VALID_SALT, 262144);
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));


		//create and insert the mocked profile
		$this->profile = new Profile(null, 34957803488540, "@handle:", "test@phpunit.de", $this->VALID_HASH,leighton, $this->VALID_SALT);
		$this->profile->insert($this->getPDO());

//create and insert the mock Organization
		$this->organization = new Organization(null, $this->profile->getProfileId(), "31482093iok", "540 Wildcat lane", "112 Wildcat Rd", "Lexington", "wildcatsrule@php.com", "12489ky", "Kentucky Pet Help", "3345952089", "KY", "40801");
		$this->organization->insert($this->getPDO());

		//create and insert the mock Post
		$this->post = new Post(null, $this->organization->getOrganizationId(), "Yorkshire", "tricolor", "male", "lalk");
		$this->post->insert($this->getPDO());

	}

	/**
	 * test that inserts a valid image and verifies that the actual mySQL data matches
	 **/
	public function testInsertValidImage(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("image");

		// create a new Image and insert into mySQL

		$image = new Image(null, $this->post->getPostId(), $this->VALID_CLOUD_ID);
		$image->insert($this->getPDO());

		// GET THE DATA from msql and ensure they match
		$pdoImage = Image::getImageByImageId($this->getPDO(), $image->getImageId());
		$this->assertsEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$this->assertEquals($pdoImage->getImageId(), $this->post->getPostId());
		$this->assertEquals($pdoImage->getImageId(), $this->VALID_CLOUD_ID);


	}

	/** test inserting a invalid image
	 * @expectedException \PDOException
	 */
	public function testInsertInvalidImage() {
//create a Image with a nono mull image id
		$image = new Image(PetRescueAbqTest::INVALID_KEY, null, null);
		$image->insert($this->getPDO());

	}

//test to create then delete an image
	public function TestDeleteValidImage() {
//Count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("image");

//create a new image and insert into msql
		$image = new Image(null, $this->post->getPostId(), $this->VALID_CLOUD_ID);
		$image->insert($this->getPDO());

		//delete image
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$image->delete($this->getPDO());

	}

	/**
	 * //delete an image that doesn't exit
	 *
	 * @expectedException |PDOException
	 **/
	public function testDeleteIvalidImange() {
		// create a Image and try to delete it without actually inserting it
		$image = new Image(null, $this->post->getPostId(), $this->VALID_CLOUD_ID);
		$image->delete($this->getPDO());
	}


	/**
	 * Test to get image by Image id
	 *
	**/
	public function testGetValidImageByImageId() {

		//count the number of rows and save for later
		$numRow = $this->getConnection()->getRowCount("image");

		//create a new image and insert
		$image = new Image(null, $this->profile->getProfileId(), $this->post->getPostId(), $this->VALID_CLOUD_ID());
		$image->insert($this->getPDO());

		//grab the data and enforce the match
		$pdoImage = Image::getImageByImageId($this->getPDO(), $image->getImageId());
		$this->assertEquals($numRow + 1, $this->getConnection()->getRowCount("image"));
		$this->assertEquals($pdoImage->getImagePostId(), $this->post->getPostId());
		$this->assertEquals($pdoImage->getImageCloudinaryId(), $this->VALID_CLOUD_ID);

	}

	/**
	 * get invalid image by imageid
	 * @expectedException \PDOException
	 */
	public function testGetInvalidImageByImageId() {

		//grab a image id that exceeds the maximum allowable profile id
		$image = Image::getImageByImageId($this->getPDO(), PetRescueAbqTest::INVALID_KEY);
		$this->assertNull($image);
	}
	/**
	 * Test to get image by Image post id
	 *
	 */
	public function testGetValidImageByImagePostId() : void {

		//count the number of rows and save for later
		$numRow = $this->getConnection()->getRowCount("image");

		//create a new image and insert
		$image = new Image(null, $this->profile->getProfileId(),$this->post->getPostId(), $this->VALID_CLOUD_ID());
		$image->insert($this->getPDO());

		//grab the data and enforce the match
		$pdoImage = Image::getImageByImagePostId($this->getPDO(), $image->getImagePostId());
		$this->assertEquals($numRow + 1, $this->getConnection()->getRowCount("image"));
		$this->assertEquals($pdoImage->getImageId(), $this->ImageId());
		$this->assertEquals($pdoImage->getImagePostId(), $this->post->getPostId());
		$this->assertEquals($pdoImage->getImageCloudinaryId(), $this->VALID_CLOUD_ID);


	}
	/**
	 * get invalid image by image post id
	 * @expectedException \PDOException
	 */
	public function testGetInvalidImageByImagePostId() {
//grab a image by image post id that doesn't exist
		$image = Image::getImageByImagePostId($this->getPDO(),$this->profile->getProfileId(), PetRescueAbqTest::INVALID_KEY);
		$this->assertCount(0, $image);


	}
	/**
	 * get image by image cloudinary id
	 *
	 */

	public function testGetValidImageByImageCloudinaryId() {

		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("image");

		// create a new image and insert to into mySQL
		$image = new Image(null, $this->post->getPostId(), $this->VALID_CLOUD_ID);
		$image->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations

		$pdoImage = Image::getImageByImageCloudinaryId(($this->getPDO()),$this->profile->getProfileId(), $image->getImageCloudinaryId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$this->assertEquals($pdoImage->getImagePostId(), $this->post->getPostId());
		$this->assertEquals($pdoImage->getImageCloudinaryId(), $this->VALID_CLOUD_ID);

	}

	/**
	 * grabbing a image by imagecloudinaryid that doesn't exist
	 * @expectedException
	 *
	 */
	public function testGetInvalidImageByImageCloudinaryId() {
//grab a image by id that doesn't exits
		$image = Image::getImageByImageCloudinaryId($this->getPDO(), $this->VALID_CLOUD_ID);
		$this->assertCount(0, $image);
	}


	/**
	 * test to grab all Images
	 * new image template per george's instructions:
	 *
	 */
	public function testGetAllValidImages() {
//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("image");
		// create an new image and insert
		$image = new Image(null, $this->profile->getProfileId(),$this->post->getPostId(), $this->VALID_CLOUD_ID);
		$image->insert($this->getPDO());

		//grab the data and enforce the fields match

		$results = Image::getAllImages($this->getPDO());
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\PetFosterAbq\\Image", $results);

		//grab the result from array and validate
		$pdoImage = $results[0];
		$this->assertEquals($pdoImage->getImagePostId(), $image->getImagePostId());
		$this->assertEquals($pdoImage->getImageCloudinaryId(), $this->VALID_CLOUD_ID);
	}

}


