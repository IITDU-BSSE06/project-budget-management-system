<?php 
	require_once("session.php");
	if($row['Role']!=2)
		header("location:login.php");
?>