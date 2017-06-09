<?php


require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\PetRescueAbq\{
	Message,
	//only use profile class for testing purpose
	Profile, Organization
	//do I use organization also for testing purposes?
};

/**
 * API for the message class
 * @author rolopez <rolopez.email@gmail.com> @deepdivedylan
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
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/fosterabq.ini");


	//mock a logged in user by mocking the session and assigning a specific user to it
	//this is the only for testing purposes and should not be in the live code
//		$_SESSION["profile"] = Profile::getProfileByProfileId($pdo, 2);
	$_SESSION["organization"] = Organization::getOrganizationByOrganizationId($pdo, 1);

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize inut
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$messageProfileId = filter_input(INPUT_GET, "messageProfileId", FILTER_VALIDATE_INT);
	$messageOrganizationId = filter_input(INPUT_GET, "messageOrganizationId", FILTER_VALIDATE_INT);

	$messageContent = filter_input(INPUT_GET, "messageContent", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$messageSubject = filter_input(INPUT_GET, "messageSubject", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);


	//handle GET request - if id is present, that message is returned, otherwise all messages are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		if((empty ($_SESSION["organization"]) === false) && (empty ($_SESSION["profile"] === false))) {
			if(empty($id) === false) {
				$message = Message::getMessageByMessageId($pdo, $id);

				if(($_SESSION["organization"]->getOrganizationId() !== $message->getMessageOrganizationId()) || ($_SESSION["organization"]->getOrganizationProfileId() !== $message->getMessageProfileId())) {
					throw (new InvalidArgumentException("you are not allowed to view org messages A"));

				} else {
					$reply->data = $message;
				}
			}

		} else if(empty($_SESSION["profile"]) === false) {

			if (empty($id) === false) {
				$message = Message::getMessageByMessageId($pdo, $id);

				if (($_SESSION["profile"]->getProfileId() !== $message->getMessageProfileId())){
					throw (new InvalidArgumentException("you are not allowed to view profile messages B"));

				} else {
					$reply->data = $message;
				}
			}


		} else if(empty($_SESSION["messageOrganizationId"]) === false) {

			if (empty($id) === false) {
				$message = Message::getMessageByMessageId($pdo, $id);

				if (($_SESSION["profile"]->getOrganizationMessageId() !== $message->getMessageProfileId())){
					throw (new InvalidArgumentException("you are not allowed to view profile messages C"));

				} else {
					$reply->data = $message;
				}
			}


		} else if(empty($_SESSION["messageProfileId"]) === false) {

			if (empty($id) === false) {
				$message = Message::getMessageByMessageId($pdo, $id);

				if (($_SESSION["profile"]->getMessageProfileId() !== $message->getMessageProfileId())){
					throw (new InvalidArgumentException("you are not allowed to view profile messages D"));

				} else {
					$reply->data = $message;
				}
			}


		} else if(empty($_SESSION["messageByMessageOrganizationId"]) === false) {

			if (empty($id) === false) {
				$message = Message::getMessageByMessageId($pdo, $id);

				if (($_SESSION["profile"]->getMessageByMessageOrganizationId() !== $message->getMessageProfileId())){
					throw (new InvalidArgumentException("you are not allowed to view profile messages E"));

				} else {
					$reply->data = $message;
				}
			}


		} else if(empty($_SESSION["messageByMessageProfileId"]) === false) {

			if (empty($id) === false) {
				$message = Message::getMessageByMessageId($pdo, $id);

				if (($_SESSION["profile"]->getMessageByMessageProfileId() !== $message->getMessageProfileId())){
					throw (new InvalidArgumentException("you are not allowed to view profile messages F"));

				} else {
					$reply->data = $message;
				}
			}









		} else {
			throw (new InvalidArgumentException("you must be logged in to view messages", 403));
		}

	if($method === "POST") {

		//verifyXsrf();
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

		//have them look that I did this right
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

	}


	//do i need this?
		else {
	throw (new InvalidArgumentException("Invalid HTTP method request"));
	}


} catch(\Exception | \TypeError $exception) {

	//ask about this?
	$reply->status = $exception->getCode();
	 $reply->message = $exception->getMessage();
}


header("Content-type: application/json");
//these have been hidden the past two weeks
if($reply->data === null) {
	unset($reply->data);
}

//encode and return reply to the front end called
echo json_encode($reply);







//BONE YARD

//		//get a specific message or all messages and update reply
//		if(empty($id) === false) {
//			$message = Message::getMessageByMessageId($pdo, $id);
//			if($message !== null) {
//				$reply->data = $message;
//			}


//try and grab the organization from the $_SESSION["organization "] if nothing happens set organization to null.
//

//
//		if(empty($_SESSION["organization"]) === true) {
//			$orgaizationProfileId = null;
//		 } elseif(empty($_SESSION["organization"]) !== true) {
//
//			$orgaizationProfileId = $_SESSION["organization"]->organizationProfileId;
//
//			//assign the organization
//
//		}



//if(!(empty($messageOrganizationId) === true ^ empty($messageProfileId) === true)) {
//throw(new InvalidArgumentException("you are not logged in, 401"));
//}
//
//// this is the code we are trying 6.5.15 revision 3.0
//if(((empty($_SESSION["organization"]) === true) && ($_SESSION["organization"]->getOrganizationId() !== $messageOrganizationId)) || ((empty($_SESSION["profile"]) === true) && ($_SESSION["profile"]->getProfileId() !== $messageProfileId))) {
//throw(new InvalidArgumentException("org or profile are not ok, 405"));
/*
 *
 * /
 *
 *
} else if(empty($messageProfileId) === false) {
$message = Message::getMessageByMessageProfileId($pdo, $messageProfileId)->toArray();
if($message !== null) {

$reply->data = $message;
}

} else if(empty($messageOrganizationId) === false) {
$message = Message::getMessageByMessageOrganizationId($pdo, $messageOrganizationId)->toArray();
if($message !== null) {
$reply->data = $message;*






//first attempt
// old check to see if org exists and org id is ok OR profile exists and profile id is ok
//			if(empty($organization->getOrganizationId) === true && $_SESSION["organization"]->getOrganizationId() !== $organizationId->getOrganizationId()) || if(empty($id->profileId) === true && $_SESSION["profile"]->getProfileId() !== $id) {
//				throw(new InvalidArgumentException("org and profile are not ok, 405"));
//			}


//second attempt
// check to see if org exists oe org id is ok and profile exists or profile id is ok
//			if(empty($organization->getOrganizationId) === true || $_SESSION["organization"]->getOrganizationId() !== $organizationId())
//
//
//
//			 && if(empty($id->profileId) === true || $_SESSION["profile"]->getProfileId() !== $id) {
//				throw(new InvalidArgumentException("org and profile are not ok, 405"));
//			}
//
//
//
//
//
//				//another attempt 2.5ish or so... something... I need a beer
//				if(($id === $organization->getOrganizationId) || ($_SESSION["organization"]->getOrganizationId() !== $organizationId()) && (($id === $profile->getProfileId) ||
//						$_SESSION["profile"]->getProfileId() !== $profileId())) {
//
//							throw(new InvalidArgumentException("org and profile are not ok, 405"));
//				}

//			//another attempt 2.75ish or so... looks more like Mikes stuff
//			if((empty($id->getOrganizationId === true) && ($_SESSION["organization"]->getOrganizationId() !== null
//					)) || (empty($id->getProfileId === true) && ($_SESSION["profile"]->getProfileId() !== null))
//			) {
//
//				throw(new InvalidArgumentException("org and profile are not ok, 405"));
//			}


// this is the code we are trying 6.5.15 revision 3.0
//			if(((empty($organization) === true) && ($_SESSION["organization"]->getOrganizationId() !== $messageOrganizationId())) || ((empty($profile)=== true) && ($_SESSION["profile"]->getProfileId() !== $messageProfileId()))
//			) {
//				throw(new InvalidArgumentException("org and profile are not ok, 405"));
//			}



//DELETED THIS
/**
 * {
 * $messages = Message::getAllMessages($pdo)->toArray();
 * if($messages !== null) {
 * $reply->data = $messages;
 * }
 * }
 **/


//make sure the id is valid for the methods that require it
//DO I NEED THIS, NO YOU DO NOT NEED THIS!!!
/**
 * if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
 * throw(new InvalidArgumentException("id cannot be empty or negative", 405));
 * }
 **/

