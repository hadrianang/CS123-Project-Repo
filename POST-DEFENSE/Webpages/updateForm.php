<html>
<body>
<?php
$con=mysqli_connect("localhost","root","","PracSys");

if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$formID = $_GET['id'];

$result = mysqli_query($con, "SELECT * FROM Form WHERE ID=$formID;");
if(count(mysqli_fetch_array($result)) == 0){
	mysqli_query($con, "INSERT INTO Form(Name, AccountPath) VALUES ('test', 'SMF');");
}

if(!mysqli_query($con, "DELETE FROM Element WHERE FormID=" . $formID . ";")){
	die( "Failed to remove old elements: " . mysqli_connect_error() );
}

$elements = [];

foreach($_POST as $key => $value){
	if($key == "formname"){
		mysqli_query($con, "UPDATE FORM SET Name=$value WHERE ID=$formID;");
		unset($_POST[$key]);
		continue;
	}
	$params = explode('_', $key);
	$id = intval($params[1]);
	$sql = "";
	if(!array_key_exists($id, $elements)){
		$element = array("type" => $params[3]);
		if($params[3] == "table"){
			$element["hasRowText"] = $params[5];
		}
		$elements[$id] = $element;
	}
	if($params[4] == "name" || $params[4] == "text"){
		$elements[$id][$params[4]] = $value;
		unset($_POST[$key]);
	}
}

foreach($elements as $key => $value){
	$type = $value["type"];
	$name = $value["name"];
	$text = $value["text"];
	if(!mysqli_query($con, "INSERT INTO Element (FormID, ElementType, Name, Description) VALUES ($formID, '$type', '$name', '$text');")){
		die('Error: ' . mysqli_error($con));
	}
	$result = mysqli_query($con, "SHOW TABLE STATUS FROM Praxis WHERE Name='Element'");
	$id = mysqli_fetch_array($result)['Auto_increment'] - 1;
	$elements[$key]["ID"] = $id;
	switch($type){
		case "text":
			$sql = "INSERT INTO Element_PlainText(ID) VALUES ($id);";
			break;
		case "field":
			$sql = "INSERT INTO Element_Field(ID) VALUES ($id);";
			break;
		case "area":
			$sql = "INSERT INTO Element_TextArea(ID) VALUES ($id);";
			break;
		case "drop":
			$sql = "INSERT INTO Element_DropDown(ID) VALUES ($id);";
			break;
		case "radio":
			$sql = "INSERT INTO Element_RadioCluster(ID) VALUES ($id);";
			break;
		case "table":
			$rows = $value["hasRowText"];
			$sql = "INSERT INTO Element_Table(ID, HasRowText) VALUES ($id, $rows);";
			break;
	}
	if(!mysqli_query($con, $sql)){
		die('Error: ' . mysqli_error($con));
	}
}

foreach($_POST as $key => $value){
	$params = explode('_', $key);
	$element = $elements[intval($params[1])];
	$id = $element["ID"];
	$sql = "";
	if($params[3] == "drop" || $params[3] == "radio" || $params[3] == "table"){
		switch($params[3]){
			case "drop":
				$sql = "INSERT INTO Element_DropDown_Choice(ElementID, Choice) VALUES ($id, '$value');";
				break;
			case "radio":
				if($params[4] == "row"){
					$sql = "INSERT INTO Element_RadioCluster_Section(ElementID, HasButtons, Text) VALUES ($id, $params[6], '$value');";
				}else{
					$sql = "INSERT INTO Element_RadioCluster_Header(ElementID, Text) VALUES ($id, '$value');";
				}
				break;
			case "table":
				if($params[4] == "header"){
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