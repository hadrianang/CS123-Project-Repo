<html>
<body>
<?php
$con = mysqli_connect("localhost", "root", "", "PracSys");

if(mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$inputID = $_GET["id"];
$username = $_GET["username"];
$result = mysqli_query($con, "SELECT * FROM FormInstance WHERE Username=$username AND FormID=$inputID;");
$resarr = mysqli_fetch_array($result);
$instanceID = $resarr['ID'];
$instanceStep = $resarr['Step'];

foreach($_POST as $key => $value){
	$params = explode('_', $key);
	if($params[0] != "comment") continue;
	if($params[1] != $instanceStep) continue;
	$result = mysqli_query($con, "SELECT * FROM Comments WHERE InstanceID=$instanceID AND FormStep=$instanceStep;");
	
	if(mysql_num_rows($result) == 0){
		if(!mysqli_query($con, "INSERT INTO Comments (InstanceID, FormStep, Text) VALUES ($instanceID, $instanceStep, '$value');")){
			die('Error: ' . mysqli_error($con));
		}
	}else{
		$tmp = mysqli_fetch_array($result)['ID'];
		if(!mysqli_query($con, "UPDATE Comments SET Text='$value' WHERE ID=$tmp;")){
			die('Error: ' . mysqli_error($con));
		}
	}
}

if($_POST['action'] == "Accept"){
	if(!mysqli_query($con, "UPDATE FormInstance SET LastResponse=TRUE WHERE ID=$instanceID;")){
		die('Error: ' . mysqli_error($con));
	}
	$instanceStep++;
}else{
	if(!mysqli_query($con, "UPDATE FormInstance SET LastResponse=FALSE WHERE ID=$instanceID;")){
		die('Error: ' . mysqli_error($con));
	}
	$instanceStep--;
}

if(!mysqli_query($con, "UPDATE FormInstance SET Step=$instanceStep WHERE ID=$instanceID;")){
	die('Error: ' . mysqli_error($con));
}

mysqli_close($con);
echo "Success!";
?>
</body>
</html>