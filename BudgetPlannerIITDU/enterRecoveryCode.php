<?php 
	require_once("config.php");
	if(empty($_GET["id"])){
		header("location:session.php");
	}
	$user_id=$_GET["id"];
	$sql=$db->query("select Email from user where UserId=$user_id");
	$result=$sql->fetch_array(MYSQLI_ASSOC);

	if($_SERVER["REQUEST_METHOD"]=="POST"){

		$recovery_code=trim($_POST["recovery_code"]);
		$ses_sql=$db->query("select pwd_reset_hash, time_requested from user_recovery where UserId=$user_id");
		$recovery=$ses_sql->fetch_array(MYSQLI_ASSOC);

		if(!empty($recovery)){
			if($recovery['pwd_reset_hash']==$recovery_code&&(time()-$recovery['time_requested']<=3*60*60*60)){
				header("location: resetPassword.php?id=".$user_id);
			}
			else $error_message='Invalid recovery code. Try again.';
		}
		else $error_message='Invalid recovery code. Try again.';
	}

	require_once('html\enterRecoveryCode.html');

?>