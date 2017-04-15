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
$search = $obj->{'search'};		//title, author or type
$name = $obj->{'name'};
 
if ($search=="author")
{
	$result = mysql_query("SELECT title, author, type, avail, issue_id, issue_date, expected_return_date FROM Library WHERE author='$name'") or die(mysql_error());
}
else if ($search=="title")
{
	$result = mysql_query("SELECT title, author, type, avail, issue_id, issue_date, expected_return_date FROM Library WHERE title='$name'") or die(mysql_error());
}
else if ($search=="type")
{
	$result = mysql_query("SELECT title, author, type, avail, issue_id, issue_date, expected_return_date FROM Library WHERE type='$name'") or die(mysql_error());
}
 
//currently it features only direct search. Will add dynamic search soon.
// make "avail" as count of books ie if 3 such books are available then sum their avails and set as "avail" 
 
if(mysql_num_rows($result) > 0)
{	
	$response["data"] = array();
 
	while ($row = mysql_fetch_array($result)) 
	{
            // temp user array
            $item = array();
            $item["title"] = $row["title"];
            $item["author"] = $row["author"];
	                $item["type"] = $row["type"];
			$item["avail"] = $row["avail"];
			$item["issue_date"] = $row["issue_date"];
			$item["issue_id"] = $row["issue_id"];
			$item["expected_return_date"] = $row["expected_return_date"];
 
 
            // push ordered items into response array 
            array_push($response["data"], $item);
    }
}
else 
{
      $response["data"] = -1;		//No such book in library
}
// echoing JSON response
echo json_encode($response);
 
?>	
