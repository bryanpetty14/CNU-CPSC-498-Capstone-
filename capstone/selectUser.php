<?php
include 'databaseConfig.php';
error_reporting(E_ERROR | E_PARSE);
$db = new mysqli($hostName, $hostUser, $hostPass, $dbName);
if($db->connect_errno){
	echo "database down";
}else{
	$username = $_POST['username'];
	if($username){
		$query = "SELECT * FROM user WHERE username = '" . $username . "'";
		$result = $db->query($query);
		
		//adapted from www.camposha.info/android/php-mysql-listview/
		while($row = mysqli_fetch_array($result)){
			$flag[] = $row;
		}
		if($flag){
			print(json_encode($flag));
		}else{
			echo "[]";
		}
	}else{
		echo "bad values";
	}
	$db->close();
}
?>