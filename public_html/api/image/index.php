<?php

require_once dirname(__DIR__,3) . "/php/classes/autoload.php";
require_once dirname(__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/etc/apache2/capstone-mysql/encrypted-config.php";

//Cloudinary?

use Edu\Cnm\PetRescueAbq\{
	Post, Profile, Image  };

/**
 * Api for Image Class
 *
 * @author Amy Skidmore <askidmore1@cnm.edu>
 *
 */

// Verify the session, start if inactive

if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();

}

//Prepare an empty reply

$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {

	//grab the connection to mySQL
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/petRescueAbq.ini");

	/** Cloudinary API  */
	$config = readConfig("/etc/apache2/capstone-mysql/petRescueAbq.ini");
	$cloudinary = json_encode($config["cloudinary"]);
	\Cloudinary::config(["cloud_name" => $cloudinary->cloudName, "api_key" => $cloudinary->apiKey, "api_secret" => $cloudinary->apiSecret]);

	// Determine the HTTP method
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$imageId = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$imagePostId = filter_input(INPUT_GET, "imagePostId", FILTER_VALIDATE_INT);
	$imageCloudinaryId = filter_input(INPUT_GET, "imageCloudinaryId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	// Validate Id per methods required
	if(($method === "DELETE") && (empty($imageId) === true || $imageId < 0)) {
		throw (new InvalidArgumentException("id can't be negative or empty", 405));
	}
  if(($method === "DELETE") && (empty($postId) === true || $postId <0)) {
		throw (new InvalidArgumentException("id can't be negative or empty", 405));
	}

	// Handle get requests
	if($method === "GET"){

		// set the XSRF cookie
		setXsrfCookie();

		//get image/all images then update reply

	if(empty($postId) === false){
		$post = Post::getPostByPostId($pdo, $postId);
		if($post !== null) {
			$reply->data = $post;
		}

	} elseif(empty($postOrganization) === false) {
			$post = Post::getPostsByPostOrganizationId($pdo, $postOrganizationId)->toArray();
			if($posts !== null) {
				$reply->data = $posts;
			}

	} elseif(empty($postBreed) === false) {
		$post = Post::getPostsByPostBreed($pdo, $postBreed)->toArray();
		if($posts !== null) {
			$reply->data = $posts;

		}

	} elseif(empty($postDescription) === false){
		$post = Post::getPostByPostDescription($pdo, $postDescription)->toArray();
			if($posts !== null) {
				$reply->data = $posts;
			}

	} elseif(empty($postSex) === false) {
		$post = Post::getPostByPostSex($pdo, $postSex)->toArray();
		if($posts !== null) {
			$reply->data = $posts;
		}

	}elseif(empty($postType) === false) {
		$post = Post::getPostByPostType($pdo, $postType)->toArray();
		if($posts !== null) {
			$reply->data = $posts;
		}

	}	if(empty($imageId) === false) {
			$image = Image::getImageByImageId($pdo, $imageId);
			if($image !== null) {
				$reply->data = $image;
			}

	} elseif(empty($imagePostId) === false){
			$image = Image::getImageByImagePostId($pdo, $imagePostId);
			if($image !== null){
				$reply->data = $image;

			}

	} elseif(empty($imageCloudinaryId) === false) {
			$image = Image::getImageByImageCloudinaryId($pdo, $imageCloudinaryId);
			if($image !== null) {
				$reply->data = $image;
			}
	} elseif($method === "POST"){
	verifyXsrf()
	}
	}







