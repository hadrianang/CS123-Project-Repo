<html>
<?php
	include 'page_setup.php';
	prepare_page();
?>

<center>
<?php
	$u = $_GET['username'];
	$n = $_GET['name'];
	$conn = mysqli_connect("localhost","root","root","Practicum");
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$quer = "SELECT * FROM account_student WHERE Username = '$u'"; 
	$results = mysqli_query($conn, $quer); 
	if(!$arr = mysqli_fetch_array($results))
	{
		$error = mysqli_error($conn); 
		echo "ERROR CREATING STUDENT ACCOUNT<br>"; 
		die('Error: ' . $error);
	}
	$id = $arr['IDNumber']; 
	$mentor = $arr['Mentor'];
	if($mentor==null) $mentor = "NULL";
	$course = $arr['Course']; 
	echo "Name : " . $n . "<br>"; 
	echo "Username: " . $u . "<br>";
	echo "ID Number: " . $id . "<br>";
	echo "Course: " . strtoupper($course) . "<br>";
	echo "Mentor: " . $mentor . "<br>";
	echo "<h2> Assign Mentor </h2> ";
	
	$querMent = mysqli_query($conn,"SELECT * FROM account WHERE type = 'mentor'"); 
?>

<form action = "perform_link.php.">
<select name="mentorName">
	<?php while ($arr = mysqli_fetch_array($querMent)): ?>
		<option><?php echo $arr['Name'] . " : " . $arr['Username']; ?></option>
	<?php endwhile; ?>
</select><br><br>
<!--Use hidden values to pass the student username to the next page-->
<input type = "hidden" name = "student" value = <?php echo $u?>>
<input type = "submit" name = "submit" value = "Link Student to Mentor">
</form> 

<form action = "link_student_page.php">
<input type = "submit" name = "submit" value = "Return to Student List">
</form>
</center>
</html>