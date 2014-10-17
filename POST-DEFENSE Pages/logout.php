<html>
<?php
	session_start(); 
	$_SESSION['status'] = false; 
	$_SESSION['uname'] = ""; 
	header("Location:login.php"); 
?>
</html>