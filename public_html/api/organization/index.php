<?php
/**
 * Created by Jeffrey Cooper.
 */
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/~jcooper37/public_html/petadopt/encrypted-config.php");

use Edu\Cnm\PetFosterAbq\{
	Organization,
	// testing with
	Profile
};


/**
 * api for the Organization class
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

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$organizationProfileId = filter_input(INPUT_GET, "organizationProfileId", FILTER_VALIDATE_INT);
	$organizationAddress1 = filter_input(INPUT_GET, "organizationAddress1", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$organizationAddress2 = filter_input(INPUT_GET, "organizationAddress2", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$organizationCity = filter_input(INPUT_GET, "organizationCity", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$organizationEmail = filter_input(INPUT_GET, "organizationEmail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);



	//make sure the id is valid for methods that require it
	if(($method === "GET" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}


	// handle GET request - if id is present, that profile is returned, otherwise nothing is returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific profile and update reply
		if(empty($id) === false) {
			$profile = Profile::getProfileByProfileId($pdo, $id);
			if($profile !== null) {
				$reply->data = $profile;
			}
		} else if(empty($profileEmail) === false) {
			$profiles = Profile::getProfileByProfileEmail($pdo, $profileEmail)->toArray();
			if($profiles !== null) {
				$reply->data = $profiles;
			}
		}
	} else if($method === "PUT" || $method === "POST") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		// Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
		$requestObject = json_decode($requestContent);
		// This Line Then decodes the JSON package and stores that result in $requestObject

		//make sure profile email is available (required field)
		if(empty($requestObject->profileEmail) === true) {
			throw(new \InvalidArgumentException ("No content for Email.", 405));
		}


		//  !!!!make sure profileId is not null
		if(empty($requestObject->ProfileId) === true) {
			throw(new \InvalidArgumentException ("No Profile ID.", 405));
		}

		//perform the actual put or post
		if($method === "PUT") {

			//enforce that the end user has a XSRF token.
			verifyXsrf();


			// retrieve the organization to update
			$organization = Organization::getOrganizationByOrganizationId($pdo, $id);
			if($organization === null) {
				throw(new RuntimeException("Organization does not exist", 404));
			}

			//enforce the user is signed in and only trying to edit their own profile
			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $profile->getProfileId()) {
				throw(new \InvalidArgumentException("You are not allowed to edit this organization", 403));
			}

			// update all attributes
			$profile->setOrganizationAddress1($requestObject->organizationAddress1);
			$profile->setOrganizationAddress2($requestObject->organizationAddress2);
			$profile->setOrganizationPhone($requestObject->organizationPhone);
			$profile->update($pdo);

			// update reply
			$reply->message = "Organization successfully updated.";

		} else if($method === "POST") {

			//enforce that the end user has a XSRF token.
			verifyXsrf();

			// enforce the user is signed in
			if(empty($_SESSION["profile"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in to view profiles", 403));
			}

			// create new organization and insert into the database
			$organization = new Organization(null, $requestObject->ProfileId, $requestObject->organizationActivationToken, $requestObject->organizationAddress1, $requestObject->organizationAddress2, $requestObject->organizationCity, $requestObject->organizationEmail, $requestObject->organizationLicense, $requestObject->organizationName, $requestObject->organizationPhone, $requestObject->organizationState, $requestObject->organizationZip);
			$organization->insert($pdo);

			// update reply
			$reply->message = "Organization created OK";
		}

	} else if($method === "DELETE") {

		//enforce that the end user has a XSRF token.
		verifyXsrf();

		// retrieve the Organization to be deleted
		$organization = Organization::getOrganizationByOrganizationId($pdo, $id);
		if($organization === null) {
			throw(new RuntimeException("Organization does not exist", 404));
		}

		//enforce the user is signed in and only trying to edit their own profile
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $profile->getProfileId()) {
			throw(new \InvalidArgumentException("You are not allowed to delete this organization.", 403));
		}

		// delete profile
		$profile->delete($pdo);
		// update reply
		$reply->message = "Organization deleted OK";
	} else {
		throw (new InvalidArgumentException("Invalid HTTP method request"));
	}
// update the $reply->status $reply->message
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