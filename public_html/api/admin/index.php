<?php
/**
 * Created by Jeffrey Cooper.
 */
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/~jcooper37/public_html/petadopt/encrypted-config.php");

use Edu\Cnm\PetRescueAbq\ {
	Organization,
	// testing with
	Profile
};


/**
 * api for the Admin panel
 *
 * @author Jeffrey Cooper <jcooper37@cnm.edu>
 **/

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//establish mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/~jcooper37/public_html/petadopt/pet-rescue-abq.ini");

	// mock a session and assign a specific user to it.
	// only for testing purposes - not in the live code.
	//$_SESSION["profile"] = Profile::getProfileByProfileId($pdo, 257);

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
}
