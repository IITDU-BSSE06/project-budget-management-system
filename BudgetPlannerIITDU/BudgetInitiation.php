<?php 
	require_once('AdminUser_check.php');
	require_once('mailconfig.php');
	$currentYear=date('Y');

	if($_SERVER["REQUEST_METHOD"]=="POST"){

		if(isset($_POST['submitDate'])){

			$start_date=trim($_POST['startDate']);
			$end_date=trim($_POST['endDate']);

			if($start_date!=""&&$end_date!=""){

				$sql_ses="INSERT into budgetinitiation (Year, StartDate, EndDate, CanEdit, Status) VALUES ('$currentYear', '$start_date', '$end_date','1', '0')";
				$db->query($sql_ses);

				$prevYear=$currentYear-1;

				$myuserId=$row['UserId'];
				$result=$db->query("select Name, Email from user where UserId!='$myuserId' ");
					
	    		$subject  =   "Budget ".$currentYear;
	    		$message  =   "<div> Budget of ".$currentYear." has been started </div> <div>
	    		The starting date :".$start_date."</div> <div>
	    		The ending date :".$end_date."</div>";
	    		$mailsend =   sendmailToAll($result,$subject,$message);

	    		if($mailsend==1){

	    			$prevBudget=$db->query("select SectorId,Amount from sectorbudget where Year='$prevYear' ");
					$prevResource=$db->query("select ResourceId,Amount from resourcebudget where Year='$prevYear' ");

					if($prevBudget->num_rows>0){
						while(list($SectorId,$Amount)=$prevBudget->fetch_row()){
							$db->query("INSERT into sectorbudget (SectorId, Year, Amount) VALUES('$SectorId','$currentYear', '$Amount')");
						}	
					}	
					if($prevResource->num_rows>0){
						while(list($ResourceId,$Amount)=$prevResource->fetch_row()){
							$db->query("INSERT into resourcebudget (ResourceId, Year, Amount) VALUES('$ResourceId','$currentYear', '$Amount')");
						}	
					}

	    		}
	    		else{
	    			echo "<script> alert('There was a problem in sending mail. Try again !') </script>";
	    		}

			}

			
		}

		else if(isset($_POST['editEndDate'])){

			$end_dateUpdated=trim($_POST['endDate']);
			if($end_dateUpdated!=""){

				$myuserId=$row['UserId'];
				$result=$db->query("select Name, Email from user where UserId!='$myuserId' ");
	    		$subject  =   "Budget ".$currentYear;
	    		$message  =   "<div>The ending time of Budget ".$currentYear."  has been expanded </div>
	    		The ending date  is now :".$end_dateUpdated."</div>";
				$mailsend =   sendmailToAll($result,$subject,$message);
				if($mailsend==1){
					$sql_ses="UPDATE budgetinitiation SET EndDate='$end_dateUpdated' where Year='$currentYear' ";
					$db->query($sql_ses);	
				} 
				else echo "<script> alert('There was a problem in sending mail. Try again !') </script>";
			}
		}
	}	

	$sql=$db->query("select Year, StartDate, EndDate, Status from budgetinitiation where Year='$currentYear' ");

	if($sql->num_rows>0){
		$result=$sql->fetch_array(MYSQLI_ASSOC);
		$start_date=$result['StartDate'];
		$end_date=$result['EndDate'];
	}
	else{
		$db->query("UPDATE user SET Vote = NULL, Comment = NULL where Role!='3' ");
		$db->query("truncate budgetinitiation");
	}

	require_once('html/BudgetInitiation.html');
	
?>