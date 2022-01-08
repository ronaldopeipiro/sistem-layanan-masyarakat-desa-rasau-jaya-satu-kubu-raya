<?php

if (isset($_GET['p'])) {
	$page = $_GET['p'];

	switch ($page) {

		case 'data-layanan':
			if ($user_level == "operator") {
				include "content/layanan/views.php";
			} else {
				include "content/layanan/views.php";
			}
			break;

			// Pengaturan
		case 'pengaturan':
			include "content/pengaturan/views.php";
			break;

			// Dashboard
		default:
			if ($user_level == "operator") {
				include 'content/dashboard/views.php';
			} else {
				include "content/layanan/views.php";
			}
			break;
	}
} else {
	if ($user_level == "operator") {
		include 'content/dashboard/views.php';
	} else {
		include "content/layanan/views.php";
	}
}
