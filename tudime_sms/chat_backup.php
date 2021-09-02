<?php
//header('Content-Type: application/json; Charset=UTF-8');



include 'db_config/db_config.php';
include 'subscription_validation/subscription_validation.php';

$response = array();
$task = $_POST['task'];
//$chatdialog_id = $_POST['chatdialog_id'];
//$custom_data = $_POST['custom_data'];

$UserID = $_POST['UserID'];
$Backup_TimeStamp = $_POST['Backup_TimeStamp'];
$fileZip = $_FILES['fileZip'];
$device_type = $_POST['device_type'];

//echo '<pre>';
//print_r($_POST);
//print_r($_FILES);
//die;

if($task == 'chat_backup'){
	
	if (!isset($_POST['UserID']) || trim($_POST['UserID']) == "") {
		$response = array("status" => "error", "error_message" => "provide UserID", 'success_message' => '', "data" => "");
	} else{
		//if(isset($_FILES['fileZip'])){
		$isSubscriptionValidate = isUserSubscriptionValid($UserID);
		if(!$isSubscriptionValidate){
			$response = array("status" => "error", "error_message" => "useid is subscription", 'success_message' => 'Your subscription has expired, please activate it by purchasing one year subscription.', "data" => "");
		} else {
			$errors= array();
			$file_name = $_FILES['fileZip']['name'];
			$file_size =$_FILES['fileZip']['size'];
			$file_tmp =$_FILES['fileZip']['tmp_name'];
			$file_type=$_FILES['fileZip']['type'];
			$explodeResult = explode('.',$_FILES['fileZip']['name']);
			$file_ext=strtolower(end($explodeResult));
			
			$extensions= array("jpeg","jpg","png");
			
			/*if(in_array($file_ext,$extensions)=== false){
				$errors[]="extension not allowed, please choose a JPEG or PNG file.";
			}
			
			if($file_size > 2097152){
				$errors[]='File size must be excately 2 MB';
			}*/
			
			//if(empty($errors)==true){
			move_uploaded_file($file_tmp,"chat_backup_file/".$file_name);
			$sql = "INSERT INTO `chat_backup_tbl`(`UserID`,`Backup_TimeStamp`,`fileZip`,`device_type`)VALUES('".$UserID."','".$Backup_TimeStamp."','".$file_name."','".$device_type."') ";
			$result = mysqli_query($con,$sql);
			$last_id = mysqli_insert_id($con);
			$response = array("status" => "success", "error_message" => "", "success_message" => "insert successfull.", "data" => array('id'=>$last_id));
			//}else{
				//$response = array("status" => "error", "error_message" => "insert failure.", 'success_message' => '', "data" => "");
			//}
		//}	
		}
	}
}else if($task == 'get_chat_backup'){
    if (!isset($_POST['UserID']) || trim($_POST['UserID']) == "") {
		$response = array("status" => "error", "error_message" => "provide UserID", 'success_message' => '', "data" => "");
	}else if(!isset($_POST['device_type']) || trim($_POST['device_type']) == ""){
		$response = array("status" => "error", "error_message" => "provide Device type", 'success_message' => '', "data" => "");
	}else{
				
		$isSubscriptionValidate = isUserSubscriptionValid($UserID);
		if(!$isSubscriptionValidate){
			$response = array("status" => "error", "error_message" => "useid is subscription", 'success_message' => 'Your subscription has expired, please activate it by purchasing one year subscription.', "data" => "");
		} else {
			$sql2 = "SELECT * FROM chat_backup_tbl WHERE `UserID` ='".$_POST['UserID']."' AND `device_type`= '".$_POST['device_type']."'  ORDER BY `id` DESC LIMIT 1 ";
			$result_img_link = mysqli_query($con,$sql2);
			mysqli_set_charset($con,"utf8");
			while($row = mysqli_fetch_assoc($result_img_link)){
				$result_data[] = $row;
			}
			$file_db_link = 'http://'.$_SERVER['HTTP_HOST'].'/tudime_sms/chat_backup_file/'.$result_data[0]['fileZip'];
			$custom_data = $result_data[0];
			if($otp_db == $_POST['otp']){
				$response = array("status" => "success", "error_message" => "", "success_message" => "img get successfull", "data" => array('file_link'=>$file_db_link,'custom_data'=>$custom_data));
			}else{
				$response = array("status" => "error", "error_message" => "Invalid id..", 'success_message' => '', "data" => "");
			}
		}
	}
    
}else{
    $response = array("status" => "error", "error_message" => "task not found", "success_message" => '', "data" => '');
}

    
echo json_encode($response);


?>