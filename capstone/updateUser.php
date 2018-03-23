<?php
include 'databaseConfig.php';
error_reporting(E_ERROR | E_PARSE);
$db = new mysqli($hostName, $hostUser, $hostPass, $dbName);
if($db->connect_errno){
	echo "database down";
}else{
	$username = $_POST['username'];
	$income = $_POST['income'];
	if($username && $income){
		$query = "UPDATE user SET income = $income where username = '$username'";
		$result = $db->query($query);
		if($result){
			echo "Data Inserted Successfully";
		}else{
			echo "Error Inserting Data";
		}
	}else{
		echo "Not all required values given";
	}
	$db->close();
}
?>