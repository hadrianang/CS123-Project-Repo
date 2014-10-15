<html>
<?php
	function prepare_page()
	{
		//check if logged-in
		$status = false; 
		session_start(); 
		$status = $_SESSION['status']; 
		$user = $_SESSION['uname']; 
		$type = $_SESSION['type'];
		if(!$status) header('Location:login.php'); 
		
		echo "<div align = 'left'> Logged in as $user </div>";
		echo"
		<div id = 'menu_bar'>
			PracSys
		</div>";
		$hold = array($user, $type); 
		return $hold;
	}
?>
</html>