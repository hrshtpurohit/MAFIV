<?php
error_reporting(0);
include("db_config.php");
 
// array for JSON response
$response = array();
 
//using arithmetics evaluate the audience for the poll on android and send it here
 
if( !(empty($_POST['data'])))
{
	$data=$_POST['data'];
}
 
$obj = json_decode($data);
$poll_id = $obj->{'poll_id'};
 
$q1 = mysql_query("DELETE FROM Poll WHERE poll_id='$poll_id'") or die(mysql_error());
$q2 = mysql_query("DELETE FROM Options WHERE poll_id='$poll_id'") or die(mysql_error());
$q3 = mysql_query("DELETE FROM Poll_Audience WHERE poll_id='$poll_id'") or die(mysql_error());
 
if($q1>0 && $q2>0 && $q3>0)
{	
	$response["data"] = 1;		//Deleted
}
else 
{
      $response["data"] = -1;		//Cannot delete
}
// echoing JSON response
echo json_encode($response);
 
?>
