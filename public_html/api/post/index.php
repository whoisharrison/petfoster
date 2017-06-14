<?php
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
use Edu\Cnm\PetRescueAbq\{Image, Post};

/**
 * api for the Profile Activation class
 *
 * @author JFarrar<tmafm1@gmail.com>
 **/

//verify the session status. start session if not active
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
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize activation input
	$activation = filter_input(INPUT_GET, "activation", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	// handle GET request - if id is present, that activation is returned, otherwise all activations are returned
	if($method === "GET") {
		setXsrfCookie();
		$posts = Post::getAllPosts($pdo)->toArray();
		$result = [];
		foreach($posts as $post) {
			$image = Image::getImageByImagePostId($pdo, $post->getPostId());
			if ($image === null) {
				continue;
			}
			$result ["https://res.cloudinary.com/petrescueabq/image/upload/" . $image->getImageCloudinaryId()] = $post;
		}

		$reply->data = $result;

	}
	else{
		throw (new\Exception("Invalid HTTP method", 405));
	}

	// update reply with exception information
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();

	//header("Content-type: application/json");
	echo json_encode($reply);
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
	$reply->trace = $typeError->getTraceAsString();
}

//header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

// encode and return reply to front end caller
echo json_encode($reply);