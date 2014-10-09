<html>
<head>
<title>Modify Form</title>
<script type="text/javascript" src="elements.js"></script>
<script>
var elements = [];
var count = 0;
var formName = "";
</script>
<script type="text/javascript" src="loadForm.php?id=<?php echo$_GET['id'];?>"></script>
</head>
<body onload="refreshForm()">
<form id="form" name="form" action="updateForm.php?id=<?php echo$_GET['id'];?>" method="post">
<p id="elements">
</p>
<p id="newItem">
<select id="newItemDropDown">
<option value="plainText">Plain Text</option>
<option value="field">Field</option>
<option value="textArea">Text Area</option>
<option value="dropDown">Drop Down</option>
<option value="radioCluster">Radio Cluster</option>
<option value="table1">Table with questions on rows</option>
<option value="table2">Table with dynamic rows</option>
</select>
<input type="button" value="Add Item" onclick="addItem()">
</p>
<input type="submit" value="Submit Form">
</form>

<script type="text/javascript">
function addItem(){
	updateData();
	
	var type = document.getElementById("newItemDropDown").value;
	if(type == "plainText"){
		elements.push(new element_plainText(count++, "", ""));
	}else if(type == "field"){
		elements.push(new element_field(count++, "", ""));
	}else if(type == "textArea"){
		elements.push(new element_textArea(count++, "", ""));
	}else if(type == "dropDown"){
		elements.push(new element_dropDown(count++, "", ""));
	}else if(type == "radioCluster"){
		elements.push(new element_radioCluster(count++, "", ""));
	}else if(type == "table1"){
		elements.push(new element_table(count++, "", "", true));
	}else if(type == "table2"){
		elements.push(new element_table(count++, "", "", false));
	}
	
	refreshForm();
}

function updateData(){
	formName = document.getElementById("formname").value;
	var formelements = document.getElementById("form").elements;
	
	for(i=0; i<elements.length; i++){
		if(!elements[i]) continue;
		var e = elements[i];
		e.name = formelements[e.getName()].value;
		e.text = formelements[e.getText()].value;
		if(elements[i].type == "dropDown"){
			for(j=0; j<elements[i].choices.length; j++){
				element = formelements[elements[i].getChoiceName(j)];
				elements[i].choices[j] = element.value;
			}
		}else if(elements[i].type == "radioCluster"){
			for(j=0; j<elements[i].rows; j++){
				element = formelements[elements[i].getRowName(j)];
				elements[i].rowText[j] = element.value;
			}
			for(j=0; j<elements[i].cols; j++){
				element = formelements[elements[i].getColName(j)];
				elements[i].colText[j] = element.value;
			}
		}else if(elements[i].type == "table"){
			for(j=0; j<elements[i].cols; j++){
				element = formelements[elements[i].getColName(j)];
				elements[i].colText[j] = element.value;
			}
			if(elements[i].hasRowText){
				for(j=0; j<elements[i].rows; j++){
					element = formelements[elements[i].getRowName(j)];
					elements[i].rowText[j] = element.value;
				}
			}
		}
	}
}

function refreshForm(){
	var p = document.getElementById("elements");
	var newHTML = [];
	newHTML.push("<p><input id=\"formname\" type=\"text\" name=\"formname\" value=\""+formName+"\" placeholder=\"Form Name\"></p>");
	console.log(elements.length);
	for(x=0; x<elements.length; x++){
		if(!elements[x]) continue;
		newHTML.push(elements[x].displayCreating());
		newHTML.push("<input type=\"button\" value=\"Delete Element\" onclick=\"removeElement("+x+")\">");
		newHTML.push("<br>");
	}
	p.innerHTML = newHTML.join('');
}

function removeElement(id){
	updateData();
	delete elements[id];
	refreshForm();
}
</script>

</body>
</html>