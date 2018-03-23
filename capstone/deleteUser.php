<?php
include 'databaseConfig.php';
error_reporting(E_ERROR | E_PARSE);
$db = new mysqli($hostName, $hostUser, $hostPass, $dbName);
if($db->connect_errno){
	echo "database down";
}else{
	$username = $_POST['username'];
	if($username){
		$query = "DELETE FROM user WHERE username = '" . $username . "'";
		$result = $db->query($query);
		
		if($result){
			echo "Data Deleted Successfully";
		}else{
			echo "Error Deleting Data";
		}
	}else{
		echo "Not all required values given";
	}
	$db->close();
}
?>