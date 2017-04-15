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
$student_id = $obj->{'student_id'};
 
$polls = mysql_query("SELECT poll_id, question, expiry_date, check_poll FROM Poll WHERE student_id='$student_id'") or die(mysql_error());
 
 
if(mysql_num_rows($polls) > 0)
{	
	$response["data"] = array();
 
	while ($row = mysql_fetch_array($polls)) 
	{
            // temp user array
            $item = array();
            $item["poll_id"] = $row["poll_id"];
            $item["question"] = $row["question"];
			$item["expiry_date"] = $row["expiry_date"];
			$item["check_poll"] = $row["check_poll"];
 
            // push ordered items into response array 
            array_push($response["data"], $item);
    }
}
else 
{
      $response["data"] = -1;		//No polls to show
}
// echoing JSON response
echo json_encode($response);
 
?>
