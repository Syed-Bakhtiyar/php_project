<?php
header('Content-Type: application/json; Charset=UTF-8');



include 'db_config/db_config.php';
include 'subscription_validation/subscription_validation.php';

$response = array();
$task = $_POST['task'];
$useid = $_POST['useid'];
//$chatdialog_id = $_POST['chatdialog_id'];
//$custom_data = $_POST['custom_data'];


if (!isset($_POST['useid']) || trim($_POST['useid']) == "") {
	$response = array("status" => "error", "error_message" => "provide useid", 'success_message' => '', "data" => "");
} else {
	$isSubscriptionValidate = isUserSubscriptionValid($useid);
	if(!$isSubscriptionValidate){
		$response = array("status" => "error", "error_message" => "Your subscription has expired, please activate it by purchasing one year subscription.", 'success_message' => '', "data" => "");
	} else {
		if(isset($_FILES['store_chat_file'])){
			$errors= array();
			$file_name = $_FILES['store_chat_file']['name'];
			$file_size =$_FILES['store_chat_file']['size'];
			$file_tmp =$_FILES['store_chat_file']['tmp_name'];
			$file_type=$_FILES['store_chat_file']['type'];
			$file_ext=strtolower(end(explode('.',$_FILES['store_chat_file']['name'])));
			
			$extensions= array();//array("jpeg","jpg","png");
			
			if(in_array($file_ext,$extensions)=== false){
			   $errors[]="extension not allowed, please choose a JPEG or PNG file.";
			}
			
			/*if($file_size > 2097152){
			   $errors[]='File size must be excately 2 MB';
			}*/
			
			$path = "file_store/";
			  $path = $path . basename( $_FILES['store_chat_file']['name']);
	
			  if(move_uploaded_file($_FILES['store_chat_file']['tmp_name'], $path)) {
				//echo "The file ".  basename( $_FILES['store_chat_file']['name']). 
				//" has been uploaded";
				$sql = "INSERT INTO `tb_store_chat_file`(`store_chat_file`)VALUES('".$file_name."') ";
				  $result = mysqli_query($con,$sql);
				  $last_id = mysqli_insert_id($con);
				  $response = array("status" => "success", "error_message" => "", "success_message" => "insert successfull.", "data" => "http://$_SERVER[HTTP_HOST]".'/tudime_sms/file_store/'.$file_name);
			  } else{
				  $response = array("status" => "error", "error_message" => "insert failure.", 'success_message' => '', "data" => $path);
			  }
			
			//if(empty($errors)==true){
			  //move_uploaded_file($file_tmp,"file_store/".$file_name);
			  //$sql = "INSERT INTO `tb_store_chat_file`(`store_chat_file`)VALUES('".$file_name."') ";
			  ///$result = mysqli_query($con,$sql);
			  //$last_id = mysqli_insert_id($con);
			  //$response = array("status" => "success", "error_message" => "", "success_message" => "insert successfull.", "data" => 'http://18.219.14.108/tudime_sms/file_store/'.$file_name);
			//}else{
			   //$response = array("status" => "error", "error_message" => "insert failure.", 'success_message' => '', "data" => "");
			//}
		}
	}
	
}

	
		
	
		
	
    
    


    
echo json_encode($response);


?>