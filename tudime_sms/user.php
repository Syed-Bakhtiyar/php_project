<?php
    header('Content-Type: application/json; Charset=UTF-8');
    include 'db_config/db_config.php';

    function postCall(){
        $response = array();
        $useid = $_POST['useid'];
        $unique_name = $_POST['unique_name'];
        if (!isset($_POST['useid']) || trim($_POST['useid']) == "" || 
            !isset($_POST['unique_name']) || trim($_POST['unique_name']) == "")
        {
            $response = array("status" => "error", "error_message" => "useid and unique_name fields are required", 'success_message' => '', "data" => "");
            echo json_encode($response);
            return;
        }

        $sqlForCheckingUniqueUser = "SELECT * FROM user_tbl WHERE `unique_name` ='".$unique_name."' ";
        $result_existing_user_data = mysqli_query($GLOBALS['con'],$sqlForCheckingUniqueUser);
        mysqli_set_charset($GLOBALS['con'],"utf8");
        while($row = mysqli_fetch_assoc($result_existing_user_data)){
            $existingUserData[] = $row;
        }
        if($existingUserData > 0){
            $response = array("status" => "error", "error_message" => $unique_name." "."unique_name is already exists", 'success_message' => '', "data" => "");
            echo json_encode($response);
            return;
        }
        $updateUniqueName = "UPDATE user_tbl SET `unique_name`='".$unique_name."' WHERE `id`='".$useid."' ";
	    mysqli_query($GLOBALS['con'], $updateUniqueName);
        $response = array("status" => "success", "error_message" => "", "success_message" => "updated successfull.", "data" => "");
        echo json_encode($response);
    }

    function getCall(){
        $text = $_GET['text'];
        if (!isset($_GET['text']) || trim($_GET['text']) == ""){
            $response = array("status" => "error", "error_message" => "useid is missing", 'success_message' => '', "data" => "");
            echo json_encode($response);
            return;
        }

        $sql2 = "SELECT `ut`.* FROM `user_tbl` `ut` 
        WHERE `ut`.`unique_name` LIKE '%".$text."%' OR `ut`.`userid` LIKE '%".$text."%' OR `ut`.`name` LIKE '%".$text."%'";
        
        $result_user_histroy = mysqli_query($GLOBALS['con'],$sql2);
        mysqli_set_charset($GLOBALS['con'],"utf8");
        $mapUser = array();
        while($row = mysqli_fetch_assoc($result_user_histroy)){
            $userData['id'] = $row['id'];
            $userData['userid'] = $row['userid'];
            $userData['name'] = $row['name'];
            $userData['email'] = $row['email'];
            $userData['pic1_url'] = is_null($row["pic1"]) ? NULL : 'http://'.$_SERVER['HTTP_HOST'].'/tudime_sms/user_profile_image/'.$row['pic1'];
            $userData['pic2_url'] = is_null($row["pic2"]) ? NULL : 'http://'.$_SERVER['HTTP_HOST'].'/tudime_sms/user_profile_image/'.$row['pic2'];
            $userData['pic3_url'] = is_null($row["pic3"]) ? NULL : 'http://'.$_SERVER['HTTP_HOST'].'/tudime_sms/user_profile_image/'.$row['pic3'];
            $userData['pic4_url'] = is_null($row["pic4"]) ? NULL : 'http://'.$_SERVER['HTTP_HOST'].'/tudime_sms/user_profile_image/'.$row['pic4'];
            $userData['Cover_pic_url'] = is_null($row["Cover_pic"]) ? NULL : 'http://'.$_SERVER['HTTP_HOST'].'/tudime_sms/user_profile_image/'.$row['Cover_pic'];
            $userData['QB_User_id'] = $row['QB_User_id'];
            $userData['unique_name'] = $row['unique_name'];
            $userData['platform'] = $row['platform'];
            array_push($mapUser, $userData);
        }
        
        $response = array("status" => "success", "error_message" => "", "success_message" => "user data get successfull.", "data" => $mapUser);
        echo json_encode($response);
    }

    switch ($_SERVER['REQUEST_METHOD']){
        case 'POST':
            postCall();
        break;
        case 'GET':
            getCall();
        break;
        // case 'DELETE':
        //     deleteCall();
        // break;
    }
?>