<?php
include 'databaseConfig.php';
error_reporting(E_ERROR | E_PARSE);
$db = new mysqli($hostName, $hostUser, $hostPass, $dbName);
if($db->connect_errno){
	echo "database down";
}else{
	$username = $_POST['username'];
	$category = $_POST['category'];
	$year = $_POST['year'];
	$month = $_POST['month'];
	$day = $_POST['day'];
	$userGen = $_POST['userGenerated'];
	$amount = $_POST['amount'];
	if($month < 10){
		$month = '0' . "$month";
	}
	if($username && $category && $year && $month && $day  && $amount && $userGen){
		$query = "insert into budget values ('$username', '$category', $userGen, '$year-$month-$day', $amount)";
		$result = $db->query($query);
		if($result){
			echo "Data Inserted Successfully";
		}else{
				echo "Error Inserting Data";
		}
	}
	else{
		echo "Not all required values given";
	}
	$db->close();
}
?>