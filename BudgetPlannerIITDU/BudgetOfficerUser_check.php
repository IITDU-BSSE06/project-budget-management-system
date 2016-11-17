<?php 
	require_once("session.php");
	if($row['Role']!=3)
		header("location:login.php");
?>