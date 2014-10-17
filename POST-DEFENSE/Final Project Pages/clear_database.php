<html>
<body>
<?php
include 'page_setup.php';
$con=sql_setup();
$user=prepare_page();

if(mysqli_connect_errno()){
	die("Failed to connect to MySQL: " . mysqli_connect_error());
}

echo "<div id='body2'>";

$tables = array("Element_Table_Column", "Element_Table_Row", "Element_Table", "Element_RadioCluster_Header", "Element_RadioCluster_Section", "Element_RadioCluster", "Element_DropDown_Choice", "Element_DropDown", "Element_TextArea", "Element_Field", "Element_PlainText", "Answer", "Element", "Comments", "FormInstance", "Form", "Account_Faculty", "Account_Student", "Account_Mentor", "Company", "Account");

foreach($tables as $value){
	if(!mysqli_query($con, "DELETE FROM $value WHERE TRUE;")){
		die ("Failed to delete $value table contents.");
	}
	if(!mysqli_query($con, "ALTER TABLE $value AUTO_INCREMENT = 1")){
		die ("Failed to reset $value table counter.");
	}
}

if(!mysqli_query($con, "INSERT INTO Account VALUES('root', 'root', '', 'root', '', 'faculty');")){
	die("Failed to insert new root account.");
}
if(!mysqli_query($con, "INSERT INTO Account_Faculty VALUES('root', -1);")){
	die("Failed to insert new root account.");
}

mysqli_close($con);
echo "Success! Please login again with root.";
echo "<br><a href='login.php'>Return to Login Screen</a>";
echo "</div>";
?>
</body>
</html>