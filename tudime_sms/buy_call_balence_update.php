<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

header('Content-Type: application/json; Charset=UTF-8');



include 'db_config/db_config.php';

$response = array();
$task = $_POST['task'];
$useid = $_POST['useid'];
$plan_name = $_POST['plan_name'];
$plan_price = $_POST['plan_price'];
$Payment_Referance_no = $_POST['Payment_Referance_no'];



	if (!isset($_POST['useid']) || trim($_POST['useid']) == "") {
		$response = array("status" => "error", "error_message" => "provide useid", 'success_message' => '', "data" => "");
	}elseif (!isset($_POST['plan_name']) || trim($_POST['plan_name']) == ""){
		$response = array("status" => "error", "error_message" => "provide plan name", 'success_message' => '', "data" => "");
	}elseif (!isset($_POST['plan_price']) || trim($_POST['plan_price']) == ""){
		$response = array("status" => "error", "error_message" => "provide plan price", 'success_message' => '', "data" => "");
	}elseif (!isset($_POST['Payment_Referance_no']) || trim($_POST['Payment_Referance_no']) == ""){
		$response = array("status" => "error", "error_message" => "provide payment reference no", 'success_message' => '', "data" => "");
	}else{
		
	
		$sql2 = "SELECT * FROM buy_call_balence_tbl WHERE `useid` ='".$useid."' ";
		$result_user_histroy = mysqli_query($con,$sql2);
		mysqli_set_charset($con,"utf8");
		while($row = mysqli_fetch_assoc($result_user_histroy)){
			$result_data_user_histroy[] = $row;
		}
		if($result_data_user_histroy > 0){
			
			$sql = "UPDATE buy_call_balence_tbl SET `plan_name`='".$plan_name."',`plan_price`='".$plan_price."',`Payment_Referance_no`='".$Payment_Referance_no."' WHERE `useid`='".$_POST['useid']."' ";
						$result = mysqli_query($con,$sql);
			$response = array("status" => "success", "error_message" => "", "success_message" => "update successful", "data" => '');
		}else{
			
			$sql = "INSERT INTO `buy_call_balence_tbl`(`useid`,`plan_name`,`plan_price`,`Payment_Referance_no`)VALUES('".$_POST['useid']."','".$plan_name."','".$plan_price."','".$Payment_Referance_no."') ";
						$result = mysqli_query($con,$sql);
			$response = array("status" => "success", "error_message" => "", "success_message" => "insert successfull", "data" => '');
		}
	
	
	}
    
    


    
echo json_encode($response);


?>