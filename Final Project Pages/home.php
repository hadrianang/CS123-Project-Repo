<html><title>PracSys: Ateneo DISCS Practicum Management System</title>
	<body>
		<link rel="stylesheet" href="style.css">
		<?php
			include 'page_setup.php';
			// temp contains the username [0] of the current user and the type of account [1]
			$temp = prepare_page();
		?>
		<div id='body2'>
			<center>
				<?php
					$con = sql_setup();
					
					$result = mysqli_query($con, "SELECT * FROM Account WHERE Username='$temp';");
					$resarr = mysqli_fetch_array($result);
					
					if($resarr['Type'] == "student"){
						echo "<h1>Student Home Page</h1><br>";
						echo "<a href=student_form_list.php>Form List</a><br>";
						echo "<a href=edit_info_page.php>Update Account Information</a><br>";
					}else if($resarr['Type'] == "mentor"){
						echo "<h1>Mentor Home Page</h1><br>";
						echo "<a href=mentor_form_list.php>Form List</a><br>";
						echo "<a href=edit_info_page.php>Update Account Information</a><br>";
					}else{
						echo "<h1>Faculty Home Page</h1><br>";
						echo "<a href=faculty_form_list.php>Form List</a><br>";
						echo "<a href=create_account_page.php>Create Account</a><br>";
						echo "<a href=link_student_page.php>Link Students and Mentors</a><br>";
						echo "<a href=create_company_page.php>Create Company</a><br>";
						echo "<a href=edit_info_page.php>Update Account Information</a><br>";
						echo "<a href=faculty_modify_forms.php>Modify Forms</a><br>";
						if($temp == "root"){
							echo "<a href=clear_database.php>Clear Database</a><br>";
						}
					}
				?>
			</center>
		</div>
	</body>
</html>