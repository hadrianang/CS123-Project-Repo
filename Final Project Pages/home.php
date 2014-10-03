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
	<a href=create_account_page.php>Create Account</a><br>
	<a href=link_student_page.php>Link Students and Mentors</a><br>
	<a href=create_company_page.php>Create Company</a><br>
	<a href=edit_info_page.php>Update Account Information</a><br>
</center>

</body>
</html>