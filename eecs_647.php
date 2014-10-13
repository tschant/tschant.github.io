<?
/*
Hooking up to Databases!
$conn contains:
	Nothing.
$conn3 contains:
	Enemies
	Drops
	Items
	Inventory
$conn 2 contains:
	User
	Location
	ImageSet
*/

$conn = mysql_connect('mysql.eecs.ku.edu', 'tschante', 'monkey08')
	or die('Could not connect: ' . mysql_error());
$conn3 = mysql_connect('mysql.eecs.ku.edu', 'jlipscom', 'Uo16uI37')
	or die('Could not connect: ' . mysql_error());
$conn2 = mysql_connect('mysql.eecs.ku.edu', 'chefley', 'Ug67Ktg8')
	or die('Could not connect: ' . mysql_error());
mysql_select_db('chefley') or die('Could not select database');

/*
If user is creating a new account, check to ensure that the username is not already taken.
If it is not taken, spawn them in the opening area.
Otherwise alert them to the error.
*/

if($create_username){
	$user = mysql_query("SELECT * FROM User WHERE Username like '".$create_username."'",$conn2);
	$u = mysql_fetch_row($user);
	if(!$u){
		mysql_query("INSERT INTO User VALUES('".$create_username."', 50, 0)");
	}	else {
		echo "<script type='text/javascript'>alert('Username is already taken, sorry...'); window.location = 'index.html'; </script>";
		exit;
	}
}

$user = mysql_query("SELECT * FROM User WHERE Username like '".$_SESSION["username"]."'",$conn2);
$u = mysql_fetch_row($user);

if($u[3]){
	echo "<script type='text/javascript'>alert('User is already logged in. Are you logged in on a different computer?'); window.location = 'index.html'; </script>";
	exit;
} else if(!$u[0]) {
	echo "<script type='text/javascript'>alert('No such user found, try again.'); window.location = 'index.html'; </script>";
	exit;		
} else {
	$query = "UPDATE User Set logged_in = 1 WHERE Username LIKE '".$u[0]."'";
	mysql_query($query,$conn2);
}
$result = mysql_query("SELECT * FROM Location, ImageSet WHERE ImageSet.ImageSetId = Location.ImageSetId AND Location_id = ".$u[2],$conn2);
$r = mysql_fetch_row($result);
$_SESSION["username"] = $u[0];
$offset = 5;

$tree = "http://fc02.deviantart.net/fs71/f/2012/171/3/7/37774bfd28fb3a1814046b2b37b18144-d546b3v.png";
$grass = "http://i38.tinypic.com/25ul6hg.jpg";

$elementsperrow = mysql_num_fields($result) - $offset;
$elementsperrow = sqrt($elementsperrow);
$percentelement = 100/ $elementsperrow;

for($i = $offset; $i<mysql_num_fields ($result); $i++){
	Echo "<div class = \"box\" id = \"box".$i."\"><div class= \"object\" style =\"background-image: url(".$r[$i].");\">&nbsp;</div>";
	if($u[1] == $i){
		Echo "<div id = \"me\">&nbsp;</div>";
	}else{
		Echo "&nbsp;";
	}Echo "</div>";
}

?>
<script>
var maxEnemies = <? echo $r[0];?>;
var myLoc = <? echo $u[1]; ?>;
var myLocid = <? echo $u[2]; ?>;
var offset = <? echo $offset; ?>;
var size = <? echo $elementsperrow;?>;
//var username = <? echo $_SESSION["username"];?>;
function drawEnemies(numEnemies){
	var divs = document.getElementsByClassName("box");
	var newhtml = "<div class = \"enemy\">&nbsp;</div>";
	var rando = Math.floor(divs.length * Math.random());
	while(divs[rando].style.backgroundImage == "url(http://fc02.deviantart.net/fs71/f/2012/171/3/7/37774bfd28fb3a1814046b2b37b18144-d546b3v.png)" || rando == myLoc - offset ){
		rando = Math.floor(divs.length * Math.random());
	}
	while(numEnemies > 0){
		divs[rando].innerHTML = newhtml;
		numEnemies--;
		rando = Math.floor(divs.length * Math.random());
		while(divs[rando].style.backgroundImage == "url(http://fc02.deviantart.net/fs71/f/2012/171/3/7/37774bfd28fb3a1814046b2b37b18144-d546b3v.png)" || rando == myLoc - offset ){
			rando = Math.floor(divs.length * Math.random());
		}
	}
}
function enterFight(){

    	clearInterval(mytimer);
	checker = false;

	var div = document.createElement("div");
	div.style.width = "90%";
	div.style.height = "90%";
	div.style.background = "white";
	div.style.color = "black";
	div.style.position = "absolute";
	div.style.top = "5%";
	div.style.left = "5%";
	div.id = "Fight";
	
	var inner = document.createElement("div");
	inner.style.width = "50%";
	inner.style.height = "50%";
	inner.style.position = "relative";
	inner.style.top = "50%";
	inner.style.left="50%";
	inner.innerHTML = "Run Away";
	inner.onclick = function(){exitFight()};
	
	document.body.appendChild(div);
	document.getElementById("Fight").appendChild(inner);
}

function exitFight(){
	document.getElementById("Fight").remove();
	mytimer = setInterval(function(){moveEnemies()}, 1000);
	checker = true;
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
		if((rando == 0 && parentnum % size == offset-1) || (rando == 1 && parentnum % size == offset) || (rando == 2 && parentnum>size*size - offset)|| (rando == 3 && parentnum<size-offset+1)|| (document.getElementById("box".concat(newparentnum.toString())).style.backgroundImage == "url(http://fc02.deviantart.net/fs71/f/2012/171/3/7/37774bfd28fb3a1814046b2b37b18144-d546b3v.png)") || ((document.getElementById("box".concat(newparentnum.toString())).innerHTML.length != 0) && (document.getElementById("box".concat(newparentnum.toString())).innerHTML != "&nbsp;"))){}
		else{
			document.getElementById("box".concat(newparentnum.toString())).innerHTML = document.getElementById("box".concat(parentnum.toString())).innerHTML;
			document.getElementById("box".concat(parentnum.toString())).innerHTML= "&nbsp;";
		}
	}
checker = true;
}
window.onload = drawEnemies(maxEnemies);
$(window).on('beforeunload', function () {

  $.ajax({
	    url: 'functions.php',
	    type: 'post',
	    async: false,
	    data: { "logout": <?echo "'".$_SESSION["username"]."'";?>}/*,
	    success: function(response) {debugger; }*/
	});
});
var mytimer = setInterval(function(){moveEnemies();}, 1000);
var checker = true;
document.onkeypress = function(evt) {
if(checker){
    evt = evt || window.event;
    var charCode = evt.keyCode || evt.which;
    var charStr = String.fromCharCode(charCode);
    if (charCode == 97 && myLoc >offset && myLoc % size != offset && document.getElementById("box".concat((myLoc-1).toString())).style.backgroundImage != "url(http://fc02.deviantart.net/fs71/f/2012/171/3/7/37774bfd28fb3a1814046b2b37b18144-d546b3v.png)"){
    	if(document.getElementById("box".concat((myLoc-1).toString())).innerHTML.indexOf("enemy") > -1){
    		enterFight();
    	}
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
    }else if (charCode == 115 && myLoc <size*size-offset && document.getElementById("box".concat((myLoc+size).toString())).style.backgroundImage != "url(http://fc02.deviantart.net/fs71/f/2012/171/3/7/37774bfd28fb3a1814046b2b37b18144-d546b3v.png)"){
    	    	if(document.getElementById("box".concat((myLoc+size).toString())).innerHTML.indexOf("enemy") > -1){
    		enterFight();
    	}
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
    }else if (charCode == 119 && myLoc >size+offset-1 && document.getElementById("box".concat((myLoc-size).toString())).style.backgroundImage != "url(http://fc02.deviantart.net/fs71/f/2012/171/3/7/37774bfd28fb3a1814046b2b37b18144-d546b3v.png)"){
    	    	if(document.getElementById("box".concat((myLoc-size).toString())).innerHTML.indexOf("enemy") > -1){
    		enterFight();
    	}
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
    }else if (charCode == 100 && myLoc >offset-1 && myLoc % size != offset-1 && document.getElementById("box".concat((myLoc+1).toString())).style.backgroundImage != "url(http://fc02.deviantart.net/fs71/f/2012/171/3/7/37774bfd28fb3a1814046b2b37b18144-d546b3v.png)"){
    	    	if(document.getElementById("box".concat((myLoc+1).toString())).innerHTML.indexOf("enemy") > -1){
    		enterFight();
    	}
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
.sanctuary{
	margin:0;
	position:absolute;
	top:33%;
	left:33%;
	font-size:200px;
	color:white;
}
#me {
	background-color:white; 
	width:50%; 
	border-top: 5px solid red; 
	height:50%;
	margin:auto;
	position:relative;
	top:25%;
}
.box{
	background-size: 100% 100%; 
	width: <? echo $percentelement?>%; 
	float: left; 
	height: <? echo $percentelement;?>%;
	background-image: url(<? echo $grass; ?>);
}
.object{
	height: 100%;
	width: 100%;
	background-size: 100% 100%;
}
</style>
