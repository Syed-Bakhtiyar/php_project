<?php
    header('Content-Type: application/json; Charset=UTF-8');
    include 'db_config/db_config.php';

    function postCall(){
        $response = array();
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $name = $_POST['name'];

        if (!isset($_POST['email']) || trim($_POST['email']) == "" || 
            !isset($_POST['mobile']) || trim($_POST['mobile']) == "" ||
            !isset($_POST['name']) || trim($_POST['name']) == "") 
        {
            $response = array("status" => "error", "error_message" => "email, mobile and name fields are required", 'success_message' => '', "data" => "");
            echo json_encode($response);
        } else {
            /**
             * This line will insert the data into contacts table
             */
            $sql = "INSERT INTO `contacts`(`email`, `mobile`, `name`)VALUES('".$email."', '".$mobile."', '".$name."') ";
            mysqli_query($GLOBALS['con'],$sql);

            $sql2 = "SELECT `ut`.`userid`, `ut`.`QB_User_id`, `tspi`.`profile_image` FROM `user_tbl` `ut` 
                     LEFT JOIN `tbl_user_profile_image` `tspi` ON `tspi`.`user_id` = `ut`.`id` 
                     WHERE `ut`.`userid` ='".$email."' OR `ut`.`userid` = '".$mobile."' ORDER BY `tspi`.`create_dt` DESC LIMIT 1";
            $result_user_histroy = mysqli_query($GLOBALS['con'],$sql2);
            while($row = mysqli_fetch_assoc($result_user_histroy)){
                $result_data_user_histroy["userId"] = $row["userid"];
                $result_data_user_histroy["qbUserId"] = $row["QB_User_id"];
                $result_data_user_histroy['profileImage'] = is_null($row["profile_image"]) ? NULL : "http://$_SERVER[HTTP_HOST]".'/tudime_sms/new_profile_image/'.$row["profile_image"];
            }
            $response = array("status" => "success", "error_message" => "", "success_message" => "insert successfull.", "data" => $result_data_user_histroy);
            echo json_encode($response);
        }
    }

    switch ($_SERVER['REQUEST_METHOD']){
        case 'POST':
            postCall();
        break;
    }
?>