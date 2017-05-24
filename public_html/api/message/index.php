<?php

require_once dirname(_DIR_, 3) . "/vendor/autoload.php";
require_once dirname (_DIR_, 3) . "php/classes/autoload. php";
require_once dirname (_DIR_, 3) . "php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\PetRescueAbq\{
	Message,
	//only use profile class for testing purpose
	Profile, Organization
	//do I use organization also for testing purposes?
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
	//DO I NEED THIS, NO YOU DO NOT NEED THIS!!!
	/**
	 * if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
	 * throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	 * }
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

		} else if(empty($messageProfileId) === false) {
			$message = Message::getMessageByMessageProfileId($pdo, $messageProfileId)->toArray();
			if($message !== null) {

				//ADDED ORGANIZATION - put in get
				if(empty($_SESSION["organization"]) === true) {
					throw(new \InvalidArgumentException("You must be logged in to post messages", 403));
				}

				$reply->data = $message;
			}

		} else if(empty($messageOrganizationId) === false) {
			$message = Message::getMessageByMessageOrganizationId($pdo, $messageOrganizationId)->toArray();
			if($message !== null) {
				$reply->data = $message;
			}

		} else {
			$messages = Message::getAllMessages($pdo)->toArray();
			if($messages !== null) {
				$reply->data = $messages;
			}
		}

	} else if($method === "POST") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		// Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the
		//front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream
		// that allows raw data to be read from the front end request which is, in this case, a JSON package.
		$requestObject = json_decode($requestContent);
		//this line decodes the JSON package and stors that result in $requestObject

		//make sure message content is available (required field)
		//is messageContent going to mess with my attribute messageContent
		if(empty($requestObject->messageContent) === true) {
			throw(new \InvalidArgumentException("No content for Message.", 405));
		}

		//make sure message date is accurate
		if(empty($requestObject->messageDateTime) === true) {
			$requestObject->messageDateTime = null;
		}

		//make sure profileId is available
		if(empty($requestObject->messageProfileId) === true) {
			throw(new \InvalidArgumentException("No profile Id.", 405));
		}

		//ADDED ORGANIZATION?
		if(empty($requestObject->messageOrganizationId) === true) {
			throw(new \InvalidArgumentException("No organization Id.", 405));
		}

		if($method === "POST") {

			//enforce the user is signed in
			if(empty($_SESSION["profile"]) === true) {
				throw(new \InvalidArgumentException("You must be logged in to post messages", 403));
			}




			//create new message and insert it into the database

			$message = new Message(null, $requestObject->messageProfileId, $requestObject->messageOrganizationId, $requestObject->messageContent,
				null);
			$message->insert($pdo);

			//update reply
			$reply->message = "Message created ok";
		}

	} else {
		throw (new InvalidArgumentException("Invalid HTTP method request"));
	}

	//update the $reply->status $reply->message, probably not gonna need

	 } catch(\Exception | \TypeError $exception) {
	 //$reply->status = $exception->getCode();
	 // $reply->message = $exception->getMessage();
	 }


	header("Content-type: application/json");
	if($reply->date === null) {
		unset($reply->date);
	}

//encode and return reply to the front end called
	echo json_encode($reply);





