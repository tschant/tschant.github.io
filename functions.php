<?
session_start();
//HOW DO YOU WORK!!!
$username = $_SESSION["username"];
if (isset($_POST['callFunc1'])) {
	echo func1($_POST['callFunc1']);
}

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

?>
