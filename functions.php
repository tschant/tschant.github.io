<?
session_start();
//HOW DO YOU WORK!!!
$username = $_SESSION["username"];
if (isset($_POST['callFunc1'])) {
	echo func1($_POST['callFunc1']);
}if (isset($_POST['callleaveR']) && isset($_POST['magicsauce'])) {
	echo leaveR($_POST['callleaveR'],$_POST['magicsauce']);
}if (isset($_POST['getEnemies'])) {
	echo getEnemies($_POST['getEnemies']);
}if(isset($_POST["logout"])){
	echo logout($_POST["logout"]);
}/* else (isset($_POST['flag'])) {
	if($_POST['flag'] == 'sign_in'){
		echo sign_in($_POST['user']);
	}
}*/
function logout($username) {
	session_unset();
	session_destroy();
	$conn2 = mysql_connect('mysql.eecs.ku.edu', 'chefley', 'Ug67Ktg8')
		or die('Could not connect: ' . mysql_error());
	mysql_select_db('chefley') or die('Could not select database');
	$query = "UPDATE User Set logged_in = 0 WHERE Username LIKE '".$username."'";
	mysql_query($query,$conn2);
	return array("success"=>true, "message"=>"Goodbye! Come again NEVER!");
}
function func1($data){
	$conn2 = mysql_connect('mysql.eecs.ku.edu', 'chefley', 'Ug67Ktg8')
		or die('Could not connect: ' . mysql_error());
	mysql_select_db('chefley') or die('Could not select database');
	$username = $_SESSION["username"];
	$names = mysql_query("Select * From ImageSet", $conn2);
	for($i = 0; $i < 10; $i++){
		for($j = 0; $j <10; $j++){
			mysql_query("UPDATE ImageSet Set Image".$i.$j." = \"http://i38.tinypic.com/25ul6hg.jpg\" WHERE Image".$i.$j." = \"blue\"", $conn2);
			mysql_query("UPDATE ImageSet Set Image".$i.$j." = \"http://fc02.deviantart.net/fs71/f/2012/171/3/7/37774bfd28fb3a1814046b2b37b18144-d546b3v.png\" WHERE Image".$i.$j." = \"green\"", $conn2)
		}
	}

	$query = "UPDATE User Set Loc = ".$data." WHERE Username LIKE '".$username."'";
	mysql_query($query,$conn2);

	return array("success"=>true, "message"=>"updated with query");
}

function getEnemies($Locid){
	$conn2 = mysql_connect('mysql.eecs.ku.edu', 'chefley', 'Ug67Ktg8')
	or die('Could not connect: ' . mysql_error());
	//echo 'Connected successfully';
	mysql_select_db('chefley') or die('Could not select database');

	$result = mysql_query("SELECT * FROM Location where Location_id = ".$Locid,$conn2);
	$r = mysql_fetch_row($result);
	
	return $r[0];
}

function leaveR($Loc, $Locid){
	$username = $_SESSION["username"];
	$conn2 = mysql_connect('mysql.eecs.ku.edu', 'chefley', 'Ug67Ktg8')
	or die('Could not connect: ' . mysql_error());
	//echo 'Connected successfully';
	mysql_select_db('chefley') or die('Could not select database');
	$query = "UPDATE User Set Loc = ".$Loc.", Locid = ".$Locid." WHERE Username LIKE '".$username."'";
	mysql_query($query,$conn2);
	
	$user = mysql_query("SELECT * FROM User where Username LIKE '".$username."'",$conn2);
	$u = mysql_fetch_row($user);
	$result = mysql_query("SELECT * FROM Location,ImageSet where ImageSet.ImageSetId = Location.ImageSetId AND Location_id = ".$Locid,$conn2);
	$r = mysql_fetch_row($result);
	$offset = 5;
	$code = "";
	//$_SESSION["username"] = $u[0];
	$elementsperrow = mysql_num_fields($result) - $offset;
	$elementsperrow = sqrt($elementsperrow);
	$percentelement = 100/ $elementsperrow;
	for($i = $offset; $i<mysql_num_fields ($result); $i++){
	Echo "<div class = \"box\" id = \"box".$i."\">";
	if($r[$i] != $grass){
		Echo "<div class= \"object\" style =\"background-image: url(".$r[$i].");\">";
	}if($u[1] == $i){
		Echo "<div id = \"me\">&nbsp;</div>";
	}else{
		Echo "&nbsp;";
	}if($r[$i] != $grass){
		echo "</div>";
	}
	Echo "</div>";
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
