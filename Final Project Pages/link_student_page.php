<html>
<?php 
	//check if logged-in
	$status = false; 
	session_start(); 
	$status = $_SESSION['status']; 
	if(!$status) header('Location:login.php'); 
	$user = $_SESSION['uname']; 
	echo "<div align = 'left'> Logged in as '$user' </div>";
?>

<!--Logout code-->
<div align = "right">
<form action="login.php"> 
<input type="submit" name="logout" value="Log-out"> 
</form>
</div> 
<h1>List of Practicum Students</h1>
<?php
	
	$conn = mysqli_connect("localhost","root","root","Practicum");
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$quer = "SELECT * FROM account WHERE Type = 'student' ORDER BY Name"; 
	$results = mysqli_query($conn, $quer); 
	//change link below when needed
	while ($arr = mysqli_fetch_array($results))
	{
		$u = $arr['Username']; 
		$n = $arr['Name']; 
		echo "<a href=link_student.php?username=" . $u . "&name=" . $n ."> $n</a><br>";
	}
?>
</html> 