<?php
header('Content-Type: application/json; Charset=UTF-8');

$con=mysqli_connect("localhost","root","IpTv@2019");
$db=mysqli_select_db($con,"tudime_sms");
$response = array();
$user_image=array();

$UserID = $_POST['UserID'];

	
		
	
			if(isset($_POST['UserID']))
			{
				
				$UserID=$_POST['UserID'];
				$PhotoID=$_POST['PhotoID'];
				$sql = "SELECT * FROM  `tbl_user_profile_image` WHERE user_id='".$UserID."' and id='".$PhotoID."' and status='1'";
				$result = mysqli_query($con,$sql);
				$row=mysqli_fetch_array($result);
				if(!empty($row))
				{
					$image_file_name=$row['profile_image'];
					
					$sql = "DELETE   FROM  `tbl_user_profile_image` WHERE  user_id='".$UserID."' and id='".$PhotoID."'";
					$result = mysqli_query($con,$sql);
					if($result>0)
					{
						$path=getcwd() .'/new_profile_image/'.$image_file_name;
						chmod($path, 777);
						unlink($path);
						$response = array("status" => "Success", 'success_message' => 'Image file delete success');
						echo json_encode($response);
						
					}	
				}
				else
				{
					$response = array("status" => "error", "error_message" => "No file is exist in this id");
					echo json_encode($response);
				}		
					
					
					
					
			
			
			
			}
			else
			{
					$response = array("status" => "error", "error_message" => "Please input user id.", 'success_message' => '');
					echo json_encode($response);
			}
    
    


    



?>