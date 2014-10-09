<html>
<head>
<title>Display Form</title>
<script type="text/javascript" src="elements.js"></script>
<script>
var elements = [];
var count = 0;
</script>
<script type="text/javascript" src="loadForm.php?id=<?php echo$_GET['id'];?>"></script>
</head>
<body onload="refreshForm()">
<form id="form" name="form" action="SubmitForm.php?id=<?php echo$_GET['id']?>&username=<?php echo$_GET['username']?>" method="post">
<p id="elements">
</p>
<input type="submit" value="Submit Form">
</form>
<script type="text/javascript">

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
	newHTML.push("<h1>"+formName+"</h1>");
	console.log(elements.length);
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