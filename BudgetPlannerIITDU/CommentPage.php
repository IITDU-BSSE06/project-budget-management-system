<?php 
	require_once('session.php');

	$yesColor="panel panel-success";
	$noColor="Panel with panel-warning class";

	$sql_comment=$db->query("select Name,Vote,Comment from user where vote IS NOT NULL");


	require_once('html/commentPage.html');
?>