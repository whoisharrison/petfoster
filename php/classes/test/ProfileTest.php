<?php
/**
 * User: @mharrison13
 * Date: 5/5/17
 * Time: 10:25 PM
 **/
namespace PetRescueAbq\http\Petfoster\Profile;

require_once(dirname(__DIR__) . "/autoload.php");

/**
 * Full PHPUnit Test for Profile class
 *
 * This is the complete PHPUnit test of the Profile class. mySQL/PDO enabled methods will be tested for both valid and invalid inputs.
 *
 * @see profile
 * @auther Michael Harrison <mharrison13@cnm.edu>
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
	protected $VALID_ATHANDLE = "@passingtest";

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
	 */
	protected $VALID_SALT;


}


