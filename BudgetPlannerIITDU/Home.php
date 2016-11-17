<?php 
	require_once('session.php');

	if($row['Role']==1){
		header('location: AdminHome.php');
	}
	else if($row['Role']==2){
		header('location: BudgetCommitteeMemberHome.php');
	}
	else{
		header('location: BudgetOfficerHome.php');
	}

?>