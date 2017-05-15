<?php
namespace Edu\Cnm\PetRescueAbq\Test;

use Edu\Cnm\PetRescueAbq\{
	Message, Profile, Organization, Post, Image
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
	protected $imagecloudinaryid;
	/**
	 * valid hash to use
	 * @var $VALID_HASH
	 *
	 */
	protected $VALID_PROFILE_HASH;
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
		parent::getSetUpOperation();

		//create a salt and hash for the mocked profile
		$password = "abc123";
		$this->VALID_PROFILE_SALT = bin2hex(random_bytes(32));
		$this->VALID_HASH = hash_pbkdf2("sha512", $password, $this->VALID_SALT, 262144);
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));

		//create and insert the mocked profile
		$this->profile = new Profile(null, null, "@handle:", "test@phpunit.de", $this->VALID_PROFILE_HASH, "leighton myers", $this->VALID_SALT, "4792873", $this->VALID_SALT);
		$this->profile->insert($this->getPDO());

//create and insert the mock Organization
		$this->organization = new Organization(null, 31243243, "31482093iok", "540 Wildcat lane", "112 Wildcat Rd", "Lexington", "wildcatsrule@php.com", "12489ky", "Kentucky Pet Help", "3345952089", "KY", "40801");
		$this->organization->insert($this->getPDO());

		//create and insert the mock Post
		$this->post = new Post(null, null, "Yorkshire", "black and white", "male", "lalk");
		$this->post->insert($this->getPDO());

		//create and insert a cloudinary acct
		$this->imageCloudinaryId = new ImageCloudinaryId(null);
		$this->imageCloudinaryId->insert($this->getPDO());


		//calculate the date (just use the time the unit test was setup)
		$this->VALID_IMAGEDATE = new\DateTime();

		//format the sunrise date to use for testing
		$this->VALID_SUNRISEDATE = new\DateTime();
		$this->VALID_SUNRISEDATE->sub(new \DateInterval("P10D"));

		//format the sunset date to use for testing
		$this->VALID_SUNSETDATE = new\DateTime();
		$this->VALID_SUNSETDATE->add(new \DateInterval("P10D"));
	}

	/**
	 * test that inserts a valid image and verifies that the actual mySQL data matches
	 **/
	public function testInsertValidImage(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("image");

		// create a new Image and insert into mySQL

		$image = new Image(null, $this->profile->getProfileId(), $this->organization->getOrganizationId(), $this->post->getPostId(), $this->VALID_IMAGEID, $this->VALID_IMAGEPOSTID, $this->VALID_IMAGECLOUDINARYID);
		$image->insert($this->getPDO());

		// GET THE DATA from msql and ensure they match
		$pdoImage = Image::getImageByImageIdAndImagePostId($this->getPDO(), $image->getImageId(), $image->getImagePostId());
		$this->assertsEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$this->assertEquals($pdoImage->getImageId(), $this->post->getPostId());
		$this->assertEquals($pdoImage->getImageId(), $this->profile->getProfileId());
		$this->assertEquals($pdoImage->getImageId(), $this->organization->getOrganizationId());
		$pdoImage = Image::getImageByImageCloudinaryId($this->getPDO(), "amy skdfj");

	}

	/** test inserting a invalid image
	 * @expectedException \PDOException
	 */
	public function testInsertInvalidImage() {
//create a Image with a nono mull image id
		$image = new Image(PetRescueAbqTest::INVALID_KEY, null, null, null, null);
		$image->insert($this->getPDO());
	}


	/** test to insert and update image
	 *
	 */
	public function testUpdateValidImage(): void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("image");


		//create a image an insert into mysql
		$image = new Image(null, "49583", "amy skid");
		$image->insert($this->getPDO());

//edit the image
		$image->setImageId($this->VALID_IMAGEID2);
		$image->update($this->getPDO());

//grab data and enforce the match
		$pdoImage = Image::getImageByImageIdAndImagePostId($this->getPDO(), $image->getImageId(), $image->getImagePostId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$this->assertEqual($pdoImage->getImagePostId(), $this->post->getPostId());
		$this->assertEqual($pdoImage->getImageCloudinaryId(), $this->VALID_IMAGEID2);
	}
	/**
	 * // test to update an invalid image
	 * @expectedException \PDOException
	 */
public function testUpdateInvalidImage (){
// create a image with a non null image id and watch it fail
	$image = new Image(null, $this->post->getPostId(), $this->VALID_IMAGECLOUDINARYID);
	$image->update($this->getPDO());

}

//test to create then delete an image
	public function TestDeleteValidImage() {
//Count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("image");

//create a new image and insert into msql
		$image = new Image(null, $this->post->getPostId(), $this->VALID_IMAGECLOUDINARYID);
		$image->insert($this->getPDO());

		//delete image
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$image->delete($this->getPDO());

	}

/**
//delete an image that doesn't exit

@expectedException |PDOException
**/
public function testDeleteIvalidImange (){
	// create a Image and try to delete it without actually inserting it
	$image = new Image(null, $this->post->getPostId(), $this->VALID_ImageCloudinaryId);
	$image->delete($this->getPDO());
}

/**
 * Test to get image by Image post id
 *
 */
public function testGetValidImageByImageId()
{
//count the number of rows and save for later
	$numRow = $this->getConnection()->getRowCount("image");
	//create a new image and insert
	$image = new Image(null, $this->profile->getProfileId(), $this->post->getPostId(), $this->organization->getOrganizationId());
	$image->insert($this->getPDO());

	//grab the data and enforce the match
	$results = Image::getImageByImageId($this->getPDO(), $image->getImageId());
	$this->assertEquals($numRow + 1, $this->getConnection()->getRowCount("image"));
	$this->assertCount(1, $results);

	//enforce that no other objects are bleeding into the test
	$this->assertContainsOnlyInstancesOf("Edu//Cnm//PetRescueAbq", $results);

	//grab the result from the array and validate it
	$pdoImage = $results[0];
	$this->assertEquals($pdoImage->getProfileId(), $this->profile->getProfileId());
	$this->assertEquals($pdoImage->getImageId(), $this->VALID_IMAGEID);

}


/**
 * get invalid image by imageid
 * @expectedException \PDOException
 */
public function testGetInvalidImageByImageIdAndImagePostId(){
//grab a image by image that doesn't exist
	$image = Image::getImageByImageIdAndImagePostId($this->getPDO(), "", "");


}
/**
 * get image by image cloudinary id
 *
 */

	public function testGetValidImageByImageCloudinaryId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("image");
		// create a new image and insert to into mySQL
		$image = new Image($this->image->getImageCloudinaryId(),$this->profile->getProfileId(), $this->organization->getOrganizationId(),$this->post->getPostId(), $this->image->imagecloudinaryid);
		$image->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations

$results = Image::getImageByImageCloudinaryId(($this->getPDO()), $image->getImageCloudinaryId());
$this->assertEquals($numRows = 1, $this->getConnection()("image"));
$this->assertCount(1, $results);

//enforce no other objects are bleeding into the test
$this->assertContainsOnlyInstancesO("Edu\\Cnm\PetFosterAbq\Image", $results);

//grab the result from the array and validate
$pdoImage = $results [0];
$this->assertEquals($pdoImage->getImageId(), $this->profile->getProfileId());
$this->assertEquals($pdoImage->getImageCloudinaryId(), $this->VALID_IMAGECLOUDINARYID);

	}

/**
 * grabbing a image by imagecloudinaryid that doesn't exist
 * @expectedException
 *
 */
public function testGetInvalidImageByImageCloudinaryId(){
//grab a image by id that doesn't exits
	$image = Image::getImageByImageCloudinaryId($this->getPDO(), "           ??");
	$this->assertCount(0, $image);
}


/**
 * test to grab all Images
 */
public function testGetAllValidImages(){
//count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("image");
	// create an new image and insert
	$image = new Image(null, $this->profile->getProfileId(),$this->post->getPostId(), $this->organization->getOrganizationId());
	$image->insert($this->getPDO());

	//grab the data and enforce the fields match

	$results = Image::getAllImages(($this->getPDO()));
	$this->assertCount(1, $results);
	$this->assertContainsOnlyInstancesOf("Edu\\Cnm\PetFosterAbq\Image", $results);

	//grab the result from array and validate
	$pdoImage = $results[0];
	$this->assertEquals($pdoImage->getImageId(), $this->profile->getProfileId());
	$this->assertEquals($$pdoImage->getImage(), $this->VALID_IMAGEID);
}

}


