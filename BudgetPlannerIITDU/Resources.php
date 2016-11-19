<?php 
require_once('session.php');

$sql=$db->query("select * from budgetinitiation");
$result=$sql->fetch_array(MYSQLI_ASSOC);
$canEdit=$result['CanEdit'];
$Year=$result['Year'];
if($Year==0) $searchedYear=date('Y');
else $searchedYear=$Year-1;

if($sql->num_rows>0){
	$sqlBudget=$db->query("select resources.resourceId, resourceName, Amount from resources, resourceBudget where resources.resourceId=resourceBudget.resourceId and resourceBudget.Year= '$Year' ");	
}

if(isset($_GET['delete_id']))
{
	$deleted_ResourceId=$_GET['delete_id'];
	$sql_query="DELETE FROM resourceBudget WHERE resourceId='$deleted_ResourceId' and Year='$Year' ";
	$db->query($sql_query);
	header('location: Resources.php');
}

if($_SERVER["REQUEST_METHOD"]=="POST"){
	
	if(isset($_POST['prevResourceSubmit'])){
		$searchedYear=trim($_POST['year']);
	}

	else if(isset($_POST['submitBudget'])){
		while (list($resourceId,$resourceName)=$sqlBudget->fetch_row()) {
			$Amount=trim($_POST[$resourceId]);
			$db->query("UPDATE ResourceBudget SET Amount='$Amount' where ResourceId='$resourceId' and Year='$Year' ");
		}
		$sqlBudget=$db->query("select resources.resourceId, resourceName, Amount from resources, resourceBudget where resources.resourceId=resourceBudget.resourceId and resourceBudget.Year= '$Year' ");                  
	}
	else if(isset($_POST['addNewResourceSubmit1'])){

		$addedItem=trim($_POST['addNewResource']);
		$db->query("INSERT into resources (ResourceName) VALUES ('$addedItem' )"); 
		$Id=$db->insert_id;
		/*echo "<script> alert('$Id') </script>";*/
		$db->query("INSERT into ResourceBudget (ResourceId,Year,Amount) VALUES ('$Id', '$Year', '0')");
		header('location: Resources.php');		
	}
	else if(isset($_POST['addNewResource2Submit'])){
		$addedItemId=trim($_POST['addNewResource2']);
		echo "<script> alert('$addedItemId') </script>";
		$db->query("INSERT into ResourceBudget (ResourceId,Year,Amount) VALUES ('$addedItemId', '$Year', '0')");
		header('location: Resources.php');	
	}   
}

$sql_SearchedBudget=$db->query("select ResourceName, Amount from resources, ResourceBudget where resources.ResourceId=ResourceBudget.ResourceId and ResourceBudget.Year= '$searchedYear' ");

require_once('html/resources.html');
?>