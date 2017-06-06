<?php

require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\PetRescueAbq\{Profile, Organization};

//ADDED ORGANIZATION
//use Edu\Cnm\PetRescueAbq\Organization;

/**
 * API for the sign-in
 * @author rolopez <rolopez.email@gmail.com> @ Gkephart
 */

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//start session
	if(session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}

	//grab mySQL statement
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/fosterabq.ini");

	//determine which HTTP method is being used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];


//	//sanitize input
//	$messageId = filter_input(INPUT_GET, "messageId", FILTER_VALIDATE_INT);
//	$messageProfileId = filter_input(INPUT_GET, "messageProfileId", FILTER_VALIDATE_INT);
//	$messageOrganizationId = filter_input(INPUT_GET, "messageOrganizationId", FILTER_VALIDATE_INT);
	$profileEmail = filter_input(INPUT_GET, "profileEmail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
//	$messageDateTime = filter_input(INPUT_GET, "eventDate", FILTER_SANITIZE_STRING);
//	$subjectContent = filter_input(INPUT_GET, "subjectContent", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profilePassword = filter_input(INPUT_GET, "profilePassword", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);



	//if method is post handle the sign in logic
	if($method === "POST") {

		//make sure the XSRF Token is valid
		verifyXsrf();

		//process the request content and decode the json object into a php object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//check to make sure the password and email field is not empty
		if(empty($requestObject->profileEmail) === true) {
			throw(new \InvalidArgumentException("Wrong email address.", 401));

		} else {
			$profileEmail = filter_var($requestObject->profileEmail, FILTER_SANITIZE_EMAIL);
		}

		if(empty($requestObject->profilePassword) === true) {
			throw(new \InvalidArgumentException("Must enter password", 401));

		} else {
			$profilePassword = $requestObject->profilePassword;
		}

		//grab te profile from the databse by the email provided
		$profile = Profile::getProfileByProfileEmail($pdo, $profileEmail);
		if(empty($profile) === true) {
			throw(new \InvalidArgumentException("Invalid Email", 401));
		}



		//if the profile activation is not null throw an error
		if($profile->getProfileActivationToken() !== null) {
			throw(new \InvalidArgumentException("you are not allowed to sign in unless you have activated your account", 403));
		}



		//has the password given to make sure it matches
		$hash = hash_pbkdf2("sha512", $profilePassword, $profile->getProfileSalt(), 262144);

		//verify hash is correct
		if($hash !== $profile->getProfileHash()) {
			throw(new \InvalidArgumentException("Password or  email is incorrect"));
		}

		//gran the profile from database and put into session
		$profile = Profile::getProfileByProfileId($pdo, $profile->getProfileId());

		 $organization = Organization::getOrganizationByOrganizationId($pdo, 52	);


		 if(empty($organization) === false) {



		  		//make sure organization activation token is null, I added this
			  if($organization->getOrganizationActivationToken() !== null) {
				  throw(new \InvalidArgumentException("this where I die", 403));
			  }


		  	$_SESSION["organization"] = $organization;
			  $_SESSION["profile"] = $profile;
			  $reply->message = "Sign in was successful";


		  } else {
			  $_SESSION["profile"] = $profile;
			  $reply->message = "Sign in was successful";
		  }

	} else {
		throw(new \InvalidArgumentException("Invalid HTTP method request"));
	}

	//if an exception is thrown update the
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();

} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}

header("Content-type: application/json");
echo json_encode($reply);