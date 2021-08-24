<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

header('Content-Type: application/json; Charset=UTF-8');



$con=mysqli_connect("localhost","root","IpTv@2019");
$db=mysqli_select_db($con,"tudime_sms");

$response = array();
$task = $_POST['task'];
$id = $_POST['QB_User_id'];



    if (!isset($_POST['QB_User_id']) || trim($_POST['QB_User_id']) == "") {
		$response = array("status" => "error", "error_message" => "provide id", 'success_message' => '', "data" => "");
	}else{
		
                
		$sql2 = "SELECT * FROM user_tbl WHERE `QB_User_id` ='".$id."' ORDER BY `id` DESC LIMIT 1 ";
		$result_user_histroy = mysqli_query($con,$sql2);
		mysqli_set_charset($con,"utf8");
		while($row = mysqli_fetch_assoc($result_user_histroy)){
			$result_data_user_histroy[] = $row;
		}
		$f_data = array();
		foreach($result_data_user_histroy as $val){
			$val['pic1_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/tudime_sms/user_profile_image/'.$val['pic1'];
			$val['pic2_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/tudime_sms/user_profile_image/'.$val['pic2'];
			$val['pic3_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/tudime_sms/user_profile_image/'.$val['pic3'];
			$val['pic4_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/tudime_sms/user_profile_image/'.$val['pic4'];
			$val['Cover_pic_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/tudime_sms/user_profile_image/'.$val['Cover_pic'];
			$val['create_dt_timestamp'] =strtotime($val['create_dt']);
			$f_data[] = $val;
		}
		$response = array("status" => "success", "error_message" => "", "success_message" => "user dara get successfull.", "data" => $f_data);
		
	}
    


    
echo json_encode($response);


?>