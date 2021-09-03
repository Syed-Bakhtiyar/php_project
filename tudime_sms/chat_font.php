<?php
    header('Content-Type: application/json; Charset=UTF-8');
    include 'db_config/db_config.php';

    function postCall(){
        $response = array();
        $chat_color = $_POST['chat_color'];
        $chat_font = $_POST['chat_font'];
        $opponent_useid = $_POST['opponent_useid'];
        if (!isset($_POST['opponent_useid']) || trim($_POST['opponent_useid']) == "" || 
            !isset($_POST['chat_font']) || trim($_POST['chat_font']) == "" || 
            !isset($_POST['chat_color']) || trim($_POST['chat_color']) == "")
        {
            $response = array("status" => "error", "error_message" => "chat_color, chat_font and opponent_useid fields are required", 'success_message' => '', "data" => "");
            echo json_encode($response);
            return;
        }

        $sqlCheckingChatFont = "SELECT * FROM chat_font_tbl WHERE `opponent_useid` ='".$opponent_useid."' ";
        $result_existing_blocked = mysqli_query($GLOBALS['con'], $sqlCheckingChatFont);
        mysqli_set_charset($GLOBALS['con'],"utf8");
        while($row = mysqli_fetch_assoc($result_existing_blocked)){
            $existingFont[] = $row;
        }
        if($existingFont > 0){
            $fontId = $existingFont[0]['id'];
            $sql = "UPDATE chat_font_tbl SET chat_color='".$chat_color."', chat_font='".$chat_font."', opponent_useid='".$opponent_useid."' WHERE id='".$fontId."'";
            mysqli_query($GLOBALS['con'], $sql);
            $response = array("status" => "error", "error_message" => "", 'success_message' => "Updated Successfully", "data" => "");
            echo json_encode($response);
            return;
        }
        $sql = "INSERT INTO `chat_font_tbl`(`chat_color`, `chat_font`, `opponent_useid`)VALUES('".$chat_color."', '".$chat_font."', '".$opponent_useid."') ";
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

        $sql2 = "SELECT `cf_t`.*, `ut`.QB_User_id from `chat_font_tbl` `cf_t` inner join `user_tbl` `ut` on `ut`.`id` = `cf_t`.`opponent_useid` WHERE `cf_t`.opponent_useid = '".$useid."'";
        
        $result_block_user_history = mysqli_query($GLOBALS['con'],$sql2);
        mysqli_set_charset($GLOBALS['con'],"utf8");
        $mapUser = array();
        while($row = mysqli_fetch_assoc($result_block_user_history)){
            $userData['id'] = $row['id'];
            $userData['chat_color'] = $row['chat_color'];
            $userData['chat_font'] = $row['chat_font'];
            $userData['opponent_useid'] = $row['opponent_useid'];
            $userData['opponent_QB_User_ID'] = $row['QB_User_id'];
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