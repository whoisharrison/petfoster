<?php
namespace Edu\Cnm\PetRescueAbq\Test;

use Edu\Cnm\Petfoster\Test\PetRescueAbqTest;
use Edu\Cnm\PetRescueAbq\{Profile, Organization, Message, Post};

//grab the class under scrutiny
require_once (dirname(__DIR__) . "/autoload.php");

/** Full PHPUnit test for the Post Class
 *
 *This is a complete PHPUnit test of the Post class. It is complete because *ALL* my SQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Post
 * @author Jabari Farrar <tmafm1@gmail.com>
 *
 **/
class PostTest extends PetRescueAbqTest {
	/**
	 * Profile that created the Organization; this is the foreign key relations
	 * @var $Profile
	 */
	protected $profile = null;

	/**
	 *Organization that created the Post; this is the foreign key relations
	 * @var $Organization
	 **/
	protected $organization = null;

	/**
	 * valid profile hash to create the profile object to own the test
	 * @var $VALID_HASH;
	 **/
	protected $VALID_HASH;

	/**
	 * valid salt to use to create the profile object to own the test
	 * @var string $VALID__SALT
	 */
	protected $VALID_SALT;

	/**
	 * valid postOrganizationId to use to create the Post
	 * @var int $VALID_POSTORGANIZATIONID
	 **/
	protected $VALID_POSTORGANIZATIONID;

	/**
	 * valid postBreed to use to create the Post
	 * @var string $VALID_POSTBREED
	 */
	protected $VALID_POSTBREED;

	/**
	 * valid postSex to use toe create the Post
	 * @var string $VALID_ POSTSEX
	 */
	protected $VALID_POSTSEX;

	/**
	 * valid postType to use to created the Post
	 * @var string $VALID_POSTTYPE
	 */
	protected $VALID_POSTTYPE;

	/**
	 * create dependent objects before running each test
	 */
	public final function setUp()  : void {
		parent::setUp();
		$password = "abc123";
		$profileActivationToken = "22222222222222222222222222222222";
		$this->VALID_SALT = bin2hex(random_bytes(64));
		$this->VALID_HASH = hash_pbkdf2("sha128", $password, $this->VALID_SALT, 262144);

		/**
		 * created and insert a Profile to own the test Organization
		 */

		$this->profile = new Profile(null,$profileActivationToken,"JamMasterJ", "tmafm1@gmail.com",$this->VALID_HASH,"Jabari",$this->VALID_SALT);
		$this->profile->insert($this->getPDO());

	}




}



