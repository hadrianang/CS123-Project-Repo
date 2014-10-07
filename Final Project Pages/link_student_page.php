<html>
<?php
	include 'page_setup.php';
	prepare_page();
?>
<h1>List of Practicum Students</h1>
<?php
	
	$conn = mysqli_connect("localhost","root","root","Practicum");
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$quer = "SELECT * FROM account WHERE Type = 'student' ORDER BY Name"; 
	$results = mysqli_query($conn, $quer); 
	//change link below when needed
	echo 
	"<table width = 50%>	
		<tr>
			<td><b>Student Name</b></td>
			<td><b>Current Mentor</b></td>
		</tr>";
	while ($arr = mysqli_fetch_array($results))
	{
		$u = $arr['Username']; 
		$n = $arr['Name']; 
		$getMentor = mysqli_query($conn, "SELECT * FROM account_student WHERE Username = '$u'");
		$temp = mysqli_fetch_array($getMentor); 
		$m = $temp['Mentor']; 
		echo "<tr>
				<td><a href=link_student.php?username=" . $u . "&name=" . $n ."> $n</a> </td>
				<td>$m <br></td> 
			</tr>";
	}
	echo "</table>";
?>
</html> 