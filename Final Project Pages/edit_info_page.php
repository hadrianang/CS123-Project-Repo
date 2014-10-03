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
<center>
<?php
	$conn = mysqli_connect("localhost","root","root","Practicum");
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$quer = "SELECT * FROM account WHERE Username = '$user'"; 
	$temp = mysqli_query($conn, $quer); 
	$results = mysqli_fetch_array($temp);
	echo "Username: " . $results['Username'] . "<br>";
	echo "E-mail Address: " . $results['Email'] . "<br>";
	echo "Name: " . $results['Name'] . "<br>";
	echo "Contact Number: " . $results['ContactNumber'] . "<br>";
?>
<br>
<form action = "edit_info.php">
E-mail Address: <input type = "text" name = "email" value = ""> <br> 
Contact Number: <input type = "text" name = "contactNum" value = ""> <br>
<input type = "submit" name = "submit" value = "Update Info"> <br>
</center>
</form>
</html> 