<html>
<head>
<title>Display Form</title>
<script type="text/javascript" src="elements.js"></script>
<script>
var elements = [];
var count = 0;
var formName = "";
var comments = [];
</script>
<script type="text/javascript" src="loadForm.php?id=<?php echo$_GET['id'];?>"></script>
<script type="text/javascript" src="loadComments.php?id=<?php echo$_GET['id']?>&username=<?php echo$_GET['username']?>"></script>
</head>
<body onload="setupForm()">
<form id=\"form\" name=\"form\" method=\"post\">
<p id="elements">
</p>
<p id="comments">
</p>
<p id="buttons">
</p>
</form>
<script type="text/javascript">
function setupForm(){
	if(formStep == 0){
		document.getElementById("form").action = "SubmitForm.php?id=<?php echo$_GET['id']?>&username=<?php echo$_GET['username']?>";
		document.getElementById("buttons").innerHTML = "<input type=\"submit\" value=\"Submit Form\">";
	}else{
		document.getElementById("form").action = "SubmitComment.php?id=<?php echo$_GET['id']?>&username=<?php echo$_GET['username']?>";
		document.getElementById("buttons").innerHTML = "<input type=\"submit\" name=\"action\" value=\"Accept\" /><input type=\"submit\" name=\"action\" value=\"Reject\" />";
	}
	
	refreshForm();
	
	var str = [];
	for(i=0; i<comments.length; i++){
		str.push(comments[i].display());
		str.push("<br>");
	}
	document.getElementById("comments").innerHTML = str.join('');
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