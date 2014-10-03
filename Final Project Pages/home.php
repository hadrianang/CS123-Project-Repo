<html>
<body>
<?php 
	//check if logged-in
	$status = false; 
	session_start(); 
	$status = $_SESSION['status']; 
	if(!$status) header('Location:login.php'); 
	$user = $_SESSION['uname']; 
	echo "<div align = 'left'> Logged in as $user </div>";
?>
<div align = "right">
<form action="login.php"> 
<input type="submit" name="logout" value="Log-out"> 
</form>
</div> 
<center>
	<h1>HELLO THIS IS THE HOME PAGE</h1>
</center>

</body>
</html>