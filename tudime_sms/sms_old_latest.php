<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

header('Content-Type: application/json; Charset=UTF-8');

require __DIR__ . '/Twilio/autoload.php';
// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;

//echo phpversion();die;

//require __DIR__ . '/Twilio/autoload.php';

// Use the REST API Client to make requests to the Twilio REST API
//use Twilio\Rest\Client;

//$sid = "AC2831162b64712ab8d9edfc352c39f54e"; // Your Account SID from www.twilio.com/console
//$token = "b002c18dbde25d146c7686cd8b7d67aa"; // Your Auth Token from www.twilio.com/console
//
//$client = new Twilio\Rest\Client($sid, $token);
//$message = $client->messages->create(
//  '+918777836924', // Text this number
//  [
//    'from' => '+12029529782', // From a valid Twilio number
//    'body' => 'Hello from Twilio!'
//  ]
//);
//
//print $message->sid;
//
//die;



//$con=mysqli_connect("localhost","tudime_app","tudimeapp123");
//$db=mysqli_select_db($con,"tudimeapp");

$con=mysqli_connect("localhost","root","IpTv@2019");
$db=mysqli_select_db($con,"tudime_sms");

$response = array();
$task = $_POST['task'];
$mobile_no = $_POST['mobile_no'];


if($task == 'send_otp'){
	if (!isset($_POST['mobile_no']) || trim($_POST['mobile_no']) == "") {
		$response = array("status" => "error", "error_message" => "provide mobile number", 'success_message' => '', "data" => "");
	}else{
		$randum_unique_code = substr(number_format(time() * rand(),0,'',''),0,6);
		
		$sql2 = "SELECT * FROM mobile_otp_tbl WHERE `mobile_no` ='".$mobile_no."' ";
		$result_mobile_otp_histroy = mysqli_query($con,$sql2);
		mysqli_set_charset($con,"utf8");
		while($row = mysqli_fetch_assoc($result_mobile_otp_histroy)){
			$result_data_otp_histroy[] = $row;
		}
		if($result_data_otp_histroy > 0){
			//$data = send_otp_on_mobile($_POST['mobile_no'],$randum_unique_code);
                        $sid = "AC2831162b64712ab8d9edfc352c39f54e"; // Your Account SID from www.twilio.com/console
                        $token = "b002c18dbde25d146c7686cd8b7d67aa"; // Your Auth Token from www.twilio.com/console
                        $mobile_number = "'+".$_POST['mobile_no']."'";
                        $client = new Twilio\Rest\Client($sid, $token);
                        $message = $client->messages->create(
                          $mobile_number, // Text this number
                          [
                                'from' => '+12029529782', // From a valid Twilio number
                                'body' => 'Hello Welcome to tudime! Your OTP Is '.$randum_unique_code , 
                          ]
                        );

                        $data = $message->sid;
			$sql = "UPDATE mobile_otp_tbl SET `otp`='".$randum_unique_code."' WHERE `mobile_no`='".$_POST['mobile_no']."' ";
                        $result = mysqli_query($con,$sql);
			$response = array("status" => "success", "error_message" => "", "success_message" => "Otp has  been send your mobile number", "data" => $randum_unique_code);
		}else{
			//$data = send_otp_on_mobile($_POST['mobile_no'],$randum_unique_code);
                        $sid = "AC2831162b64712ab8d9edfc352c39f54e"; // Your Account SID from www.twilio.com/console
                        $token = "b002c18dbde25d146c7686cd8b7d67aa"; // Your Auth Token from www.twilio.com/console
                        $mobile_number = "'+".$_POST['mobile_no']."'";
                        $client = new Twilio\Rest\Client($sid, $token);
                        $message = $client->messages->create(
                          $mobile_number, // Text this number
                          [
                                'from' => '+12029529782', // From a valid Twilio number
                                'body' => 'Hello Welcome to tudime! Your OTP Is '.$randum_unique_code , 
                          ]
                        );

                        $data = $message->sid;
			$sql = "INSERT INTO `mobile_otp_tbl`(`mobile_no`,`otp`)VALUES('".$_POST['mobile_no']."','".$randum_unique_code."') ";
                        $result = mysqli_query($con,$sql);
			$response = array("status" => "success", "error_message" => "", "success_message" => "Otp has  been send your mobile number", "data" => $randum_unique_code);
		}
	}
    
    
}else if($task == 'verify_otp'){
    if (!isset($_POST['mobile_no']) || trim($_POST['mobile_no']) == "") {
		$response = array("status" => "error", "error_message" => "provide mobile number", 'success_message' => '', "data" => "");
	}elseif (!isset($_POST['otp']) || trim($_POST['otp']) == ""){
		$response = array("status" => "error", "error_message" => "provide otp number", 'success_message' => '', "data" => "");
	}else{
		
                //$newmob = str_replace ( "+","", $_POST['mobile_no'] );
				$newmob =	'+'.trim($_POST['mobile_no']);
		$sql2 = "SELECT * FROM mobile_otp_tbl WHERE `mobile_no` ='".$newmob."' ORDER BY `id` DESC LIMIT 1 ";
		$result_mobile_otp_histroy = mysqli_query($con,$sql2);
		mysqli_set_charset($con,"utf8");
		while($row = mysqli_fetch_assoc($result_mobile_otp_histroy)){
			$result_data_otp_histroy[] = $row;
		}
		$otp_db = $result_data_otp_histroy[0]['otp'];
		if($otp_db == $_POST['otp']){
			$response = array("status" => "success", "error_message" => "", "success_message" => "Otp verify successfull", "data" => $_POST['mobile_no']);
		}else{
			$response = array("status" => "error", "error_message" => "Invalid OTP..", 'success_message' => '', "data" => "");
		}
		
	}
    
}else{
    $response = array("status" => "error", "error_message" => "task not found", "success_message" => '', "data" => '');
}

    
echo json_encode($response);

/*function send_otp_on_mobile($mobile_number,$otp){
	
	$sid = "AC2831162b64712ab8d9edfc352c39f54e"; // Your Account SID from www.twilio.com/console
	$token = "b002c18dbde25d146c7686cd8b7d67aa"; // Your Auth Token from www.twilio.com/console

	$client = new Twilio\Rest\Client($sid, $token);
	$message = $client->messages->create(
	  $mobile_number, // Text this number
	  [
		'from' => '+12029529782', // From a valid Twilio number
		'body' => 'Hello Welcome to tudime! Your OTP Is ' , 
	  ]
	);
	
	return $message->sid;
	//print $message->sid;	
	
}*/
?>