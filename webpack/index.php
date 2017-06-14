<?php
require_once(dirname(__DIR__) . "/php/lib/xsrf.php");
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
setXsrfCookie();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<base href="<?php echo dirname($_SERVER["PHP_SELF"]) . "/"; ?>" />
		<!-- Google Fonts -->
		<link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,300,700italic,700|Merriweather|Playfair+Display:400,400italic Alegreya+Sans+SC|Handlee|Rancho|Yellowtail' rel='stylesheet' type='text/css'>

		<title>Angular example</title>
	</head>
	<body>
		<petrescue-abq>Loading&hellip;</petrescue-abq>
	</body>
</html>