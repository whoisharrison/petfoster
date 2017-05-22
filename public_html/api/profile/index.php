<?php

require_once dirname(__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\PetRescueAbq\ {
	Profile
};

/**
 * api for profile class
 *
 * @author Valente Meza <mharrison13@cnm.edu>
 */

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->status = null;

try {
	//grab the mySQL connection
	$pdo =
}