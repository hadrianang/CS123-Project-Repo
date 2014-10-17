<html><title>PracSys: Ateneo DISCS Practicum Management System</title>
<link rel="stylesheet" href="style.css">
<head>
<title>Display Form</title>
<?php
include 'page_setup.php';
$temp = prepare_page();
?>
<script type="text/javascript" src="elements.js"></script>
<script>
var elements = [];
var count = 0;
var formName = "";
var formPath = "";
var comments = [];
var formStep = 0;
</script>
<script type="text/javascript" src="loadForm.php?id=<?php echo$_GET['id'];?>&username=<?php echo$_GET['username']?>"></script>
<script type="text/javascript" src="loadComments.php?id=<?php echo$_GET['id']?>&username=<?php echo$_GET['username']?>"></script>
<script>
<?php
$con = sql_setup();

$result = mysqli_query($con, "SELECT * FROM Account WHERE Username='$temp';");
$resarr = mysqli_fetch_array($result);
echo "var displayButtons = '" . strtoupper($resarr['Type'])[0] . "' == formPath[formStep];";
?>
</script>
</head>
<body onload="setupForm()">
<div id='body2'>
<form id="form" name="form" method="post">
<p id="elements">
</p>
<p id="comments">
</p>
<p id="buttons">
</p>
</form>
</div>
<script type="text/javascript">
function setupForm(){
	if(displayButtons){
		if(formStep == 0){
			document.getElementById("form").action = "SubmitForm.php?id=<?php echo$_GET['id']?>&username=<?php echo$_GET['username']?>";
			document.getElementById("buttons").innerHTML = "<input type=\"submit\" value=\"Submit Form\" onclick=\"this.disabled=true;this.value='Sending, please wait...';this.form.submit();\">";
		}else{
			document.getElementById("form").action = "SubmitComment.php?id=<?php echo$_GET['id']?>&username=<?php echo$_GET['username']?>";
			document.getElementById("buttons").innerHTML = "<input type=\"hidden\" id=\"action\" name=\"action\" value=\"Reject\"><input type=\"submit\" value=\"Accept\" onclick=\"this.disabled=true;this.value='Sending, please wait...';document.getElementById('action').value='Accept';this.form.submit();\"><input type=\"submit\" value=\"Reject\" onclick=\"this.disabled=true;this.value='Sending, please wait...';this.form.submit();\">";
		}
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