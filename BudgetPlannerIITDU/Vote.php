<?php 
if($_SERVER["REQUEST_METHOD"]=="POST"){
         if(isset($_POST['voteSubmit'])){
            /*echo "<script> alert('Yse')</script>";
*/            
            $vote=trim($_POST['radgroup']);
            $comment=trim($_POST['comment']);

            $sqlVoteCmnt=$db->query("UPDATE user SET Vote='$vote', Comment='$comment' where UserId='".$row['UserId']."' ");

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
            header('location: Home.php');
      }

      if(isset($_POST['prevBudgetSubmit'])){
         $searchedYear=trim($_POST['year']);
      }
   }
?>