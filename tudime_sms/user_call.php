<?php
    header('Content-Type: application/json; Charset=UTF-8');
    include 'db_config/db_config.php';

    function postCall(){
        $response = array();
        $useid = $_POST['useid'];
        $opponent_useid = $_POST['opponent_useid'];
        $call_type = $_POST['call_type'];
        $service_type = $_POST['service_type'];
        if (!isset($_POST['opponent_useid']) || trim($_POST['opponent_useid']) == "" || 
            !isset($_POST['call_type']) || trim($_POST['call_type']) == "" || 
            !isset($_POST['service_type']) || trim($_POST['service_type']) == "" || 
            !isset($_POST['useid']) || trim($_POST['useid']) == "")
        {
            $response = array("status" => "error", "error_message" => "useid, opponent_useid, call_type and service_type fields are required", 'success_message' => '', "data" => "");
            echo json_encode($response);
            return;
        }

        if($call_type != "1" && $call_type != "2"){
            $response = array("status" => "failure", "error_message" => "Only 1 and 2 values are allowed in call_type field", "success_message" => "", "data" => "");
            echo json_encode($response);
            return;
        }

        if($service_type != '1' && $service_type != '2'){
            $response = array("status" => "failure", "error_message" => "Only 1 and 2 values are allowed in service_type field", "success_message" => "", "data" => "");
            echo json_encode($response);
            return;
        }

        $sql = "INSERT INTO `call_tbl`(`useid`, `opponent_useid`, `call_type`, `service_type`)VALUES('".$useid."', '".$opponent_useid."', '".$call_type."', '".$service_type."') ";
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

        $sql2 = "SELECT * from `call_tbl` WHERE useid = '".$useid."'";
        
        $result_block_user_history = mysqli_query($GLOBALS['con'],$sql2);
        mysqli_set_charset($GLOBALS['con'],"utf8");
        $mapUser = array();
        while($row = mysqli_fetch_assoc($result_block_user_history)){
            $userData['id'] = $row['id'];
            $userData['useid'] = $row['useid'];
            $userData['opponent_useid'] = $row['opponent_useid'];
            $userData['call_type'] = $row['call_type'];
            $userData['service_type'] = $row['service_type'];
            $userData['timestamp'] = $row['timestamp'];
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