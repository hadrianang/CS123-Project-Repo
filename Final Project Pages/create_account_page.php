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
<h1> Account Creation Page </h1>
<form action = "create_account.php">
Username: <input type = "text" name = "username" value = ""><br>
Password: <input type = "password" name = "password" value = ""><br>
Name: <input type = "text" name = "name" value =""><br>
ID Number (if student or faculty): <input type = "text" name = "idnum" value =""> <br>
Course (if student): 
<select name = "course">
	<option value="bs cs">BS CS</option>
	<option value="bsms cs">BSMS CS</option>
	<option value="bs mis">BS MIS</option>
	<option value="bsms mis">BS MIS - MS CS</option>
</select>
<br>
Account Type:
<select name = "type">
  <option value="student">Student</option>
  <option value="mentor">Mentor</option>
  <option value="faculty">Faculty</option>
</select>
<br><br>
<font color="red">For Mentor Accounts:</font><br>
<?php
	$conn = mysqli_connect("localhost","root","root","Practicum");
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$quer = "SELECT Name FROM Company"; 
	$companies = mysqli_query($conn, $quer); 
?>
Company:
<select name="company">
	<?php while ($arr = mysqli_fetch_array($companies)): ?>
		<option><?php echo $arr['Name']; ?></option>
	<?php endwhile; ?>
</select><br>
Department: <input type = "text" name = "department" value = ""><br>
Title: <input type = "text" name = "title" value = ""><br><br>
<input type = "submit" name = "submit" value = "Create Account">
</form> 
</center>
</html>