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
	if($month < 10){
		$month = '0' . "$month";
	}
	if($username&&$year&&$month){
		$query = "select * from entry where user_username = '".$username."' and dateEntered like '".$year."-".$month."%'";
		$result = $db->query($query);
		if($result){	//adapted from www.camposha.info/android/php-mysql-listview/
			while($row = mysqli_fetch_array($result)){
				$flag[] = $row;
			}
			echo(json_encode($flag));
		}
		else{
			echo "nah";
		}
	}
	else{
		echo "bad values";
	}
	$db->close();
}
?>

