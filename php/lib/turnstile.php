<?php

declare(strict_types=1);

function verifyTurnstileToken(string $token): void {
	$token = trim($token);

	if($token === "") {
		throw new InvalidArgumentException(
			"Please complete the human verification.",
			400
		);
	}

	if(strlen($token) > 2048) {
		throw new InvalidArgumentException(
			"Human verification is invalid.",
			400
		);
	}

	$secretFile = getenv("TURNSTILE_SECRET_FILE");

	if(
		$secretFile === false ||
		!is_readable($secretFile)
	) {
		throw new RuntimeException(
			"Human verification is not configured.",
			500
		);
	}

	$secret = trim(
		(string) file_get_contents($secretFile)
	);

	if($secret === "") {
		throw new RuntimeException(
			"Human verification is not configured.",
			500
		);
	}

	$data = [
		"secret" => $secret,
		"response" => $token
	];

	if(!empty($_SERVER["HTTP_CF_CONNECTING_IP"])) {
		$data["remoteip"] =
			$_SERVER["HTTP_CF_CONNECTING_IP"];
	}

	$context = stream_context_create([
		"http" => [
			"method" => "POST",
			"header" =>
				"Content-Type: application/x-www-form-urlencoded\r\n",
			"content" => http_build_query($data),
			"timeout" => 10,
			"ignore_errors" => true
		]
	]);

	$response = @file_get_contents(
		"https://challenges.cloudflare.com/turnstile/v0/siteverify",
		false,
		$context
	);

	if($response === false) {
		throw new RuntimeException(
			"Human verification is temporarily unavailable.",
			503
		);
	}

	$result = json_decode($response, true);

	if(!is_array($result)) {
		throw new RuntimeException(
			"Human verification returned an invalid response.",
			503
		);
	}

	if(($result["success"] ?? false) !== true) {
		error_log(
			"Turnstile validation failed: " .
			json_encode($result["error-codes"] ?? [])
		);

		throw new InvalidArgumentException(
			"Human verification failed. Please try again.",
			400
		);
	}

	$allowedHostnames = [
		"petrescueabq.org",
		"www.petrescueabq.org"
	];

	if(
		!in_array(
			$result["hostname"] ?? "",
			$allowedHostnames,
			true
		)
	) {
		throw new InvalidArgumentException(
			"Human verification hostname is invalid.",
			400
		);
	}

	if(($result["action"] ?? "") !== "signup") {
		throw new InvalidArgumentException(
			"Human verification action is invalid.",
			400
		);
	}
}
