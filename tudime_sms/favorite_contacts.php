<?php
    header('Content-Type: application/json; Charset=UTF-8');
    include 'db_config/db_config.php';

    function postCall(){
        $response = array();
        $useid = $_POST['useid'];
        $opponent_useid = $_POST['opponent_useid'];
        if (!isset($_POST['useid']) || trim($_POST['useid']) == "" || 
            !isset($_POST['opponent_useid']) || trim($_POST['opponent_useid']) == "")
        {
            $response = array("status" => "error", "error_message" => "useid and opponent_useid fields are required", 'success_message' => '', "data" => "");
            echo json_encode($response);
            return;
        }

        $sqlForCheckingExistingFavorite = "SELECT * FROM favorite_contacts WHERE `useid` ='".$useid."' AND `opponent_useid` = '".$opponent_useid."'";
        $result_existingFavorite = mysqli_query($GLOBALS['con'],$sqlForCheckingExistingFavorite);
        mysqli_set_charset($GLOBALS['con'],"utf8");
        while($row = mysqli_fetch_assoc($result_existingFavorite)){
            $existingFavoriteData[] = $row;
        }
        if($existingFavoriteData > 0){
            $response = array("status" => "error", "error_message" => "Your favorite contacts is already exist", 'success_message' => '', "data" => "");
            echo json_encode($response);
            return;
        }
        $sql = "INSERT INTO `favorite_contacts`(`useid`, `opponent_useid`)VALUES('".$useid."', '".$opponent_useid."') ";
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

        $sql2 = "SELECT `fc`.*, `ut`.QB_User_id from `favorite_contacts` `fc` inner join `user_tbl` `ut` on `ut`.`id` = `fc`.`opponent_useid` WHERE `fc`.useid = '".$useid."'";
        
        $result_block_user_history = mysqli_query($GLOBALS['con'],$sql2);
        mysqli_set_charset($GLOBALS['con'],"utf8");
        $mapUser = array();
        while($row = mysqli_fetch_assoc($result_block_user_history)){
            $userData['id'] = $row['id'];
            $userData['useid'] = $row['useid'];
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