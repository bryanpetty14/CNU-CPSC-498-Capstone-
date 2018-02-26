<?php
//grab the user name and password from the form
$username = $_POST['username'];
$password = $_POST['password'];

//used to supress weird errors
error_reporting(E_ERROR | E_PARSE);

//connect to database, only for local use right now
//will update when the AWS RDS is set up
$db = new mysqli("localhost", "user", "root", "test");
if($db->connect_errno){
	echo "database down";
}
else{
	//check the database for the user
	$query = "SELECT * FROM user WHERE username = '" . $username . "'";
	$result = $db->query($query);
	
	//see if there was anything returned
	$rows = mysqli_num_rows($result);

	if($rows != 0){
		$row = $result->fetch_assoc();
	}
	//if password is wrong or user not in database, display wrong username/password
	if(($rows == 0) || $password != $row["password"]){
?>
<script language=JavaScript>
alert("Password or Username incorrect")
</script>
<!DOCTYPE html>
<html lang="en">
<!-- head adapted from a project from https://github.com/awslabs/eb-demo-php-simple-app-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title> Capstone Budget Helper </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body {background: url(assets/img/background.png) repeat;}
      .hero-unit {background-color: white;}
    </style>
    <link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet">
    <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>

<!-- scrips adapted from old CPSC 360 project I did last semester-->
<script language=JavaScript>
	function verify( form ) {
		var name = form.elements[ "username" ];
		var pass = form.elements[ "password" ];
		if (( name.value == "" ) || ( pass.value == "" )) {
			alert( "Password or username can't be blank" );
			return false;
		}
		return true;
	}
</script>
<script language=JavaScript>
	function checkValues( form ) {
		var month = form.elements[ "Month" ];
		var year = form.elements[ "Year" ];
		if( (isNaN(month.value) ) || (isNaN(year.value))){
			alert("Please enter numbers only");
			return false
		} 
		else if ((month.value <0 ) || ( month.value >12 )) {
			alert( "Month cannot be less than 0 or greater than 12" );
			return false;
		}
		return true;
	}
</script>

<body>
	<div class="container">
		<h1>Capstone Budget Helper</h1>
		<h2>Login</h2>
		<form action = "password.php" method = "post" onsubmit = "return verify(this)">
			<div class="w3-row-padding">
				<div class="w3-half">
					<label>Username</label>
					<input type="text" name="username" value = <?php echo "$username"?> id= "username" class="input-xxlarge" placeholder= "Username">
				</div>
				<div class="w3-half">
					<label>Password</label>
					<input type="password" name="password" id="password" class="input-xxlarge" placeholder = "Password">
				</div>
			</div>
			<input type="submit" value="Submit">
		</form>
		<br></br>
	</div> 
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
  </body>

</html>
<?php
	}
	//user in the database
	//ask them what month and year they would like to view
	else{?>
<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Capstone Budget Helper</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link href="assets/css/bootstrap.min.css" rel="stylesheet">
		<style>
		  body {background: url(assets/img/background.png) repeat;}
		  .hero-unit {background-color: white;}
		</style>
		<link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet">
		<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	</head>
	<body>
		<div class = "container">
			<h2>Input Month and Year that you would like to view</h2>
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
		<br></br>
		</div> 
		<!-- scripts adapted from a project from https://github.com/awslabs/eb-demo-php-simple-app-->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
	</body>
</html>
<?php
	}
}?>
