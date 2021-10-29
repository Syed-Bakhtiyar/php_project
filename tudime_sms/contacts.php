<?php
    header('Content-Type: application/json; Charset=UTF-8');
    include 'db_config/db_config.php';
    include 'subscription_validation/subscription_validation.php';

    function postCall(){
        $response = array();
        $useid = $_POST['useid'];
        $userIds = json_decode( $_POST['userIds']);

        if (!isset($_POST['userIds']) || trim($_POST['userIds']) == "" || 
            !isset($_POST['useid']) || trim($_POST['useid']) == "") 
        {
            $response = array("status" => "error", "error_message" => "userIds and useid fields are required", 'success_message' => '', "data" => "");
            echo json_encode($response);
        } else {

            $isSubscriptionValidate = isUserSubscriptionValid($useid);
            if(!$isSubscriptionValidate){
                $response = array("status" => "error", "error_message" => "Your subscription has expired, please activate it by purchasing one year subscription.", 'success_message' => '', "data" => "");
                echo json_encode($response);
                return;
            }
            $implodeString = '('."'".implode("', '", $userIds)."'".')';
            $sql2 = "SELECT `ut`.`userid`, Max(`ut`.`QB_User_id`) as QB_User_id, Max(`tspi`.`profile_image`) as profile_image, Max(`tspi`.`create_dt`) as create_dt FROM `user_tbl` `ut` 
                     LEFT JOIN `tbl_user_profile_image` `tspi` ON `tspi`.`user_id` = `ut`.`id` 
                     WHERE `ut`.`userid` IN ".$implodeString." Group by `ut`.`userid` ORDER BY `create_dt` DESC";
            $result_user_histroy = mysqli_query($GLOBALS['con'],$sql2);
            $result_data_users = [];
            while($row = mysqli_fetch_assoc($result_user_histroy)){
                $result_data_user_histroy["userId"] = $row["userid"];
                $result_data_user_histroy["qbUserId"] = $row["QB_User_id"];
                $result_data_user_histroy['profileImage'] = is_null($row["profile_image"]) ? NULL : "http://$_SERVER[HTTP_HOST]".'/tudime_sms/new_profile_image/'.$row["profile_image"];
                array_push($result_data_users, $result_data_user_histroy);
            }
            $response = array("status" => "success", "error_message" => "", "success_message" => "insert successfull.", "data" => $result_data_users);
            echo json_encode($response);
        }
    }

    switch ($_SERVER['REQUEST_METHOD']){
        case 'POST':
            postCall();
        break;
    }
?>