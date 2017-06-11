<?php

require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/mailgun.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\PetRescueAbq\ {
	Organization, Profile
};

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
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/fosterabq.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] :
		$_SERVER["REQUEST_METHOD"];

	if($method === "POST") {
		// handle requestContent, requestObject here
		//decode the json and turn it into a php object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		// check for Profile required fields
		//profile at handle is a required field
		if(empty($requestObject->profileAtHandle) === true) {
			throw(new \InvalidArgumentException("Please enter a handle", 405));
		}

		//profile email is a required field
		if(empty($requestObject->profileEmail) === true) {
			throw(new \InvalidArgumentException("Please enter a valid email", 405));
		}

		//profile users full name is a required field
		if(empty($requestObject->profileName) === true) {
			throw(new \InvalidArgumentException("Please enter your full name", 405));
		}

		//verify that profile password is present
		if(empty($requestObject->profilePassword) === true) {
			throw(new \InvalidArgumentException("Please enter a valid Password", 405));
		}

		//make sure the password and confirm password match
		if($requestObject->profilePassword !== $requestObject->profilePasswordConfirm) {
			throw(new \InvalidArgumentException("Passwords do not match"));
		}

		// create new Profile, insert, send profile activation email
		$salt = bin2hex(random_bytes(32));
		$hash = hash_pbkdf2("sha512", $requestObject->profilePassword, $salt, 262144);
		$activationToken = bin2hex(random_bytes(16));
		//create the profile object and prepare to insert into the database
		$profile = new Profile(null, $activationToken, $requestObject->profileAtHandle, $requestObject->profileEmail, $hash, $requestObject->profileName, $salt);
		//insert the profile into the database
		$profile->insert($pdo);

		//compose the email message to send with activation token
		$basePath = dirname($_SERVER["SCRIPT_NAME"], 3);
		//create the path
		$urlglue = $basePath . "/api/activation/?activation=" . $activationToken;
		//create the redirect link
		$confirmLink = "https://" . $_SERVER["SERVER_NAME"] . $urlglue;
		//compose message to send with email
		$messageSubject = "Thank you for signing up for an account to Pet Rescue Abq!";
		$message = <<< EOF
		<h2>Welcome to Pet Rescue ABQ</h2>
		<p>Please visit the following URL to verify your account: </p><p><a href="$confirmLink">$confirmLink<a></p>
EOF;
		$response = mailGunslinger("petrescueabq", "petrescueabq@gmail.com", $requestObject->profileName, $requestObject->profileEmail, $messageSubject, $message);
		$reply->message = "Almost there! An email has been sent to activate your account.";
	} else {
		throw(new \InvalidArgumentException("Invalid HTTP request.", 405));
	}
	// check for "O" flag, if Y, create Org, insert and send Org email
	if($requestObject->profileFlag === "O") {

		//verify that address is present
		if(empty($requestObject->organizationAddress1) === true) {
			throw(new \InvalidArgumentException("Please enter a valid address", 405));
		}

		//verify that address is present
		if(empty($requestObject->organizationAddress2) === true) {
			$requestObject->profilePhone = null;
		}

		//verify that City is present
		if(empty($requestObject->organizationCity) === true) {
			throw(new \InvalidArgumentException("Please enter a valid City", 405));
		}

		//verify that organization ID is present
		if(empty($requestObject->organizationLicense) === true) {
			throw(new \InvalidArgumentException("Please enter a valid Organization Adoption License", 405));
		}

		//profile organization name is a required field
		if(empty($requestObject->organizationName) === true) {
			throw(new \InvalidArgumentException("Please enter your organization's name", 405));
		}

		//if phone is empty set it to null
		if(empty($requestObject->organizationPhone) === true) {
			$requestObject->organizationPhone = null;
		}

		//verify that State is present
		if(empty($requestObject->organizationState) === true) {
			throw(new \InvalidArgumentException("Please enter a valid State", 405));
		}

		//verify that Zip Code is present
		if(empty($requestObject->organizationZip) === true) {
			throw(new \InvalidArgumentException("Please enter your Zip-Code", 405));
		}
		$activationTokenOrg = bin2hex(random_bytes(16));
		//create the organization object and prepare to insert into the database
		$organization = new Organization(null, $profile->getProfileId(), $activationTokenOrg, $requestObject->organizationAddress1, $requestObject->organizationAddress2, $requestObject->organizationCity, $profile->getProfileEmail(), $requestObject->organizationLicense, $requestObject->organizationName, $requestObject->organizationPhone, $requestObject->organizationState, $requestObject->organizationZip);
		//insert the organization into the database
		$organization->insert($pdo);

		//activation token for org
		$salt = bin2hex(random_bytes(32));
		$hash = hash_pbkdf2("sha512", $requestObject->profilePassword, $salt, 262144);
		//compose the email message to send with activation token
		$basePath = dirname($_SERVER["SCRIPT_NAME"], 3);
		//create the path
		$urlglue = $basePath . "/api/admin/?activation=" . $activationTokenOrg;
		//create the redirect link
		$confirmLink = "https://" . $_SERVER["SERVER_NAME"] . $urlglue;
		//compose message to send with email
		$messageSubject = "Organization account ready for activation!";
		$message = <<< EOF
		<h2>Organization ready for Activation</h2>
		<p>Please click the following URL to verify this account: </p><p><a href="$confirmLink">$confirmLink<a></p>
EOF;
		$response = mailGunslinger("petrescueabq", "petrescueabq@gmail.com", $requestObject->profileName, "jcooper37@cnm.edu", $messageSubject, $message);
		$reply->message = "Almost there! An email has been sent to activate your account.";
	} else {
		throw(new \InvalidArgumentException("Invalid HTTP request.", 405));
	}

} catch(\Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(\TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}

header("Content-type: application/json");
echo json_encode($reply);