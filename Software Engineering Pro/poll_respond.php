<?php
error_reporting(0);
include("db_config.php");
 
// array for JSON response
$response = array();
 
if( !(empty($_POST['data'])))
{
	$data=$_POST['data'];
}
 
$obj = json_decode($data);
$poll_id = $obj->{'poll_id'};
$option_number = $obj->{'option_number'};
 
$result = mysql_query("UPDATE Options SET number_of_resp = number_of_resp + 1 WHERE poll_id='$poll_id' AND option_number='$option_number'") or die(mysql_error());
 
 
if($result > 0)
{	
	$response["data"] = 1;		//Success
}
else 
{
      $response["data"] = -1;		//Failure
}
// echoing JSON response
echo json_encode($response);
 
?>
