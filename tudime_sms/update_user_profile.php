<?php
header('Content-Type: application/json; Charset=UTF-8');



include 'db_config/db_config.php';
include 'subscription_validation/subscription_validation.php';

$response = array();
$task = $_POST['task'];
$name = $_POST['name'];
$email = $_POST['email'];
$privacy_status = $_POST['privacy_status'];
$Bio = $_POST['Bio'];
$QB_User_id = $_POST['QB_User_id'];
$userid = $_POST['userid'];

$isSubscriptionValidate = isUserSubscriptionValid($userid);
if(!$isSubscriptionValidate){
	$response = array("status" => "error", "error_message" => "useid is subscription", 'success_message' => 'Your subscription has expired, please activate it by purchasing one year subscription.', "data" => "");
	die(json_encode($response));
}
if($_POST['name'] != ''){
	$sql = "UPDATE user_tbl SET `name`='".$name."' WHERE `id`='".$userid."' ";
	$result = mysqli_query($con,$sql);
	
	$response = array("status" => "success", "error_message" => "", "success_message" => "update successfull.", "data" => "");
}
if($_POST['email'] != ''){
	$sql = "UPDATE user_tbl SET `email`='".$email."' WHERE `id`='".$userid."' ";
	$result = mysqli_query($con,$sql);
	
	$response = array("status" => "success", "error_message" => "", "success_message" => "update successfull.", "data" => "");
}
if($_POST['privacy_status'] != ''){
	$sql = "UPDATE user_tbl SET `privacy_status`='".$privacy_status."' WHERE `id`='".$userid."' ";
	$result = mysqli_query($con,$sql);
	
	$response = array("status" => "success", "error_message" => "", "success_message" => "update successfull.", "data" => "");
}
if($_POST['Bio'] != ''){
	$sql = "UPDATE user_tbl SET `Bio`='".$Bio."' WHERE `id`='".$userid."' ";
	$result = mysqli_query($con,$sql);
	
	$response = array("status" => "success", "error_message" => "", "success_message" => "update successfull.", "data" => "");
}
if($_FILES['pic1']['name'] != ''){
	$errors= array();
	$file_name = $_FILES['pic1']['name'];
	$file_size =$_FILES['pic1']['size'];
	$file_tmp =$_FILES['pic1']['tmp_name'];
	$file_type=$_FILES['pic1']['type'];
	$file_ext=strtolower(end(explode('.',$_FILES['pic1']['name'])));

	$extensions= array("jpeg","jpg","png");

	if(in_array($file_ext,$extensions)=== false){
	 $errors[]="extension not allowed, please choose a JPEG or PNG file.";
	}
	move_uploaded_file($file_tmp,"user_profile_image/".$file_name);
	$sql = "UPDATE user_tbl SET `pic1`='".$file_name."' WHERE `id`='".$userid."' ";
	$result = mysqli_query($con,$sql);
	$response = array("status" => "success", "error_message" => "", "success_message" => "update successfull.", "data" => "");
}
if($_FILES['pic2']['name'] != ''){
	$errors= array();
	$file_name = $_FILES['pic2']['name'];
	$file_size =$_FILES['pic2']['size'];
	$file_tmp =$_FILES['pic2']['tmp_name'];
	$file_type=$_FILES['pic2']['type'];
	$file_ext=strtolower(end(explode('.',$_FILES['pic2']['name'])));

	$extensions= array("jpeg","jpg","png");

	if(in_array($file_ext,$extensions)=== false){
	 $errors[]="extension not allowed, please choose a JPEG or PNG file.";
	}
	move_uploaded_file($file_tmp,"user_profile_image/".$file_name);
	$sql = "UPDATE user_tbl SET `pic2`='".$file_name."' WHERE `id`='".$userid."' ";
	$result = mysqli_query($con,$sql);
	$response = array("status" => "success", "error_message" => "", "success_message" => "update successfull.", "data" => "");
}
if($_FILES['pic3']['name'] != ''){
	$errors= array();
	$file_name = $_FILES['pic3']['name'];
	$file_size =$_FILES['pic3']['size'];
	$file_tmp =$_FILES['pic3']['tmp_name'];
	$file_type=$_FILES['pic3']['type'];
	$file_ext=strtolower(end(explode('.',$_FILES['pic3']['name'])));

	$extensions= array("jpeg","jpg","png");

	if(in_array($file_ext,$extensions)=== false){
	 $errors[]="extension not allowed, please choose a JPEG or PNG file.";
	}
	move_uploaded_file($file_tmp,"user_profile_image/".$file_name);
	$sql = "UPDATE user_tbl SET `pic3`='".$file_name."' WHERE `id`='".$userid."' ";
	$result = mysqli_query($con,$sql);
	$response = array("status" => "success", "error_message" => "", "success_message" => "update successfull.", "data" => "");
}
if($_FILES['pic4']['name'] != ''){
	$errors= array();
	$file_name = $_FILES['pic4']['name'];
	$file_size =$_FILES['pic4']['size'];
	$file_tmp =$_FILES['pic4']['tmp_name'];
	$file_type=$_FILES['pic4']['type'];
	$file_ext=strtolower(end(explode('.',$_FILES['pic4']['name'])));

	$extensions= array("jpeg","jpg","png");

	if(in_array($file_ext,$extensions)=== false){
	 $errors[]="extension not allowed, please choose a JPEG or PNG file.";
	}
	move_uploaded_file($file_tmp,"user_profile_image/".$file_name);
	$sql = "UPDATE user_tbl SET `pic4`='".$file_name."' WHERE `id`='".$userid."' ";
	$result = mysqli_query($con,$sql);
	$response = array("status" => "success", "error_message" => "", "success_message" => "update successfull.", "data" => "");
}
if($_FILES['Cover_pic']['name'] != ''){
	$errors= array();
	$file_name = $_FILES['Cover_pic']['name'];
	$file_size =$_FILES['Cover_pic']['size'];
	$file_tmp =$_FILES['Cover_pic']['tmp_name'];
	$file_type=$_FILES['Cover_pic']['type'];
	$file_ext=strtolower(end(explode('.',$_FILES['Cover_pic']['name'])));

	$extensions= array("jpeg","jpg","png");

	if(in_array($file_ext,$extensions)=== false){
	 $errors[]="extension not allowed, please choose a JPEG or PNG file.";
	}
	move_uploaded_file($file_tmp,"user_profile_image/".$file_name);
	$sql = "UPDATE user_tbl SET `Cover_pic`='".$file_name."' WHERE `id`='".$userid."' ";
	$result = mysqli_query($con,$sql);
	$response = array("status" => "success", "error_message" => "", "success_message" => "update successfull.", "data" => "");
}
if($_POST['QB_User_id'] != ''){
	$sql = "UPDATE user_tbl SET `QB_User_id`='".$QB_User_id."' WHERE `id`='".$userid."' ";
	$result = mysqli_query($con,$sql);
	
	$response = array("status" => "success", "error_message" => "", "success_message" => "update successfull.", "data" => "");
}

echo json_encode($response);







?>