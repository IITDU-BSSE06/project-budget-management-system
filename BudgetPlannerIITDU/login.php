<?php 
require_once("config.php");	

	session_start();
	$error="";
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		$email = mysqli_real_escape_string($db,trim($_POST['email']));
		$password=mysqli_real_escape_string($db,trim($_POST['password']));
		$password = substr(hash('sha256', $password),7,20) ;
		
		$sql = "SELECT UserId FROM user WHERE email = '$email' and password = '$password'";
		$result=$db->query($sql);
		
		if($result->num_rows==1){
			$_SESSION['login_user']=$email;
            header("location: index.php");
		}
        else{
            $error="Your Email or Password is invalid";
        }
	}

	require_once('html/login.html');

?>
