<?
session_start();
//HOW DO YOU WORK!!!
$username = $_SESSION["username"];
if (isset($_POST['callFunc1'])) {
	echo func1($_POST['callFunc1']);
}/* else (isset($_POST['flag'])) {
	if($_POST['flag'] == 'sign_in'){
		echo sign_in($_POST['user']);
	}
}*/

function func1($data){
	$conn2 = mysql_connect('mysql.eecs.ku.edu', 'chefley', 'Ug67Ktg8')
		or die('Could not connect: ' . mysql_error());
	//echo 'Connected successfully';
	mysql_select_db('chefley') or die('Could not select database');
	$username = "BlakeHefley"; //Remove once session is working
	$query = "UPDATE User Set Loc = ".$data." WHERE Username LIKE '".$username."'";
	mysql_query($query,$conn2);
	return array("success"=>true, "message"=>"Updated user: ".$username);
}

function leaveR($Loc, $Locid){
	$conn2 = mysql_connect('mysql.eecs.ku.edu', 'chefley', 'Ug67Ktg8')
	or die('Could not connect: ' . mysql_error());
	//echo 'Connected successfully';
	mysql_select_db('chefley') or die('Could not select database');
	$username = "BlakeHefley"; //Remove once session is working
	$query = "UPDATE User Set Loc = ".$data.", Locid = ".$Locid+.1." WHERE Username LIKE '".$username."'";
	mysql_query($query,$conn2);
	return array("success"=>true, "message"=>"Updated user: ".$username);
	redraw();
}

function redraw(){
	$conn2 = mysql_connect('mysql.eecs.ku.edu', 'chefley', 'Ug67Ktg8')
	or die('Could not connect: ' . mysql_error());
	//echo 'Connected successfully';
	mysql_select_db('chefley') or die('Could not select database');
	$username = "BlakeHefley"; //Remove once session is working
	$result = mysql_query("SELECT * FROM Location",$conn2);
	$r = mysql_fetch_row($result);
	$user = mysql_query("SELECT * FROM User",$conn2);
	$u = mysql_fetch_row($user);

	$_SESSION["username"] = $u[0];

	$elementsperrow = mysql_num_fields($result) - 3;
	$elementsperrow = sqrt($elementsperrow);
	$percentelement = 100/ $elementsperrow;
	echo "<script>document.getElementsByTagName('html')[0].innerHTML = '';</script>";
	for($i = 3; $i<mysql_num_fields ($result); $i++){
		if($u[1] == $i){
			Echo "<div id = \"box".$i."\" style=\"background-color: ".$r[$i]."; width: ".$percentelement."%; float: left; height: ".$percentelement."%;\"><div id = \"me\"style=\"background-color:white; width:50%; height:50%;margin:auto;position:relative; top:25%;\">&nbsp;</div></div>";
		}else{
			Echo "<div id = \"box".$i."\" style=\"background-color: ".$r[$i]."; width: ".$percentelement."%; float: left; height: ".$percentelement."%;\">&nbsp;</div>";
		}
	}
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
