<?php
	define('DB_SERVER', 'localhost');
	define('DB_USERNAME','pritom');
	define('DB_PASSWORD','saq123');
	define('DB_DATABASE','mydb');
	$db=mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

	// Check connection
	if ($db->connect_error) {
		die("Connection failed: " . $db->connect_error);
	}
?>