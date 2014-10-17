<html><title>PracSys: Ateneo DISCS Practicum Management System</title>
<link rel="stylesheet" href="style.css">
<head>
<?php
include 'page_setup.php';
$temp = prepare_page();
$con=sql_setup();

if (mysqli_connect_errno()) {
	die( "Failed to connect to MySQL: " . mysqli_connect_error() );
}
?>
</head>
<body>
<div id='body2'>
<center>
<?php
	echo "<h1>Modify Pages</h1><br>";
	$types = array("Student", "Mentor", "Faculty");
	
	$result = mysqli_query($con, "SELECT * FROM Form;");
	echo "<form id=\"form\" name=\"form\" method=\"post\" action=\"faculty_modify_forms_action.php\">";
	echo "<table class=\"custom\">";
	echo "<tr><th>Form Name</th><th>Path 1</th><th>Path 2</th><th>Path 3</th><th>Active?</th></tr>";
	$count = 0;
	while($row = mysqli_fetch_array($result)){
		echo "<tr" . ($count++%2==0?"":" class=\"alt\"") . ">";
		$tmp = $row['ID'];
		$tmp2 = $row['Name'];
		echo "<td><a href=\"ModifyForm.php?id=$tmp\">$tmp2</a></td>";
		for($i=0; $i<3; $i++){
			echo "<td>";
			echo "<select id=\"$tmp" . "_$i\" name=\"$tmp" . "_$i\" form=\"form\"><option value=\"\"></option>";
			for($j=0; $j<3; $j++){
				echo "<option value=\"$types[$j]\"";
				if($i < strlen($row['AccountPath']) && $row['AccountPath'][$i] == $types[$j][0]){
					echo " selected=\"selected\"";
				}
				echo ">$types[$j]</option>";
			}
			echo "</select>";
			echo "</td>";
		}
		echo "<td>";
		echo "<input type=\"checkbox\" name=\"$tmp" . "_box\"";
		if($row['Active']){
			echo "checked";
		}
		echo "></input>";
		echo "</td>";
		echo "</tr>";
	}
	echo "</table>";
	echo "<input type=\"submit\" value=\"Update Forms\" onclick=\"this.disabled=true;this.value='Sending, please wait...';this.form.submit();\"></input>";
	echo "</form>";
?>
<form action="faculty_create_form_action.php">
<input type="submit" value="New Form" onclick="this.disabled=true;this.value='Sending, please wait...';this.form.submit();"></input>
</form>
</center>
</div>
</body>
</html>