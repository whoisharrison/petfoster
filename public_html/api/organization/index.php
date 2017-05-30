<?php
/**
 * Created by Jeffrey Cooper.
 */
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\PetRescueAbq\ {
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
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/fosterabq.ini");

	// mock a session and assign a specific user to it.
	// only for testing purposes - not in the live code.
	//$_SESSION["profile"] = Profile::getProfileByProfileId($pdo, 257);

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$organizationProfileId = filter_input(INPUT_GET, "organizationProfileId", FILTER_VALIDATE_INT);
	// TODO: ??Auth Token included???
	$organizationAddress1 = filter_input(INPUT_GET, "organizationAddress1", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$organizationAddress2 = filter_input(INPUT_GET, "organizationAddress2", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$organizationCity = filter_input(INPUT_GET, "organizationCity", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$organizationEmail = filter_input(INPUT_GET, "organizationEmail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$organizationLicense = filter_input(INPUT_GET, "organizationLicense", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$organizationName = filter_input(INPUT_GET, "organizationName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$organizationPhone = filter_input(INPUT_GET, "organizationPhone", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$organizationState = filter_input(INPUT_GET, "organizationState", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$organizationZip = filter_input(INPUT_GET, "organizationZip", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);



	//make sure the id is valid for methods that require it
	if(($method === "GET" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}


	// handle GET request - if id is present, that organization is returned, otherwise nothing is returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific organization and update reply
		if(empty($id) === false) {
			$organization = Organization::getOrganizationByOrganizationId($pdo, $id);
			if($organization !== null) {
				$reply->data = $organization;
			}
		} else if(empty($organizationProfileId) === false) {
			$organization = Organization::getOrganizationByOrganizationProfileId($pdo, $organizationProfileId);
			if($organization !== null) {
				$reply->data = $organization;
			}
		} else if(empty($organizationActivationToken) === false) {
			$organization = Organization::getOrganizationByOrganizationActivationToken($pdo, $organizationActivationToken);
			if($organization !== null) {
				$reply->data = $organization;
			}
		} else if(empty($organizationAddress1) === false) {
			$organization = Organization::getOrganizationByOrganizationAddress1($pdo, $organizationAddress1);
			if($organization !== null) {
				$reply->data = $organization;
			}
		} else if(empty($organizationAddress2) === false) {
			$organization = Organization::getOrganizationByOrganizationAddress2($pdo, $organizationAddress2);
			if($organization !== null) {
				$reply->data = $organization;
			}
		} else if(empty($organizationCity) === false) {
			$organization = Organization::getOrganizationByOrganizationCity($pdo, $organizationCity);
			if($organization !== null) {
				$reply->data = $organization;
			}
		} else if(empty($organizationEmail) === false) {
			$organization = Organization::getOrganizationByOrganizationEmail($pdo, $organizationEmail);
			if($organization !== null) {
				$reply->data = $organization;
			}
		} else if(empty($organizationLicense) === false) {
			$organization = Organization::getOrganizationByOrganizationLicense($pdo, $organizationLicense);
			if($organization !== null) {
				$reply->data = $organization;
			}
		} else if(empty($organizationName) === false) {
			$organization = Organization::getOrganizationByOrganizationName($pdo, $organizationName);
			if($organization !== null) {
				$reply->data = $organization;
			}
		} else if(empty($organizationPhone) === false) {
			$organization = Organization::getOrganizationByOrganizationPhone($pdo, $organizationPhone);
			if($organization !== null) {
				$reply->data = $organization;
			}
		} else if(empty($organizationState) === false) {
			$organization = Organization::getOrganizationByOrganizationState($pdo, $organizationState);
			if($organization !== null) {
				$reply->data = $organization;
			}
		} else if(empty($organizationZip) === false) {
			$organization = Organization::getOrganizationByOrganizationZip($pdo, $organizationZip);
			if($organization !== null) {
				$reply->data = $organization;
			}
		}
	} else if($method === "PUT") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		// Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
		$requestObject = json_decode($requestContent);
		// This Line then decodes the JSON package and stores that result in $requestObject
		//make sure organization email is available (required field) (no id, token or Add2)
		if(empty($requestObject->organizationProfileId) === true) {
			throw(new \InvalidArgumentException ("No associated profile is listed or available.", 405));
		}
		if(empty($requestObject->organizationAddress1) === true) {
			throw(new \InvalidArgumentException ("No address is listed or available.", 405));
		}
		if(empty($requestObject->organizationCity) === true) {
			throw(new \InvalidArgumentException ("No city is listed or available.", 405));
		}
		if(empty($requestObject->organizationEmail) === true) {
			throw(new \InvalidArgumentException ("No email listed or available.", 405));
		}
		if(empty($requestObject->organizationLicense) === true) {
			throw(new \InvalidArgumentException ("No license is listed or available.", 405));
		}
		if(empty($requestObject->organizationName) === true) {
			throw(new \InvalidArgumentException ("No name is listed or available.", 405));
		}
		if(empty($requestObject->organizationPhone) === true) {
			throw(new \InvalidArgumentException ("No phone number is listed or available.", 405));
		}
		if(empty($requestObject->organizationState) === true) {
			throw(new \InvalidArgumentException ("No state is listed or available.", 405));
		}
		if(empty($requestObject->organizationZip) === true) {
			throw(new \InvalidArgumentException ("No zip code is listed or available.", 405));
		}

		//  !!!!make sure profileId is not null
		if(empty($requestObject->OrganizationId) === true) {
			throw(new \InvalidArgumentException ("No Organization ID.", 405));
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
			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $organization->getOrganizationProfileId()) {
				throw(new \InvalidArgumentException("You are not allowed to edit this organization", 403));
			}
			// update all attributes (not primary or foreign)
			$organization->setOrganizationAddress1($requestObject->organizationAddress1);
			$organization->setOrganizationAddress2($requestObject->organizationAddress2);
			$organization->setOrganizationCity($requestObject->organizationCity);
			$organization->setOrganizationEmail($requestObject->organizationEmail);
			$organization->setOrganizationLicense($requestObject->organizationLicense);
			$organization->setOrganizationName($requestObject->organizationName);
			$organization->setOrganizationPhone($requestObject->organizationPhone);
			$organization->setOrganizationState($requestObject->organizationState);
			$organization->setOrganizationZip($requestObject->organizationZip);
			$organization->update($pdo);

			// update reply
			$reply->message = "Organization successfully updated.";

//		} else if($method === "POST") {

			//enforce that the end user has a XSRF token.
//			verifyXsrf();

			// enforce the user is signed in
//			if(empty($_SESSION["profile"]) === true) {
			/*				throw(new \InvalidArgumentException("you must be logged in to create", 403));
			//			}

						// create new organization and insert into the database
						$organization = new Organization(null, $requestObject->ProfileId, $requestObject->organizationActivationToken, $requestObject->organizationAddress1, $requestObject->organizationAddress2, $requestObject->organizationCity, $requestObject->organizationEmail, $requestObject->organizationLicense, $requestObject->organizationName, $requestObject->organizationPhone, $requestObject->organizationState, $requestObject->organizationZip);
						$organization->insert($pdo);

						// update reply
						$reply->message = "Organization created OK";
					*/
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
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $organization->getOrganizationProfileId()) {
			throw(new \InvalidArgumentException("You are not allowed to delete this organization.", 403));
		}

		// delete organization
		$organization->delete($pdo);
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