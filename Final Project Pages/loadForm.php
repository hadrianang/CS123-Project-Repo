<?php
header("content-type: application/x-javascript");
$con=mysqli_connect("localhost","root","","PracSys");

if (mysqli_connect_errno()) {
	die( "Failed to connect to MySQL: " . mysqli_connect_error() );
}

$inputID = $_GET["id"];
$result = mysqli_query($con, "SELECT * FROM Form WHERE ID=$inputID;");
$formName = mysqli_fetch_array($result)['Name'];
echo "formName = \"$formName\";";

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
			echo "elements.push(temp);";
			break;
		case "area":
			$tmp = $row['Name'];
			$tmp2 = $row['Description'];
			$tmp3 = $row['ID'];
			echo "var temp = new element_textArea(count++, \"$tmp\", \"$tmp2\");";
			echo "temp.databaseID = $tmp3;";
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
			break;
	}
}

mysqli_close($con);
?>