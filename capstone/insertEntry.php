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
	$description = $_POST['description'];
	$amount = $_POST['amount'];
	$place = $_POST['place'];
	if($month < 10){
		$month = '0' . "$month";
	}
	if($username && $category && $year && $month && $day && $description && $amount && $place){
		$query = "insert into entry (user_userName, category_Name, dateEntered, description, cost, placeSpent) 
	values ('$username', '$category','$year-$month-$day','$description', $amount, '$place')";
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