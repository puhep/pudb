function CheckNum(){

	var good = "VALID".fontcolor("green");
	var bad = "INVALID".fontcolor("red");
	var available = "unchanged";

	var id_str = document.getElementById("wafer_id").value;
		var id = parseInt(id_str);

	if(id_str == ""){
		document.getElementById("wafresp").innerHTML = "";
		window.id_val = false;
	}
	else if(isNaN(id_str) || !id_str.indexOf(" ")){
		document.getElementById("wafresp").innerHTML = bad;
		window.id_val = false;
	}
	else if(parseInt(id_str) > 0 && parseInt(id_str) < 1000){
		document.getElementById("wafresp").innerHTML = good;
		window.id_val = true;
	}
	else{
		window.id_val = false;
	}

	SubmitButton();
}

function FormatDate(){

	var good = "VALID DATE".fontcolor("green");
	var bad = "INVALID DATE".fontcolor("red");

	var date_str = document.getElementById("receive").value;

	if(date_str == "" || date_str.length < 10){
		document.getElementById("dateresp").innerHTML = "";
		window.date_val = false;
	}
	else if(!/^\d{4}\/\d{2}\/\d{2}$/.test(date_str)){
		document.getElementById("dateresp").innerHTML = bad;
		window.date_val = false;
	}
	else{
		document.getElementById("dateresp").innerHTML = good;
		window.date_val = true;
	}

	SubmitButton();
}

function SubmitButton(){

	if(id_val && date_val){
		document.getElementById("submit").disabled = false;
	}
	else{
		document.getElementById("submit").disabled = true;
	}
}

function Start(){
	
	document.getElementById("submit").disabled = true;
	document.getElementById("wafer_id").onkeyup = CheckNum;
	document.getElementById("receive").onkeyup = FormatDate;

	window.id_val = false;
	window.date_val = false;
}

window.onload = Start;
