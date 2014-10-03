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
<!--Home Page-->
<div align = "right">
<form action="home.php"> 
<input type="submit" name="home" value="Home"> 
</form>
</div> 

<!--Logout code-->
<div align = "right">
<form action="login.php"> 
<input type="submit" name="logout" value="Log-out"> 
</form>
</div> 



<center>
<h1> Company Creation </h1>
<form action ="create_company.php">
Company Name: <input type = "text" name = "name" value = ""><br>
Mailing Address: <input type = "text" name = "mailAdd" value = ""><br>
Phone Number: <input type = "text" name = "phoneNum" value = ""><br>
<input type = "submit" name = "submit" value = "Create Company">
</form> 
</center>
</html> 