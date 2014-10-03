<html>
<center>
<?php
	$name = $_GET['name']; 
	$mailAdd = $_GET['mailAdd']; 
	$phoneNum = $_GET['phoneNum']; 
	$success = true; 
	$conn = mysqli_connect("localhost","root","root","Practicum");
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	$quer = "INSERT INTO company VALUE('$name','$mailAdd','$phoneNum')";
	if (!mysqli_query($conn,$quer))
	{
		echo "ERROR CREATING COMPANY<br>"; 
		die('Error: ' . $error);
		$success = false; 
	}
	if($success) echo "<h1>COMPANY CREATION SUCCESS!</h1>"
?>
<br>
<form action = "home.php">
<input type = "submit" value = "Return to Home">
</form> 
<form action = "create_company_page.php">
<input type = "submit" value = "Create Another Company">
</form> 
</center>
</html> 