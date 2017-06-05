<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\PetRescueAbq\ {
	Profile
};

/**
 * api for profile class
 *
 * @author michael harrison <mharrison13@cnm.edu>
 */

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/fosterabq.ini");
	//Mock a logged in user
	$_SESSION["profile"] = Profile::getProfileByProfileId($pdo, 3);

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$profileAtHandle = filter_input(INPUT_GET, "profileAtHandle", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileEmail = filter_input(INPUT_GET, "profileEmail", FILTER_VALIDATE_EMAIL);
	$profilePassword = filter_input(INPUT_GET, "profilePassword", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

// make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative, 405"));
	}

	// handle GET request - if id is present, that profile is returned, otherwise nothing is returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific profile and update
		if(empty($id !== null)) {
			$reply->data = $id;
		} else if(empty($id) === false) {
			$profile = Profile::getProfileByProfileId($pdo, $id);
		}
	} else if($method === "PUT") {

		//ensure that the user is signed in and only trying to edit their own profile
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $id) {
			throw(new \InvalidArgumentException("You are not allowed to access this profile", 403));
		}

		//decode response from front end
		$request_content = file_get_contents("php://input");
		$requestObject = json_decode($request_content);

		//retrieve the profile to be updated
		$profile = Profile::getProfileByProfileId($pdo, $id);
		if($profile === null) {
			throw(new RuntimeException("Profile does not exist", 404));
		}
		if(empty($requestObject->profilePassword) === true) {
			//enforce that the XSRF token is present in the header
			verifyXsrf();
			//profile at handle
			if(empty($requestObject->profileAtHandle) === true) {
				throw(new \InvalidArgumentException ("No profile at handle", 405));
			}
			//profile email
			if(empty($requestObject->profileEmail) === true) {
				throw(new \InvalidArgumentException ("No profile email present", 405));
			}
			//profile name
			if(empty($requestObject->profileName) === true) {
				$requestObject->profileName = $profile->getProfileName();
			}
			$profile->setProfileAtHandle($requestObject->profileAtHandle);
			$profile->setProfileEmail($requestObject->profileEmail);
			$profile->setProfileName($requestObject->profileName);
			$profile->update($pdo);
			// update reply
			$reply->message = "Profile information updated";
		}



		/**
		 * update the password if requested
		 **/

		//enforce that current password new password and confirm password is present
		if(empty($requestObject->profilePassword) === false && empty($requestObject->profileConfirmPassword) === false && empty($requestContent->ConfirmPassword) === false) {
			//make sure the new password and confirm password exist
			if($requestObject->newProfilePassword !== $requestObject->profileConfirmPassword) {
				throw(new RuntimeException("New passwords do not match", 401));
			}
			//hash the previous password
			$currentPasswordHash = hash_pbkdf2("sha512", $requestObject->currentProfilePassword, $profile->getProfileSalt(), 262144);
			//make sure the hash given by the end user matches what is in the database
			if($currentPasswordHash !== $profile->getProfileHash()) {
				throw(new \RuntimeException("Previous password is incorrect", 401));
			}
			// salt and hash the new password and update the profile object
			$newPasswordSalt = bin2hex(random_bytes(16));
			$newPasswordHash = hash_pbkdf2("sha512", $requestObject->newProfilePassword, $newPasswordSalt, 262144);
			$profile->setProfileHash($newPasswordHash);
			$profile->setProfileSalt($newPasswordSalt);
		}
		//preform the actual update to the database and update message
		$profile->update($pdo);
		$reply->message = "profile successfully updated";

	} else {
		throw (new InvalidArgumentException("Invalid HTTP request", 400));
	}
	// catch any exceptions that were thrown and update the status and message state variable fields
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

// encode and return reply to front end caller
echo json_encode($reply);

