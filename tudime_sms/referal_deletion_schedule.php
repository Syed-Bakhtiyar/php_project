<?php
    header('Content-Type: application/json; Charset=UTF-8');
    include 'db_config/db_config.php';

    function deleteOldReferal(){
        $sql = "INSERT INTO `user_referal`(`useid`, `referal_username`)VALUES('2', 'bakhti') ";
        mysqli_query($GLOBALS['con'], $sql);
        $response = array("status" => "success", "error_message" => "", "success_message" => "insert successfull.", "data" => "");
        echo json_encode($response);
    }

    deleteOldReferal();
?>