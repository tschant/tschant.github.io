<?
session_start();
//HOW DO YOU WORK!!!
$username = $_SESSION["username"];
if (isset($_POST['callFunc1'])) {
	echo func1($_POST['callFunc1']);
}if (isset($_POST['callleaveR']) && isset($_POST['magicsauce'])) {
	echo leaveR($_POST['callleaveR'],$_POST['magicsauce']);
}/* else (isset($_POST['flag'])) {
	if($_POST['flag'] == 'sign_in'){
		echo sign_in($_POST['user']);
	}
}*/

function func1($data){
	$conn2 = mysql_connect('mysql.eecs.ku.edu', 'chefley', 'Ug67Ktg8')
		or die('Could not connect: ' . mysql_error());
	mysql_select_db('chefley') or die('Could not select database');
	$username = "BlakeHefley"; //Remove once session is working
	$query = "UPDATE User Set Loc = ".$data." WHERE Username LIKE '".$username."'";
	mysql_query($query,$conn2);
	return array("success"=>true, "message"=>"Updated user: ".$username);
}
function redraw(){
	$conn2 = mysql_connect('mysql.eecs.ku.edu', 'chefley', 'Ug67Ktg8')
	or die('Could not connect: ' . mysql_error());
	//echo 'Connected successfully';
	mysql_select_db('chefley') or die('Could not select database');
	$username = "BlakeHefley"; //Remove once session is working
	
	$user = mysql_query("SELECT * FROM User where Username LIKE '".$username."'",$conn2);
	$u = mysql_fetch_row($user);
	$result = mysql_query("SELECT * FROM Location where Locid = ".$u[2],$conn2);
	$r = mysql_fetch_row($result);
	$_SESSION["username"] = $u[0];
	$code = "";
	$elementsperrow = mysql_num_fields($result) - 3;
	$elementsperrow = sqrt($elementsperrow);
	$percentelement = 100/ $elementsperrow;
	for($i = 3; $i<mysql_num_fields ($result); $i++){
		if($u[1] == $i){
			echo "<div id = \"box".$i."\" style=\"background-color: ".$r[$i]."; width: ".$percentelement."%; float: left; height: ".$percentelement."%;\"><div id = \"me\"style=\"background-color:white; width:50%; height:50%;margin:auto;position:relative; top:25%;\">&nbsp;</div></div>";
		}else{
			echo "<div id = \"box".$i."\" style=\"background-color: ".$r[$i]."; width: ".$percentelement."%; float: left; height: ".$percentelement."%;\">&nbsp;</div>";
		}
	}
}

function leaveR($Loc, $Locid){
	$conn2 = mysql_connect('mysql.eecs.ku.edu', 'chefley', 'Ug67Ktg8')
	or die('Could not connect: ' . mysql_error());
	//echo 'Connected successfully';
	mysql_select_db('chefley') or die('Could not select database');
	$username = "BlakeHefley"; //Remove once session is working
	$query = "UPDATE User Set Loc = ".$Loc.", Locid = ".$Locid." WHERE Username LIKE '".$username."'";
	mysql_query($query,$conn2);
	
	$user = mysql_query("SELECT * FROM User where Username LIKE '".$username."'",$conn2);
	$u = mysql_fetch_row($user);
	$result = mysql_query("SELECT * FROM Location where Locid = ".$Locid,$conn2);
	$r = mysql_fetch_row($result);
	echo $Locid;
	$code = "";
	//$_SESSION["username"] = $u[0];
	$elementsperrow = mysql_num_fields($result) - 3;
	$elementsperrow = sqrt($elementsperrow);
	$percentelement = 100/ $elementsperrow;
	echo $elementsperrow;
	for($i = 3; $i<mysql_num_fields ($result); $i++){
		if($Loc == $i){
			$code = $code."<div id = \"box".$i."\" style=\"background-color: ".$r[$i]."; width: ".$percentelement."%; float: left; height: ".$percentelement."%;\"><div id = \"me\"style=\"background-color:white; width:50%; height:50%;margin:auto;position:relative; top:25%;\">&nbsp;</div></div>";
		}else{
			$code = $code."<div id = \"box".$i."\" style=\"background-color: ".$r[$i]."; width: ".$percentelement."%; float: left; height: ".$percentelement."%;\">&nbsp;</div>";
		}
	}
	return $code;
}



/*function sign_in($user){
	$file = file_get_contents('https://raw.github.com/tschant/tschant.github.io/master/eecs_647.php');
	file_put_contents('eecs_647_2.php', $file);
	include 'eecs_647_2.php';
	$file2 = file_get_contents('https://raw.github.com/tschant/tschant.github.io/master/functions.php');
	file_put_contents('functions.php', $file2);
	include 'functions.php';
}*/

?>
