<?php 
	require_once('BudgetCommitteeMemberUser_check.php');

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

   $canComment=false;

   $sql=$db->query("select * from budgetinitiation");
   $result=$sql->fetch_array(MYSQLI_ASSOC);
   $Year=$result['Year'];
   $searchedYear=$Year-1;
   require_once('Vote.php');

   


   
   /*if($_SERVER["REQUEST_METHOD"]=="POST"){*/

/*   }
*/      /*echo "<script> alert('$searchedYear') </script>";*/
   $sql_SearchedBudget=$db->query("select SectorName, Amount from sectors, sectorBudget where sectors.SectorId=sectorBudget.SectorId and sectorBudget.Year= '$searchedYear' ");
   
   if($sql->num_rows>0){
      /*echo "<script> alert('".$result['CanEdit']."'')</script>";*/
   		if($result['CanEdit']=='0' and $row['Vote']==NULL){ 
            /*echo "<script> alert('Yaeh')</script>";*/       
   			$canComment=true;
         }
   		$sqlBudget=$db->query("select sectors.SectorId, SectorName, Amount from sectors, sectorBudget where sectors.SectorId=sectorBudget.SectorId and sectorBudget.Year= '$Year' ");
   }
	
	require_once('html/Home.html');
 ?>