<?php
	// require_once ('login.php');
	// require_once ('func.php');
	
	$db_hostname = 'localhost';
	$db_username = 'root';
	$db_password = '';
	$db_database = 'xujmsh';

	$connection = @mysqli_connect($db_hostname, $db_username, $db_password, $db_database);

	if (!$connection) {
		die ('База билан боғланишда хатолик: ' . mysqli_connect_errno());
	}
?>