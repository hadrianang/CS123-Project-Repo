<html><title>PracSys: Ateneo DISCS Practicum Management System</title>
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
				<input type = "submit" value = "Create Company" onclick="this.disabled=true;this.value='Sending, please wait...';this.form.submit();">
			</form> 
		</center>
	</div>
</html> 