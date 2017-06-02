<?php

require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/etc/apache2/capstone-mysql/encrypted-config.php";

//Cloudinary?

use Edu\Cnm\PetRescueAbq\{
	Post, Profile, Image
};

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
	$id = filter_input(INPUT_GET, "post", FILTER_VALIDATE_INT);
	$postOrganizationId = filter_input(INPUT_GET, "organization", FILTER_VALIDATE_INT);
	$postBreed = filter_input(INPUT_GET, "postBreed", FILTER_SANITIZE_STRING);
	$postDescription = filter_input(INPUT_GET, "postDescription", FILTER_SANITIZE_STRING);
	$imageId = filter_input(INPUT_GET, "imageId", FILTER_VALIDATE_INT);
	$imagePostId = filter_input(INPUT_GET, "imagePostId", FILTER_VALIDATE_INT);
	$imageCloudinaryId = filter_input(INPUT_GET, "imageCloudinaryId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	// Validate Id per methods required
	if(($method === "DELETE") && (empty($postId) === true || $id < 0)) {
		throw (new InvalidArgumentException("id can't be negative or empty", 405));
	}

	// Handle get requests
	if($method === "GET") {

		// set the XSRF cookie
		setXsrfCookie();

		//get image/all images then update reply

		if(empty($id) === false){
			$profile = Profile::getProfileByProfileId($pdo, $id);
		if($profile !== null){
			$reply->data = $profile;
		}

	}
		if(empty($Id) === false) {
			$post = Post::getPostByPostId($pdo, $id);
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

		} elseif(empty($postDescription) === false) {
			$post = Post::getPostByPostDescription($pdo, $postDescription)->toArray();
			if($posts !== null) {
				$reply->data = $posts;
			}

		} elseif(empty($postSex) === false) {
			$post = Post::getPostByPostSex($pdo, $postSex)->toArray();
			if($posts !== null) {
				$reply->data = $posts;
			}

		} elseif(empty($postType) === false) {
			$post = Post::getPostByPostType($pdo, $postType)->toArray();
			if($posts !== null) {
				$reply->data = $posts;
			}

		}
		if(empty($imageId) === false) {
			$image = Image::getImageByImageId($pdo, $imageId);
			if($image !== null) {
				$reply->data = $image;
			}

		} elseif(empty($imagePostId) === false) {
			$image = Image::getImageByImagePostId($pdo, $imagePostId);
			if($image !== null) {
				$reply->data = $image;

			}

		} elseif(empty($imageCloudinaryId) === false) {
			$image = Image::getImageByImageCloudinaryId($pdo, $imageCloudinaryId);
			if($image !== null) {
				$reply->data = $image;
			}
		} elseif($method === "POST") {
			verifyXsrf();

			//TODO enforce that all the needed variables to create both post and image are present
			//added profile, have Q's about profile id or $id
			//verifying that the user is logged in before they can insert an image

			if($empty($_SESSION["profile"]) === true) {
				throw (new\InvalidArgumentException(("User must be logged in to upload images."), 401));

			}

			//Variable assignment for the users image name, MIME type, and image extension
			//ask about image id below ""
			$tempUserFileName = $_FILES["file"]["tmp_name"];
			$userFileType = $_FILES["file"]["type"];
			$userFileExtension = strtolower(strrchr($_FILES["file"]["name"], "."));

			//upload the image to Cloudinary and get the public id
			$cloudinaryResult = \Cloudinary\Uploader::upload($_FILES["file"]["tmp_name"], array("width" => 500, "crop" => "scale"));

			//TODO create the post before creating the image object (use the $post->getPostId() for the imagePostId)
			$post = new Post($post->getPostId(), $imagePostId());
			$post->insert($imagePostId);

			// After the sending the image to Cloudinary, grab the public id and create the new image
			$image = new Image(null, $postId, $cloudinaryResult["public_id"]);
			$image->insert($pdo);

//Push the data to the imageId, upload the new image, and notify user.
			$reply->data = $image->getImageId();
			$reply->message = "Image upoad successful.";

		} elseif($method === "DELETE") {
			verifyXsrf();

			//retrieve the postid to delete
			$post = Post::getPostByPostId($pdo, $id);
			if($post === null) {
				throw (new RuntimeException("Post does not exist", 404));
			}

			//TODO grab the organization by the postOrganizationId
			//TODO grab the profile by the organizationProfileId
			//TODO use the profile object's profile Id to insure the user logged in can  delete what he actually created

			//verify user is logged in to delete post/image
			if(empty($_SESSION ["profile"]) === true || $_SESSION ["profile"]->getProfileId() !== $post->) {
				throw (new\InvalidArgumentException("You must be logged in to delete."));
			}

			// TODO kill the children fisrt (delete the image object in the database before deleting the actual post)



			$post->delete($pdo);
			$reply->message = "Post successfully deleted.";

		} else {
			throw (new InvalidArgumentException("Invalid HTTP method request"));
		}
catch
	(Exception $exception) {
		$reply->status = $exception->getCode();
		$reply->
	}














