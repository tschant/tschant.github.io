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
$result = mysql_query("SELECT * FROM Location, ImageSet WHERE ImageSet.ImageSetId = Location.ImageSetId AND Location_id = ".$u[2],$conn2);
$r = mysql_fetch_row($result);
$_SESSION["username"] = $u[0];
$offset = 5;


$elementsperrow = mysql_num_fields($result) - $offset;
$elementsperrow = sqrt($elementsperrow);
$percentelement = 100/ $elementsperrow;

for($i = $offset; $i<mysql_num_fields ($result); $i++){
	if($u[1] == $i){
		Echo "<div class = \"box\" id = \"box".$i."\" style=\"background-color: ".$r[$i]."; width: ".$percentelement."%; float: left; height: ".$percentelement."%;\"><div id = \"me\"style=\"background-color:white; width:50%; border-top: 5px solid red; height:50%;margin:auto;position:relative; top:25%;\">&nbsp;</div></div>";
	}else{
		Echo "<div class = \"box\" id = \"box".$i."\" style=\"background-color: ".$r[$i]."; width: ".$percentelement."%; float: left; height: ".$percentelement."%;\">&nbsp;</div>";
	}
}

?>
<script>
var maxEnemies = <? echo $r[0];?>;
var myLoc = <? echo $u[1]; ?>;
var myLocid = <? echo $u[2]; ?>;
var offset = <? echo $offset; ?>;
var size = <? echo $elementsperrow;?>;
function drawEnemies(numEnemies){
	var divs = document.getElementsByClassName("box");
	var newhtml = "<div class = \"enemy\">&nbsp;</div>";
	var rando = Math.floor(divs.length * Math.random());
	while(divs[rando].style.backgroundColor == "green" || rando == myLoc - offset ){
		rando = Math.floor(divs.length * Math.random());
	}
	while(numEnemies > 0){
		divs[rando].innerHTML = newhtml;
		numEnemies--;
		rando = Math.floor(divs.length * Math.random());
		while(divs[rando].style.backgroundColor == "green" || rando == myLoc - offset ){
			rando = Math.floor(divs.length * Math.random());
		}
	}
}

function moveEnemies(){
checker = false;
	for (var i = 0; i<$(".enemy").length; i++){
		var parentid = $(".enemy").eq(i).parent().attr('id');
		var rando = Math.floor(4 * Math.random());
		if (rando < 2){
			var amount = 1;
		}else{
			var amount = size;
		}if (rando % 2 == 0){
			var neg = 1;
		}else{
			var neg = -1;
		}var parentnum = parseInt(parentid.substr(3));
		var newparentnum = parentnum + (amount * neg);
		if((rando == 0 && parentnum % size == offset-1) || (rando == 1 && parentnum % size == offset) || (rando == 2 && parentnum>size*size - offset)|| (rando == 3 && parentnum<size-offset+1)|| (document.getElementById("box".concat(newparentnum.toString())).style.backgroundColor == "green") || ((document.getElementById("box".concat(newparentnum.toString())).innerHTML.length != 0) && (document.getElementById("box".concat(newparentnum.toString())).innerHTML != "&nbsp;"))){}
		else{
			document.getElementById("box".concat(newparentnum.toString())).innerHTML = document.getElementById("box".concat(parentnum.toString())).innerHTML;
			document.getElementById("box".concat(parentnum.toString())).innerHTML= "&nbsp;";
		}
	}
checker = true;
}
window.onload = drawEnemies(maxEnemies);
var mytimer = setInterval(function(){moveEnemies();}, 1000);
var checker = true;
document.onkeypress = function(evt) {
if(checker){
    evt = evt || window.event;
    var charCode = evt.keyCode || evt.which;
    var charStr = String.fromCharCode(charCode);
    if (charCode == 97 && myLoc >offset && myLoc % size != offset && document.getElementById("box".concat((myLoc-1).toString())).style.backgroundColor != "green"){
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
    }else if (charCode == 115 && myLoc <size*size-offset && document.getElementById("box".concat((myLoc+size).toString())).style.backgroundColor != "green"){
    	document.getElementById("box".concat((myLoc+size).toString())).innerHTML = document.getElementById("box".concat(myLoc.toString())).innerHTML;
    	document.getElementById("box".concat(myLoc.toString())).innerHTML = "&nbsp;";
    	myLoc= myLoc+size;
    	document.getElementById("me").style.border = "0px solid red";
    	document.getElementById("me").style.borderBottom = "5px solid red";
    	$.ajax({
	    url: 'functions.php',
	    type: 'post',
	    data: { "callFunc1": myLoc}/*,
	    success: function(response) { }*/
	});
    }else if (charCode == 119 && myLoc >size+offset-1 && document.getElementById("box".concat((myLoc-size).toString())).style.backgroundColor != "green"){
    	document.getElementById("box".concat((myLoc-size).toString())).innerHTML = document.getElementById("box".concat(myLoc.toString())).innerHTML;
    	document.getElementById("box".concat(myLoc.toString())).innerHTML = "&nbsp;";
    	myLoc= myLoc-size;
    	document.getElementById("me").style.border = "0px solid red";
    	document.getElementById("me").style.borderTop = "5px solid red";
    	$.ajax({
	    url: 'functions.php',
	    type: 'post',
	    data: { "callFunc1": myLoc}/*,
	    success: function(response) { }*/
	});
    }else if (charCode == 100 && myLoc >offset-1 && myLoc % size != offset-1 && document.getElementById("box".concat((myLoc+1).toString())).style.backgroundColor != "green"){
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
    }else if (charCode == 100 && myLoc >offset-1 && myLoc % size == offset-1){
    	    myLoc = myLoc - size + 1;
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
    	$.ajax({
	    url: 'functions.php',
	    type: 'post',
	    data: { "getEnemies": myLocid},
	    success: function(response) { 
	    	drawEnemies(response);
	    	checker = true;
	    }
	});
	    }
	    });
	    
    }else if (charCode == 97 && myLoc >offset-1 && myLoc % size == offset){
    	    myLoc = myLoc + size -1;
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

    	    	$.ajax({
	    url: 'functions.php',
	    type: 'post',
	    data: { "getEnemies": myLocid},
	    success: function(response) { 
	    	drawEnemies(response);
	    	checker = true;
	    }
	});
	    	
	    }
	    });
	    
    }else if (charCode == 115  && myLoc >size*(size - 1) + offset -1){
    	    myLoc = myLoc - size*(size-1);
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
    	    	$.ajax({
	    url: 'functions.php',
	    type: 'post',
	    data: { "getEnemies": myLocid},
	    success: function(response) { 
	    	drawEnemies(response);
	      	checker = true;
	    }
	});
	    }
	    });
	    
    }else if (charCode == 119 && myLoc > offset-1 && myLoc < size+offset){
    	    myLoc = myLoc + size*(size-1);
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
    	    	$.ajax({
	    url: 'functions.php',
	    type: 'post',
	    data: { "getEnemies": myLocid},
	    success: function(response) { 
	    	drawEnemies(response); 
	    	checker = true;
	    }
	});
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
