<html>
<body>
<?php
include 'page_setup.php';
prepare_page();
$con=sql_setup();

echo "<div id='body2'>";

if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if(!mysqli_query($con, "INSERT INTO Form (Name, AccountPath, Active) VALUES('Unnamed Form', '   ', FALSE);")){
	die( "Failed to create new form." );
}

mysqli_close($con);
echo "Success!<br>";
echo "<a href=\"faculty_modify_forms.php\">Return</a>";
echo "</div>";
?>
</body>
</html>