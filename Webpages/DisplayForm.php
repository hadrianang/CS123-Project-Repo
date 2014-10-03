<html>
<head>
<title>Display Form</title>
<script type="text/javascript" src="elements.js"></script>
<?php
echo "<p id=\"hidden\" hidden>";
$con=mysqli_connect("localhost","root","","Praxis");

if (mysqli_connect_errno()) {
	die( "Failed to connect to MySQL: " . mysqli_connect_error() );
}

$inputID = $_GET["id"];
$result = mysqli_query($con, "SELECT * FROM Element WHERE FormID=$inputID;");

while($row = mysqli_fetch_array($result)){
	$elementID = $row["ID"];
	switch($row['ElementType']){
		case "text":
			echo "text;;;" . $row['Description'] . "|||";
			break;
		case "field":
			$subresult = mysqli_query($con, "SELECT * FROM Element_Field WHERE ID=$elementID;");
			$subrow = mysqli_fetch_array($subresult);
			echo "field;;;" . $row['Description'] . ";;;" . $subrow['DefaultAnswer'] . "|||";
			break;
		case "area":
			$subresult = mysqli_query($con, "SELECT * FROM Element_TextArea WHERE ID=$elementID;");
			$subrow = mysqli_fetch_array($subresult);
			echo "area;;;" . $row['Description'] . ";;;" . $subrow['DefaultAnswer'] . "|||";
			break;
		case "drop":
			echo "drop;;;" . $row['Description'];
			$subresult = mysqli_query($con, "SELECT COUNT(*) FROM Element_DropDown_Choice WHERE ElementID=$elementID;");
			$subrow = mysqli_fetch_array($subresult);
			echo ";;;" . $subrow[0] . "|||";
			$subresult = mysqli_query($con, "SELECT * FROM Element_DropDown_Choice WHERE ElementID=$elementID;");
			while($subrow = mysqli_fetch_array($subresult)){
				echo $subrow['Choice'] . "|||";
			}
			break;
		case "radio":
			echo "radio;;;" . $row['Description'];
			$subresult = mysqli_query($con, "SELECT COUNT(*) FROM Element_RadioCluster_Section WHERE ElementID=$elementID;");
			$subrow = mysqli_fetch_array($subresult);
			echo ";;;" . $subrow[0];
			$subresult = mysqli_query($con, "SELECT COUNT(*) FROM Element_RadioCluster_Header WHERE ElementID=$elementID;");
			$subrow = mysqli_fetch_array($subresult);
			echo ";;;" . $subrow[0];
			echo "|||";
			$subresult = mysqli_query($con, "SELECT * FROM Element_RadioCluster_Section WHERE ElementID=$elementID;");
			while($subrow = mysqli_fetch_array($subresult)){
				echo $subrow['HasButtons'] . ";;;" . $subrow['Text'] . "|||";
			}
			$subresult = mysqli_query($con, "SELECT * FROM Element_RadioCluster_Header WHERE ElementID=$elementID;");
			while($subrow = mysqli_fetch_array($subresult)){
				echo $subrow['Text'] . "|||";
			}
			break;
		case "table":
			echo "table;;;" . $row['Description'] . ";;;";
			$subresult = mysqli_query($con, "SELECT * FROM Element_Table WHERE ID=$elementID;");
			$subrow = mysqli_fetch_array($subresult);
			echo $subrow['HasRowText'];
			$rowText = $subrow['HasRowText'];
			$subresult = mysqli_query($con, "SELECT COUNT(*) FROM Element_Table_Column WHERE ElementID=$elementID;");
			$subrow = mysqli_fetch_array($subresult);
			echo ";;;" . $subrow[0];
			if($rowText){
				$subresult = mysqli_query($con, "SELECT COUNT(*) FROM Element_Table_Row WHERE ElementID=$elementID;");
				$subrow = mysqli_fetch_array($subresult);
				echo ";;;" . $subrow[0];
			}
			echo "|||";
			$subresult = mysqli_query($con, "SELECT * FROM Element_Table_Column WHERE ElementID=$elementID;");
			while($subrow = mysqli_fetch_array($subresult)){
				echo $subrow['Text'] . "|||";
			}
			if($rowText){
				$subresult = mysqli_query($con, "SELECT * FROM Element_Table_Row WHERE ElementID=$elementID;");
				while($subrow = mysqli_fetch_array($subresult)){
					echo $subrow['Text'] . "|||";
				}
			}
			break;
	}
}

mysqli_close($con);

echo "</p>";
?>
</head>
<body onload="setupForm()">
<form id="form" name="form" action="answerForm.php" method="post">
<p id="elements">
</p>
<input type="submit" value="Submit Form">
</form>
<script type="text/javascript">
var elements = [];
var count = 0;

function setupForm(){
	var input = document.getElementById("hidden").innerHTML;
	var arr = input.split("|||");
	console.log(input);

	for(index=0; index<arr.length; index++){
		var arr2 = arr[index].split(";;;");
		if(arr2[0] == "text"){
			elements.push(new element_plainText(count++, "", arr2[1]));
		}else if(arr2[0] == "field"){
			elements.push(new element_field(count++, arr2[1], arr2[2]));
		}else if(arr2[0] == "area"){
			elements.push(new element_textArea(count++, arr2[1], arr2[2]));
		}else if(arr2[0] == "drop"){
			var temp = new element_dropDown(count++, arr2[1]);
			elements.push(temp);
			var n = parseInt(arr2[2]);
			for(i=0; i<n; i++){
				index++;
				elements[count-1].addChoice(arr[index]);
			}
		}else if(arr2[0] == "radio"){
			var temp = new element_radioCluster(count++, arr2[1]);
			temp.removeRow(0);
			temp.removeRow(0);
			temp.removeCol(0);
			elements.push(temp);
			var n = parseInt(arr2[2]);
			var m = parseInt(arr2[3]);
			for(i=0; i<n; i++){
				index++;
				arr2 = arr[index].split(";;;");
				elements[count-1].addRow(arr2[0]==1, arr2[1]);
			}
			for(i=0; i<m; i++){
				index++;
				arr2 = arr[index].split(";;;");
				elements[count-1].addCol(arr2[0]);
			}
		}else if(arr2[0] == "table"){
			var temp = new element_table(count++, arr2[1], arr2[2]==1);
			temp.removeRow(0);
			temp.removeCol(0);
			elements.push(temp);
			var row = arr2[2];
			var n = parseInt(arr2[3]);
			var m = -1;
			if(row == 1){
				m = parseInt(arr2[4]);
			}
			for(i=0; i<n; i++){
				index++;
				elements[count-1].addCol(arr[index]);
			}
			if(row == 1){
				for(i=0; i<m; i++){
					index++;
					elements[count-1].addRow(arr[index]);
				}
			}else{
				elements[count-1].addAnswerRow();
			}
		}
	}
	refreshForm();
}

function updateData(){
	var formelements = document.getElementById("form").elements;
	for(i=0; i<elements.length; i++){
		if(!elements[i]) continue;
		var element = formelements[elements[i].getName()];
		if(elements[i].type == "field"){
			elements[i].ans = element.value;
		}else if(elements[i].type == "textArea"){
			elements[i].ans = element.value;
		}else if(elements[i].type == "dropDown"){
			var value = element.options[element.selectedIndex].value;
			elements[i].cur = parseInt(value);
		}else if(elements[i].type == "radioCluster"){
			for(a=0; a<elements[i].rows; a++){
				if(!elements[i].rowButtons[a]) continue;
				var selection = document.getElementsByName(elements[i].getRowName(a));
				for(b=0; b<selection.length; b++){
					if(selection[b].checked){
						elements[i].ans[a] = parseInt(selection[b].value);
						break;
					}
				}
			}
		}else if(elements[i].type == "table"){
			for(a=0; a<elements[i].rows; a++){
				for(b=0; b<elements[i].cols; b++){
					element = formelements[elements[i].getCellName(a, b)];
					elements[i].ans[a+"_"+b] = element.value;
				}
			}
		}
	}
}

function refreshForm(){
	var p = document.getElementById("elements");
	var newHTML = [];
	for(x=0; x<elements.length; x++){
		if(!elements[x]) continue;
		newHTML.push(elements[x].displayAnswering());
		newHTML.push("<br>");
	}
	p.innerHTML = newHTML.join('');
}
</script>
</body>
</html>