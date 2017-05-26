<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\PetRescueAbq\ {
	Profile
};

/**
 * api for profile class
 *
 * @author Valente Meza <mharrison13@cnm.edu>
 */

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->status = null;

try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/PetRescueAbq.ini");
	//Mock a logged in user
	//$_SESSION["profile"] = Profile::getProfileByProfileId($pdo, 732);

	//determine which HTTP method was used
	$method = array_key_exists("http_X_HTTP_METHOD", $_SERVER ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["$_REQUEST_METHOD"];

	//sanitize input
	$id = filter_unput(INPUT_GET, "id", FILTER_VALIDATE_INT;
	$profileAtHandle = filter_input(INPUT_GET, "profileAtHandle", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileEmail = filter_input(INPUT_GET, "profileEmail", FILTER_VALIDATE_EMAIL);
	$profilePassword = filter_input(INPUT_GET), "profilePassword", FILTER_SANITIZE_STRINGFILTER_FLAG_NO_ENCODE_QUOTES);

// make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty(id) === true || $id <0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative, 405"));
	}

	// handle GET request - if id is present, that profile is returned, otherwise nothing is returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCoofie();

		//get a specific profile and update
		if(empty($id !== null)) {
			$reply->data = $id;
		}
	} else if(empty($id) === false) {
		$profile = Profile::getProfileByProfileId($pdo, $id)->toArray();
	} else if($method === "put") {

		//ensure that the user is signed in and only trying to edit their own profile
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $id) {
			throw(new \InvalidArgumentException("You are not allowed to access this profile", 403));
		}

		//decode response from front end
		$request_content = file_get_contents("php://input");
		$requestObject = json_decode($request_content);
	}

	if(empty($id) === false) {
			$profile - Profile::getProfileById($pdo, $id);
			if($profile !== null) {
				$reply->data = $profile;
			}
		} else if(empty($profileId) === false) {
			$profile = Profile::getProfileId($pdo, $id)->toArray();
			if($profile !== null) {
				$reply->data = $profile;
			}
		} else if(empty($profileEmail) === false) {
		$profile = Profile::getProfileByProfileEmail($pdo, $profileEmail)->toArray();
		if($profile !== null) {
			$reply->data = $profile;
		}
	}

}