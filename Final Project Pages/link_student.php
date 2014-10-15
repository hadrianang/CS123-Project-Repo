<html>
	<link rel="stylesheet" href="style.css">
	<?php
		include 'page_setup.php';
		prepare_page();
	?>
	<div id='body2'>
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
				echo "<h1> Assign Mentor </h1> ";
				echo "Name : " . $n . "<br>"; 
				echo "Username: " . $u . "<br>";
				echo "ID Number: " . $id . "<br>";
				echo "Course: " . strtoupper($course) . "<br>";
				echo "Current Mentor: " . $mentor . "<br>";
				
				
				$querMent = mysqli_query($conn,"SELECT * FROM account WHERE type = 'mentor'"); 
			?>
			<br>
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
			<a href='link_student_page.php'><button>Return to Student List</button></a>
			</center>
		</div>
</html>