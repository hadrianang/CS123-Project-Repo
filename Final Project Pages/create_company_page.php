<html>
	<link rel="stylesheet" href="style.css">

	<?php
		include 'page_setup.php';
		prepare_page();
	?>
	<div id='body2'>
		<center>
			<h1> Company Creation </h1>
			<form action ="create_company.php">
				Company Name: <input type = "text" name = "name" value = ""><br>
				Mailing Address: <input type = "text" name = "mailAdd" value = ""><br>
				Phone Number: <input type = "text" name = "phoneNum" value = ""><br><br>
				<input type = "submit" name = "submit" value = "Create Company">
			</form> 
		</center>
	</div>
</html> 