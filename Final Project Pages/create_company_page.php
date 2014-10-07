<html>

<?php
	include 'page_setup.php';
	prepare_page();
?>

<center>
<h1> Company Creation </h1>
<form action ="create_company.php">
Company Name: <input type = "text" name = "name" value = ""><br>
Mailing Address: <input type = "text" name = "mailAdd" value = ""><br>
Phone Number: <input type = "text" name = "phoneNum" value = ""><br>
<input type = "submit" name = "submit" value = "Create Company">
</form> 
</center>
</html> 