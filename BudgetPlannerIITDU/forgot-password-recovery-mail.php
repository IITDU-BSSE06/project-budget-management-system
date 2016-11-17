<?php
require_once("mailconfig.php");
	
	$time=time();
	$recovery_code=substr(hash('sha256', $user['Email'].$user['Password'].$time),0,30);
	$user_id=$user['UserId'];
	$ses_sql=$db->query("select UserId from User_recovery where UserId ='$user_id'  ");
	if(!empty($ses_sql->fetch_array(MYSQLI_ASSOC))){
		$db->query("UPDATE User_recovery SET pwd_reset_hash='$recovery_code', time_requested='$time' WHERE UserId='$user_id' ");
	}
	else{
		$sql = "INSERT INTO User_recovery (UserId, pwd_reset_hash, time_requested)
		VALUES ('$user_id', '$recovery_code', '$time')";	
		$db->query($sql);
	}

	$to=$user["Email"];
    $subject  =   "Forgot Password Recovery";
    $message  =   "<div>" . $user["Name"] . ",<br><p>Your password recovery code is: ".$recovery_code."<br> You can use this code within 3 hours </div>";
    $name     =   "Budget Planner";
    $mailsend =   sendmail($to,$subject,$message,$name);

    if($mailsend==1){
    	header("location: enterRecoveryCode.php?id=".$user['UserId']);
    }
    else{
    	echo '<h2>Problem in sending email.</h2>';
    }
?>
