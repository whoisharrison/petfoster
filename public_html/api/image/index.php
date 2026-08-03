<?php

declare(strict_types=1);

require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once "/etc/apache2/capstone-mysql/encrypted-config.php";

use Edu\Cnm\PetRescueAbq\Image;
use Edu\Cnm\PetRescueAbq\Organization;
use Edu\Cnm\PetRescueAbq\Post;

if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

header("Content-Type: application/json; charset=utf-8");

$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

$pdo = null;
$savedFile = null;

try {
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ??
		$_SERVER["REQUEST_METHOD"];

	if($method !== "POST") {
		throw new InvalidArgumentException(
			"Invalid HTTP request.",
			405
		);
	}

	verifyXsrf();

	$pdo = connectToEncryptedMySQL(
		"/etc/apache2/capstone-mysql/fosterabq.ini"
	);

	if(empty($_SESSION["profile"])) {
		throw new InvalidArgumentException(
			"You must be signed in to submit an animal.",
			401
		);
	}

	$organization =
		Organization::getOrganizationByOrganizationProfileId(
			$pdo,
			$_SESSION["profile"]->getProfileId()
		);

	if($organization === null) {
		throw new InvalidArgumentException(
			"Only organization accounts may submit animals.",
			403
		);
	}

	$postBreed = trim((string) ($_POST["postBreed"] ?? ""));
	$postDescription =
		trim((string) ($_POST["postDescription"] ?? ""));
	$postSex = trim((string) ($_POST["postSex"] ?? ""));
	$postType = trim((string) ($_POST["postType"] ?? ""));

	if($postBreed === "") {
		throw new InvalidArgumentException(
			"You must specify a breed.",
			400
		);
	}

	if($postDescription === "") {
		throw new InvalidArgumentException(
			"You must provide a description.",
			400
		);
	}

	if($postSex === "") {
		throw new InvalidArgumentException(
			"You must specify the animal's sex.",
			400
		);
	}

	if($postType === "") {
		throw new InvalidArgumentException(
			"You must specify the animal type.",
			400
		);
	}

	if(!isset($_FILES["dog"])) {
		throw new InvalidArgumentException(
			"Please select an image.",
			400
		);
	}

	$file = $_FILES["dog"];

	if($file["error"] !== UPLOAD_ERR_OK) {
		throw new RuntimeException(
			"The image upload failed.",
			400
		);
	}

	if((int) $file["size"] > 8 * 1024 * 1024) {
		throw new InvalidArgumentException(
			"The image must be smaller than 8 MB.",
			400
		);
	}

	$finfo = new finfo(FILEINFO_MIME_TYPE);
	$mimeType = $finfo->file($file["tmp_name"]);

	$allowedTypes = [
		"image/jpeg" => "jpg",
		"image/png" => "png",
		"image/gif" => "gif",
		"image/webp" => "webp"
	];

	if(!isset($allowedTypes[$mimeType])) {
		throw new InvalidArgumentException(
			"Only JPG, PNG, GIF, and WebP images are supported.",
			400
		);
	}

	$extension = $allowedTypes[$mimeType];

	/*
	 * Keep the filename below the database column's
	 * existing 32-character limit.
	 */
	$fileName =
		bin2hex(random_bytes(12)) .
		"." .
		$extension;

	$uploadDirectory = "/var/www/html/uploads";

	if(
		!is_dir($uploadDirectory) &&
		!mkdir($uploadDirectory, 0755, true)
	) {
		throw new RuntimeException(
			"Unable to create the upload directory.",
			500
		);
	}

	if(!is_writable($uploadDirectory)) {
		throw new RuntimeException(
			"The upload directory is not writable.",
			500
		);
	}

	$savedFile = $uploadDirectory . "/" . $fileName;

	$pdo->beginTransaction();

	$post = new Post(
		null,
		$organization->getOrganizationId(),
		$postBreed,
		$postDescription,
		$postSex,
		$postType
	);

	$post->insert($pdo);

	if(
		!move_uploaded_file(
			$file["tmp_name"],
			$savedFile
		)
	) {
		throw new RuntimeException(
			"Unable to save the uploaded image.",
			500
		);
	}

	$image = new Image(
		null,
		$post->getPostId(),
		$fileName
	);

	$image->insert($pdo);

	$pdo->commit();

	$reply->data = [
		"postId" => $post->getPostId(),
		"imageUrl" => "/uploads/" . $fileName
	];

	$reply->message = "Animal submitted successfully.";

} catch(Throwable $exception) {
	if(
		$pdo instanceof PDO &&
		$pdo->inTransaction()
	) {
		$pdo->rollBack();
	}

	if(
		$savedFile !== null &&
		is_file($savedFile)
	) {
		unlink($savedFile);
	}

	$status = (int) $exception->getCode();

	if($status < 400 || $status > 599) {
		$status = 500;
	}

	$reply->status = $status;
	$reply->message = $exception->getMessage();
}

echo json_encode($reply);
