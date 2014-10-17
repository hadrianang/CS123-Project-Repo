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
	echo "<h1>Form List</h1><br>";
	$forms = array();
	$result = mysqli_query($con, "SELECT * FROM Form WHERE Active=TRUE;");
	while($row = mysqli_fetch_array($result)){
		array_push($forms, $row);
	}
	
	echo "<table class=\"custom\">";
	echo "<tr><th>Student</th>";
	foreach($forms as $value){
		$tmp = $value['Name'];
		echo "<th>$tmp</th>";
	}
	echo "</tr>";
	
	$result = mysqli_query($con, "SELECT * FROM Account a, Account_Student b WHERE a.Username=b.Username;");
	$count = 0;
	while($row = mysqli_fetch_array($result)){
		$tmp = $row['Name'];
		$tmp2 = $row['Username'];
		echo "<tr" . ($count++%2==0?"":" class=\"alt\"") . ">";
		echo "<td>$tmp</td>";
		foreach($forms as $value){
			$tmp3 = $value['ID'];
			$resultb = mysqli_query($con, "SELECT * FROM FormInstance WHERE Username='$tmp2' AND FormID=$tmp3;");
			$rowb = mysqli_fetch_array($resultb);
			if(mysqli_num_rows($resultb) == 0){
				echo "<td>Unanswered</td>";
			}else{
				$character = '.';
				if($rowb['Step'] < strlen($value['AccountPath'])){
					$character = $value['AccountPath'][$rowb['Step']];
				}
				switch($character){
					case 'S':
						if($rowb['LastResponse']){
							echo "<td>Unanswered</td>";
						}else{
							echo "<td><a href=\"DisplayForm.php?id=$tmp3&username=$tmp2\">Rejected on Review</a></td>";
						}
						break;
					case 'M':
						if($rowb['LastResponse']){
							echo "<td><a href=\"DisplayForm.php?id=$tmp3&username=$tmp2\">Awaiting Review</a></td>";
						}else{
							echo "<td><a href=\"DisplayForm.php?id=$tmp3&username=$tmp2\">Rejected</a></td>";
						}
						break;
					case 'F':
						if($rowb['LastResponse']){
							echo "<td><a href=\"DisplayForm.php?id=$tmp3&username=$tmp2\">Awaiting Approval</a></td>";
						}else{
						}
						break;
					default:
						echo "<td><a href=\"DisplayForm.php?id=$tmp3&username=$tmp2\">Approved</a></td>";
						break;
				}
			}
		}
		echo "</tr>";
	}
	echo "</table>";
?>
</center>
</div>
</body>
</html>