<?
session_start();

$username = $_SESSION["username"];
//Password has been removed...
$conn2 = mysql_connect('localhost', 'chefley', '')
	or die('Could not connect: ' . mysql_error());
mysql_select_db('chefley') or die('Could not select database');
$user = mysql_query("SELECT * FROM User where Username LIKE '".$username."'",$conn2);
$u = mysql_fetch_row($user);
$offset = 9;
$tree = "http://fc02.deviantart.net/fs71/f/2012/171/3/7/37774bfd28fb3a1814046b2b37b18144-d546b3v.png";
$grass = "http://i38.tinypic.com/25ul6hg.jpg";
$enemies = mysql_query("SELECT * FROM enemies",$conn2);
$numOfenemies = mysql_num_rows($enemies);
if (isset($_POST['callFunc1'])) {
	echo func1($_POST['callFunc1']);
}if (isset($_POST['callleaveR']) && isset($_POST['magicsauce'])) {
	echo leaveR($_POST['callleaveR'],$_POST['magicsauce']);
}if (isset($_POST['getEnemies'])) {
	echo getEnemies($_POST['getEnemies']);
}if(isset($_POST["logout"])){
	echo logout($_POST["logout"]);

}if(isset($_POST["enemyNum"])){
	echo returnEnemyInfo($_POST["enemyNum"]);




function logout($username) {
	session_unset();
	session_destroy();
	global $conn2;
	$query = "UPDATE User Set logged_in = 0 WHERE Username LIKE '".$username."'";
	mysql_query($query,$conn2);
	return array("success"=>true, "message"=>"Goodbye! Come again NEVER!");
}


function getEnemies($Locid){	
	global $conn2;
	$result = mysql_query("SELECT * FROM Location where Location_id = ".$Locid,$conn2);
	$r = mysql_fetch_row($result);
	return $r[0];
}
function returnEnemyInfo($randoNums){
	global $conn2, $enemies, $numOfenemies;
	$enemyNum = (array)json_decode($randoNums, true);
	for($i = 0; $i < count($enemyNum); $i++){
		mysql_data_seek($enemies, $enemyNum[$i] % $numOfenemies);
		$r = mysql_fetch_row($enemies);
		$returnArray[$i] = $r;
	}
	return json_encode($returnArray);
}
function leaveR($Loc, $Locid){
	global $conn2, $username, $user, $u, $offset, $tree, $grass;
	
	$query = "UPDATE User Set Loc = ".$Loc.", Locid = ".$Locid." WHERE Username LIKE '".$username."'";	
	mysql_query($query,$conn2);
	
	$result = mysql_query("SELECT * FROM Location,ImageSet where ImageSet.ImageSetId = Location.ImageSetId AND Location_id = ".$Locid,$conn2);
	$r = mysql_fetch_row($result);
	$code = "";


	$enemies = mysql_query("SELECT * FROM enemies",$conn2);
	$numOfenemies = mysql_num_rows($enemies);
	
	$elementsperrow = mysql_num_fields($result) - $offset;
	$elementsperrow = sqrt($elementsperrow);
	$percentelement = 100/ $elementsperrow;
	
	for($i = $offset; $i<mysql_num_fields ($result); $i++){
		$button="";
		if($i<$elementsperrow+$offset){
			$button = 119;
		}else if (($elementsperrow * $elementsperrow) + $offset - $i < $elementsperrow){
			$button = 115;
		}else if ($i % $elementsperrow == $offset){
			$button = 97;
		}else if ($i % $elementsperrow == $offset-1){
			$button = 100;
		}else{
			$button = "";
		}
		$code = $code."<div class = \"box\" id = \"box".$i."\" onClick = \"buttonPresser(".$button.")\">";
		if($r[$i] != $grass){
			$code = $code."<div class= \"object\" style =\"background-image: url(".$r[$i].");\">";
		}if($Loc == $i){
			$code = $code."<div id = \"me\">&nbsp;</div>";
		}else{
			$code = $code."&nbsp;";
		}if($r[$i] != $grass){
			$code = $code."</div>";
		}
		$code = $code."</div>";
	}
	return json_encode(array($code, $r[4], $r[5], $r[6], $r[7], $r[2]));
}



/*function sign_in($user){
	$file = file_get_contents('https://raw.github.com/tschant/tschant.github.io/master/eecs_647.php');
	file_put_contents('eecs_647_2.php', $file);
	include 'eecs_647_2.php';
	$file2 = file_get_contents('https://raw.github.com/tschant/tschant.github.io/master/functions.php');
	file_put_contents('functions.php', $file2);
	include 'functions.php';
}*/

	/*$names = mysql_query("Select * From ImageSet", $conn2);
	for($i = 0; $i < 10; $i++){
		for($j = 0; $j <10; $j++){
			mysql_query("UPDATE ImageSet Set Image".$i.$j." = \"http://i38.tinypic.com/25ul6hg.jpg\" WHERE Image".$i.$j." = \"blue\"", $conn2);
			mysql_query("UPDATE ImageSet Set Image".$i.$j." = \"http://fc02.deviantart.net/fs71/f/2012/171/3/7/37774bfd28fb3a1814046b2b37b18144-d546b3v.png\" WHERE Image".$i.$j." = \"green\"", $conn2);
		}
	}
*/
?>