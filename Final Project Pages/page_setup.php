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
		</div>
		<!--Home Page-->
		<div align = 'right'>
		<form action='home.php'> 
		<input type='submit' name='home' value='Home'> 
		</form>
		</div> 

		<!--Logout code-->
		<div align = 'right'>
		<form action='logout.php'> 
		<input type='submit' name='logout' value='Log-out'> 
		</form>
		</div> ";
		return $user; 
	}
?>
</html>