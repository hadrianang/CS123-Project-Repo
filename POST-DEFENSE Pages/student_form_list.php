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
	$result = mysqli_query($con, "SELECT * FROM Form WHERE Active=TRUE;");
	echo "<h1>Form List</h1><br>";
	echo "<table class=\"custom\">";
	echo "<tr><th>Form Name</th><th>Status</th></tr>";
	$count = 0;
	while($row = mysqli_fetch_array($result)){
		if(strpos($row['AccountPath'], 'S') === FALSE){
			continue;
		}
		echo "<tr" . ($count++%2==0?"":" class=\"alt\"") . ">";
		$tmp = $row['ID'];
		$tmp2 = $row['Name'];
		echo "<td><a href=\"DisplayForm.php?id=$tmp&username=$temp\">$tmp2</a></td>";
		$resultb = mysqli_query($con, "SELECT * FROM FormInstance WHERE Username='$temp' AND FormID=$tmp;");
		echo "<td>";
		if(mysqli_num_rows($resultb) == 0){
			echo "Not Accomplished";
		}else{
			$rowb = mysqli_fetch_array($resultb);
			switch($row['AccountPath'][$rowb['Step']]){
				case 'S':
					if($rowb['LastResponse']){
						echo "Not Accomplished";
					}else{
						echo "Rejected on Review";
					}
					break;
				case 'M':
					if($rowb['LastResponse']){
						echo "Awaiting Review";
					}else{
						echo "Rejected";
					}
					break;
				case 'F':
					if($rowb['LastResponse']){
						echo "Awaiting Approval";
					}else{
					}
					break;
				default:
					echo "Approved";
					break;
			}
		}
		echo "</td>";
		echo "</tr>";
	}
	echo "</table>";
?>
</center>
</div>
</body>
</html>