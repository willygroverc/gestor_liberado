<?php
session_start();
ob_start();
?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php
if (@phpversion() >= '5.0.0' && (!@ini_get('register_long_arrays') || @ini_get('register_long_arrays') == '0' || strtolower(@ini_get('register_long_arrays')) == 'off')) { // PHP5 with register_long_arrays off
	$PHP_POST =& $_POST;
	$PHP_GET =& $_GET;
	$PHP_SERVER =& $_SERVER;
	$PHP_COOKIE =& $_COOKIE;
	$PHP_ENV =& $_ENV;
	$PHP_FILES =& $_FILES;
	if (isset($_SESSION)) $PHP_SESSION =& $_SESSION;
} else {
	$PHP_POST =& $HTTP_POST_VARS;
	$PHP_GET =& $HTTP_GET_VARS;
	$PHP_SERVER =& $HTTP_SERVER_VARS;
	$PHP_COOKIE =& $HTTP_COOKIE_VARS;
	$PHP_ENV =& $HTTP_ENV_VARS;
	$PHP_FILES =& $HTTP_POST_FILES;
	if (isset($_SESSION)) $PHP_SESSION =& $HTTP_SESSION_VARS;
}
?>
