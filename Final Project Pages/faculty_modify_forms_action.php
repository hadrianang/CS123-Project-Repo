<html>
<body>
<?php
include 'page_setup.php';
$con=sql_setup();
$user=prepare_page();

if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

echo "<div id='body2'>";
$forms = [];
foreach($_POST as $key => $value){
	$params = explode('_', $key);
	if(!array_key_exists($params[0], $forms)){
		$forms[$params[0]] = array('id' => $params[0], 'path' => "   ", 'active' => FALSE);
	}
	if($params[1] == "box"){
		$forms[$params[0]]['active'] = $value=='on';
	}else{
		if(strlen($value) > 0){
			$forms[$params[0]]['path'][intval($params[1])] = $value[0];
		}
	}
}

foreach($forms as $value){
	$tmp = $value['path'];
	$tmp2 = $value['active'];
	$tmp3 = $value['id'];
	if(!mysqli_query($con, "UPDATE FORM SET AccountPath='$tmp' WHERE ID=$tmp3;")){
		die("Failed to update forms.");
	}
	if(!mysqli_query($con, "UPDATE FORM SET Active=".($tmp2==1?"TRUE":"FALSE")." WHERE ID=$tmp3;")){
		die("Failed to update forms.");
	}
}

mysqli_close($con);
echo "Success!";
echo "<br><a href=\"faculty_modify_forms.php\">Return</a>";
echo "</div>";
?>
</body>
</html>