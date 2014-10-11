<?
$conn = mysql_connect('mysql.eecs.ku.edu', 'tschante', 'monkey08')
	or die('Could not connect: ' . mysql_error());
$conn2 = mysql_connect('mysql.eecs.ku.edu', 'chefley', 'Ug67Ktg8')
	or die('Could not connect: ' . mysql_error());
//echo 'Connected successfully';
mysql_select_db('chefley') or die('Could not select database');

session_start();


$user = mysql_query("SELECT * FROM User",$conn2);
$u = mysql_fetch_row($user);
$result = mysql_query("SELECT * FROM Location WHERE Location_id = ".$u[2],$conn2);
$r = mysql_fetch_row($result);
$_SESSION["username"] = $u[0];


$elementsperrow = mysql_num_fields($result) - 3;
$elementsperrow = sqrt($elementsperrow);
$percentelement = 100/ $elementsperrow;

for($i = 3; $i<mysql_num_fields ($result); $i++){
	if($u[1] == $i){
		Echo "<div class = \"box\" id = \"box".$i."\" style=\"background-color: ".$r[$i]."; width: ".$percentelement."%; float: left; height: ".$percentelement."%;\"><div id = \"me\"style=\"background-color:white; width:50%; border-top: 5px solid red; height:50%;margin:auto;position:relative; top:25%;\">&nbsp;</div></div>";
	}else{
		Echo "<div class = \"box\" id = \"box".$i."\" style=\"background-color: ".$r[$i]."; width: ".$percentelement."%; float: left; height: ".$percentelement."%;\">&nbsp;</div>";
	}
}

?>
<script>
var numEnemies = <? echo $r[0];?>;
var myLoc = <? echo $u[1]; ?>;
var myLocid = <? echo $u[2]; ?>;
$(document).ready(function(){
	var divs = document.getElementsByClassName("box");
	var newhtml = "<div class = \"enemy\">&nbsp;</div>";
	var rando = Math.floor(divs.length * Math.random());
	while(divs[rando].style.backgroundColor == "green" || rando == myLoc - 3 ){
		rando = Math.floor(divs.length * Math.random());
	}
	while(numEnemies > 0){
		divs[rando].innerHTML = newhtml;
		numEnemies--;
		rando = Math.floor(divs.length * Math.random());
		while(divs[rando].style.backgroundColor == "green" || rando == myLoc - 3 ){
			rando = Math.floor(divs.length * Math.random());
		}
	}
});
var checker = true;
document.onkeypress = function(evt) {
if(checker){
    evt = evt || window.event;
    var charCode = evt.keyCode || evt.which;
    var charStr = String.fromCharCode(charCode);
    if (charCode == 97 && myLoc >3 && myLoc % 5 != 3 && document.getElementById("box".concat((myLoc-1).toString())).style.backgroundColor != "green"){
    	document.getElementById("box".concat((myLoc-1).toString())).innerHTML = document.getElementById("box".concat(myLoc.toString())).innerHTML;
    	document.getElementById("box".concat(myLoc.toString())).innerHTML = "&nbsp;";
    	document.getElementById("me").style.border = "0px solid red";
    	document.getElementById("me").style.borderLeft = "5px solid red";
    	myLoc--;
    	$.ajax({
	    url: 'functions.php',
	    type: 'post',
	    data: { "callFunc1": myLoc}/*,
	    success: function(response) {alert(response); }*/
	});
    }else if (charCode == 115 && myLoc <23 && document.getElementById("box".concat((myLoc+5).toString())).style.backgroundColor != "green"){
    	document.getElementById("box".concat((myLoc+5).toString())).innerHTML = document.getElementById("box".concat(myLoc.toString())).innerHTML;
    	document.getElementById("box".concat(myLoc.toString())).innerHTML = "&nbsp;";
    	myLoc= myLoc+5;
    	document.getElementById("me").style.border = "0px solid red";
    	document.getElementById("me").style.borderBottom = "5px solid red";
    	$.ajax({
	    url: 'functions.php',
	    type: 'post',
	    data: { "callFunc1": myLoc}/*,
	    success: function(response) { }*/
	});
    }else if (charCode == 119 && myLoc >7 && document.getElementById("box".concat((myLoc-5).toString())).style.backgroundColor != "green"){
    	document.getElementById("box".concat((myLoc-5).toString())).innerHTML = document.getElementById("box".concat(myLoc.toString())).innerHTML;
    	document.getElementById("box".concat(myLoc.toString())).innerHTML = "&nbsp;";
    	myLoc= myLoc-5;
    	document.getElementById("me").style.border = "0px solid red";
    	document.getElementById("me").style.borderTop = "5px solid red";
    	$.ajax({
	    url: 'functions.php',
	    type: 'post',
	    data: { "callFunc1": myLoc}/*,
	    success: function(response) { }*/
	});
    }else if (charCode == 100 && myLoc >2 && myLoc % 5 != 2 && document.getElementById("box".concat((myLoc+1).toString())).style.backgroundColor != "green"){
    	document.getElementById("box".concat((myLoc+1).toString())).innerHTML = document.getElementById("box".concat(myLoc.toString())).innerHTML;
    	document.getElementById("box".concat(myLoc.toString())).innerHTML = "&nbsp;";
    	myLoc++;
    	document.getElementById("me").style.border = "0px solid red";
    	document.getElementById("me").style.borderRight = "5px solid red";
    	$.ajax({
	    url: 'functions.php',
	    type: 'post',
	    data: { "callFunc1": myLoc}/*,
	    success: function(response) { }*/
	});
    }else if (charCode == 100 && myLoc >2 && myLoc % 5 == 2){
    	    myLoc = myLoc - 4;
    	    myLocid += 0.1;
    	    checker = false;
    	    $.ajax({
	    url: 'functions.php',
	    type: 'post',
	    data: { "callleaveR": myLoc, "magicsauce": myLocid},
	    success: function(response) { 
	    
    	    $("div").remove();
    	    document.getElementsByTagName("body")[0].innerHTML = response + document.getElementsByTagName("body")[0].innerHTML;
    	document.getElementById("me").style.border = "0px solid red";
    	document.getElementById("me").style.borderRight = "5px solid red";
    	checker = true;
	    }
	    });
	    
    }else if (charCode == 97 && myLoc >2 && myLoc % 5 == 3){
    	    myLoc = myLoc + 4;
    	    myLocid -= 0.1;
    	    checker = false;
    	    $.ajax({
	    url: 'functions.php',
	    type: 'post',
	    data: { "callleaveR": myLoc, "magicsauce": myLocid},
	    success: function(response) { 
	    
    	    $("div").remove();
    	    document.getElementsByTagName("body")[0].innerHTML = response + document.getElementsByTagName("body")[0].innerHTML;
    	document.getElementById("me").style.border = "0px solid red";
    	document.getElementById("me").style.borderLeft = "5px solid red";
    	checker = true;
	    }
	    });
	    
    }else if (charCode == 115  && myLoc >22){
    	    myLoc = myLoc - 20;
    	    myLocid += 1;
    	    checker = false;
    	    $.ajax({
	    url: 'functions.php',
	    type: 'post',
	    data: { "callleaveR": myLoc, "magicsauce": myLocid},
	    success: function(response) { 
    	    $("div").remove();
    	    document.getElementsByTagName("body")[0].innerHTML = response + document.getElementsByTagName("body")[0].innerHTML;
    	document.getElementById("me").style.border = "0px solid red";
    	document.getElementById("me").style.borderBottom = "5px solid red";
    	checker = true;
	    }
	    });
	    
    }else if (charCode == 119 && myLoc >2 && myLoc <8){
    	    myLoc = myLoc + 20;
    	    myLocid -= 1;
    	    checker = false;
    	    $.ajax({
	    url: 'functions.php',
	    type: 'post',
	    data: { "callleaveR": myLoc, "magicsauce": myLocid},
	    success: function(response) { 
    	    $("div").remove();
    	    document.getElementsByTagName("body")[0].innerHTML = response + document.getElementsByTagName("body")[0].innerHTML;
    	document.getElementById("me").style.border = "0px solid red";
    	document.getElementById("me").style.borderTop = "5px solid red";
    	checker = true;
	    }
	    });
	    
    }
}
};
</script>
<style>
body{
	margin:0;
}
.enemy{
	background-color:red;
	width:50%;
	height:50%;
	margin:auto;
	position:relative;
	top:25%;
}
</style>
