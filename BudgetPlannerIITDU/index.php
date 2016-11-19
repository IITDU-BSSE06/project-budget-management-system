<?php
	require_once('session.php');

	if(!isset($_SESSION['login_user'])){
      header("location:login.php");
   	}
   	else{
   		header("location:Home.php");
   	}
?>