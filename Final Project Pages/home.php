<html>
	<body>
		<link rel="stylesheet" href="style.css">
		<?php
			include 'page_setup.php';
			// temp contains the username [0] of the current user and the type of account [1]
			$temp = prepare_page();
		?>
		<div id='body2'>
			<center>
				<h1>HELLO THIS IS THE HOME PAGE</h1>
				<a href=create_account_page.php>Create Account</a><br>
				<a href=link_student_page.php>Link Students and Mentors</a><br>
				<a href=create_company_page.php>Create Company</a><br>
				<a href=edit_info_page.php>Update Account Information</a><br>
				<a href=ModifyForm.php>Modify Forms</a><br>
			</center>
		</div>
	</body>
</html>