<?php
header("content-type: application/x-javascript");
include 'page_setup.php';
$con=sql_setup();
session_start();
$user = $_SESSION['uname'];

if (mysqli_connect_errno()) {
	die( "Failed to connect to MySQL: " . mysqli_connect_error() );
}

$inputID = $_GET["id"];
$username = $_GET["username"];

$result = mysqli_query($con, "SELECT * FROM Account WHERE Username='$user';");
$row = mysqli_fetch_array($result);
$type = $row['Type'];

$result = mysqli_query($con, "SELECT * FROM Form WHERE ID=$inputID;");
$row = mysqli_fetch_array($result);
$path = $row['AccountPath'];


$result = mysqli_query($con, "SELECT * FROM FormInstance WHERE Username='$username' AND FormID=$inputID;");
echo "var formStep = 0;";
if(mysqli_num_rows($result) != 0){
	$resarr = mysqli_fetch_array($result);
	$instanceID = $resarr['ID'];
	$instanceStep = $resarr['Step'];
	echo "formStep = $instanceStep;";

	$result = mysqli_query($con, "SELECT * FROM Comments WHERE InstanceID=$instanceID;");

	while($row = mysqli_fetch_array($result)){
		$tmp = $row['ID'];
		$tmp2 = $row['FormStep'];
		$tmp3 = $row['Text'];
		echo "var temp = new comment($tmp2);";
		echo "temp.databaseID = $tmp;";
		echo "temp.ans = '$tmp3';";
		echo "comments.push(temp);";
	}
	
	if($type[0] == strtolower($path)[$instanceStep] && $instanceStep != 0)
		echo "comments.push(new comment($instanceStep));";
}else{
	echo "var formStep = 0;";
}

mysqli_close($con);
?>