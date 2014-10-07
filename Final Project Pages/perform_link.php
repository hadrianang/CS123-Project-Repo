<html>
<center>
<?php
	$success = true; 
	$string = $_GET['mentorName'];
	$tok = explode(" : ", $string); 
	$mentorUsername = $tok[1];
	$student = $_GET['student'];
	$conn = mysqli_connect("localhost","root","root","Practicum");
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$quer = "UPDATE account_student
	SET Mentor = '$mentorUsername'
	WHERE Username = '$student'";
	if(!$arr = mysqli_query($conn, $quer))
	{
		$success = false; 
		$error = mysqli_error($conn); 
		echo "ERROR LINKING ACCOUNTS<br>"; 
		die('Error: ' . $error);
	}
	if($success) echo "<h1> SUCCESSFULLY LINKED STUDENT AND MENTOR! <h1>" 
?>
<br>
<form action = "home.php">
<input type = "submit" value = "Return to Home">
</form> 
<form action = "link_student_page.php">
<input type = "submit" value = "Link More Accounts">
</form> 

</center> 
</html>
