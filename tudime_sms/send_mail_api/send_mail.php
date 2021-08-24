<?php

include_once('Mail.php');

$funObj = new Mail();

if (isset($_POST['email']) && isset($_POST['text']) ) {

    $email = $_POST['email'];
    $text = $_POST['text'];

    if (!$email=="" && !$text=="") {

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                $user= $funObj->email_send($email,$text);

                if($user){
                    echo $user;
                }
                else{
                    echo $user;
                }

            }
            else{

                echo '{"status":"0","msg":"Invalid email format"}';
            }
    		
    }
    else{
         echo '{"status":"0","msg":"Fill both fields"}';
    }
  }  
  else{
    echo '{"status":"0","msg":"Wrong parameter"}';
  }

?>