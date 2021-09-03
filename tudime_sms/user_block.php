<?php
    header('Content-Type: application/json; Charset=UTF-8');
    include 'db_config/db_config.php';

    function postCall(){
        $response = array();
        $useid = $_POST['useid'];
        $block_useid = $_POST['block_useid'];
        $reason = $_POST['reason'];
        if (!isset($_POST['useid']) || trim($_POST['useid']) == "" || 
            !isset($_POST['block_useid']) || trim($_POST['block_useid']) == "" || 
            !isset($_POST['reason']) || trim($_POST['reason']) == "")
        {
            $response = array("status" => "error", "error_message" => "useid, block_useid and reason fields are required", 'success_message' => '', "data" => "");
            echo json_encode($response);
            return;
        }

        $sqlCheckingForBlockUser = "SELECT * FROM block_user_tbl WHERE `block_useid` ='".$block_useid."' ";
        $result_existing_blocked = mysqli_query($GLOBALS['con'],$sqlCheckingForBlockUser);
        mysqli_set_charset($GLOBALS['con'],"utf8");
        while($row = mysqli_fetch_assoc($result_existing_blocked)){
            $existingUserData[] = $row;
        }
        if($existingUserData > 0){
            $response = array("status" => "error", "error_message" => "User with id: ".$block_useid." is already blocked", 'success_message' => '', "data" => "");
            echo json_encode($response);
            return;
        }
        $sql = "INSERT INTO `block_user_tbl`(`useid`, `block_useid`, `reason`)VALUES('".$useid."', '".$block_useid."', '".$reason."') ";
        mysqli_query($GLOBALS['con'], $sql);
        $response = array("status" => "success", "error_message" => "", "success_message" => "insert successfull.", "data" => "");
        echo json_encode($response);
    }

    function getCall(){
        $useid = $_GET['useid'];
        if (!isset($_GET['useid']) || trim($_GET['useid']) == ""){
            $response = array("status" => "error", "error_message" => "useid is missing", 'success_message' => '', "data" => "");
            echo json_encode($response);
            return;
        }

        $sql2 = "SELECT `bu_t`.*, `ut`.QB_User_id from `block_user_tbl` `bu_t` inner join `user_tbl` `ut` on `ut`.`id` = `bu_t`.`block_useid` WHERE `bu_t`.useid = '".$useid."'";
        
        $result_block_user_history = mysqli_query($GLOBALS['con'],$sql2);
        mysqli_set_charset($GLOBALS['con'],"utf8");
        $mapUser = array();
        while($row = mysqli_fetch_assoc($result_block_user_history)){
            $userData['id'] = $row['id'];
            $userData['useid'] = $row['useid'];
            $userData['blocked_useid'] = $row['block_useid'];
            $userData['blocked_QB_User_ID'] = $row['QB_User_id'];
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
    }
?>