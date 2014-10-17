<html>
<?php
	
	function prepare_page()
	{
		//check if logged-in
		$status = false; 
		session_start(); 
		$status = $_SESSION['status']; 
		$user = $_SESSION['uname']; 
		if(!$status) header('Location:login.php'); 
		
		echo "<div align = 'left'> Logged in as $user </div>";
		echo"
		<div id = 'menu_bar'>
			PracSys
		</div>";
		return $user; 
	}
	
	function sql_setup()
	{
		$conn = mysqli_connect("localhost","root","root","Practicum");
		return $conn; 
	}
?>
</html>