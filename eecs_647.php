<?
$conn = mysql_connect('mysql.eecs.ku.edu', 'tschante', 'monkey08')
	or die('Could not connect: ' . mysql_error());
$conn2 = mysql_connect('mysql.eecs.ku.edu', 'chefley', 'Ug67Ktg8')
	or die('Could not connect: ' . mysql_error());
//echo 'Connected successfully';
mysql_select_db('chefley') or die('Could not select database');

$result = mysql_query("SELECT * FROM Location",$conn2);
$r = mysql_fetch_row($result);
$user = mysql_query("SELECT * FROM User",$conn2);
$u = mysql_fetch_row($user);

$elementsperrow = mysql_num_fields($result) - 3;
$elementsperrow = sqrt($elementsperrow);
$percentelement = 100/ $elementsperrow;

if (isset($_POST['callFunc1'])) {
	echo func1($_POST['callFunc1']);
}

for($i = 3; $i<mysql_num_fields ($result); $i++){
	if($u[1] == $i){
		Echo "<div id = \"box".$i."\" style=\"background-color: ".$r[$i]."; width: ".$percentelement."%; float: left; height: ".$percentelement."%;\"><div id = \"me\"style=\"background-color:white; width:50%; height:50%;margin:auto;position:relative; top:25%;\">&nbsp;</div></div>";
	}else{
		Echo "<div id = \"box".$i."\" style=\"background-color: ".$r[$i]."; width: ".$percentelement."%; float: left; height: ".$percentelement."%;\">&nbsp;</div>";
	}
}

function func1($data){
	/*$conn2 = mysql_connect('mysql.eecs.ku.edu', 'chefley', 'Ug67Ktg8')
		or die('Could not connect: ' . mysql_error());
	//echo 'Connected successfully';
	mysql_select_db('chefley') or die('Could not select database');*/
	$query = "UPDATE User Set Loc = ".$data." WHERE Username LIKE 'BlakeHefley'";
	$user = mysql_query($query,$conn2);
}
?>
<script>
var numEnemies = <? echo $r[0];?>;
var myLoc = <? echo $u[1]; ?>;
var tmp;
window.onload = function(){
	var divs = document.getElementsByTagName("div");
	var newhtml = "<div class = \"enemy\">&nbsp;</div>";
	var rando = Math.floor(divs.length * Math.random());
	while(divs[rando].style.backgroundColor == "green" || rando == myLoc - 3 || rando == myLoc - 2){
		rando = Math.floor(divs.length * Math.random());
	}tmp = rando;
	while(numEnemies > 0){
		divs[rando].innerHTML = newhtml;
		numEnemies--;
		rando = Math.floor(divs.length * Math.random());
		while(divs[rando].style.backgroundColor == "green" || rando == myLoc - 3 || rando == myLoc - 2 || rando == tmp){
			rando = Math.floor(divs.length * Math.random());
		}
	}
};

document.onkeypress = function(evt) {
    evt = evt || window.event;
    var charCode = evt.keyCode || evt.which;
    var charStr = String.fromCharCode(charCode);
    if (charCode == 97 && myLoc >3 && myLoc % 5 != 3 && document.getElementById("box".concat((myLoc-1).toString())).style.backgroundColor != "green"){
    	document.getElementById("box".concat((myLoc-1).toString())).innerHTML = document.getElementById("box".concat(myLoc.toString())).innerHTML;
    	document.getElementById("box".concat(myLoc.toString())).innerHTML = "&nbsp;";
    	myLoc--;
    	$.ajax({
	    url: 'eecs_647_2.php',
	    type: 'post',
	    data: { "callFunc1": myLoc},
	    success: function(response) { alert(response); }
	});
    }else if (charCode == 115 && myLoc <23 && document.getElementById("box".concat((myLoc+5).toString())).style.backgroundColor != "green"){
    	document.getElementById("box".concat((myLoc+5).toString())).innerHTML = document.getElementById("box".concat(myLoc.toString())).innerHTML;
    	document.getElementById("box".concat(myLoc.toString())).innerHTML = "&nbsp;";
    	myLoc= myLoc+5;
    }else if (charCode == 119 && myLoc >7 && document.getElementById("box".concat((myLoc-5).toString())).style.backgroundColor != "green"){
    	document.getElementById("box".concat((myLoc-5).toString())).innerHTML = document.getElementById("box".concat(myLoc.toString())).innerHTML;
    	document.getElementById("box".concat(myLoc.toString())).innerHTML = "&nbsp;";
    	myLoc= myLoc-5;
    }else if (charCode == 100 && myLoc >2 && myLoc % 5 != 2 && document.getElementById("box".concat((myLoc+1).toString())).style.backgroundColor != "green"){
    	document.getElementById("box".concat((myLoc+1).toString())).innerHTML = document.getElementById("box".concat(myLoc.toString())).innerHTML;
    	document.getElementById("box".concat(myLoc.toString())).innerHTML = "&nbsp;";
    	myLoc++;
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
