function element_plainText(id, name, text){
	this.type = "plainText";
	this.id = id;
	this.name = name;
	this.text = text;
	this.getName = function(){
		return "element"+this.id;
	};
	this.displayCreating = function(){
		return "<p id=\"element"+this.id+"\" name=\"element"+this.id+"\">" +
		"<h1>"+this.name+"</h1>" +
		text +
		"</p>";
	};
	this.displayAnswering = function(){
	};
}

function element_field(id, name, hint){
	this.type = "field";
	this.id = id;
	this.name = name;
	this.text = "";
	this.getName = function(){
		return "element"+this.id+"field";
	};
	this.displayCreating = function(){
		return "<p id=\"element"+this.id+"\">" +
		"<h1>"+this.name+"</h1>" +
		"<input id=\"element"+this.id+"field\" type=\"text\" name=\"element"+this.id+"field\" value=\""+this.text+"\" placeholder=\""+hint+"\">" +
		"</p>";
	};
	this.displayAnswering = function(){
	};
}

function element_textArea(id, name, hint){
	this.type = "textArea";
	this.id = id;
	this.name = name;
	this.text = "";
	this.getName = function(){
		return "element"+this.id+"area";
	};
	this.displayCreating = function(){
		return "<p id=\"element"+this.id+"\">" +
		"<h1>"+this.name+"</h1>" +
		"<textarea id=\"element"+this.id+"area\" form=\"form\" name=\"element"+this.id+"area\" placeholder=\""+hint+"\">" + this.text + 
		"</textarea>" + 
		"</p>";
	};
	this.displayAnswering = function(){
	};
}

function element_dropDown(id, name){
	this.type = "dropDown";
	this.id = id;
	this.name = name;
	this.choices = [""];
	this.cur = 0;
	this.getName = function(){
		return "element"+this.id;
	};
	this.getChoiceName = function(i){
		return "element"+this.id+"choice"+i;
	};
	this.displayCreating = function(){
		var str = [];
		str.push("<p id=\"element"+this.id+"\">");
		for(i=0; i<this.choices.length; i++){
			str.push("<input id=\"element"+this.id+"choice"+i+"\" type=\"text\" name=\"element"+this.id+"choice"+i+"\" value=\""+this.choices[i]+"\" placeholder=\"choice "+(i+1)+"\">");
			str.push("<input type=\"button\" value=\"Remove Choice\" onclick=\"element_dropDown_removeChoice("+this.id+","+i+")\">");
			str.push("<br>");
		}
		str.push("<input type=\"button\" value=\"Add Choice\" onclick=\"element_dropDown_addChoice("+this.id+")\"></p>");
		return str.join('');
	};
	this.displayAnswering = function(){
		var str = "<p id=\"element"+this.id+"\">";
		str += "<select id=\"element"+this.id+"DropDown\">";
		for(i=0; i<this.choices.length; i++){
			str += "<option value=\"choice"+i+"\">"+choices[i]+"</option>";
		}
		str += "</select>";
	};
}

function element_dropDown_addChoice(id){
	updateData();
	elements[id].choices.push("");
	refreshForm();
}

function element_dropDown_removeChoice(id, i){
	updateData();
	elements[id].choices.splice(i, 1);
	refreshForm();
}

function element_radioCluster(id, name){
	this.type = "radioCluster";
	this.id = id;
	this.name = name;
	this.rows = 2;
	this.cols = 1;
	this.rowText = ["", ""];
	this.colText = [""];
	this.rowButtons = [false, true];
	this.ans = [];
	this.getName = function(){
		return "element"+this.id;
	};
	this.getRowName = function(i){
		return "element"+this.id+"row"+i;
	};
	this.getColName = function(i){
		return "element"+this.id+"col"+i;
	};
	this.displayCreating = function(){
		var str = [];
		str.push("<p id=\"element"+this.id+"\">");
		for(i=0; i<this.rows; i++){
			str.push("<input id=\"element"+this.id+"row"+i+"\" type=\"text\" name=\"element"+this.id+"row"+i+"\" value=\""+this.rowText[i]+"\" placeholder=\""+(this.rowButtons[i]?"Question ":"Section ")+"\">");
			str.push("<input type=\"button\" value=\"Remove "+(this.rowButtons[i]?"Question":"Section")+"\" onclick=\"element_radioCluster_removeRow("+this.id+","+i+")\">");
			str.push("<br>");
		}
		str.push("<br><br>");
		for(i=0; i<this.cols; i++){
			str.push("<input id=\"element"+this.id+"col"+i+"\" type=\"text\" name=\"element"+this.id+"col"+i+"\" value=\""+this.colText[i]+"\" placeholder=\"choice "+(i+1)+"\">");
			str.push("<input type=\"button\" value=\"Remove Choice\" onclick=\"element_radioCluster_removeCol("+this.id+","+i+")\">");
			str.push("<br>");
		}
		str.push("<input type=\"button\" value=\"Add Question\" onclick=\"element_radioCluster_addRow("+this.id+", true)\">");
		str.push("<input type=\"button\" value=\"Add Section\" onclick=\"element_radioCluster_addRow("+this.id+", false)\">");
		str.push("<input type=\"button\" value=\"Add Choice\" onclick=\"element_radioCluster_addCol("+this.id+")\"></p>");
		return str.join('');
	};
	this.displayAnswering = function(){
	};
}

function element_radioCluster_addRow(id, buttons){
	updateData();
	elements[id].rows++;
	elements[id].rowText.push("");
	elements[id].rowButtons.push(buttons);
	refreshForm();
}

function element_radioCluster_addCol(id){
	updateData();
	elements[id].cols++;
	elements[id].colText.push("");
	refreshForm();
}

function element_radioCluster_removeRow(id, i){
	updateData();
	elements[id].rows--;
	elements[id].rowText.splice(i, 1);
	elements[id].rowButtons.splice(i, 1);
	refreshForm();
}

function element_radioCluster_removeCol(id, i){
	updateData();
	elements[id].cols--;
	elements[id].colText.splice(i, 1);
	refreshForm();
}

function element_table(id, name, type){
	this.type = "table";
	this.id = id;
	this.rows = 1;
	this.cols = 1;
	this.rowText = [""];
	this.colText = [""];
	this.hasRowText = type;
	this.ans = {};
	this.getName = function(){
		return "element"+this.id;
	};
	this.getColName = function(i){
		return "element"+this.id+"header"+i;
	};
	this.getRowName = function(i){
		return "element"+this.id+"question"+i;
	};
	this.displayCreating = function(){
		var str = [];
		str.push("<p id=\"element"+this.id+"\">");
		for(i=0; i<this.cols; i++){
			str.push("<input id=\"element"+this.id+"header"+i+"\" type=\"text\" name=\"element"+this.id+"header"+i+"\" value=\""+this.colText[i]+"\" placeholder=\"header "+(i+1)+"\">");
			str.push("<input type=\"button\" value=\"Remove Header\" onclick=\"element_table_removeCol("+this.id+","+i+")\">");
			str.push("<br>");
		}
		if(this.hasRowText){
			str.push("<br><br>");
			for(i=0; i<this.rows; i++){
				str.push("<input id=\"element"+this.id+"question"+i+"\" type=\"text\" name=\"element"+this.id+"question"+i+"\" value=\""+this.rowText[i]+"\" placeholder=\"question "+(i+1)+"\">");
				str.push("<input type=\"button\" value=\"Remove Question\" onclick=\"element_table_removeRow("+this.id+","+i+")\">");
				str.push("<br>");
			}
		}
		str.push("<input type=\"button\" value=\"Add Header\" onclick=\"element_table_addCol("+this.id+")\">");
		if(this.hasRowText){
		str.push("<input type=\"button\" value=\"Add Question\" onclick=\"element_table_addRow("+this.id+")\">");
		}
		str.push("</p>");
		return str.join('');
	};
	this.displayAnswering = function(){
	};
}

function element_table_addCol(id){
	updateData();
	elements[id].cols++;
	elements[id].colText.push("");
	refreshForm();
}

function element_table_addRow(id){
	updateData();
	elements[id].rows++;
	elements[id].rowText.push("");
	refreshForm();
}

function element_table_removeRow(id, i){
	updateData();
	elements[id].rows--;
	elements[id].rowText.splice(i, 1);
	refreshForm();
}
	
function element_table_removeCol(id, i){
	updateData();
	elements[id].cols--;
	elements[id].colText.splice(i, 1);
	refreshForm();
}