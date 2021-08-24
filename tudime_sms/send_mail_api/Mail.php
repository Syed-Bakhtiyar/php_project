<?php

class Mail {


    public function email_send($email,$text) {
        

                        require 'PHPMailerAutoload.php';
                        $mail = new PHPMailer(true);

                        $mail->IsSMTP(); 
                        $mail->SMTPAuth = true; 
                        $mail->SMTPSecure = "tls"; 
                        $mail->Host = "smtp.gmail.com"; 
                        $mail->Port = 587; 
                        $mail->Username = "otptudime@gmail.com"; 
                        $mail->Password = "Dirk2019"; 
                        $mail->AddAddress($email);
                        $mail->SetFrom('otptudime@gmail.com');
                        $mail->Subject = "OTP Verification";
                        $mail->Body = "$text";

                        try {
                            $mail->Send();

                            return '{"status":"1","msg":"Mail sent successfully"}';
                        } catch (Exception $e) {
                            
                         return '{"status":"0","msg":"Something went wrong"}';

                        }           


}

}
?>  

