<html>
<body>
<?php
include 'page_setup.php';
$con=sql_setup();

if(mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$formID = $_GET['id'];
$student = $_GET['username'];

if(!mysqli_query($con, "INSERT INTO FormInstance (Username, FormID, Step) VALUES ('$student', $formID, 0);")){
	die('Error: ' . mysqli_error($con));
}

$result = mysqli_query($con, "SHOW TABLE STATUS FROM Praxis WHERE Name='FormInstance'");
$instanceID = mysqli_fetch_array($result)['Auto_increment'] - 1;

foreach($_POST as $key => $value){
	$params = explode('_', $key);
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

mysqli_close($con);
echo "Success!";
?>
</body>
</html>