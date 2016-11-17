<?php
require_once("config.php");
	if(empty($_GET["id"])){
		header("location:session.php");
	}
	$user_id=$_GET["id"];

if($_SERVER["REQUEST_METHOD"]=="POST"){
	$newPassword=trim($_POST['member_password']);
	$hash=substr(hash('sha256', $newPassword),7,20);
	if(mysqli_query($db,"UPDATE user SET password='$hash' WHERE UserId='$user_id' " )){
		$result=$db->query("select Email from user where userId='$user_id'")->fetch_array(MYSQLI_ASSOC);
		session_start();
		$_SESSION['login_user']=$result['Email'];
		header("location: index.php");
	}
	else echo "Error updating password." .mysqli_error($db);
}

	require_once('html\resetPassword.html');
?>
				