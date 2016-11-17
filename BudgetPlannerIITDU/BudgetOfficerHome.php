<?php 
	require_once('BudgetOfficerUser_check.php');
   require_once('mailconfig.php');

      $checkIfanyNULL=$db->query("select UserId from user where Vote IS NULL and Role!='3' ");
      if($checkIfanyNULL->num_rows==0){
               $checkIfAnyNo=$db->query("select UserId from user where Vote='0' ");
               if($checkIfAnyNo->num_rows==0){
                  $finalizeBudget=$db->query("UPDATE budgetinitiation SET Status='1' ");
               }
               else{
                  $db->query("UPDATE budgetinitiation SET CanEdit='1' ");
                  $db->query("UPDATE user SET Vote = NULL, Comment = NULL where Role!='3' ");
               }
      }
      /*header('location: Home.php');*/
	
	   $sql=$db->query("select * from budgetinitiation where Status='0' ");
   	$result=$sql->fetch_array(MYSQLI_ASSOC);
   	$canEdit=$result['CanEdit'];
   	$Year=$result['Year'];

      if(isset($_GET['delete_id']))
      {
         $deleted_SectorId=$_GET['delete_id'];
         $sql_query="DELETE FROM sectorBudget WHERE SectorId='$deleted_SectorId' and Year='$Year' ";
         $db->query($sql_query);
      }


      $searchedYear=$Year-1;
      /*echo "<script> alert('$searchedYear') </script>";*/ 
      if($sql->num_rows>0){
   		
   		$sqlBudget=$db->query("select sectors.SectorId, SectorName, Amount from sectors, sectorBudget where sectors.SectorId=sectorBudget.SectorId and sectorBudget.Year= '$Year' ");
   		

   		if($_SERVER["REQUEST_METHOD"]=="POST"){
            
            if(isset($_POST['prevBudgetSubmit'])){
               $searchedYear=trim($_POST['year']);
            }

            else{
                  while (list($SectorId,$SectorName)=$sqlBudget->fetch_row()) {
                  $Amount=trim($_POST[$SectorId]);
                  /*echo "<script> alert($Amount) </script>";*/
                  $db->query("UPDATE sectorBudget SET Amount='$Amount' where SectorId='$SectorId' and Year='$Year' ");

                  }

                  $db->query("UPDATE budgetinitiation SET CanEdit='0' where Year='$Year' ");
                  $canEdit='0';

                  $myuserId=$row['UserId'];
                  $result=$db->query("select Name, Email from user where UserId!='$myuserId' ");
                     
                  $subject  =   "Budget ".$Year;
                  $message  =   "<div> A draft Budget ".$Year." has been created. Please response by giving your vote and comment. </div>";
                  $mailsend =   sendmailToAll($result,$subject,$message);               
   
            }	
   		}


 }
   $sqlBudget=$db->query("select sectors.SectorId, SectorName, Amount from sectors, sectorBudget where sectors.SectorId=sectorBudget.SectorId and sectorBudget.Year= '$Year' ");

   $sql_SearchedBudget=$db->query("select SectorName, Amount from sectors, sectorBudget where sectors.SectorId=sectorBudget.SectorId and sectorBudget.Year= '$searchedYear' ");
	
	require_once('html/Home.html');
?>