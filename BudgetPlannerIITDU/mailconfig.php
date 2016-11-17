<?php 
require_once('session.php');
require_once( 'PHPMailer/PHPMailerAutoload.php');

function sendmail($to,$subject,$message,$name){

                  $mail             = new PHPMailer();
                  $body             = $message;
                  $mail->IsSMTP();
                  $mail->SMTPAuth   = true;
                  $mail->Host       = "smtp.gmail.com";
                  $mail->Port       = 587;
                  $mail->Username   = "auser062013";
                  $mail->Password   = "iitdu123";
                  $mail->SMTPSecure = 'tls';
                  $mail->SetFrom('auser062013@gmail.com', 'Online Budget Planner ,IIT, University of Dhaka');
                  /*$mail->AddReplyTo("youraccount@gmail.com","Your name");*/
                  $mail->Subject    = $subject;
                  //$mail->AltBody    = "Any message.";
                  $mail->MsgHTML($body);
                  $address = $to;
                  $mail->AddAddress($address, $name);
                  
                  if(!$mail->Send())return 0;
                  else return 1;
}

function sendmailToAll($to,$subject,$message){

                  $mail             = new PHPMailer();
                  $body             = $message;
                  $mail->IsSMTP();
                  $mail->SMTPAuth   = true;
                  $mail->Host       = "smtp.gmail.com";
                  $mail->Port       = 587;
                  $mail->Username   = "auser062013";
                  $mail->Password   = "iitdu123";
                  $mail->SMTPSecure = 'tls';
                  $mail->SetFrom('auser062013@gmail.com', 'Online Budget Planner ,IIT, University of Dhaka');
                  /*$mail->AddReplyTo("youraccount@gmail.com","Your name");*/
                  $mail->Subject    = $subject;
                  //$mail->AltBody    = "Any message.";
                  $mail->MsgHTML($body);

                  while(list($Name,$Email)=$to->fetch_row()){

                        $mail->AddCC($Email,$Name);
                  }
                  
                  if(!$mail->Send())return 0;
                  else return 1;
}

?>