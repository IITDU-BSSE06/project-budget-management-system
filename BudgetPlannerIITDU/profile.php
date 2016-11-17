<?php 
	require_once('session.php');

	if($_SERVER["REQUEST_METHOD"]=="POST"){
		$newPassword=trim($_POST["newPassword"]);
		$hash=substr(hash('sha256', $newPassword),7,20);
		$db->query("UPDATE user SET password='$hash' WHERE Email='".$row['Email']."' "); 
	}
		
	require_once('html/profile.html');

?>