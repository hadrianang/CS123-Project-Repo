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

				$idnum = $_GET['idnum'];
				$course = $_GET['course'];
				
				$company = $_GET['company'];
				$dept = $_GET['department'];
				$title = $_GET['title'];

				$valid_username_chars = array("a","b","c","d","e","f","g","h","i","j",
					"k","l","m","n","o","p","q","r","s","t","u","v","w","x",
					"y","z","0","1","2","3","4","5","6","7","8","9","_");
				$valid_idnum_chars = array("0","1","2","3","4","5","6","7","8","9");
				$username_check = str_replace($valid_username_chars, "", strtolower($username));
				$idnum_check = str_replace($valid_idnum_chars, "", strtolower($idnum));
				$conn = sql_setup();
				if (mysqli_connect_errno()){
					echo "Failed to connect to MySQL: " . mysqli_connect_error();
				}
				if (strlen($username) < 1 || strlen($username_check) > 0){
					$success = false;
					echo "Invalid Username";
				} else if(strlen(trim($password)) < 1){
					$success = false;
					echo "Invalid Password";
				} else if(strlen(trim($name)) < 1){
					$success = false;
					echo "Invalid Name";
				} else if($type=="student" && (strlen(trim($idnum)) < 1 || strlen(trim($course)) < 1 || strlen($idnum_check) > 0)){
					$success = false;
					echo "Invalid Student Information";
				} else if($type=="faculty" && (strlen(trim($idnum)) < 1 || strlen($idnum_check) > 0)){
					$success = false;
					echo "Invalid Faculty Information";
				} else if($type=="mentor" && (strlen(trim($company)) < 1 || strlen(trim($dept)) < 1 || strlen(trim($title)) < 1)){
					$success = false;
					echo "Invalid Mentor Information";
				} else {
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
				}
				
			?>
			<br>
			<a href = 'home.php'><button> Return Home </button></a>
			<br><br>
			<a href = 'create_account_page.php'><button> Create More Accounts </button></a>
		</center>
	</div>
</html>