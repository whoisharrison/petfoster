<?php

declare(strict_types=1);

require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/turnstile.php";
require_once "/etc/apache2/capstone-mysql/encrypted-config.php";

use Edu\Cnm\PetRescueAbq\Organization;
use Edu\Cnm\PetRescueAbq\Profile;

if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

header("Content-Type: application/json; charset=utf-8");

$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

$pdo = null;

try {
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ??
		$_SERVER["REQUEST_METHOD"];

	if($method !== "POST") {
		throw new InvalidArgumentException(
			"Invalid HTTP request.",
			405
		);
	}

	$requestContent = file_get_contents("php://input");
	$requestObject = json_decode($requestContent);

	if(!is_object($requestObject)) {
		throw new InvalidArgumentException(
			"Invalid JSON request.",
			400
		);
	}

	verifyTurnstileToken(
		(string) ($requestObject->turnstileToken ?? "")
	);

	if(empty($requestObject->profileAtHandle)) {
		throw new InvalidArgumentException(
			"Please enter a handle.",
			400
		);
	}

	if(empty($requestObject->profileEmail)) {
		throw new InvalidArgumentException(
			"Please enter a valid email.",
			400
		);
	}

	if(empty($requestObject->profileName)) {
		throw new InvalidArgumentException(
			"Please enter your full name.",
			400
		);
	}

	if(empty($requestObject->profilePassword)) {
		throw new InvalidArgumentException(
			"Please enter a valid password.",
			400
		);
	}

	if(
		!isset($requestObject->profilePasswordConfirm) ||
		$requestObject->profilePassword !==
			$requestObject->profilePasswordConfirm
	) {
		throw new InvalidArgumentException(
			"Passwords do not match.",
			400
		);
	}

	$isOrganization =
		($requestObject->profileFlag ?? "") === "O";

	if($isOrganization) {
		$requiredOrganizationFields = [
			"organizationAddress1" =>
				"Please enter a valid address.",
			"organizationCity" =>
				"Please enter a valid city.",
			"organizationLicense" =>
				"Please enter a valid adoption license.",
			"organizationName" =>
				"Please enter the organization name.",
			"organizationPhone" =>
				"Please enter a valid phone number.",
			"organizationState" =>
				"Please enter a valid state.",
			"organizationZip" =>
				"Please enter a valid ZIP code."
		];

		foreach(
			$requiredOrganizationFields as $field => $message
		) {
			if(empty($requestObject->{$field})) {
				throw new InvalidArgumentException(
					$message,
					400
				);
			}
		}
	}

	$pdo = connectToEncryptedMySQL(
		"/etc/apache2/capstone-mysql/fosterabq.ini"
	);

	$pdo->beginTransaction();

	$salt = bin2hex(random_bytes(32));

	$hash = hash_pbkdf2(
		"sha512",
		$requestObject->profilePassword,
		$salt,
		262144
	);

	/*
	 * Email activation is temporarily disabled.
	 * A null token means the account is active.
	 */
	$profile = new Profile(
		null,
		null,
		$requestObject->profileAtHandle,
		$requestObject->profileEmail,
		$hash,
		$requestObject->profileName,
		$salt
	);

	$profile->insert($pdo);

	if($isOrganization) {
		$address2 = null;

		if(!empty($requestObject->organizationAddress2)) {
			$address2 =
				$requestObject->organizationAddress2;
		}

		$organization = new Organization(
			null,
			$profile->getProfileId(),
			null,
			$requestObject->organizationAddress1,
			$address2,
			$requestObject->organizationCity,
			$requestObject->profileEmail,
			$requestObject->organizationLicense,
			$requestObject->organizationName,
			$requestObject->organizationPhone,
			$requestObject->organizationState,
			$requestObject->organizationZip
		);

		$organization->insert($pdo);
	}

	$pdo->commit();

	$reply->data = [
		"profileId" => $profile->getProfileId()
	];

	$reply->message =
		"Your account was created. You can now sign in.";

} catch(Throwable $exception) {
	if(
		$pdo instanceof PDO &&
		$pdo->inTransaction()
	) {
		$pdo->rollBack();
	}

	$status = (int) $exception->getCode();

	if($status < 400 || $status > 599) {
		$status = 500;
	}

	$reply->status = $status;
	$reply->message = $exception->getMessage();
}

echo json_encode($reply);
