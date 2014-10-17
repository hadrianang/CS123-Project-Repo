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
	$forms = array();
	echo "<h1>Form list</h1><br>";
	$result = mysqli_query($con, "SELECT * FROM Form WHERE Active=TRUE;");
	while($row = mysqli_fetch_array($result)){
		if(strpos($row['AccountPath'], 'M') === FALSE){
			continue;
		}
		array_push($forms, $row);
	}
	
	echo "<table class=\"custom\">";
	echo "<tr><th>Student</th>";
	foreach($forms as $value){
		$tmp = $value['Name'];
		echo "<th>$tmp</th>";
	}
	echo "</tr>";
	
	$result = mysqli_query($con, "SELECT * FROM Account a, Account_Student b WHERE b.Mentor='$temp' AND a.Username=b.Username;");
	$count = 0;
	while($row = mysqli_fetch_array($result)){
		$tmp = $row['Name'];
		$tmp2 = $row['Username'];
		echo "<tr" . ($count++%2==0?"":" class=\"alt\"") . ">";
		echo "<td>$tmp</td>";
		foreach($forms as $value){
			$tmp3 = $value['ID'];
			$resultb = mysqli_query($con, "SELECT * FROM FormInstance WHERE Username='$tmp2' AND FormID=$tmp3;");
			if(mysqli_num_rows($resultb) == 0){
				echo "<td>";
				if($value['AccountPath'][0] == 'M'){
					echo "<a href=\"DisplayForm.php?id=$tmp3&username=$tmp2\">";
				}
				echo "Unanswered";
				if($value['AccountPath'][0] == 'M'){
					echo "</a>";
				}
				echo "</td>";
			}else{
				$rowb = mysqli_fetch_array($resultb);
				switch($value['AccountPath'][$rowb['Step']]){
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