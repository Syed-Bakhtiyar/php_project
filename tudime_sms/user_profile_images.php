<?php
header('Content-Type: application/json; Charset=UTF-8');

include 'db_config/db_config.php';
include 'subscription_validation/subscription_validation.php';
$response = array();
$user_image=array();
$task = $_POST['task'];
$UserID = $_POST['UserID'];



	
		/*if(isset($_POST['UserID']))
		{
		  $errors= array();
		  $file_name = $_FILES['store_chat_file']['name'];
		  $file_size =$_FILES['store_chat_file']['size'];
		  $file_tmp =$_FILES['store_chat_file']['tmp_name'];
		  $file_type=$_FILES['store_chat_file']['type'];
		  $file_ext=strtolower(end(explode('.',$_FILES['store_chat_file']['name'])));
		  
		  $extensions= array();//array("jpeg","jpg","png");
		  
		  if(in_array($file_ext,$extensions)=== false){
			 $errors[]="extension not allowed, please choose a JPEG or PNG file.";
		  }
		  
		  
		  
			$path = "new_profile_image/";
			$path = $path . basename( $_FILES['store_chat_file']['name']);

			if(move_uploaded_file($_FILES['store_chat_file']['tmp_name'], $path)) 
			{
			  //echo "The file ".  basename( $_FILES['store_chat_file']['name']). 
			  //" has been uploaded";
			  $sql = "INSERT INTO `tb_store_chat_file`(`store_chat_file`)VALUES('".$file_name."') ";
				$result = mysqli_query($con,$sql);
				$last_id = mysqli_insert_id($con);
				$response = array("status" => "success", "error_message" => "", "success_message" => "insert successfull.", "data" => 'http://18.219.14.108/tudime_sms/file_store/'.$file_name);
			} 
			else
			{
				$response = array("status" => "error", "error_message" => "insert failure.", 'success_message' => '', "data" => $path);
			}
			
			for($j=0; $j < count($user_image); $j++)
			{
				
				
			
			
			}	
		  
		  
	   }*/
	
		
	
			if(isset($_POST['UserID']))
			{
				$UserID=$_POST['UserID'];
				$isSubscriptionValidate = isUserSubscriptionValid($UserID);
				if(!$isSubscriptionValidate){
					$response = array("status" => "error", "error_message" => "Your subscription has expired, please activate it by purchasing one year subscription.", 'success_message' => '', "data" => "");
				} else {
					$profile_image=$_FILES['profile_image']['name'];
					$image = array();
					$ImageCount = count($profile_image);
					if($ImageCount<=10)
					{
							for($i = 0; $i < $ImageCount; $i++)
							{
								$_FILES['file']['name']       = $_FILES['profile_image']['name'][$i];
								$_FILES['file']['type']       = $_FILES['profile_image']['type'][$i];
								$_FILES['file']['tmp_name']   = $_FILES['profile_image']['tmp_name'][$i];
								$_FILES['file']['error']      = $_FILES['profile_image']['error'][$i];
								$_FILES['file']['size']       = $_FILES['profile_image']['size'][$i];

								// File upload configuration
								$path = "new_profile_image/";
								$temp_file=$_FILES['profile_image']['tmp_name'][$i];
								//$path = $path . basename($_FILES['profile_image']['name'][$i]);
								$uniquid=uniqid();
								$file_name = $_FILES['profile_image']['name'][$i];
								$temp = explode(".",$file_name);
								//$newfilename = round(microtime(true)) . '.' . end($temp);
								$newfilename=$uniquid.'_'.$file_name;	
								$path = $path . basename($newfilename);
								if(move_uploaded_file($temp_file, $path)) 
								{
									
									
									$sql = "INSERT INTO `tbl_user_profile_image`(`user_id`,`profile_image`,`status`)VALUES('".$UserID."','".$newfilename."','1') ";
									$result = mysqli_query($con,$sql);
									$last_id = mysqli_insert_id($con);
									$response = array("status" => "Success",'success_message' => 'File upload success');
									
								}
								
							}
					}
					else
					{
							$response = array("status" => "error", "error_message" => "You cannot upload more than 10 images");
					
					}	
				}
			}
			else
			{
					$response = array("status" => "error", "error_message" => "Please input user id.", 'success_message' => '');
			}
    
    


    
echo json_encode($response);


?>