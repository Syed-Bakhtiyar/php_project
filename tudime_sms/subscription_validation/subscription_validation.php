<?php

    function isUserSubscriptionValid($useid){
        $sql2 = "SELECT `u`.`id` as `id`, `u`.`create_dt` as `created_date`, `bts`.`end_date` as `subscription_end_date`  FROM `user_tbl` `u` 
                LEFT JOIN `buy_tudime_subscription` `bts` ON `bts`.`useid` = `u`.`id`
                WHERE `u`.`id` = '".$useid."' ORDER BY `bts`.`start_date` DESC LIMIT 1";
        $user_themes = mysqli_query($GLOBALS['con'], $sql2);
        $row = mysqli_fetch_assoc($user_themes);
        $id = $row["id"];
        $created_date = $row["created_date"];
        $subscriptionEndDate = is_null($row["subscription_end_date"]) ? NULL : new DateTime($row["subscription_end_date"]);
        $isUserNull = is_null($id);
        if( $isUserNull ){
            return false;
        }
        $currentDate = new DateTime();
        $userCreatedDate = new DateTime($created_date);
        $difference = $currentDate->diff($userCreatedDate);

        if((is_null($subscriptionEndDate)) && intval($difference->format("%a")) > 30){
            return false;
        }

        if((!is_null($subscriptionEndDate)) && ($currentDate > $subscriptionEndDate)) {
            return false;
        }
        return true;
    }
?>