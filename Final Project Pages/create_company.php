<html>
	<link rel="stylesheet" href="style.css">
	<?php
		include 'page_setup.php';
		prepare_page();
	?>
	<div id='body2'>
		<center>
			<?php
				$name = $_GET['name']; 
				$mailAdd = $_GET['mailAdd']; 
				$phoneNum = $_GET['phoneNum']; 
				$success = true; 
				$conn = mysqli_connect("localhost","root","root","Practicum");
				if (mysqli_connect_errno()){
					echo "Failed to connect to MySQL: " . mysqli_connect_error();
				}
				
				$quer = "INSERT INTO company VALUE('$name','$mailAdd','$phoneNum')";
				if (!mysqli_query($conn,$quer))
				{
					$error = mysqli_error($conn); 
					echo "ERROR CREATING COMPANY<br>"; 
					die('Error: ' . $error);
					$success = false; 
				}
				if($success) echo "<h1>COMPANY CREATION SUCCESS!</h1>"
			?>
			<br>
			<a href = 'home.php'><button> Return Home </button></a>
			<br><br>
			<a href = 'create_company_page.php'><button> Create Another Company </button></a>
		</center>
	</div>
</html> 