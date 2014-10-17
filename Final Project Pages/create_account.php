<html>
	<link rel="stylesheet" href="style.css">
	<?php
		include 'page_setup.php';
		prepare_page();
	?>
	<div id='body2'>
		<center>
			<?php
				$conn = sql_setup();
				if (mysqli_connect_errno()){
					echo "Failed to connect to MySQL: " . mysqli_connect_error();
				}
				$success = true; 
				$inserted = false; 
				$username = $_GET['username']; 
				$password = $_GET['password'];
				$name = $_GET['name'];
				$type = $_GET['type'];
				
				$conn = sql_setup();
				if (mysqli_connect_errno()){
					echo "Failed to connect to MySQL: " . mysqli_connect_error();
				}
				$quer = "INSERT INTO account (Username, Password, Name, Type)
				VALUES(\"$username\",\"$password\",\"$name\", \"$type\")";
				if (!mysqli_query($conn,$quer))
				{
					echo "ERROR CREATING ACCOUNT"; 
					die('Error: ' . mysqli_error($conn));
					$success = false; 
				}
				if($success) $inserted = true; 
				if($type=="student")
				{
					$idnum = $_GET['idnum'];
					$course = $_GET['course'];
					$insertStudent = "INSERT INTO Account_Student (Username, IDNumber, Course)
					VALUES(\"$username\",\"$idnum\", \"$course\")";
					if (!mysqli_query($conn,$insertStudent))
					{
						$error = mysqli_error($conn); 
						$dropWrong = "DELETE FROM account WHERE Username ='" . $username . "'"; 
						if($inserted)
							mysqli_query($conn, $dropWrong); 
						echo "ERROR CREATING STUDENT ACCOUNT<br>"; 
						die('Error: ' . $error);
						$success = false; 
					}
				}elseif($type=="mentor")
				{
					$company = $_GET['company'];
					$dept = $_GET['department'];
					$title = $_GET['title']; 
					$error = mysqli_error($conn); 
					$insertMentor = "INSERT INTO Account_Mentor
					VALUES(\"$username\",\"$company\",\"$title\",\"$dept\")";
					if (!mysqli_query($conn,$insertMentor))
					{
						$dropWrong = "DELETE FROM account WHERE Username ='" . $username . "'"; 
						if($inserted)
							mysqli_query($conn, $dropWrong); 
						echo "ERROR CREATING MENTOR ACCOUNT<br>"; 
						die('Error: ' . $error);
						$success = false; 
					}
				}else
				{
					$idnum = $_GET['idnum'];
					$error = mysqli_error($conn); 
					$insertFaculty = "INSERT INTO Account_Faculty
					VALUES(\"$username\",\"$idnum\")";
					if (!mysqli_query($conn,$insertFaculty))
					{
						$dropWrong = "DELETE FROM account WHERE Username ='" . $username . "'"; 
						if($inserted)
							mysqli_query($conn, $dropWrong); 
						echo "ERROR CREATING FACULTY ACCOUNT<br>"; 
						die('Error: ' . $error);
						$success = false; 
					}
				}
				
				if($success)
				{
					echo "<h1>ACCOUNT CREATION SUCCESS!</h1>";
				}
			?>
			<br>
			<a href = 'home.php'><button> Return Home </button></a>
			<br><br>
			<a href = 'create_account_page.php'><button> Create More Accounts </button></a>
		</center>
	</div>
</html>