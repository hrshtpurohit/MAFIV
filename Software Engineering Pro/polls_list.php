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
$audience = $obj->{'audience'};
 
$row1 = mysql_query("SELECT semester FROM Student WHERE id='$audience'") or die(mysql_error());
$row2 = mysql_query("SELECT branch FROM Student WHERE id='$audience'") or die(mysql_error());
 
$var1 = mysql_fetch_assoc($row1)['semester'];
$var2 = mysql_fetch_assoc($row2)['branch'];
 
$var1 = intval($var1/2);
 
if($var2=="CS")
	$var1 = $var1*2+1;
else
	$var1 = $var1*2+2;
 
$x = mysql_query("SELECT poll_id FROM Poll_Audience WHERE audience='$var1'") or die(mysql_error());
$polls = mysql_query("SELECT DISTINCT Poll.poll_id AS poll_id, question, expiry_date FROM Poll JOIN (SELECT poll_id FROM Poll_Audience WHERE audience='$var1') AS x ON (check_poll='1')") or die(mysql_error());
 
 
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
