<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; Charset=UTF-8');
define("TIMEZONE", "India/Delhi");
define("CONTACT_EMAIL", "tudimechatapplication@gmail.com");
define("SMTP_DEBUG", 0);
define("SMTP_DEBUG_OUTPUT", "html");
define("SMTP_SECURE", "tls");
define("SMTP_PORT", "587");
define("SMTP_AUTH", true);
define("SMTP_HOST", "smtp.gmail.com");
define("SMTP_USERNAME", "tudimechatapplication@gmail.com");
define("SMTP_PASSWORD", "Drik2020");
define("MAIL_FROM_NAME", "TuDime OTP Verification.");
define("MAIL_FROM_EMAIL", "tudimechatapplication@gmail.com");
$task  = $_POST['task'];
if($task == 'send_mail'){
	if (!isset($_POST['text']) || trim($_POST['text']) == "") {
		$response = array("status" => "error", "error_message" => "provide text", 'success_message' => '', "data" => "");
	}elseif (!isset($_POST['email']) || trim($_POST['email']) == ""){
		$response = array("status" => "error", "error_message" => "provide email", 'success_message' => '', "data" => "");
	} else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$response = array("status" => "error", "error_message" => "Invalid email format", "success_message" => "", "data" => "");
	}else{
		$email_id = $_POST['email'];
        $user_service_taker_email = $email_id;
        $otp = '123';
        if($email_id == 'meorthodox2@gmail.com'){
            $otp = '123456';
        }
		$to = array(array('email'=>$user_service_taker_email, 'otp'=>$otp));
		$subject = "TuDime OTP Verification.";
		//$headers = "From:" . $c_email . "\r\n";
		//$headers .= "To:" . $to . "\r\n";
		//$msgg = "Dear friend"."<br><br>Thank you .<br><br>Your Account Has Been created.<br>Your Mail ID is ".$mail."<br><br> Your otp is ".$half."<br><br><a href=''>Reply From mylookbookproject@gmail.com</a><br><br>From,<br>mylookbookproject@gmail.com";
		$msgg = $_POST['text'];
		/*$msgg = "Hi  ".$_POST['first_name'].' '.$_POST['last_name']. "<br><br>";
		$msgg .= "Welcome to the family. <br><br>";
		$msgg .= "<img src='".$_SERVER['DOCUMENT_ROOT']."/mcs_0.1/images/logo.png' style='height:100px;width:180px;'/> <br>";
		$msgg .= "Please use our online tools to get over thousands of Ocean Freight / Air Freight quotes and get up to date prices from any carrier. <br>";
		$msgg .= "Thank you for registering with us. <br>";
		$msgg .= "www.onlinefrt.com <br>";
		$msgg .= "______________________________________________________________________________________<br>";
		$msgg .= "If you have any queries, please contact info@onlinefrt.com";*/
		if(sendMail($to, $subject, $msgg)) {
		 ///echo "Mailer Error: " . $mail->ErrorInfo;
            
			$response = array("status" => "success", "error_message" => "", "success_message" => "Mail sent successfully", "data" => "");
			//echo json_encode($response);

			
		}else{
	//        echo 'mail failure';
	//echo "Mailer Error: " . $mail->ErrorInfo;
			$response = array("status" => "error", "error_message" => "", "success_message" => "Network Problem.", "data" => ""); 
			//echo json_encode($response);die;
		}
		
	}
    
    
}else{
    $response = array("status" => "error", "error_message" => "task not found", "success_message" => '', "data" => '');
}

    
echo json_encode($response);

function sendMail($to,$subject, $msg, $cc=array(), $bcc=array(), $attachment=array()){
        //date_default_timezone_set(TIMEZONE);

        require_once 'PHPMailer-master/PHPMailerAutoload.php'; 

       //Create a new PHPMailer instance
        $mail = new PHPMailer();

       //Tell PHPMailer to use SMTP
        $mail->isSMTP();

       //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
       $mail->SMTPDebug = SMTP_DEBUG;

       //Ask for HTML-friendly debug output
        $mail->Debugoutput = SMTP_DEBUG_OUTPUT;

       //Set the hostname of the mail server
        $mail->Host = SMTP_HOST;

       //Set the SMTP port number - likely to be 25, 465 or 587
        $mail->Port = SMTP_PORT;

       //Set the encryption system to use - ssl (deprecated) or tls
        $mail->SMTPSecure = SMTP_SECURE;

       //Whether to use SMTP authentication
        $mail->SMTPAuth = SMTP_AUTH;

       //Username to use for SMTP authentication
        $mail->Username = SMTP_USERNAME;

       //Password to use for SMTP authentication
        $mail->Password = SMTP_PASSWORD;
        
        $mail->isHTML(true); 
        
       //Set who the message is to be sent from
        $mail->setFrom(MAIL_FROM_EMAIL, MAIL_FROM_NAME);

       //Set an alternative reply-to address
        //$mail->addReplyTo('replyto@example.com', 'First Last');
        //Set who the message is to be sent to
        foreach($to as $toMail){
         $mail->addAddress($toMail['email']); //$toMail['name']);//echo $toMail['email'];
         }

        foreach($cc as $ccMail)
         $mail->addAddress($ccMail['email'], $ccMail['name']);
        foreach($bcc as $bccMail)
         $mail->addAddress($bccMail['email'], $bccMail['name']);
        foreach($attachment as $attach)
         $mail->addAttachment($attach);

       //Set the subject line
        $mail->Subject = $subject;

       //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        $mail->msgHTML($msg);

       //Replace the plain text body with one created manually
        $mail->AltBody = $msg;

       //Attach an image file
        //$mail->addAttachment('images/phpmailer_mini.gif');

        //send the message, check for errors
        if (!$mail->send()){
       //     return false;
           if(defaultMailFallback($to,$subject, $msg) ){
               return TRUE;
           }
           else{
               return false;
           }

        }
        else{
         return true;
        }

    }


    function defaultMailFallback($to,$subject, $msg){

        $finaltoArr = array();
        foreach($to as $eachTo){
            $finaltoArr[] = $eachTo['email'];
        }
        if(count($finaltoArr)){
            $finalto = implode(',', $finaltoArr);

    //                echo $finalto;

            $subject2 = str_replace('<br>', "\r\n", $subject);
            $to      = $finalto;
            $headers = 'From: '.CONTACT_EMAIL . "\r\n" .
                'Reply-To: '.CONTACT_EMAIL . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            return mail($to, $subject2, $msg, $headers);
        }
        return false;
    }
    function defaultMailFallbackHTML($to,$subject, $msg){

        $finaltoArr = array();
        foreach($to as $eachTo){
            $finaltoArr[] = $eachTo['email'];
        }
        if(count($finaltoArr)){
            $finalto = implode(',', $finaltoArr);

    //        echo $finalto;

            // To send HTML mail, the Content-type header must be set
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1';

            // Additional headers
            $headers[] = 'To: '.$finalto;
            $headers[] = 'From: '.CONTACT_EMAIL;

            // Mail it
            return mail($to, $subject, $msg, implode("\r\n", $headers));
        }
        return false;
    }
?>