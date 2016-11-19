<?php 
	function validate_email($emailAddress){
		require_once('AdminUser_check.php');
		$result=$db->query("select UserId from user where Email='$emailAddress' ");
		if($result->num_rows>0){
			echo true;
		}
		else echo false;
	}

	function validate_role($role){
		require_once('session.php');
		$result=$db->query("select UserId from user where Role='$role' ");

		if($result->num_rows>0) echo false;
		else echo true;
	}

	function validate_currentPass($currentPass){
		require_once('session.php');

		$user_id=$row['UserId'];
		$hash=substr(hash('sha256',$currentPass), 7,20);

		$result=$db->query("select Password from user where UserId='$user_id' ");
		$pass=$result->fetch_array(MYSQLI_ASSOC);
		
		if($pass['Password']==$hash) echo true;
		else echo false;
	}

	function validate_newSectorId($sectorId,$year){
		require_once('session.php');
		$result=$db->query("select SectorId from SectorBudget where SectorId='$sectorId' and Year='$year' ");
		if($result->num_rows>0){
			echo true;
		}
		else echo false;		
	}

	function validate_newSectorName($sectorName){
		require_once('session.php');
		$sectorName=strtolower($sectorName);
		$result=$db->query("select SectorId from sectors where LOWER(SectorName)='$sectorName' ");
		if($result->num_rows>0){
			echo true;
		}
		else echo false;		
	}

	function validate_newResourceId($resourceId,$year){
		require_once('session.php');
		$result=$db->query("select ResourceId from ResourceBudget where ResourceId='$resourceId' and Year='$year' ");
		if($result->num_rows>0){
			echo true;
		}
		else echo false;		
	}

	function validate_newResourceName($resourceName){
		require_once('session.php');
		$resourceName=strtolower($resourceName);
		$result=$db->query("select ResourceId from resources where LOWER(ResourceName)='$resourceName' ");
		if($result->num_rows>0){
			echo true;
		}
		else echo false;		
	}



	if (isset($_POST['itemId'])) {
        validate_email($_POST['itemId']);
    }
    
    else if(isset($_POST['pass'])){
    	validate_currentPass($_POST['pass']);
    }

    else if(isset($_POST['role'])){
    	validate_role($_POST['role']);
    }

    else if(isset($_POST['sectorId']) and isset($_POST['Year'])){
    	validate_newSectorId($_POST['sectorId'],$_POST['Year']);
    }

    else if(isset($_POST['sectorName'])){
    	validate_newSectorName($_POST['sectorName']);
    }

    else if(isset($_POST['resourceId']) and isset($_POST['Year'])){
    	validate_newResourceId($_POST['resourceId'],$_POST['Year']);
    }

    else if(isset($_POST['resourceName'])){
    	validate_newResourceName($_POST['resourceName']);
    }

 ?>