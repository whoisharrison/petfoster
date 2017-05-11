<?php
namespace Edu\Cnm\PetRescueAbq\Test;

use Edu\Cnm\Petfoster\Test\PetRescueAbqTest;
use Edu\Cnm\PetRescueAbq\{
	Post, Profile, Image
};



// grab the class under scrutiny
require_once(dirname(_DIR_) . "/autoload.php");

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
	 * Post that created the Image; this is for foreign key relations
	 * @var Post $post
	 *
	 */
	protected $post = null;
	/**
	 * Profile that created the Post which posted the image; this is for foreign key relations
	 * @var Profile $profile
	 */
	protected $profile;
	/**
	 * valid has to use
	 * @var VALID_HASH

	 * valid salt to use to create the profile object to own the test
	 * @var string $VALID_SALT
	 */
	protected $VALID_SALT

	/**
	 * create dependent objects before running each test
	 *
	 */
public final function setUp() : void {
	//run the default setUp() method first
	parent::setUp();

	//create a salt and hash for the mocked profile
	$password = "abc123";
	$this->VALID_SALT = binhex(random_bytes(32));
	$this->VALID_HASH = hash_pbkdf2("sha512, $password, $this->VALID_SALT,262144");
	$this->VALID_ACTIVATION = bin2hex(random_bytes(16));

	//create and insert the mocked profile
	$this->profile = new Profile(null,)
}












}

