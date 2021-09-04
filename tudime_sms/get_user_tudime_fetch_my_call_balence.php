<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

header('Content-Type: application/json; Charset=UTF-8');



include 'db_config/db_config.php';

$response = array();
$task = $_POST['task'];
$id = $_POST['useid'];



    if (!isset($_POST['useid']) || trim($_POST['useid']) == "") {
		$response = array("status" => "error", "error_message" => "provide id", 'success_message' => '', "data" => "");
	}else{
		$sql2 = "SELECT * FROM buy_call_balence_tbl WHERE `useid` ='".$id."' ORDER BY `id` DESC  ";
		$result_user_histroy = mysqli_query($con,$sql2);
		mysqli_set_charset($con,"utf8");
		while($row = mysqli_fetch_assoc($result_user_histroy)){
			$result_data_user_histroy[] = $row;
		}
		$f_data = array();
		foreach($result_data_user_histroy as $val){
			//$val['start_time_unix_timestamp'] = strtotime($val['start_date']);
			//$val['end_time_unix_timestamp'] = strtotime($val['end_date']);
			
			$f_data[] = $val;
		}
		$response = array("status" => "success", "error_message" => "", "success_message" => "user data get successfull.", "data" => $f_data);
			
		
		
	}
    


    
echo json_encode($response);


?>