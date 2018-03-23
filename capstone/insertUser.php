<?php
include 'databaseConfig.php';
error_reporting(E_ERROR | E_PARSE);
$db = new mysqli($hostName, $hostUser, $hostPass, $dbName);
if($db->connect_errno){
	echo "database down";
}else{
	$username = $_POST['username'];
	$password = $_POST['password'];
	if($username && $password){
		$query = "insert into user(username,password) values ('$username','$password')";
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