<?php
    header('Content-Type: application/json; Charset=UTF-8');
    include 'db_config/db_config.php';

    function postCall(){
        $response = array();
        $useid = $_POST['useid'];
        $theme_url = $_POST['theme_url'];
        if (!isset($_POST['useid']) || trim($_POST['useid']) == "" || 
            !isset($_POST['theme_url']) || trim($_POST['theme_url']) == "")
        {
            $response = array("status" => "error", "error_message" => "useid and theme_url fields are required", 'success_message' => '', "data" => "");
            echo json_encode($response);
            return;
        }
        $sql = "INSERT INTO `theme`(`useid`, `theme_url`)VALUES('".$useid."', '".$theme_url."') ";
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
        $sql2 = "SELECT `t`.`id`, `t`.`useid`, `t`.`theme_url` FROM `theme` `t` 
                WHERE `t`.`useid` = '".$useid."' ORDER BY `t`.`id` DESC";
        $user_themes = mysqli_query($GLOBALS['con'], $sql2);
        $mapUserTheme = array();
        while($row = mysqli_fetch_assoc($user_themes)){
            $result_data_user_histroy["id"] = $row["id"];
            $result_data_user_histroy["useid"] = $row["useid"];
            $result_data_user_histroy["theme_url"] = $row["theme_url"];
            array_push($mapUserTheme, $result_data_user_histroy);
        }
        $response = array("status" => "success", "error_message" => "", "success_message" => "get theme data successfully.", "data" => $mapUserTheme);
        echo json_encode($response);
    }

    function deleteCall(){
        $id = $_GET['id'];
        if (!isset($_GET['id']) || trim($_GET['id']) == ""){
            $response = array("status" => "error", "error_message" => "id is missing", 'success_message' => '', "data" => "");
            echo json_encode($response);
            return;
        }
        $sql2 = "Delete FROM `theme` WHERE `id` = '".$id."'  ";
		mysqli_query($GLOBALS['con'], $sql2);
        $response = array("status" => "success", "error_message" => "", "success_message" => "Delete successfull.", "data" => "");
        echo json_encode($response);
    }

    switch ($_SERVER['REQUEST_METHOD']){
        case 'POST':
            postCall();
        break;
        case 'GET':
            getCall();
        break;
        case 'DELETE':
            deleteCall();
        break;
    }
?>