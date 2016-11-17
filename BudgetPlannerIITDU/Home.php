<<<<<<< HEAD
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

=======
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

>>>>>>> a23ea29b4172790faf33b8da896cce0a74587b57
?>