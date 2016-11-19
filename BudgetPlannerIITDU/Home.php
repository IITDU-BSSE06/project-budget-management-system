<?php 
require_once('session.php');
require_once('mailconfig.php');

$sql=$db->query("select * from budgetinitiation");
$result=$sql->fetch_array(MYSQLI_ASSOC);
$Year=$result['Year'];
if($Year==0) $searchedYear=date('Y');
else $searchedYear=$Year-1;

if($sql->num_rows>0){
    $sqlBudget=$db->query("select sectors.SectorId, SectorName, Amount from sectors, sectorBudget where sectors.SectorId=sectorBudget.SectorId and sectorBudget.Year= '$Year' ");
}

if(isset($_GET['delete_id'])){
    $deleted_SectorId=$_GET['delete_id'];
    $sql_query="DELETE FROM sectorBudget WHERE SectorId='$deleted_SectorId' and Year='$Year' ";
    $db->query($sql_query);
    header('location: Home.php');
}


if($_SERVER["REQUEST_METHOD"]=="POST"){
    //echo "<script> alert('djdhdjdh')</script>";
    if(isset($_POST['voteSubmit'])){ 
        
        $vote=trim($_POST['radgroup']);
        $comment=mysqli_real_escape_string($db,$_POST['comment']);
        $sqlVoteCmnt=$db->query("UPDATE user SET Vote='$vote', Comment='$comment' where UserId='".$row['UserId']."' ");
        header('location: Home.php');
    }
    else if(isset($_POST['prevBudgetSubmit'])){
        $searchedYear=trim($_POST['year']);
    }

    else if(isset($_POST['addNewSectorSubmit1'])){

        $addedItem=mysqli_real_escape_string($db,trim($_POST['addNewSector']));
        $db->query("INSERT into sectors (SectorName) VALUES ('$addedItem' )"); 
        $Id=$db->insert_id;
        /*echo "<script> alert('$Id') </script>";*/
        $db->query("INSERT into SectorBudget (SectorId,Year,Amount) VALUES ('$Id', '$Year', '0')");
        header('location: Home.php');      
    }
    else if(isset($_POST['addNewSector2Submit'])){
        $addedItemId=trim($_POST['addNewSector2']);
        echo "<script> alert('$addedItemId') </script>";
        $db->query("INSERT into SectorBudget (SectorId,Year,Amount) VALUES ('$addedItemId', '$Year', '0')");
        header('location: Home.php');  
    }

    else if(isset($_POST['submitBudget'])){
        while (list($SectorId,$SectorName)=$sqlBudget->fetch_row()) {
            $Amount=trim($_POST[$SectorId]);
            $db->query("UPDATE sectorBudget SET Amount='$Amount' where SectorId='$SectorId' and Year='$Year' ");
        }

        $myuserId=$row['UserId'];
        $userToSendMail=$db->query("select Name, Email from user where UserId!='$myuserId' ");
            
        $subject  =   "Budget ".$Year;
        $message  =   "<div> A draft Budget ".$Year." has been created. Please response by giving your vote and comment. </div>";
        $mailsend =   sendmailToAll($userToSendMail,$subject,$message);
        if($mailsend==1){
            $db->query("UPDATE budgetinitiation SET CanEdit='0' where Year='$Year' ");
            $db->query("UPDATE user SET Vote = NULL, Comment = NULL where Role!='3' ");
            header('location: Home.php');    
        }
        else{
            echo "<script>alert('There was a problem to send mail. Try again !')</script>";
        }
    }   
} 

$checkIfanyNULL=$db->query("select UserId from user where Vote IS NULL and Role!='3' ");
if($checkIfanyNULL->num_rows==0){
    $checkIfAnyNo=$db->query("select UserId from user where Vote='0' ");
    if($checkIfAnyNo->num_rows==0){
        $finalizeBudget=$db->query("UPDATE budgetinitiation SET Status='1' ");
    }
    else{
        $db->query("UPDATE budgetinitiation SET CanEdit='1' ");
    }
}
     
$sql_SearchedBudget=$db->query("select SectorName, Amount from sectors, sectorBudget where sectors.SectorId=sectorBudget.SectorId and sectorBudget.Year= '$searchedYear' "); 

require_once('html/Home.html');
?>