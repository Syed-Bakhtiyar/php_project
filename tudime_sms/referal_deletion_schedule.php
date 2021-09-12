<?php
    header('Content-Type: application/json; Charset=UTF-8');
    include 'db_config/db_config.php';

    function deleteOldReferal(){
        $threeDaysPreviousDate = date('Y-m-d', strtotime('-3 days', strtotime(date('Y-m-d H:i:s'))));
        $sql = "DELETE FROM `user_referal` WHERE `timestamp` < '".$threeDaysPreviousDate."' ";
        mysqli_query($GLOBALS['con'], $sql);
        $response = array("status" => "success", "error_message" => "", "success_message" => "Deletion Success.", "data" => "");
        echo json_encode($response);
    }

    deleteOldReferal();
?>