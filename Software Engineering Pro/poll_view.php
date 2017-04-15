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
 
$options = mysql_query("SELECT option_number, description FROM Options WHERE poll_id='$poll_id'") or die(mysql_error());
 
$var = mysql_query("SELECT name FROM Student JOIN Poll ON (Student.id = Poll.student_id)") or die(mysql_error());
 
 
if(mysql_num_rows($options) > 0)
{	
	$response["data"] = array();
 
	while ($row = mysql_fetch_array($options)) 
	{
            // temp user array
            $item = array();
            $item["option_number"] = $row["option_number"];
            $item["description"] = $row["description"];
 
            // push ordered items into response array 
            array_push($response["data"], $item);
    }
 
	$temp = mysql_fetch_array($var);
	$var = array();
	$var["name"] = $temp["name"];
	array_push($response["data"], $var);
}
else 
{
      $response["data"] = -1;		//Error in retrieving poll
}
// echoing JSON response
echo json_encode($response);
 
?>
