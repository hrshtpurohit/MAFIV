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
 
$result = mysql_query("SELECT option_number, description, number_of_resp FROM Options WHERE poll_id='$poll_id'") or die(mysql_error());
 
 
if(mysql_num_rows($result) > 0)
{	
	$response["data"] = array();
 
	while ($row = mysql_fetch_array($result)) 
	{
            // temp user array
            $item = array();
            $item["option_number"] = $row["option_number"];
            $item["description"] = $row["description"];
			$item["number_of_resp"] = $row["number_of_resp"];
 
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
