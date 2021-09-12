<?php

    function isUserSubscriptionValid($useid){
        $currentDate = new DateTime();
        $sqlCheckReferCount = "SELECT * FROM `user_refer_count` WHERE `useid` = ".$useid." Limit 1";
        $result_referal_user_count = mysqli_query($GLOBALS['con'], $sqlCheckReferCount);
        $result_referal_user_count_histroy = mysqli_fetch_assoc($result_referal_user_count);
        // die(json_encode($result_referal_user_count_histroy));
        if(!is_null( $result_referal_user_count_histroy)){
            $userCreatedDate = new DateTime($result_referal_user_count_histroy['exp_timestamp']);
            if($currentDate > $userCreatedDate){

                $refer_count_id = $result_referal_user_count_histroy['id'];
                $start_date_time = date('Y-m-d H:i:s');
                $end_date_time = date('Y-m-d H:i:s', strtotime('+1 year', strtotime($start_date_time)));
                $sql = "UPDATE user_refer_count SET `counter`='0', `is_first_time`=False, exp_timestamp='".$end_date_time."' WHERE `id`='".$refer_count_id."' ";
                $result = mysqli_query($GLOBALS['con'],$sql);
            } else {
                
                if($result_referal_user_count_histroy['is_first_time'] && intval($result_referal_user_count_histroy['counter']) >= 20 ){
                    return true;
                }

                if(!$result_referal_user_count_histroy['is_first_time'] && intval($result_referal_user_count_histroy['counter']) >= 100 ){
                    return true;
                }
            }
        }


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