<?php
	require_once('session.php');

	if(!isset($_SESSION['login_user'])){
      header("location:login.php");
   	}
   	else{
   		if($row['Role']==1)
   			header("location:AdminHome.php");
   		else if($row['Role']==2)
   			header("location:BudgetCommitteeMemberHome.php");
   		else if($row['Role']==3) header("location:BudgetOfficerHome.php");
   	}
?>