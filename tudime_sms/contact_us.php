<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

header('Content-Type: application/json; Charset=UTF-8');





//$con=mysqli_connect("localhost","tudime_app","tudimeapp123");
//$db=mysqli_select_db($con,"tudimeapp");

include 'db_config/db_config.php';
include 'subscription_validation/subscription_validation.php';

$response = array();
$task = $_POST['task'];
$name = $_POST['name'];
$email = $_POST['email'];
$mobile_no = $_POST['mobile_no'];
$address = $_POST['address'];
$country = $_POST['country'];
$pincode = $_POST['pincode'];
$comments = $_POST['comments'];
$useid = $_POST['useid'];


if($task == 'contact_us'){
	if (!isset($_POST['name']) || trim($_POST['name']) == "") {
		$response = array("status" => "error", "error_message" => "provide name", 'success_message' => '', "data" => "");
	}elseif (!isset($_POST['email']) || trim($_POST['email']) == ""){
		$response = array("status" => "error", "error_message" => "provide email", 'success_message' => '', "data" => "");
	}elseif (!isset($_POST['mobile_no']) || trim($_POST['mobile_no']) == ""){
		$response = array("status" => "error", "error_message" => "provide mobile no", 'success_message' => '', "data" => "");
	}elseif (!isset($_POST['address']) || trim($_POST['address']) == ""){
		$response = array("status" => "error", "error_message" => "provide address", 'success_message' => '', "data" => "");
	}elseif (!isset($_POST['country']) || trim($_POST['country']) == ""){
		$response = array("status" => "error", "error_message" => "provide country", 'success_message' => '', "data" => "");
	}elseif (!isset($_POST['pincode']) || trim($_POST['pincode']) == ""){
		$response = array("status" => "error", "error_message" => "provide pincode", 'success_message' => '', "data" => "");
	}elseif (!isset($_POST['comments']) || trim($_POST['comments']) == ""){
		$response = array("status" => "error", "error_message" => "provide comments", 'success_message' => '', "data" => "");
	}elseif (!isset($_POST['useid']) || trim($_POST['useid']) == ""){
		$response = array("status" => "error", "error_message" => "provide useid", 'success_message' => '', "data" => "");
	}else{
		$isSubscriptionValidate = isUserSubscriptionValid($useid);
		if(!$isSubscriptionValidate){
			$response = array("status" => "error", "error_message" => "Your subscription has expired, please activate it by purchasing one year subscription.", 'success_message' => '', "data" => "");
		} else {
			$sql = "INSERT INTO `contact_us`(`name`,`email`,`mobile_no`,`address`,`country`,`pincode`,`comments`)VALUES('".$_POST['name']."','".$_POST['email']."','".$_POST['mobile_no']."','".$_POST['address']."','".$_POST['country']."','".$_POST['pincode']."','".$_POST['comments']."') ";
			$result = mysqli_query($con,$sql);
			$response = array("status" => "success", "error_message" => "", "success_message" => "inserted successfully.", "data" => '1');
		}
	}
    
    
}else if($task == 'verify_otp'){
    if (!isset($_POST['mobile_no']) || trim($_POST['mobile_no']) == "") {
		$response = array("status" => "error", "error_message" => "provide mobile number", 'success_message' => '', "data" => "");
	}elseif (!isset($_POST['otp']) || trim($_POST['otp']) == ""){
		$response = array("status" => "error", "error_message" => "provide otp number", 'success_message' => '', "data" => "");
	}elseif (!isset($_POST['useid']) || trim($_POST['useid']) == ""){
		$response = array("status" => "error", "error_message" => "provide useid", 'success_message' => '', "data" => "");
	}else{
		$isSubscriptionValidate = isUserSubscriptionValid($useid);
		if(!$isSubscriptionValidate){
			$response = array("status" => "error", "error_message" => "Your subscription has expired, please activate it by purchasing one year subscription.", 'success_message' => '', "data" => "");
		} else {
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
	}
    
}else{
    $response = array("status" => "error", "error_message" => "task not found", "success_message" => '', "data" => '');
}

    
echo json_encode($response);


?>