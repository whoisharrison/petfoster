<?php

require_once dirname(_DIT_, 3) . "/vendor/autoload.php";
require_once dirname (_DIR_, 3) . "php/classes/autoload. php";
require_once dirname (_DIR_, 3) . "php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\PetRescueAbq\{
	Message,
	//only use profile class for testing purpose
	Profile
	//do I use organization also for testing purposes?
	//Organization
};

/**
 * API for the message class
 * @author rolopez <rolopez.email@gmoail.com> @deepdivedylan
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
	//do I need this or should it be something else?
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/ddctwiiter.ini");

	//mock a logged in user by mocking the session and assigning a specific user to it
	//this is the only for testin purposes and should not be in the live code
	//$_SESSION["profile"] = Profile::getProfileByProfileId($pdo, 732);
	//$_SESSION["organization"] = Organization::getOrganizationByOrganizationId($pdo, 732);

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize inut
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$messageProfileId = filter_input(INPUT_GET, "messageProfileId", FILTER_VALIDATE_INT);
	$messageOrganizationId = filter_input(INPUT_GET, "messageOrganizationId", FILTER_VALIDATE_INT);

	$messageContent = filter_input(INPUT_GET, "messageContent", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$messageSubject = filter_input(INPUT_GET, "messageSubject", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the id is valid for the methods that require it
	//DO I NEED THIS?
	/**
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}
	**/

	//handle GET request - if id is present, that message is returned, otherwise all messages are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific message or all messages and update reply
		if(empty($id) === false) {
			$message = Message::getMessageByMessageId($pdo, $id);
			if($message !== null) {
				$reply->data = $message;
			}

		}else if(empty($messageProfileId) === false) {
			$message = Message::getMessageByMessageProfileId($pdo, $messageProfileId)->toArray();
			if($message !== null) {
				$reply->data = $message;
			}

		} else if(empty($messageOrganizationId) === false) {
			$message = Message::getMessageByMessageOrganizationId($pdo, $messageOrganizationId)->toArray();
			if($message !==null) {
				$reply->data = $message;
			}

		} else if(empty($messageContentId) === false) {
			$message = Message::getMessageByMessageContentId($pdo, $messa)
		}

	}














}




