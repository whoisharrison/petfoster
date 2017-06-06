<?php


/**
 * function for the activation of email
 *
 * @author Jabari Farrar <tmafm1@gmail.com
 */

require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once dirname(__DIR__, 2) . "/vendor/autoload.php";

function mailGunslinger($senderName, $senderEmail, $receiverName, $receiverEmail, $subject, $message) {
	$config = readConfig("/etc/apache2/capstone-mysql/fosterabq.ini");
	$mailgun = json_decode($config["mailgun"]);

	//start the mailgun client
	$client = new \Http\Adapter\Guzzle6\Client();
	$mailGunslinger = new \Mailgun\Mailgun($mailgun->apiKey, $client);

	//send the message
	$result = $mailGunslinger->sendMessage($mailgun->domain, [
			"from" => "$senderName <$senderEmail>",
			"to" => "$receiverName <$receiverEmail>",
			"subject" => $subject,
			"html" => $message,
			"text" => html_entity_decode($message)
		]
	);

	if($result->http_response_code !== 200) {
		throw(new RuntimeException("unable to send email", $result->http_response_code));
	}

	//split the result before the at symbol

	$atIndex = strpos($result->http_response_body->id, "@");
	if($atIndex === false) {
		throw (new RangeException("unable to send email", 503));
	}
	$mailgunMessageId = substr($result->http_response_body->id, 1, $atIndex - 1);
	return $mailgunMessageId;
}