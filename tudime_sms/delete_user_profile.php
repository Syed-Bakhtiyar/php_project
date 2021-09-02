<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

header('Content-Type: application/json; Charset=UTF-8');



include 'db_config/db_config.php';
include 'subscription_validation/subscription_validation.php';

$response = array();
$task = $_POST['task'];
$id = $_POST['userid'];



    if (!isset($_POST['userid']) || trim($_POST['userid']) == "") 
	{
		$response = array("status" => "error", "error_message" => "provide user id", 'success_message' => '', "data" => "");
	}
	else
	{
		$isSubscriptionValidate = isUserSubscriptionValid($id);
		if(!$isSubscriptionValidate){
			$response = array("status" => "error", "error_message" => "useid is subscription", 'success_message' => 'Your subscription has expired, please activate it by purchasing one year subscription.', "data" => "");
		} else {
			$sql2 = "Delete FROM user_tbl WHERE `id` ='".$id."'  ";
			$result_user_histroy = mysqli_query($con,$sql2);
			mysqli_set_charset($con,"utf8");
			
			$sql3 = "Delete FROM tbl_user_profile_image WHERE `user_id` ='".$id."'  ";
			$result_user_histroy1 = mysqli_query($con,$sql3);
			mysqli_set_charset($con,"utf8");
			
			$sql4 = "Delete FROM chat_backup_tbl WHERE `UserID` ='".$id."'  ";
			$result_user_histroy2 = mysqli_query($con,$sql4);
			mysqli_set_charset($con,"utf8");
			
			//$sql5 = "Delete FROM buy_tudime_subscription WHERE `useid` ='".$id."'  ";
			//$result_user_histroy3 = mysqli_query($con,$sql5);
			//mysqli_set_charset($con,"utf8");
			
			
			
			$response = array("status" => "success", "error_message" => "", "success_message" => "user profile deleted.", "data" => '');
		}		
	}
    


    
echo json_encode($response);


?>