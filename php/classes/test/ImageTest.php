<?php
namespace Edu\Cnm\PetRescueAbq\Test;

use Edu\Cnm\PetRescueAbq\{
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
	 * Organization that created the image post, this is for foreign key reltions..don't understand, ask? org/ image not foreign key
	 * @var Organization $organization;
	 */
	 protected $organization;
	 /**
	 * Post that created the Image; this is for foreign key relations
	 * @var Post $post
	 *
	 */
	protected $post = null;
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

	/**
	 * set up create dependent objects before running each test
	 *
	 */
public final function setUp() : void {
	//run the default setUp() method first
	parent::getSetUpOperation();

	//create a salt and hash for the mocked profile
	$password = "abc123";
	$this->VALID_PROFILE_SALT = bin2hex(random_bytes(32));
	$this->VALID_HASH = hash_pbkdf2("sha512", $password, $this->VALID_SALT, 262144);
	$this->VALID_ACTIVATION = bin2hex(random_bytes(16));

	//create and insert the mocked profile
	$this->profile = new Profile(null, null, "@handle:", "test@phpunit.de", $this->VALID_PROFILE_HASH, "+3345952089",$this->VALID_SALT);
	$this->profile->insert($this->getPDO());

//create and insert the mock Organization
	$this->organization = new Organization(null, null, null, null, null, null, null, null, null, null, $this->profile->getProfileId(),"PhPUnit image test passing");
	$this->organization->insert($this->getPDO());

	//create and insert the mock Post
	$this->post = new Post(null, null, null, null, null, $this->profile->getProfileId(), "PHPUnit image test passing");
	$this->post->insert($this->getPDO());


	//calculate the date (just use the time the unit test ws setup)
	$this->VALID_IMAGEDATE = new\DateTime();
	}

	/**
	 * test that inserts a valid image and verifies that the actual mySQL data matches
	 **/
	public function testInsertValidImage() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("image");

		// create a new Image and insert into mySQL
		$image = new  Image($this->profile->getProfileId(), $this->organization->getOrganizationId(), $this->post->getPostId(),)
	}















}

