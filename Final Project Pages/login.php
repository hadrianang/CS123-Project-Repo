<!DOCTYPE HTML> 
<html>
<body> 

<?php
	session_start();
	$start = true; 
	
	$uname = $pass = "";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$start = false; 
		$uname = test_input($_POST["Username"]); 
		$pass = test_input($_POST["Password"]); 
	}
	function test_input($data) {
	   $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}
?>
<center>
<h1>Practicum System Log-in</h1>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
Username: <input type="text" name="Username" value="">
<br><br>
Password: <input type="password" name="Password" value="">
<br><br>
<input type="submit" name="submit" value="Submit"> 
</form>
</center>

<?php
date_default_timezone_set("Asia/Manila");
	$u = $uname;
	$p = $pass;
	$conn = mysqli_connect("localhost","root","root","Practicum");
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$quer = mysqli_query($conn, "SELECT * FROM account WHERE Username = '" . $u ."'"); 
	$row = mysqli_fetch_array($quer);
	
	$success = true; 
	if($row==null) $success=false; 
	else if($p!=$row["Password"]) $success = false; 
	if(!$start)
	{
		if($success)
		{
			//page different depending on account type
			$loggedin = true; 
			$_SESSION['status'] = $loggedin;
			$_SESSION['uname'] = $uname;
			header('Location: home.php');  
		}
		else echo "<font color = 'red'> <p align=center>(Invalid Username or Password) </p> </font>";
	}
	mysqli_close($conn);

?>

</body>
</html>