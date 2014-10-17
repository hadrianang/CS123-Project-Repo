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
		<link rel='stylesheet' href='style.css'>
		<div id = 'menu_bar'>
		<li class = 'logo'> <img src='testlogo.png' width='100' height='12' alt='TEST'> </li>
		<li class = 'link'> <a href='home.php'> Home </a></li> 
		<li class = 'link'> <a href='logout.php'> Log Out </a></li> 
		</div>";
		return $user; 
	}
	
	function sql_setup()
	{
		$conn = mysqli_connect("localhost","root","root","PracSys");
		return $conn; 
	}
?>