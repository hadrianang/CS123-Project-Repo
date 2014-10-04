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
	while ($arr = mysqli_fetch_array($results))
	{
		$u = $arr['Username']; 
		$n = $arr['Name']; 
		echo "<a href=link_student.php?username=" . $u . "&name=" . $n ."> $n</a><br>";
	}
?>
</html> 