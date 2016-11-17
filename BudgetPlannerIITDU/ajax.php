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

	if (isset($_POST['itemId'])) {
        validate_email($_POST['itemId']);
    }
    
    if(isset($_POST['pass'])){
    	validate_currentPass($_POST['pass']);
    }

    if(isset($_POST['role'])){
    	validate_role($_POST['role']);
    }
 ?>