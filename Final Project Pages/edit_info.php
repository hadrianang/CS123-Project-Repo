<html>
	<center>
		<link rel="stylesheet" href="style.css">

		<?php
			session_start(); 
			$user = $_SESSION['uname'];
			$success = true; 
			$conn = sql_setup();
			echo "<div id='body2'>";
			if (mysqli_connect_errno()){
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}
			
			$email = $_GET['email']; 
			$contact = $_GET['contactNum']; 
			
			$quer = "UPDATE account 
			SET Email = '$email', ContactNumber = '$contact'
			WHERE Username = '$user'"; 
			if(!mysqli_query($conn,$quer))
			{
				$error = mysqli_error($conn); 
				echo "ERROR UPDATING ACCOUNT INFO<br>"; 
				die('Error: ' . $error);
				$success = false; 
			}
			if($success) echo "<h1> ACCOUNT INFO UPDATED </h1>"; 
		?>
		<br>
		<a href = 'home.php'><button> Return Home </button></a>
		</div>
	</center>
</html> 