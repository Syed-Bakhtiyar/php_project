<?php
header('Content-Type: application/json; Charset=UTF-8');

include 'db_config/db_config.php';

$response = array();
$user_image=array();

$UserID = $_POST['UserID'];

	
		
	
if(isset($_POST['UserID']))
{
	$UserID=$_POST['UserID'];
	$sql = "SELECT * FROM  `tbl_user_profile_image` WHERE user_id='".$UserID."' and status='1'";
	$result = mysqli_query($con,$sql);
	$rowcount=mysqli_num_rows($result);
	if($rowcount>0)
	{
		while($row=mysqli_fetch_array($result))
		{
			
			$image_id[]=$row['id'];
			$profile_image[]=$row['profile_image'];
			$response = array("status" => "success", "imageid" =>$image_id, "profileimage" =>$profile_image,"data" => 'http://18.219.14.108/tudime_sms/new_profile_image/');
			
			
		}	
	}
	else
	{
		$response = array("status" => "failure", "imageid" =>[], "profileimage" =>[],"data" =>"");
	}

}
else
{
		$response = array("status" => "error", "error_message" => "Please input user id.", 'success_message' => 'failure');
}





echo json_encode($response);


?>