<<<<<<< HEAD
<?php 
	require_once('AdminUser_check.php');
	require_once("mailconfig.php");
	$error_message="";

	if(isset($_GET['delete_id']))
	{

	$sql=$db->query("select * from budgetinitiation where Status='0' ");
	if($sql->num_rows>0){
		echo "<script>alert('User cannot be removed in the middle of Budget process !')</script>";
	}
	else{
		$sql_query="DELETE FROM user WHERE UserId=".$_GET['delete_id'];
     	$db->query($sql_query);	
	}
     
	}

	if($_SERVER["REQUEST_METHOD"]=="POST"){

		$sql=$db->query("select * from budgetinitiation where Status='0' ");
		if($sql->num_rows>0){
			echo "<script>alert('User cannot be added in the middle of Budget process !')</script>";
		}

		else{

			$Name=trim($_POST['name']);
			$Email=trim($_POST['email']);
			$Role=trim($_POST['radgroup']);

			$Password=substr(hash('sha256',$Email.time()), 10,20);
    		$subject  =   "User Registration";
    		$message  =   "<div>" . $Name . ",You have been registered to <b> Budget PlannerIITDU </b> <br>
    		Your password is : ".$Password."<br>Please click to the link <a href='http://localhost/BudgetPlanner/'>Budget Planner IITDU</a> to login to the website </div>";
    		$name     =   "Budget Planner";
	    	$mailsend =   sendmail($Email,$subject,$message,$name);
	    	if($mailsend==1){
	    		echo "Mail has been sent";
	    		$hash=substr(hash('sha256',$Password), 7,20);
	    		$sql = "INSERT INTO user (Name,Email,Password,Role)
				VALUES ('$Name', '$Email', '$hash','$Role')";	
				$db->query($sql);
	    	}

		}
		
	}

	$result1=$db->query("select UserId, Name,Email from user where Role='2'");
	$result2=$db->query("select UserId, Name,Email from user where Role='3'");

	require_once('html/Users.html');

?>

=======
<?php 
	require_once('AdminUser_check.php');
	require_once("mailconfig.php");
	$error_message="";

	if(isset($_GET['delete_id']))
	{

	$sql=$db->query("select * from budgetinitiation where Status='0' ");
	if($sql->num_rows>0){
		echo "<script>alert('User cannot be removed in the middle of Budget process !')</script>";
	}
	else{
		$sql_query="DELETE FROM user WHERE UserId=".$_GET['delete_id'];
     	$db->query($sql_query);	
	}
     
	}

	if($_SERVER["REQUEST_METHOD"]=="POST"){

		$sql=$db->query("select * from budgetinitiation where Status='0' ");
		if($sql->num_rows>0){
			echo "<script>alert('User cannot be added in the middle of Budget process !')</script>";
		}

		else{

			$Name=trim($_POST['name']);
			$Email=trim($_POST['email']);
			$Role=trim($_POST['radgroup']);

			$Password=substr(hash('sha256',$Email.time()), 10,20);
    		$subject  =   "User Registration";
    		$message  =   "<div>" . $Name . ",You have been registered to <b> Budget PlannerIITDU </b> <br>
    		Your password is : ".$Password."<br>Please click to the link <a href='http://localhost/BudgetPlanner/'>Budget Planner IITDU</a> to login to the website </div>";
    		$name     =   "Budget Planner";
	    	$mailsend =   sendmail($Email,$subject,$message,$name);
	    	if($mailsend==1){
	    		echo "Mail has been sent";
	    		$hash=substr(hash('sha256',$Password), 7,20);
	    		$sql = "INSERT INTO user (Name,Email,Password,Role)
				VALUES ('$Name', '$Email', '$hash','$Role')";	
				$db->query($sql);
	    	}

		}
		
	}

	$result1=$db->query("select UserId, Name,Email from user where Role='2'");
	$result2=$db->query("select UserId, Name,Email from user where Role='3'");

	require_once('html/Users.html');

?>

>>>>>>> a23ea29b4172790faf33b8da896cce0a74587b57
