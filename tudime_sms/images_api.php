<?php
header('Content-Type: application/json; Charset=UTF-8');



$con=mysqli_connect("localhost","root","IpTv@2019");
$db=mysqli_select_db($con,"tudime_sms");

$response = array();
$task = $_POST['task'];
$chatdialog_id = $_POST['chatdialog_id'];
$custom_data = $_POST['custom_data'];


if($task == 'image_upload'){
	$sql2 = "SELECT * FROM chat_img_tbl WHERE `chatdialog_id` ='".$chatdialog_id."' ORDER BY `id` DESC LIMIT 1 ";
	$result_id = mysqli_query($con,$sql2);
	mysqli_set_charset($con,"utf8");
	while($row = mysqli_fetch_assoc($result_id)){
		$result_data_id[] = $row;
	}
	$result_data_id_db = $result_data_id[0]['id'];
	if($result_data_id_db != ''){
		//if(isset($_FILES['chat_dialog_picture'])){
		  $errors= array();
		  $file_name = $_FILES['chat_dialog_picture']['name'];
		  $file_size =$_FILES['chat_dialog_picture']['size'];
		  $file_tmp =$_FILES['chat_dialog_picture']['tmp_name'];
		  $file_type=$_FILES['chat_dialog_picturechat_dialog_picture']['type'];
		  $file_ext=strtolower(end(explode('.',$_FILES['chat_dialog_picture']['name'])));
		  
		  $extensions= array("jpeg","jpg","png");
		  
		  if(in_array($file_ext,$extensions)=== false){
			 $errors[]="extension not allowed, please choose a JPEG or PNG file.";
		  }
		  
		  /*if($file_size > 2097152){
			 $errors[]='File size must be excately 2 MB';
		  }*/
		  
		  //if(empty($errors)==true){
			
			
			if($_FILES['chat_dialog_picture']['name'] != ''){
				move_uploaded_file($file_tmp,"img/".$file_name);
				$sql = "UPDATE chat_img_tbl SET `chat_dialog_picture`='".$file_name."' WHERE `chatdialog_id`='".$chatdialog_id."' ";
				$result = mysqli_query($con,$sql);
			}
			$sql = "UPDATE chat_img_tbl SET `custom_data`='".$custom_data."' WHERE `chatdialog_id`='".$chatdialog_id."' ";
            $result = mysqli_query($con,$sql);
			
			$response = array("status" => "success", "error_message" => "", "success_message" => "update successfull.", "data" => "");
		  //}else{
			 //$response = array("status" => "error", "error_message" => "insert failure.", 'success_message' => '', "data" => "");
		  //}
	   //}
	}else{
		if(isset($_FILES['chat_dialog_picture'])){
		  $errors= array();
		  $file_name = $_FILES['chat_dialog_picture']['name'];
		  $file_size =$_FILES['chat_dialog_picture']['size'];
		  $file_tmp =$_FILES['chat_dialog_picture']['tmp_name'];
		  $file_type=$_FILES['chat_dialog_picturechat_dialog_picture']['type'];
		  $file_ext=strtolower(end(explode('.',$_FILES['chat_dialog_picture']['name'])));
		  
		  $extensions= array("jpeg","jpg","png");
		  
		  if(in_array($file_ext,$extensions)=== false){
			 $errors[]="extension not allowed, please choose a JPEG or PNG file.";
		  }
		  
		  /*if($file_size > 2097152){
			 $errors[]='File size must be excately 2 MB';
		  }*/
		  
		  if(empty($errors)==true){
			move_uploaded_file($file_tmp,"img/".$file_name);
			$sql = "INSERT INTO `chat_img_tbl`(`chatdialog_id`,`chat_dialog_picture`,`custom_data`)VALUES('".$chatdialog_id."','".$file_name."','".$custom_data."') ";
            $result = mysqli_query($con,$sql);
			$last_id = mysqli_insert_id($con);
			$response = array("status" => "success", "error_message" => "", "success_message" => "insert successfull.", "data" => array('chatdialog_id'=>$last_id));
		  }else{
			 $response = array("status" => "error", "error_message" => "insert failure.", 'success_message' => '', "data" => "");
		  }
	   }
	}
		
	
    
    
}else if($task == 'get_link'){
    if (!isset($_POST['chatdialog_id']) || trim($_POST['chatdialog_id']) == "") {
		$response = array("status" => "error", "error_message" => "provide chatdialog id", 'success_message' => '', "data" => "");
	}else{
				
		$sql2 = "SELECT * FROM chat_img_tbl WHERE `chatdialog_id` ='".$_POST['chatdialog_id']."' ORDER BY `id` DESC LIMIT 1 ";
		$result_img_link = mysqli_query($con,$sql2);
		mysqli_set_charset($con,"utf8");
		while($row = mysqli_fetch_assoc($result_img_link)){
			$result_data_img[] = $row;
		}
		$img_db_link = 'http://18.219.14.108/tudime_sms/img/'.$result_data_img[0]['chat_dialog_picture'];
		$custom_data = $result_data_img[0]['custom_data'];
		if($otp_db == $_POST['otp']){
			$response = array("status" => "success", "error_message" => "", "success_message" => "img get successfull", "data" => array('img_link'=>$img_db_link,'custom_data'=>$custom_data));
		}else{
			$response = array("status" => "error", "error_message" => "Invalid id..", 'success_message' => '', "data" => "");
		}
		
	}
    
}else{
    $response = array("status" => "error", "error_message" => "task not found", "success_message" => '', "data" => '');
}

    
echo json_encode($response);


?>