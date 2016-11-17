<?php 
	require_once('session.php');

	$yesColor="panel panel-success";
	$noColor="Panel with panel-warning class";
<<<<<<< HEAD

	$sql_comment=$db->query("select Name,Vote,Comment from user where vote IS NOT NULL");


=======
>>>>>>> 6cd41e290367a2cdedd766d5f9b480d2959dc6a1
	require_once('html/commentPage.html');
?>