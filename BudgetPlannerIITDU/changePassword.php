<?php 
	require_once("session.php");
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		$newPassword=trim($_POST["newPassword"]);
		if($row['Password']!=substr(hash('sha256', $currentPassword),7,20)){
			$error="current password is not correct";
		}
		else{
			$hash=substr(hash('sha256', $newPassword),7,20);
			if(mysqli_query($db,"UPDATE user SET password='$hash' WHERE Email='".$row['Email']."' " )){
					echo "Password updated successfully.";
			}
			else echo "Error updating password." .mysqli_error($db);
		}
	}

	include("html/changePassword.html");
?>

