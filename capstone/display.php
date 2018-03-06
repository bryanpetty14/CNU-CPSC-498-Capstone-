<!DOCTYPE html>
<?php
//grab the username, month and year from the form
$monthNoZero = $_POST["Month"];
$year = $_POST["Year"];
$username = $_POST["username"];

//adds a 0 on the value of the month if it is less that 10
//this is so that the SQL query will look for 01/2017 instead of 1/2017
//so that the results will not include 11/2017 if the user choose 1
if($monthNoZero < 10){
	$month = '0' . "$monthNoZero";
}else{
	$month = $monthNoZero;
}

//connect to database, only for local use right now
//will update when the AWS RDS is set up
$db = new mysqli("localhost", "user", "root", "test");
$categories  = $db->query("select * from category");
$query = "select * from entry where user_username = '".$username."' and dateEntered like '".$year."-".$month."%'";
$result = $db->query($query);

//see if there was anything returned
$rows = mysqli_num_rows($result);
?>
<html lang="en">
<!-- head adapted from a project from https://github.com/awslabs/eb-demo-php-simple-app-->
  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" title = "bootstrapStyle">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<nav class = "navbar navbar-light" style="background-color: #CDCDCD;">
		<div class = "container-fluid">
			<div class = "navbar-header">
				<h1>Capstone Budget Helper</h1>
			</div>
		</div>	
	</nav>

	<meta http-equiv="Content-Style" content="bootstrapStyle">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title> Capstone Budget Helper </title>


    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body {background: url(assets/img/background.png) repeat;}
      .hero-unit {background-color: white;}
    </style>
    <link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet">
    <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

	<!-- bootstrap things-->

	
<!-- scrips adapted from old CPSC 360 project I did last semester-->	
<script language=JavaScript>
	function verifyValues( form ) {
		var month = form.elements[ "Month" ];
		var year = form.elements[ "Year" ];
		if( (isNaN(month.value) ) || (isNaN(year.value))){
			alert("Please enter numbers only");
			return false
		} 
		else if (( parseInt(month.value) <0 ) || ( parseInt(month.value) >12 )) {
			alert( "Month cannot be less than 0 or greater than 12" );
			return false;
		}
		return true;
	}
</script>

<style>
table { 
    display: table;
    border-collapse: separate;
    border-color: black;
}
th {
    padding: 8px;
	background-color: #a00000;
	color: white;
	text-align: center;
}
td {
	padding: 8px;
}
tr:hover{
	background-color: #fff5f5;
}
</style>
</head>

  <body>

    <div class="container">

		

		<!-- sign out button, takes the user back to the login screen-->
		<p><a href="index.html" class="btn"><b></b> Sign Out</a></p>
	
	<b style = "font-size:25px;">Input Month and Year that you would like to view</b>
	<br></br>
	<!-- allows the user to enter in a different date combination to view different months and years-->
	<form name = "dostuff" action = "display.php" method = "post" onsubmit = "return verifyValues(this)">
		<div class="w3-row-padding">
			<div class="w3-half">
				<label>Month (From 1 to 12)</label>
				<input type="number" 
					   name="Month" 
					   value = "<?php echo "$monthNoZero"?>" 
					   id="month" 
					   class="input-xxlarge"/
					   min = "0" max ="12" 
					   placeholder="Month"
					   list="months">
					<datalist id="months">
						<option value="0">
						<option value="1">
						<option value="2">
						<option value="3">
						<option value="4">
						<option value="5">
						<option value="6">
						<option value="7">
						<option value="8">
						<option value="9">
						<option value="10">
						<option value="11">
						<option value="12">
					</datalist>
			</div>
			<div class="w3-half">
				<label>Year</label>
				<input type="number" name="Year" id="year" value = "<?php echo"$year"?>" class="input-xxlarge" min = "0" max ="9999"  placeholder = "Year">
			</div>
		</div>
		<input type="hidden" name="username" value = "<?php echo "$username"?>">
		<input type="submit" value="New Date">
	</form>
 

<div class="hero-unit">
    <div class="row-fluid">
	<?php 
	$query = "select * from entry where user_username = '".$username."' and dateEntered like '".$year."-".$month."%'";
	$result = $db->query($query);

	//see if there was anything returned
	$rows = mysqli_num_rows($result);
	$catRows = mysqli_num_rows($categories);
	//if no rows, that means no entries in the entry table
	if($rows == 0){
		echo "<b style = \"font-size:35px;\"> There are no entries for the month and year " 
		. $month ."/". $year . " for user \"" . $username . "\"</b>";
		$categoryTable = $db->query("select * from category");
		echo "		<br></br>
		<p style = \"font-size:30px;\">Current categories </p>
		<dl>";
		$numbCats = mysqli_num_rows($categoryTable);
		for($i = 0; $i<$numbCats; $i++){
			$catAssoc = $categoryTable->fetch_assoc();
			$catN = $catAssoc['categoryName'];
			$catD = $catAssoc['descriptionOfCategory'];	
			echo "<dt>>$catN</dt>";
			echo "<dd> - $catD </dd><br></br>";
			}
		echo "</dl>";
	} else{//there are entries, displace them all in a table
		echo "<b style = \"font-size:35px;\"> $username's expense log for the month " . $month ."/". $year."</b>";
		
		$catsWithoutEntries = 0;
		$catsWOEntriesArray = array();
		$catDescription = array();
		
		while($catRows != 0){
			$catRows = $catRows-1;
			$catList = $categories->fetch_assoc();
			$catName = $catList['categoryName'];
			$catDescript = $catList['descriptionOfCategory'];
			$query = "select * from entry where user_username = '".$username."' and category_Name = '".$catName."' and dateEntered like '".$year."-".$month."%'";
			$result = $db->query($query);
			$rowsForCat = mysqli_num_rows($result);	
			if($rowsForCat != 0){?>
			<table class='display'>
				<table border = "2" cellpadding ="8">
				<?php echo "<br></br><p style = \"font-size:30px;\">For the $catName category </p>"?>
				<tr class='highlight'>
					<th><h3> Date Entered </h3><p> (yyyy-mm-dd) </p></th>
					<th><h3> Desciption </h3></th>
					<th><h3> Amount spent </h3></th>
				</tr>
				<?php 
					$total = 0;
					for($i = 0; $i<$rowsForCat; $i++){
						$row = $result->fetch_assoc();
						//$category = $row["category_Name"];
						$date = $row["dateEntered"];
						$descript = $row["description"];
						$amount = $row["cost"];
						$total = $total + $amount;
						echo 
							"<tr class='highlight'>
								<td><p>$date</p></td>
								<td><p>$descript</p></td>
								<td><p>$amount</p></td>
							</tr>";
					}
					echo 
							"<tr class='highlight'>
								<td><h4></h4></td>
								<td><p>Total Spent in  ". $catName . " in " . $month ."/". $year ."</p></td>
								<td><h4>$total</h4></td>
							</tr>";
			
				?></table>
			</table>
				<?php
				}
			else{
				$catsWOEntriesArray[$catsWithoutEntries] = $catName;
				$catDescription[$catsWithoutEntries] = $catDescript;
				$catsWithoutEntries = $catsWithoutEntries + 1;
				}
		}?>
		<br></br>
		<p style = "font-size:30px;">Other possible categories </p>
		<dl>
		<?php
		for($i = 0; $i<$catsWithoutEntries; $i++){
			echo "<dt>$catsWOEntriesArray[$i]</dt>";
			echo "<dd>- $catDescription[$i] </dd>";
			}
		echo "</dl>";
	}?>
    </div>
</div>

	  
	      </div> 
<!-- script adapted from a project from https://github.com/awslabs/eb-demo-php-simple-app-->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
  </body>

</html>