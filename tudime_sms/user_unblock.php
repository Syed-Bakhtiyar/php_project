<?php
    header('Content-Type: application/json; Charset=UTF-8');
    include 'db_config/db_config.php';

    function deleteCall(){
        $response = array();
        $block_useid = $_GET['block_useid'];
        if (!isset($_GET['block_useid']) || trim($_GET['block_useid']) == "")
        {
            $response = array("status" => "error", "error_message" => "block_useid field is required", 'success_message' => '', "data" => "");
            echo json_encode($response);
            return;
        }

        $sqlDeleteBlockUser = "DELETE FROM block_user_tbl WHERE `block_useid` ='".$block_useid."' ";
        mysqli_query($GLOBALS['con'],$sqlDeleteBlockUser);
        $response = array("status" => "success", "error_message" => "", "success_message" => "User is unblocked successfully.", "data" => "");
        echo json_encode($response);
    }
    switch ($_SERVER['REQUEST_METHOD']){
        case 'DELETE':
            deleteCall();
        break;
        default:
            $response = array("status" => "failure", "error_message" => "Request Not Found", "success_message" => "", "data" => "");
            echo json_encode($response);
    }
?>