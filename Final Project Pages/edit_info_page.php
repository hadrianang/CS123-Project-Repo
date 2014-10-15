<html>
	<link rel="stylesheet" href="style.css">

		<?php
			include 'page_setup.php';
			$user = prepare_page();
		?>
		<div id='body2'>
			<center>
				<h1> UPDATE ACCOUNT INFORMATION </h1><br>
				<?php
					$conn = sql_setup();
					if (mysqli_connect_errno()){
						echo "Failed to connect to MySQL: " . mysqli_connect_error();
					}
					$quer = "SELECT * FROM account WHERE Username = '$user'"; 
					$temp = mysqli_query($conn, $quer); 
					$results = mysqli_fetch_array($temp);
					echo "Username: " . $results['Username'] . "<br>";
					echo "E-mail Address: " . $results['Email'] . "<br>";
					echo "Name: " . $results['Name'] . "<br>";
					echo "Contact Number: " . $results['ContactNumber'] . "<br>";
				?>
				<br>
				*Re-type fields even if only one of them needs updating
				<form action = "edit_info.php">
					New E-mail Address: <input type = "text" name = "email" value = ""> <br> 
					New Contact Number: <input type = "text" name = "contactNum" value = ""> <br><br>
				<input type = "submit" name = "submit" value = "Update Info"> <br>
			</center>
		</div>
	</form>
</html> 