<?php
require_once dirname(__DIR__, 3) . "vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "php/liv/xsrd.php";
requre_once("etc/apache2/capstone-mysql/encrypted-config.php");
use Edu\Cnm\PetRescueAbq;

/**
 * api for signing up to PetRescueAbq
 * @author MHARRISON <mharrison13@cnm.edu>
 **/
// verify the session start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply-> status= 200;
$reply-> data = null;
try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/PetRescueAbq.ini");
	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] :
		$_SERVER["REQUEST_METHOD"];
	if($method === "POST") {
		//decode the json and turn it into a php object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//profile users full name is a required field
		if (empty($requestObject->profileName) === true) {
			throw(new \InvalidArgumentException("Please enter your full name", 405));
		}

		//profile organization name is a required field
		if (empty($requestObject->organizationName) === true) {
			throw(new \InvalidArgumentException("Please enter your organization's name", 405));
		}

		//profile at handle is a required field
		if(empty($requestObject->profileAtHandle) === true) {
			throw(new \InvalidArgumentException("Please enter a handle", 405));
		}

		//profile email is a required field
		if(empty($requestObject->profileEmail) === true) {
			throw(new \InvalidArgumentException("Please enter a valid email", 405));
		}

		//verify that profile password is present
		if(empty($requestObject->profilePassword) === true) {
			throw(new \InvalidArgumentException("Please enter a valid Password", 405));
		}

		//verify that organization ID is present
		if(empty($requestObject->organizationLicense) === true) {
			throw(new \InvalidArgumentException("Please enter a valid Organization Adoption License", 405));
		}

		//verify that address is present
		if(empty($requestObject->organizationAddress1) === true) {
			throw(new \InvalidArgumentException("Please enter a valid address", 405));
		}

		//if phone is empty set it to null
		if(empty($requestObject->profilePhone) === true) {
			$requestObject->profilePhone = null;
		}

		//make sure the password and confirm password match
		if ($requestObject->profilePassword !== $requestObject->profilePasswordConfirm) {
			throw(new \InvalidArgumentException("Passwords do not match"));
		}
		$salt =
	}

}