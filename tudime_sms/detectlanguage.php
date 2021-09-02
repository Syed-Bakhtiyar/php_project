<?php

include 'db_config/db_config.php';
include 'subscription_validation/subscription_validation.php';

$text_to_translate=$_POST['text'];
$target_language=$_POST['targetlan'];
$useid=$_POST['useid'];
if (!isset($_POST['useid']) || trim($_POST['useid']) == "") 
{
    $response = array("status" => "error", "error_message" => "provide user id", 'success_message' => '', "data" => "");
    echo json_encode($response);
} else {
    $source_lang=guess_lang($text_to_translate);
    echo $translate=translate_lang($text_to_translate,$source_lang,$target_language, $useid);
}
	
function guess_lang($str) 
{

    $str = str_replace(" ", "%20", $str);

    $content = file_get_contents("https://translation.googleapis.com/language/translate/v2/detect?key=AIzaSyBIMUuiseY_YGPEsKvizaS2570NQMKRma8&q=".$str);

    $lang = (json_decode($content, true));

    if(isset($lang))
        return $lang["data"]["detections"][0][0]["language"];
 }
 

 function translate_lang($text_to_translate,$source_lang,$target_language, $useid)
 {
    $isSubscriptionValidate = isUserSubscriptionValid($useid);
    if(!$isSubscriptionValidate){
        $response = array("status" => "error", "error_message" => "Your subscription has expired, please activate it by purchasing one year subscription.", 'success_message' => '', "data" => "");
        return json_encode($response);
    }
    $apiKey = 'AIzaSyBIMUuiseY_YGPEsKvizaS2570NQMKRma8';
    $url = 'https://www.googleapis.com/language/translate/v2?key=' . $apiKey . '&q=' . rawurlencode($text_to_translate) . '&source='.$source_lang.'&target='.$target_language;
    $handle = curl_init($url);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($handle);
    $responseDecoded = json_decode($response, true);

    curl_close($handle);

if(isset($responseDecoded))
        return $responseDecoded['data']['translations'][0]['translatedText'];
    // echo  json_encode("success"=>1,"Text"=>$responseDecoded);
    /*print_r($responseDecoded['data']['translations'][0]['translatedText']);
    die;*/


 }

?>