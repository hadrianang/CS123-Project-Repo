<html>
<body>
<?php
$con=mysqli_connect("localhost","root","","Praxis");

if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

mysqli_query($con, "INSERT INTO Form (Name, AccountPath)
VALUES ('Test', 'SMF');");

$result = mysqli_query($con,"SELECT COUNT(*) FROM Form;");
$resultRow = mysqli_fetch_array($result);
$formID = $resultRow[0];
$elements = [];

foreach($_POST as $key => $value){
	$params = explode('_', $key);
	$id = -1;
	$sql = "";
	if(array_key_exists($params[1], $elements)){
		$id = $elements[$params[1]];
	}else{
		if(!mysqli_query($con, "INSERT INTO Element (FormID, ElementType, Name, Description) VALUES ($formID, '$params[2]', '', '$value');")){
			die('Error: ' . mysqli_error($con));
		}
		$result = mysqli_query($con, "SELECT MAX(ID) FROM Element");
		$resultRow = mysqli_fetch_array($result);
		$elements[$params[1]] = $resultRow[0];
		$id = $elements[$params[1]];
		switch($params[2]){
			case "text":
				$sql = "INSERT INTO Element_PlainText(ID) VALUES ($id);";
				break;
			case "field":
				$sql = "INSERT INTO Element_Field(ID, DefaultAnswer) VALUES ($id, '$value');";
				break;
			case "area":
				$sql = "INSERT INTO Element_TextArea(ID, DefaultAnswer) VALUES ($id, '$value');";
				break;
			case "drop":
				$sql = "INSERT INTO Element_DropDown(ID) VALUES ($id);";
				break;
			case "radio":
				$sql = "INSERT INTO Element_RadioCluster(ID) VALUES ($id);";
				break;
			case "table":
				$sql = "INSERT INTO Element_Table(ID, HasRowText) VALUES ($id, $params[5]);";
				break;
		}
		if(!mysqli_query($con, $sql)){
			die('Error: ' . mysqli_error($con));
		}
	}
	if($params[2] == "drop" || $params[2] == "radio" || $params[2] == "table"){
		switch($params[2]){
			case "drop":
				$sql = "INSERT INTO Element_DropDown_Choice(ElementID, Choice) VALUES ($id, '$value');";
				break;
			case "radio":
				if($params[3] == "row"){
					$sql = "INSERT INTO Element_RadioCluster_Section(ElementID, HasButtons, Text) VALUES ($id, $params[5], '$value');";
				}else{
					$sql = "INSERT INTO Element_RadioCluster_Header(ElementID, Text) VALUES ($id, '$value');";
				}
				break;
			case "table":
				if($params[3] == "header"){
					$sql = "INSERT INTO Element_Table_Column(ElementID, Text) VALUES ($id, '$value');";
				}else{
					$sql = "INSERT INTO Element_Table_Row(ElementID, Text) VALUES ($id, '$value');";
				}
				break;
		}
		if(!mysqli_query($con, $sql)){
			die('Error: ' . mysqli_error($con));
		}
	}
}

mysqli_close($con);
echo "Success!";
?>
</body>
</html>