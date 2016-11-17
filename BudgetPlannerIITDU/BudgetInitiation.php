<?php 
	require_once('AdminUser_check.php');
	require_once('mailconfig.php');
	$currentYear=date('Y');

	/*echo "<script> alert('$prevYear') </script>";*/
	/*$db->query("truncate budgetinitiation");*/
	if($_SERVER["REQUEST_METHOD"]=="POST"){

		if(isset($_POST['submitDate'])){

			$start_date=trim($_POST['startDate']);
			$end_date=trim($_POST['endDate']);

			$sql_ses="INSERT into budgetinitiation (Year, StartDate, EndDate, CanEdit, Status) VALUES ('$currentYear', '$start_date', '$end_date','1', '0')";
			$db->query($sql_ses);

			$prevYear=$currentYear-1;
			$prevBudget=$db->query("select SectorId,Amount from sectorbudget where Year='$prevYear' ");

			$prevResource=$db->query("select ResourceId,Amount from resourcebudget where Year='$prevYear' ");			

			while(list($SectorId,$Amount)=$prevBudget->fetch_row()){
				$db->query("INSERT into sectorbudget (SectorId, Year, Amount) VALUES('$SectorId','$currentYear', '$Amount')");
			}

			while(list($ResourceId,$Amount)=$prevResource->fetch_row()){
				$db->query("INSERT into resourcebudget (ResourceId, Year, Amount) VALUES('$ResourceId','$currentYear', '$Amount')");
			}

			$myuserId=$row['UserId'];
			$result=$db->query("select Name, Email from user where UserId!='$myuserId' ");
				
    		$subject  =   "Budget ".$currentYear;
    		$message  =   "<div> Budget of ".$currentYear." has been started </div> <div>
    		The starting date :".$start_date."</div> <div>
    		The ending date :".$end_date."</div>";
    		$mailsend =   sendmailToAll($result,$subject,$message);

    		if($mailsend==0){
    			echo "<script> alert('There was a problem in sending mail') </script>";
    		}
		}

		else if(isset($_POST['editEndDate'])){

			$end_dateUpdated=trim($_POST['endDate']);

			$sql_ses="UPDATE budgetinitiation SET EndDate='$end_dateUpdated' where Year='$currentYear' ";

			if($db->query($sql_ses)){

				$myuserId=$row['UserId'];
				$result=$db->query("select Name, Email from user where UserId!='$myuserId' ");
				
    			$subject  =   "Budget ".$currentYear;
    			$message  =   "<div>The ending time of Budget ".$currentYear."  has been expanded </div>
    			The ending date  is now :".$end_dateUpdated."</div>";

    			$mailsend =   sendmailToAll($result,$subject,$message);
    			
			} 
			else echo "failed";	

		}
	}	

	$sql=$db->query("select Year, StartDate, EndDate, Status from budgetinitiation where Year='$currentYear' ");

	if($sql->num_rows>0){
		$result=$sql->fetch_array(MYSQLI_ASSOC);
		$start_date=$result['StartDate'];
		$end_date=$result['EndDate'];

		if($result['Status']==1){
			require_once('html/showBudgetPlanningDate.html');	
		}
		else{
			require_once('html/editEndDate.html');	
		}
	}
	else{
		$db->query("truncate budgetinitiation");
		require_once('html/BudgetInitiation.html');
	}
	
?>