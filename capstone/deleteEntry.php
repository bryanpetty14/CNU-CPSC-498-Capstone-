<?php
include 'databaseConfig.php';
error_reporting(E_ERROR | E_PARSE);
$db = new mysqli($hostName, $hostUser, $hostPass, $dbName);
if($db->connect_errno){
	echo "database down";
}else{
	$username = $_POST['username'];
	$year = $_POST['year'];
	$month = $_POST['month'];
	$category = $_POST['category'];
	if($month < 10){
		$month = '0' . "$month";
	}
	if($username){
		if($category&&$year&&$month){
			$query = "delete from entry where user_username = '".$username."' and dateEntered like '".$year."-".$month."%' and category_Name = '$category'";
			$result = $db->query($query);
		}

		if($result){
			echo "Data Deleted Successfully";
		}
		else{
			echo "Error Deleteing Data";
		}
	}
	else{
		echo "Not all required values given";
	}
	$db->close();
}
?>

