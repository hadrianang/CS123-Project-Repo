function element_plainText(id, name, text){
	this.type = "plainText";
	this.id = id;
	this.name = name;
	this.text = text;
	this.getName = function(){
		return "element_"+this.id+"_text";
	};
	this.displayCreating = function(){
		return "<p id=\"element"+this.id+"\" name=\"element"+this.id+"\">" +
		"<input id=\"element_"+this.id+"_text\" type=\"text\" name=\"element_"+this.id+"_text\" value=\""+this.text+"\" placeholder=\"Text\">" +
		"</p>";
	};
	this.displayAnswering = function(){
		return "<p id=\"element"+this.id+"\" name=\""+this.getName()+"\">" +
		this.text +
		"</p>";
	};
}

function element_field(id, name, hint){
	this.type = "field";
	this.id = id;
	this.name = name;
	this.text = "";
	this.ans = "";
	this.getName = function(){
		return "element_"+this.id+"_field";
	};
	this.displayCreating = function(){
		return "<p id=\"element"+this.id+"\">" +
		"<h1>"+this.name+"</h1>" +
		"<input id=\"element_"+this.id+"_field\" type=\"text\" name=\"element_"+this.id+"_field\" value=\""+this.text+"\" placeholder=\""+hint+"\">" +
		"</p>";
	};
	this.displayAnswering = function(){
		return "<p id=\"element"+this.id+"\">" + 
		this.name + "<br>" +
		"<input id=\""+this.getName()+"\" type=\"text\" name=\""+this.getName()+"\" placeholder=\""+this.text+"\" value=\""+this.ans+"\">" +
		"</p>";
	};
}

function element_textArea(id, name, hint){
	this.type = "textArea";
	this.id = id;
	this.name = name;
	this.text = "";
	this.ans = "";
	this.getName = function(){
		return "element_"+this.id+"_area";
	};
	this.displayCreating = function(){
		return "<p id=\"element"+this.id+"\">" +
		"<h1>"+this.name+"</h1>" +
		"<textarea id=\"element_"+this.id+"_area\" form=\"form\" name=\"element_"+this.id+"_area\" placeholder=\""+hint+"\">" + this.text + 
		"</textarea>" + 
		"</p>";
	};
	this.displayAnswering = function(){
		return "<p id=\"element"+this.id+"\">" + 
		this.name + "<br>" +
		"<textarea id=\""+this.getName()+"\" form=\"form\" name=\""+this.getName()+"\" placeholder=\""+this.text+"\">"+this.ans+"</textarea>" +
		"</p>";
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
		return "element_"+this.id+"_drop_choice_"+i;
	};
	this.addChoice = function(text){
		this.choices.push(text);
	};
	this.removeChoice = function(i){
		this.choices.splice(i, 1);
	};
	this.displayCreating = function(){
		var str = [];
		str.push("<p id=\"element"+this.id+"\">");
		for(i=0; i<this.choices.length; i++){
			str.push("<input id=\"element_"+this.id+"_drop_choice_"+i+"\" type=\"text\" name=\"element_"+this.id+"_drop_choice_"+i+"\" value=\""+this.choices[i]+"\" placeholder=\"choice "+(i+1)+"\">");
			str.push("<input type=\"button\" value=\"Remove Choice\" onclick=\"element_dropDown_removeChoice("+this.id+","+i+")\">");
			str.push("<br>");
		}
		str.push("<input type=\"button\" value=\"Add Choice\" onclick=\"element_dropDown_addChoice("+this.id+")\"></p>");
		return str.join('');
	};
	this.displayAnswering = function(){
		var str = [];
		str.push("<p id=\"element"+this.id+"\">");
		str.push("<select id=\""+this.getName()+"\">");
		for(i=0; i<this.choices.length; i++){
			str.push("<option value=\""+i+"\"");
			if(i == this.cur){
				str.push(" selected=\"selected\"");
			}
			str.push(">"+this.choices[i]+"</option>");
		}
		str.push("</select>");
		str.push("</p>");
		return str.join('');
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
		return "element_"+this.id+"_radio_row_"+i+"_"+(this.rowButtons[i]?"TRUE":"FALSE");
	};
	this.getColName = function(i){
		return "element_"+this.id+"_radio_col_"+i;
	};
	this.addRow = function(buttons, text){
		this.rows++;
		this.rowText.push(text);
		this.rowButtons.push(buttons);
		this.ans.push(-1);
	};
	this.addCol = function(text){
		this.cols++;
		this.colText.push(text);
	};
	this.removeRow = function(i){
		this.rows--;
		this.rowText.splice(i, 1);
		this.rowButtons.splice(i, 1);
	};
	this.removeCol = function(i){
		this.cols--;
		this.colText.splice(i, 1);
	};
	this.displayCreating = function(){
		var str = [];
		str.push("<p id=\"element"+this.id+"\">");
		for(i=0; i<this.rows; i++){
			str.push("<input id=\"element_"+this.id+"_radio_row_"+i+"_"+(this.rowButtons[i]?"TRUE":"FALSE")+"\" type=\"text\" name=\"element_"+this.id+"_radio_row_"+i+"_"+(this.rowButtons[i]?"TRUE":"FALSE")+"\" value=\""+this.rowText[i]+"\" placeholder=\""+(this.rowButtons[i]?"Question ":"Section ")+"\">");
			str.push("<input type=\"button\" value=\"Remove "+(this.rowButtons[i]?"Question":"Section")+"\" onclick=\"element_radioCluster_removeRow("+this.id+","+i+")\">");
			str.push("<br>");
		}
		str.push("<br><br>");
		for(i=0; i<this.cols; i++){
			str.push("<input id=\"element_"+this.id+"_radio_col_"+i+"\" type=\"text\" name=\"element_"+this.id+"_radio_col_"+i+"\" value=\""+this.colText[i]+"\" placeholder=\"choice "+(i+1)+"\">");
			str.push("<input type=\"button\" value=\"Remove Choice\" onclick=\"element_radioCluster_removeCol("+this.id+","+i+")\">");
			str.push("<br>");
		}
		str.push("<input type=\"button\" value=\"Add Question\" onclick=\"element_radioCluster_addRow("+this.id+", true)\">");
		str.push("<input type=\"button\" value=\"Add Section\" onclick=\"element_radioCluster_addRow("+this.id+", false)\">");
		str.push("<input type=\"button\" value=\"Add Choice\" onclick=\"element_radioCluster_addCol("+this.id+")\"></p>");
		return str.join('');
	};
	this.displayAnswering = function(){
		var str = [];
		str.push("<p id=\"element"+this.id+"\">");
		str.push("<table>");
		str.push("<tr>");
		for(i=0; i<=this.cols; i++){
			str.push("<td>");
			if(i != 0){
				str.push(this.colText[i-1]);
			}
			str.push("</td>");
		}
		str.push("</tr>");
		for(i=0; i<this.rows; i++){
			str.push("<tr>");
			str.push("<td>" + this.rowText[i] + "</td>");
			for(j=0; j<this.cols; j++){
				str.push("<td>");
				if(this.rowButtons[i]){
					str.push("<input type=\"radio\" name=\""+this.getRowName(i)+"\" value=\""+j+"\"")
					if(this.ans[i] == j){
						str.push(" checked");
					}
					str.push(">");
				}
				str.push("</td>");
			}
			str.push("</tr>");
		}
		str.push("</table>");
		return str.join('');
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
		return "element_"+this.id+"_table_header_"+i+"_"+(this.hasRowText?"TRUE":"FALSE");
	};
	this.getRowName = function(i){
		return "element_"+this.id+"_table_question_"+i;
	};
	this.getCellName = function(i, j){
		return "element_"+this.id+"_table_"+i+"_"+j;
	};
	this.addCol = function(text){
		this.cols++;
		this.colText.push(text);
	};
	this.addRow = function(text){
		this.rows++;
		this.rowText.push(text);
	};
	this.removeRow = function(i){
		this.rows--;
		this.rowText.splice(i, 1);
	};
	this.removeCol = function(i){
		this.cols--;
		this.colText.splice(i, 1);
	};
	this.addAnswerRow = function(){
		for(i=0; i<this.cols; i++){
			this.ans[this.rows+"_"+i] = "";
		}
		this.rows++;
	};
	this.displayCreating = function(){
		var str = [];
		str.push("<p id=\"element"+this.id+"\">");
		for(i=0; i<this.cols; i++){
			str.push("<input id=\"element_"+this.id+"_table_header_"+i+"_"+(this.hasRowText?"TRUE":"FALSE")+"\" type=\"text\" name=\"element_"+this.id+"_table_header_"+i+"_"+(this.hasRowText?"TRUE":"FALSE")+"\" value=\""+this.colText[i]+"\" placeholder=\"header "+(i+1)+"\">");
			str.push("<input type=\"button\" value=\"Remove Header\" onclick=\"element_table_removeCol("+this.id+","+i+")\">");
			str.push("<br>");
		}
		if(this.hasRowText){
			str.push("<br><br>");
			for(i=0; i<this.rows; i++){
				str.push("<input id=\"element_"+this.id+"_table_question_"+i+"\" type=\"text\" name=\"element_"+this.id+"_table_question_"+i+"\" value=\""+this.rowText[i]+"\" placeholder=\"question "+(i+1)+"\">");
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
		var str = [];
		str.push("<p id=\"element"+this.id+"\">");
		str.push("<table>");
		str.push("<tr>");
		if(this.hasRowText){
			str.push("<td></td>");
		}
		for(i=0; i<this.cols; i++){
			str.push("<td>"+this.colText[i]+"</td>");
		}
		str.push("</tr>");
		for(i=0; i<this.rows; i++){
			str.push("<tr>");
			if(this.hasRowText){
				str.push("<td>"+this.rowText[i]+"</td>");
			}
			for(j=0; j<this.cols; j++){
				str.push("<td><textarea id=\""+this.getCellName(i, j)+"\" form=\"form\" name=\""+this.getCellName(i, j)+"\" placeholder=\""+this.text+"\">")
				str.push(this.ans[i+"_"+j]);
				str.push("</textarea></td>");
			}
			str.push("</tr>");
		}
		
		str.push("</table>");
		if(!this.hasRowText){
			str.push("<input type=\"button\" value=\"Add Answer\" onclick=\"element_table_addAnswerRow("+this.id+")\">");
		}
		str.push("</p>");
		return str.join('');
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

function element_table_addAnswerRow(id){
	updateData();
	for(i=0; i<elements[id].cols; i++){
		elements[id].ans[elements[id].rows+"_"+i] = "";
	}
	elements[id].rows++;
	refreshForm();
}