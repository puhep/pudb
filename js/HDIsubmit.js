function FormatDate(){

	var good = "VALID DATE".fontcolor("green");

	var bad = "INVALID DATE".fontcolor("red");

	var date_str = document.getElementById("arrival").value;

	if(date_str == "" || date_str.length < 10){
		document.getElementById("dateresp").innerHTML = "";
		document.getElementById("submit").disabled = true;
	}
	else if(!/^\d{4}\/\d{2}\/\d{2}$/.test(date_str)){
		document.getElementById("dateresp").innerHTML = bad;
		document.getElementById("submit").disabled = true;
	}
	else{
		document.getElementById("dateresp").innerHTML = good;
		document.getElementById("submit").disabled = false;
	}
		
}

function Start(){
	
	document.getElementById("submit").disabled = true;
	document.getElementById("arrival").onkeyup = FormatDate;
}

window.onload = Start;
