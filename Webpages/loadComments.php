<?php
header("content-type: application/x-javascript");
$con=mysqli_connect("localhost","root","","PracSys");

if (mysqli_connect_errno()) {
	die( "Failed to connect to MySQL: " . mysqli_connect_error() );
}

$inputID = $_GET["id"];
$username = $_GET["username"];
$result = mysqli_query($con, "SELECT * FROM FormInstance WHERE Username=$username AND FormID=$inputID;");
$resarr = mysqli_fetch_array($result);
$instanceID = $resarr['ID'];
$instanceStep = $resarr['Step'];
echo "var formStep = $instanceStep;";

$result = mysqli_query($con, "SELECT * FROM Comments WHERE InstanceID=$instanceID;");

while($row = mysqli_fetch_array($result)){
	$tmp = $row['ID'];
	$tmp2 = $row['FormStep'];
	$tmp3 = $row['Text'];
	echo "var temp = new comment($tmp2);";
	echo "temp.databaseID = $tmp;";
	echo "temp.ans = $tmp3;";
	echo "comments.push(temp);";
}

echo "comments.push(new comment($instanceStep));";

mysqli_close($con);
?>