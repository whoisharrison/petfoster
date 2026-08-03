<?php

declare(strict_types=1);

require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once "/etc/apache2/capstone-mysql/encrypted-config.php";

use Edu\Cnm\PetRescueAbq\Image;
use Edu\Cnm\PetRescueAbq\Post;

if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

header("Content-Type: application/json; charset=utf-8");

$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	$pdo = connectToEncryptedMySQL(
		"/etc/apache2/capstone-mysql/fosterabq.ini"
	);

	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ??
		$_SERVER["REQUEST_METHOD"];

	if($method !== "GET") {
		throw new InvalidArgumentException(
			"Invalid HTTP request.",
			405
		);
	}

	setXsrfCookie();

	$posts = Post::getAllPosts($pdo);
	$results = [];

	foreach($posts as $post) {
		$image = Image::getImageByImagePostId(
			$pdo,
			$post->getPostId()
		);

		if($image === null) {
			continue;
		}

		$result = new stdClass();

		$result->postId =
			$post->getPostId();

		$result->postOrganizationId =
			$post->getPostOrganizationId();

		$result->postBreed =
			$post->getPostBreed();

		$result->postDescription =
			$post->getPostDescription();

		$result->postSex =
			$post->getPostSex();

		$result->postType =
			$post->getPostType();

		$result->imageUrl =
			"/uploads/" .
			rawurlencode(
				$image->getImageCloudinaryId()
			);

		$results[] = $result;
	}

	$reply->data = $results;

} catch(Throwable $exception) {
	$status = (int) $exception->getCode();

	if($status < 400 || $status > 599) {
		$status = 500;
	}

	$reply->status = $status;
	$reply->message = $exception->getMessage();
}

echo json_encode($reply);
