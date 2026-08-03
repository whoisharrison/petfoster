<?php

declare(strict_types=1);

if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

header("Content-Type: application/json; charset=utf-8");

$reply = new stdClass();
$reply->status = 200;

try {
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ??
		$_SERVER["REQUEST_METHOD"];

	if($method !== "GET") {
		throw new InvalidArgumentException(
			"Invalid HTTP request.",
			405
		);
	}

	$_SESSION = [];

	if(ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();

		setcookie(
			session_name(),
			"",
			time() - 42000,
			$params["path"],
			$params["domain"],
			$params["secure"],
			$params["httponly"]
		);
	}

	session_destroy();

	$reply->message = "You are signed out.";

} catch(Throwable $exception) {
	$status = (int) $exception->getCode();

	if($status < 400 || $status > 599) {
		$status = 500;
	}

	$reply->status = $status;
	$reply->message = $exception->getMessage();
}

echo json_encode($reply);
