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
$question = $obj->{'question'};
$expiry_date = $obj->{'expiry_date'};
$student_id = $obj->{'student_id'};
$check_poll = 0;
$number_of_options = $obj->{'number_of_options'};
 
$option = array();
 
 
for($i=0;$i<$number_of_options;$i++)
	$option[$i] = $obj->{'description'}[$i];
 
$number_of_audience = $obj->{'number_of_audience'};
$audience = array();
for($i=0;$i<$number_of_audience;$i++)
	$audience[$i] = $obj->{'audience'}[$i];
 
$insert_poll = mysql_query("INSERT INTO Poll VALUES (NULL, '$question','$number_of_options','$expiry_date','$check_poll', '$student_id')") or die(mysql_error());
 
$q1 = mysql_query("SELECT poll_id FROM Poll WHERE question = '$question' AND number_of_options = '$number_of_options' AND expiry_date = '$expiry_date' AND student_id = '$student_id'") or die(mysql_error());
 
$var = mysql_fetch_assoc($q1)['poll_id'];
$resp = 0;
 
for($i=0;$i<$number_of_options;$i++)
{
	$x = $i+1;
	$insert_opt = mysql_query("INSERT INTO Options VALUES ('$x','$var','$option[$i]','$resp')") or die(mysql_error());
}
 
for($i=0;$i<$number_of_audience;$i++)
	$insert_aud = mysql_query("INSERT INTO Poll_Audience VALUES ('$var','$audience[$i]')") or die(mysql_error());
 
if($insert_poll > 0 && $insert_opt > 0 && $insert_aud > 0)
{	
	$response["data"] = 1;
 
 
}
else 
{
      $response["data"] = -1;		//No such book in library
}
// echoing JSON response
echo json_encode($response);
 
?>
