<?php
header("content-type: application/x-javascript");
include 'page_setup.php';
$con=sql_setup();

if (mysqli_connect_errno()) {
	die( "Failed to connect to MySQL: " . mysqli_connect_error() );
}

$inputID = $_GET["id"];
$result = mysqli_query($con, "SELECT * FROM Form WHERE ID=$inputID;");
$resarr = mysqli_fetch_array($result);
$formName = $resarr['Name'];
$formPath = $resarr['AccountPath'];
echo "formName = \"$formName\";";
echo "formPath = \"$formPath\";";

$username = $_GET["username"];
$result = mysqli_query($con, "SELECT * FROM FormInstance WHERE FormID=$inputID AND Username='$username';");
$instanceID = -1;
if(mysqli_num_rows($result) != 0){
	$instanceID = mysqli_fetch_array($result)['ID'];
}

$result = mysqli_query($con, "SELECT * FROM Element WHERE FormID=$inputID;");

while($row = mysqli_fetch_array($result)){
	$elementID = $row["ID"];
	
	switch($row['ElementType']){
		case "text":
			$tmp = $row['Name'];
			$tmp2 = $row['Description'];
			$tmp3 = $row['ID'];
			echo "var temp = new element_plainText(count++, \"$tmp\", \"$tmp2\");";
			echo "temp.databaseID = $tmp3;";
			echo "elements.push(temp);";
			break;
		case "field":
			$tmp = $row['Name'];
			$tmp2 = $row['Description'];
			$tmp3 = $row['ID'];
			echo "var temp = new element_field(count++, \"$tmp\", \"$tmp2\");";
			echo "temp.databaseID = $tmp3;";
			if($instanceID != -1){
				$resultb = mysqli_query($con, "SELECT * FROM Answer WHERE ElementID=$elementID AND InstanceID=$instanceID;");
				$rowb = mysqli_fetch_array($resultb);
				$tmp = $rowb['Val'];
				echo "temp.ans = \"$tmp\";";
			}
			echo "elements.push(temp);";
			break;
		case "area":
			$tmp = $row['Name'];
			$tmp2 = $row['Description'];
			$tmp3 = $row['ID'];
			echo "var temp = new element_textArea(count++, \"$tmp\", \"$tmp2\");";
			echo "temp.databaseID = $tmp3;";
			if($instanceID != -1){
				$resultb = mysqli_query($con, "SELECT * FROM Answer WHERE ElementID=$elementID AND InstanceID=$instanceID;");
				$rowb = mysqli_fetch_array($resultb);
				$tmp = $rowb['Val'];
				echo "temp.ans = \"$tmp\";";
			}
			echo "elements.push(temp);";
			break;
		case "drop":
			$tmp = $row['Name'];
			$tmp2 = $row['Description'];
			$tmp3 = $row['ID'];
			echo "var temp = new element_dropDown(count++, \"$tmp\", \"$tmp2\");";
			echo "temp.databaseID = $tmp3;";
			echo "elements.push(temp);";
			$subresult = mysqli_query($con, "SELECT * FROM Element_DropDown_Choice WHERE ElementID=$elementID;");
			while($subrow = mysqli_fetch_array($subresult)){
				$tmp = $subrow['Choice'];
				echo "temp.addChoice(\"$tmp\");";
			}
			if($instanceID != -1){
				$resultb = mysqli_query($con, "SELECT * FROM Answer WHERE ElementID=$elementID AND InstanceID=$instanceID;");
				$rowb = mysqli_fetch_array($resultb);
				echo "for(n=0; n<temp.choices.length; n++){";
				echo "if(temp.choices[n] == '" . $rowb['Val'] . "'){";
				echo "temp.cur = n; break;";
				echo "}};";
			}
			break;
		case "radio":
			$tmp = $row['Name'];
			$tmp2 = $row['Description'];
			$tmp3 = $row['ID'];
			echo "var temp = new element_radioCluster(count++, \"$tmp\", \"$tmp2\");";
			echo "temp.databaseID = $tmp3;";
			echo "elements.push(temp);";
			$subresult = mysqli_query($con, "SELECT * FROM Element_RadioCluster_Section WHERE ElementID=$elementID;");
			while($subrow = mysqli_fetch_array($subresult)){
				$tmp = $subrow['HasButtons'];
				$tmp2 = $subrow['Text'];
				echo "temp.addRow($tmp, \"$tmp2\");";
			}
			$subresult = mysqli_query($con, "SELECT * FROM Element_RadioCluster_Header WHERE ElementID=$elementID;");
			while($subrow = mysqli_fetch_array($subresult)){
				$tmp = $subrow['Text'];
				echo "temp.addCol(\"$tmp\");";
			}
			if($instanceID != -1){
				$resultb = mysqli_query($con, "SELECT * FROM Answer WHERE ElementID=$elementID AND InstanceID=$instanceID;");
				while($rowb = mysqli_fetch_array($resultb)){
					$tmp = $rowb['Param1'];
					$tmp2 = $rowb['Val'];
					echo "temp.ans[$tmp] = $tmp2;";
				}
			}
			break;
		case "table":
			$tmp = $row['Name'];
			$tmp2 = $row['Description'];
			$tmp3 = $row['ID'];
			echo "var temp = new element_table(count++, \"$tmp\", \"$tmp2\", ";
			$subresult = mysqli_query($con, "SELECT * FROM Element_Table WHERE ID=$elementID;");
			$subrow = mysqli_fetch_array($subresult);
			$tmp = $subrow['HasRowText'];
			echo "$tmp);";
			echo "temp.databaseID = $tmp3;";
			echo "elements.push(temp);";
			$rowText = $subrow['HasRowText'];
			$count = 0;
			$subresult = mysqli_query($con, "SELECT * FROM Element_Table_Column WHERE ElementID=$elementID;");
			while($subrow = mysqli_fetch_array($subresult)){
				$tmp = $subrow['Text'];
				echo "temp.addCol(\"$tmp\");";
			}
			$subresult = mysqli_query($con, "SELECT * FROM Element_Table_Row WHERE ElementID=$elementID;");
			while($subrow = mysqli_fetch_array($subresult)){
				$tmp = $subrow['Text'];
				echo "temp.addRow(\"$tmp\");";
			}
			if($instanceID != -1){
				$resultb = mysqli_query($con, "SELECT * FROM Answer WHERE ElementID=$elementID AND InstanceID=$instanceID;");
				while($rowb = mysqli_fetch_array($resultb)){
					$tmp = $rowb['Param1'];
					while($rowText == 0 && $count <= $tmp){
						$count++;
						echo "for(n=0; n<temp.cols; n++){";
						echo "temp.ans[temp.rows+\"_\"+n] = \"\";";
						echo "}";
						echo "temp.rows++;";
					}
					$tmp2 = $rowb['Param2'];
					$tmp3 = $rowb['Val'];
					echo "temp.ans['$tmp" . "_" . "$tmp2'] = \"$tmp3\";";
				}
			}
			break;
	}
}

mysqli_close($con);
?>