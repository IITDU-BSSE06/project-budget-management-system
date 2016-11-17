<?php 
require_once("config.php");
if($_SERVER["REQUEST_METHOD"]=="POST"){
	
	$userEmail=trim($_POST["user-email"]);
	$result=$db->query("SELECT * FROM user WHERE email = '$userEmail' ");
	$user=$result->fetch_array(MYSQLI_ASSOC);	
		if(!empty($user)){
			require_once('forgot-password-recovery-mail.php');
		}
		else{
			$error_message="No user has been found!";
		}
}
	require_once('html\recoveryPassword.html');
?>

