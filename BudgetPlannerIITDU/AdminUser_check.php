<?php 
	require_once("session.php");
	if($row['Role']!=1)
		header("location:login.php");
?>