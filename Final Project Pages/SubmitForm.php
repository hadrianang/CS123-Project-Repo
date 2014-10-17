<html><title>PracSys: Ateneo DISCS Practicum Management System</title>
<body>
<?php
include 'page_setup.php';
$con=sql_setup();
$user=prepare_page();

if(mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

echo "<div id='body2'>";
$formID = $_GET['id'];
$student = $_GET['username'];

$result = mysqli_query($con, "SELECT * FROM FormInstance WHERE Username='$student' AND FormID=$formID;");
$updating = FALSE;
$step = 0;
if(mysqli_num_rows($result) != 0){
	$updating = TRUE;
	$step = mysqli_fetch_array($result)['Step'];
	if(!mysqli_query($con, "DELETE FROM FormInstance WHERE Username='$student' AND FormID=$formID;")){
		die("Failed to remove old instance.");
	}
}

$step = $step+1;
if(!mysqli_query($con, "INSERT INTO FormInstance (Username, FormID, Step, LastResponse) VALUES ('$student', $formID, $step, TRUE);")){
	die('Error: ' . mysqli_error($con));
}
$result = mysqli_query($con, "SHOW TABLE STATUS FROM PracSys WHERE Name='FormInstance'");
$instanceID = mysqli_fetch_array($result)['Auto_increment'] - 1;

foreach($_POST as $key => $value){
	$params = explode('_', $key);
	if($params[0] == "comment") continue;
	$databaseID = intval($params[2]);
	$sql = "";
	switch($params[3]){
		case "field": case "area": case "drop":
			$sql = "INSERT INTO Answer (ElementID, InstanceID, Val) VALUES ($databaseID, $instanceID, '$value');";
			break;
		case "radio":
			$tmp = $params[5];
			$sql = "INSERT INTO Answer (ElementID, InstanceID, Param1, Val) VALUES ($databaseID, $instanceID, $tmp, '$value');";
			break;
		case "table":
			$tmp = $params[4];
			$tmp2 = $params[5];
			$sql = "INSERT INTO Answer (ElementID, InstanceID, Param1, Param2, Val) VALUES ($databaseID, $instanceID, $tmp, $tmp2, '$value');";
			break;
	}
	if(!mysqli_query($con, $sql)){
		die('Error: ' . mysqli_error($con));
	}
}

$result = mysqli_query($con, "SELECT * FROM Account WHERE Username='$user';");
$type = mysqli_fetch_array($result)['Type'];

mysqli_close($con);
echo "Success!";
if($type == 'student'){
	echo "<br><a href=\"student_form_list.php\">Return to Form List</a>";
}else{
	echo "<br><a href=\"mentor_form_list.php\">Return to Form List</a>";
}
echo "</div>";
?>
</body>
</html>