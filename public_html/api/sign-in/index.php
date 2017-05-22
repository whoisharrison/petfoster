<?php

require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\PetRescueAbq\Profile;

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
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/ddctwitter.ini");

	//determine which HTTP method is being used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];


	//if method is post handle the sign in logic
	if($method === "POST") {

		//make sure the XSRF Token is valid
		verifyXsrf();

		//process the request content and decode the json object into a php object
		$requestContent = file_get_contents("php://input"):
		$requestObject = json_decode($requestContent);

		//check to make sure the password and emial field is not empty
		if(empty($requestObject->profile))
	}

}