<?php
require_once dirname(__DIR__, 3) . "vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "php/lib/xsrf.php";
requre_once("etc/apache2/capstone-mysql/encrypted-config.php");
use Edu\Cnm\PetRescueAbq;

/**
 * api for signing up to PetRescueAbq
 * @author MHARRISON <mharrison13@cnm.edu>
 **/

// verify the session start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply-> status= 200;
$reply-> data = null;

try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/PetRescueAbq.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] :
		$_SERVER["REQUEST_METHOD"];

	if($method === "POST") {
		// handle requestContent, requestObject here
		//decode the json and turn it into a php object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		// check for Profile required fields
		//profile at handle is a required field
		if(empty($requestObject->profileAtHandle) === true) {
			throw(new \InvalidArgumentException("Please enter a handle", 405));
		}

		//profile email is a required field
		if(empty($requestObject->profileEmail) === true) {
			throw(new \InvalidArgumentException("Please enter a valid email", 405));
		}

		//profile users full name is a required field
		if(empty($requestObject->profileName) === true) {
			throw(new \InvalidArgumentException("Please enter your full name", 405));
		}

		//verify that profile password is present
		if(empty($requestObject->profilePassword) === true) {
			throw(new \InvalidArgumentException("Please enter a valid Password", 405));
		}

		//make sure the password and confirm password match
		if($requestObject->profilePassword !== $requestObject->profilePasswordConfirm) {
			throw(new \InvalidArgumentException("Passwords do not match"));
		}

		// check for "O" flag, then check for "O" required fields
		if($requestObject->profileFlag === "O") {
			//verify that address is present
			if(empty($requestObject->organizationAddress1) === true) {
				throw(new \InvalidArgumentException("Please enter a valid address", 405));
			}

			//verify that address is present
			if(empty($requestObject->organizationAddress2) === true) {
				$requestObject->profilePhone = null;
			}

			//verify that City is present
			if(empty($requestObject->organizationCity) === true) {
				throw(new \InvalidArgumentException("Please enter a valid City", 405));
			}

			//verify that organization ID is present
			if(empty($requestObject->organizationLicense) === true) {
				throw(new \InvalidArgumentException("Please enter a valid Organization Adoption License", 405));
			}

			//profile organization name is a required field
			if(empty($requestObject->organizationName) === true) {
				throw(new \InvalidArgumentException("Please enter your organization's name", 405));
			}

			//if phone is empty set it to null
			if(empty($requestObject->organizationPhone) === true) {
				$requestObject->organizationPhone = null;
			}

			//verify that State is present
			if(empty($requestObject->organizationState) === true) {
				throw(new \InvalidArgumentException("Please enter a valid State", 405));
			}

			//verify that Zip Code is present
			if(empty($requestObject->organizationZip) === true) {
				throw(new \InvalidArgumentException("Please enter your Zip-Code", 405));
			}
		}

		// create new Profile, insert, send profile activation email
		$salt = bin2hex(random_bytes(32));
		$hash = hash_pbkdf2("sha512", $requestObject->profilePassword, $salt, 262144);
		$profileActivationToken = bin2hex(random_bytes(16));
		//create the profile object and prepare to insert into the database
		$profile = new Profile(null, $profileActivationToken, $requestObject->profileAtHandle, $requestObject->profileEmail, $hash, $requestObject->profileName, $salt);
		//insert the profile into the database
		$profile->insert($pdo);

		//compose the email message to send with activation token
		$messageSubject = "Thank you for signing up for an account to Pet Rescue Abq!";
		//building the activation link that can travel to another server and still work. This is the link what will be clicked to confirm account.
		//make sure URL is /public_html/api/activation/$activation

		$basePath = dirname($_SERVER["SCRIPT_NAME"], 3);
		//create the path
		$urlglue = $basePath . "/api/activation/?activation=" . $profileActivationToken;
		//create the redirect link
		$confirmLink = "https://" . $_SERVER["SERVER_NAME"] . $urlglue;
		//compose message to send with email
		$message = <<< EOF
<h2>Thanks for signing up!</h2>
<p>You must confirm your email to begin using your account. Click the link below: </p>
<p><a href="$confirmLink">$confirmLink</a></p>
EOF;
		//create swift email
		$swiftMessage = Swift_Message::newInstance();
		// attach the sender to the message
		// this takes the form of an associative array where the email is the key to a real name
		$swiftMessage->setFrom(["petrescueabq.com" => "admin"]);
		/**
		 * attach recipients to the message
		 * notice this is an array that can include or omit the recipient's name
		 * use the recipient's real name where possible;
		 * this reduces the probability of the email is marked as spam
		 */
		//define who the recipient is
		$recipients = [$requestObject->profileEmail];
		//set the recipient to the swift message
		$swiftMessage->setTo($recipients);
		//attach the subject line to the email message
		$swiftMessage->setSubject($messageSubject);
		/**
		 * attach the message to the email
		 * set two versions of the message: a html formatted version and a filter_var()ed version of the message, plain text
		 * notice the tactic used is to display the entire $confirmLink to plain text
		 * this lets users who are not viewing the html content to still access the link
		 */
		//attach the html version fo the message
		$swiftMessage->setBody($message, "text/html");
		//attach the plain text version of the message
		$swiftMessage->addPart(html_entity_decode($message), "text/plain");

		//setup smtp
		$smtp = Swift_SmtpTransport::newInstance("localhost", 25);
		$mailer = Swift_Mailer::newInstance($smtp);
		//send the message
		$numSent = $mailer->send($swiftMessage, $failedRecipients);
		/**
		 * the send method returns the number of recipients that accepted the Email
		 * so, if the number attempted is not the number accepted, this is an Exception
		 **/
		if($numSent !== count($recipients)) {
			// the $failedRecipients parameter passed in the send() method now contains contains an array of the Emails that failed
			throw(new RuntimeException("unable to send email"));
		}

	} else {
		throw (new InvalidArgumentException("invalid http request"));
	}

	// check for "O" flag, if Y, create Org, insert and send Org email
	if($requestObject->profileFlag === "O") {
		$profileActivationTokenOrg = bin2hex(random_bytes(16));
		//create the organization object and prepare to insert into the database
		$organization = new Organization(null, $profileActivationTokenOrg, $requestObject->organizationAddress1, $requestObject->organizationAddress2, $requestObject->organizationCity, $requestObject->organizationLicense, $requestObject->organizationName, $requestObject->organizationPhone, $requestObject->organizationAddress);
		//insert the organization into the database
		$organization->insert($pdo);

		$messageSubject = "Your Pet Rescue Abq account is under review!";
		//compose message to send with email
		$message = <<< EOF
	<h2>Thanks for signing up as an Pet Rescue Abq Organization!</h2>
	<p>Your account is currently under review. You will be notified as soon as your account is approved.</p>
EOF;
		//create swift email
		$swiftMessage = Swift_Message::newInstance();
		// attach the sender to the message
		// this takes the form of an associative array where the email is the key to a real name
		$swiftMessage->setFrom(["petrescueabq.com" => "admin"]);
		/**
		 * attach recipients to the message
		 * notice this is an array that can include or omit the recipient's name
		 * use the recipient's real name where possible;
		 * this reduces the probability of the email is marked as spam
		 */
		//define who the recipient is
		$recipients = [$requestObject->profileEmail];
		//set the recipient to the swift message
		$swiftMessage->setTo($recipients);
		//attach the subject line to the email message
		$swiftMessage->setSubject($messageSubject);
		/**
		 * attach the message to the email
		 * set two versions of the message: a html formatted version and a filter_var()ed version of the message, plain text
		 * notice the tactic used is to display the entire $confirmLink to plain text
		 * this lets users who are not viewing the html content to still access the link
		 */
		//attach the html version fo the message
		$swiftMessage->setBody($message, "text/html");
		//attach the plain text version of the message
		$swiftMessage->addPart(html_entity_decode($message), "text/plain");

		//setup smtp
		$smtp = Swift_SmtpTransport::newInstance("localhost", 25);
		$mailer = Swift_Mailer::newInstance($smtp);
		//send the message
		$numSent = $mailer->send($swiftMessage, $failedRecipients);
		/**
		 * the send method returns the number of recipients that accepted the Email
		 * so, if the number attempted is not the number accepted, this is an Exception
		 **/
		if($numSent !== count($recipients)) {
			// the $failedRecipients parameter passed in the send() method now contains contains an array of the Emails that failed
			throw(new RuntimeException("unable to send email"));
		}

		// success message
		$reply->message = "Thank you for creating a profile Pet Rescue Abq!";

	} else {
		throw (new InvalidArgumentException("invalid http request"));
	}

} catch(\Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(\TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}

header("Content-type: application/json");
echo json_encode($reply);