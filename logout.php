<?php

session_start();
$_SESSION = [];
session_unset();
session_destroy();

// setcookie('id', '', time() - 3600);
// setcookie('id', '', time() - 3600);

if (isset($_SERVER['HTTP_COOKIE'])) {
	$cookies = explode(';', $_SERVER['HTTP_COOKIE']);
	foreach ($cookies as $cookie) {
		$parts = explode('=', $cookie);
		$name = trim($parts[0]);
		setcookie($name, '', time() - 1036800);
		setcookie($name, '', time() - 1036800, '/');
	}
}

echo "<script>document.location.href = 'login.php';</script>";
exit;
