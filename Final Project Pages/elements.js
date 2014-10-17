function element_plainText(id, name, text){
	this.type = "plainText";
	this.id = id;
	this.databaseID = -1;
	this.name = name;
	this.text = text;
	this.getName = function(){
		return "element_"+this.id+"_"+this.databaseID+"_text_name";
	};
	this.getText = function(){
		return "element_"+this.id+"_"+this.databaseID+"_text_text";
	};
	this.displayCreating = function(){
		var str = [];
		str.push("<p id=\"element"+this.id+"\">");
		str.push("<input id=\""+this.getName()+"\" type=\"text\" name=\""+this.getName()+"\" value=\""+this.name+"\" placeholder=\"Header\">");
		str.push("<br>");
		str.push("<input id=\""+this.getText()+"\" type=\"text\" name=\""+this.getText()+"\" value=\""+this.text+"\" placeholder=\"Text\">");
		str.push("</p>");
		return str.join('');
	};
	this.displayAnswering = function(){
		var str = [];
		str.push("<p id=\"element"+this.id+"\">");
		str.push("<h3>"+this.name+"</h3>");
		str.push(this.text+"<br>");
		str.push("</p>");
		return str.join('');
	};
}

function element_field(id, name, text){
	this.type = "field";
	this.id = id;
	this.databaseID = -1;
	this.name = name;
	this.text = text;
	this.ans = "";
	this.getName = function(){
		return "element_"+this.id+"_"+this.databaseID+"_field_name";
	};
	this.getText = function(){
		return "element_"+this.id+"_"+this.databaseID+"_field_text";
	};
	this.displayCreating = function(){
		var str = [];
		str.push("<p id=\"element"+this.id+"\">");
		str.push("<input id=\""+this.getName()+"\" type=\"text\" name=\""+this.getName()+"\" value=\""+this.name+"\" placeholder=\"Field name\">");
		str.push("<br>");
		str.push("<input id=\""+this.getText()+"\" type=\"text\" name=\""+this.getText()+"\" value=\""+this.text+"\" placeholder=\"Field Subtext\">");
		str.push("</p>");
		return str.join('');
	};
	this.displayAnswering = function(){
		var str = [];
		str.push("<p id=\"element"+this.id+"\">");
		str.push("<b>"+this.name+"</b>"+"<br>");
		str.push(this.text+"<br>");
		str.push("<input id=\""+this.getName()+"\" type=\"text\" name=\""+this.getName()+"\" value=\""+this.ans+"\">");
		str.push("</p>");
		return str.join('');
	};
}

function element_textArea(id, name, text){
	this.type = "textArea";
	this.id = id;
	this.databaseID = -1;
	this.name = name;
	this.text = text;
	this.ans = "";
	this.getName = function(){
		return "element_"+this.id+"_"+this.databaseID+"_area_name";
	};
	this.getText = function(){
		return "element_"+this.id+"_"+this.databaseID+"_area_text";
	};
	this.displayCreating = function(){
		var str = [];
		str.push("<p id=\"element"+this.id+"\">");
		str.push("<input id=\""+this.getName()+"\" type=\"text\" name=\""+this.getName()+"\" value=\""+this.name+"\" placeholder=\"Text Area Name\">");
		str.push("<br>");
		str.push("<input id=\""+this.getText()+"\" type=\"text\" name=\""+this.getText()+"\" value=\""+this.text+"\" placeholder=\"Text Area Subtext\">");
		str.push("</p>");
		return str.join('');
	};
	this.displayAnswering = function(){
		var str = [];
		str.push("<p id=\"element"+this.id+"\">");
		str.push("<b>"+this.name+"</b>"+"<br>");
		str.push(this.text+"<br>");
		str.push("<textarea id=\""+this.getName()+"\" form=\"form\" name=\""+this.getName()+"\">"+this.ans+"</textarea>");
		str.push("</p>");
		return str.join('');
	};
}

function element_dropDown(id, name, text){
	this.type = "dropDown";
	this.id = id;
	this.databaseID = -1;
	this.name = name;
	this.text = text;
	this.choices = [];
	this.cur = 0;
	this.getName = function(){
		return "element_"+this.id+"_"+this.databaseID+"_drop_name";
	};
	this.getText = function(){
		return "element_"+this.id+"_"+this.databaseID+"_drop_text";
	};
	this.getChoiceName = function(i){
		return "element_"+this.id+"_"+this.databaseID+"_drop_choice_"+i;
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
		str.push("<input id=\""+this.getName()+"\" type=\"text\" name=\""+this.getName()+"\" value=\""+this.name+"\" placeholder=\"Drop Down Subtext\">");
		str.push("<br>");
		str.push("<input id=\""+this.getText()+"\" type=\"text\" name=\""+this.getText()+"\" value=\""+this.text+"\" placeholder=\"Drop Down Subtext\">");
		str.push("<br>");
		str.push("<br>");
		for(i=0; i<this.choices.length; i++){
			str.push("<input id=\""+this.getChoiceName(i)+"\" type=\"text\" name=\""+this.getChoiceName(i)+"\" value=\""+this.choices[i]+"\" placeholder=\"choice "+(i+1)+"\">");
			str.push("<input type=\"button\" value=\"Remove Choice\" onclick=\"element_dropDown_removeChoice("+this.id+","+i+")\">");
			str.push("<br>");
		}
		str.push("<input type=\"button\" value=\"Add Choice\" onclick=\"element_dropDown_addChoice("+this.id+")\"></p>");
		return str.join('');
	};
	this.displayAnswering = function(){
		var str = [];
		str.push("<p id=\"element"+this.id+"\">");
		str.push("<b>"+this.name+"</b>"+"<br>");
		str.push(this.text+"<br>");
		str.push("<select id=\""+this.getName()+"\" name=\""+this.getName()+"\">");
		for(i=0; i<this.choices.length; i++){
			str.push("<option value=\""+this.choices[i]+"\"");
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

function element_radioCluster(id, name, text){
	this.type = "radioCluster";
	this.id = id;
	this.databaseID = -1;
	this.name = name;
	this.text = text;
	this.rows = 0;
	this.cols = 0;
	this.rowText = [];
	this.colText = [];
	this.rowButtons = [];
	this.ans = [];
	this.getName = function(){
		return "element_"+this.id+"_"+this.databaseID+"_radio_name";
	};
	this.getText = function(){
		return "element_"+this.id+"_"+this.databaseID+"_radio_text";
	};
	this.getRowName = function(i){
		return "element_"+this.id+"_"+this.databaseID+"_radio_row_"+i+"_"+(this.rowButtons[i]?"TRUE":"FALSE");
	};
	this.getColName = function(i){
		return "element_"+this.id+"_"+this.databaseID+"_radio_col_"+i;
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
		str.push("<input id=\""+this.getName()+"\" type=\"text\" name=\""+this.getName()+"\" value=\""+this.name+"\" placeholder=\"Radio Cluster Name\">");
		str.push("<br>");
		str.push("<input id=\""+this.getText()+"\" type=\"text\" name=\""+this.getText()+"\" value=\""+this.text+"\" placeholder=\"Radio Cluster Subtext\">");
		str.push("<br>");
		str.push("<br>");
		for(i=0; i<this.rows; i++){
			console.log(this.getRowName(i));
			str.push("<input id=\""+this.getRowName(i)+"\" type=\"text\" name=\""+this.getRowName(i)+"\" value=\""+this.rowText[i]+"\" placeholder=\""+(this.rowButtons[i]?"Question ":"Section ")+"\">");
			str.push("<input type=\"button\" value=\"Remove "+(this.rowButtons[i]?"Question":"Section")+"\" onclick=\"element_radioCluster_removeRow("+this.id+","+i+")\">");
			str.push("<br>");
		}
		str.push("<br>");
		for(i=0; i<this.cols; i++){
			str.push("<input id=\""+this.getColName(i)+"\" type=\"text\" name=\""+this.getColName(i)+"\" value=\""+this.colText[i]+"\" placeholder=\"choice "+(i+1)+"\">");
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
		str.push("<b>"+this.name+"</b>"+"<br>");
		str.push(this.text+"<br>");
		str.push("<table class=\"custom\">");
		str.push("<tr>");
		for(i=0; i<=this.cols; i++){
			str.push("<th>");
			if(i != 0){
				str.push(this.colText[i-1]);
			}
			str.push("</th>");
		}
		str.push("</tr>");
		for(i=0; i<this.rows; i++){
			str.push("<tr" + (i%2==0?"":" class=\"alt\"") + ">");
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

function element_table(id, name, text, type){
	this.type = "table";
	this.name = name;
	this.text = text;
	this.id = id;
	this.databaseID = -1;
	this.rows = 0;
	this.cols = 0;
	this.rowText = [];
	this.colText = [];
	this.hasRowText = type;
	this.ans = {};
	this.getName = function(){
		return "element_"+this.id+"_"+this.databaseID+"_table_name_"+(this.hasRowText?"TRUE":"FALSE");
	};
	this.getText = function(){
		return "element_"+this.id+"_"+this.databaseID+"_table_text_"+(this.hasRowText?"TRUE":"FALSE");
	};
	this.getColName = function(i){
		return "element_"+this.id+"_"+this.databaseID+"_table_header_"+i+"_"+(this.hasRowText?"TRUE":"FALSE");
	};
	this.getRowName = function(i){
		return "element_"+this.id+"_"+this.databaseID+"_table_question_"+i;
	};
	this.getCellName = function(i, j){
		return "element_"+this.id+"_"+this.databaseID+"_table_"+i+"_"+j;
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
		str.push("<input id=\""+this.getName()+"\" type=\"text\" name=\""+this.getName()+"\" value=\""+this.name+"\" placeholder=\"Table Name\">");
		str.push("<br>");
		str.push("<input id=\""+this.getText()+"\" type=\"text\" name=\""+this.getText()+"\" value=\""+this.text+"\" placeholder=\"Table Subtext\">");
		str.push("<br>");
		str.push("<br>");
		for(i=0; i<this.cols; i++){
			str.push("<input id=\""+this.getColName(i)+"\" type=\"text\" name=\""+this.getColName(i)+"\" value=\""+this.colText[i]+"\" placeholder=\"header "+(i+1)+"\">");
			str.push("<input type=\"button\" value=\"Remove Header\" onclick=\"element_table_removeCol("+this.id+","+i+")\">");
			str.push("<br>");
		}
		if(this.hasRowText){
			str.push("<br>");
			for(i=0; i<this.rows; i++){
				str.push("<input id=\""+this.getRowName(i)+"\" type=\"text\" name=\""+this.getRowName(i)+"\" value=\""+this.rowText[i]+"\" placeholder=\"question "+(i+1)+"\">");
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
		str.push("<b>"+this.name+"</b>"+"<br>");
		str.push(this.text+"<br>");
		str.push("<table class=\"custom\">");
		str.push("<tr>");
		if(this.hasRowText){
			str.push("<th></th>");
		}
		for(i=0; i<this.cols; i++){
			str.push("<th>"+this.colText[i]+"</th>");
		}
		str.push("</tr>");
		for(i=0; i<this.rows; i++){
			str.push("<tr" + (i%2==0?"":" class=\"alt\"") + ">");
			if(this.hasRowText){
				str.push("<td>"+this.rowText[i]+"</td>");
			}
			for(j=0; j<this.cols; j++){
				str.push("<td><textarea id=\""+this.getCellName(i, j)+"\" form=\"form\" name=\""+this.getCellName(i, j)+"\">")
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

function comment(step){
	this.step = step;
	this.databaseID = -1;
	this.ans = "";
	this.getName = function(){
		return "comment_"+this.step+"_"+this.databaseID;
	};
	this.display = function(){
		var str = [];
		str.push("<p id=\"comment"+this.step+"\">");
		str.push("<textarea id=\""+this.getName()+"\" form=\"form\" name=\""+this.getName()+"\">"+this.ans+"</textarea>");
		str.push("</p>");
		return str.join('');
	};
}