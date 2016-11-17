<?php
   require_once('config.php');
   session_start();
   
   $user_check = $_SESSION['login_user'];
   
   $ses_sql=$db->query("select * from user where Email = '$user_check' ");
   $row=$ses_sql->fetch_array(MYSQLI_ASSOC);
   
   if(!isset($_SESSION['login_user'])){
      header("location:login.php");
   }
?>