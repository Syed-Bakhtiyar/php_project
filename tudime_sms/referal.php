<?php
    header('Content-Type: application/json; Charset=UTF-8');
    include 'db_config/db_config.php';

    function postCall(){
        $response = array();
        $useid = $_POST['useid'];
        $referal_username = $_POST['referal_username'];
        if (!isset($_POST['useid']) || trim($_POST['useid']) == "" || 
            !isset($_POST['referal_username']) || trim($_POST['referal_username']) == "")
        {
            $response = array("status" => "error", "error_message" => "useid and referal_username fields are required", 'success_message' => '', "data" => "");
            echo json_encode($response);
            return;
        }

        $sqlCheckIfReferalUserAlreadyExist = "SELECT * FROM user_tbl WHERE `userid` ='".$referal_username."'";
        $result_existing_user = mysqli_query($GLOBALS['con'], $sqlCheckIfReferalUserAlreadyExist);
        mysqli_set_charset($GLOBALS['con'],"utf8");
        while($row = mysqli_fetch_assoc($result_existing_user)){
            $existingUser[] = $row;
        }
        if($existingUser > 0){
            $response = array("status" => "error", "error_message" => $referal_username." is already exist", 'success_message' => "", "data" => "");
            echo json_encode($response);
            return;
        }

        $sqlCheckIsUserIsAlreadyRefered = "SELECT * FROM user_referal WHERE `referal_username` ='".$referal_username."'";
        $result_already_refered = mysqli_query($GLOBALS['con'], $sqlCheckIsUserIsAlreadyRefered);
        mysqli_set_charset($GLOBALS['con'],"utf8");
        while($row = mysqli_fetch_assoc($result_already_refered)){
            $existingRefered[] = $row;
        }
        if($existingRefered > 0){
            $response = array("status" => "error", "error_message" => $referal_username." is already refered", 'success_message' => "", "data" => "");
            echo json_encode($response);
            return;
        }
        $sql = "INSERT INTO `user_referal`(`useid`, `referal_username`)VALUES('".$useid."', '".$referal_username."') ";
        mysqli_query($GLOBALS['con'], $sql);
        $response = array("status" => "success", "error_message" => "", "success_message" => "insert successfull.", "data" => "");
        echo json_encode($response);
    }

    switch ($_SERVER['REQUEST_METHOD']){
        case 'POST':
            postCall();
        break;
    }
?>