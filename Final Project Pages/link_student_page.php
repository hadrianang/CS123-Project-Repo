<html><title>PracSys: Ateneo DISCS Practicum Management System</title>
<link rel="stylesheet" href="style.css">
<?php
	include 'page_setup.php';
	prepare_page();
?>


<?php
	echo "<div id='body2'>";
	echo "<form action = 'link_student_page.php'>
	<input type='submit' id='submit' value='Search Now'>
	<input type='text' name='searchbox' value =''>
	</form>";
	echo "<center><h1>List of Practicum Students</h1></center>";
	$conn = sql_setup();
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$searchQuer = '';
	if(isset($_GET['searchbox'])) $searchQuer = $_GET['searchbox'];
	if($searchQuer==null) $searchQuer = '';
	$quer = "
	SELECT account.Username as Username, account.Name as Name, account_student.IDNumber as IDNumber, account_student.Mentor as Mentor
	FROM account, account_student
	WHERE account.Type = 'student' AND (Name LIKE '%$searchQuer%'OR IDNumber LIKE '%$searchQuer%' OR account_student.Mentor LIKE'%$searchQuer%') AND account.Username = account_student.Username
	ORDER BY account.Name"; 
	$results = mysqli_query($conn, $quer); 
	//change link below when needed
	echo 
	"<table class=\"custom\">	
		<tr>
			<th><b>ID Number</b></th>
			<th><b>Student Name</b></th>
			<th><b>Current Mentor</b></th>
		</tr>";
	$count = 0;
	while ($arr = mysqli_fetch_array($results))
	{
		$u = $arr['Username']; 
		$n = $arr['Name']; 
		$id = $arr['IDNumber'];
		$m = $arr['Mentor']; 
		$getMentor = mysqli_query($conn, "SELECT Name from account WHERE Username = '$m'");
		$temp2 = mysqli_fetch_array($getMentor); 
		$mentor_name = $temp2['Name']; 
		echo "<tr" . ($count++%2==0?"":" class=\"alt\"") . ">
				<td>$id</td>
				<td><a href=link_student.php?username=" . $u . "&name=" . $n ."> $n</a> </td>
				<td>$mentor_name <br></td> 
			</tr>";
	}
	echo "</table>";
	echo "</div>";
?>
</html> 