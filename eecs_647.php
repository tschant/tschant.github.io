<script  src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="layout-styles.css" />
<?
function create_user($user, $pass, $class, $element) {
	//Password has been removed...
	$conn2 = mysql_connect('localhost', 'chefley', '')
	or die('Could not connect: ' . mysql_error());
	mysql_select_db('chefley') or die('Could not select database');
	$items = array(1,6,7,8,11);
	$stats = array();
	switch($class) {
		case 'wizard':
			$hp = 10;
		        $stats = array(
		        	"strength" => 4,
		        	"defense" => 4,
		        	"magic" => 8,
		        	"resistance" => 5,
		        	"agility" => 4
		        );
		        break;
	    	case 'druid':
		        $hp = 10;
		        $stats = array(
		        	"strength" => 4,
		        	"defense" => 6,
		        	"magic" => 5,
		        	"resistance" => 6,
		        	"agility" => 4
		        );
		        break;
		case 'warrior':
		        $hp = 10;
		        $stats = array(
		        	"strength" => 7,
		        	"defense" => 5,
		        	"magic" => 4,
		        	"resistance" => 5,
		        	"agility" => 4
		        );
		        break;
		case 'spellsword':
		        $hp = 10;
		        $stats = array(
		        	"strength" => 6,
		        	"defense" => 4,
		        	"magic" => 6,
		        	"resistance" => 5,
		        	"agility" => 4
		        );
		        break;
		case 'rogue':
		        $hp = 10;
		        $stats = array(
		        	"strength" => 6,
		        	"defense" => 4,
		        	"magic" => 4,
		        	"resistance" => 4,
		        	"agility" => 7
		        );
		        break;
		case 'trickster':
		        $hp = 10;
		        $stats = array(
		        	"strength" => 4,
		        	"defense" => 4,
		        	"magic" => 6,
		        	"resistance" => 4,
		        	"agility" => 7
		        );
		        break;
	}
	switch ($element) {
		case 'fire':
			$stats["strength"] += 1;
			$stats["magic"] += 2;
			$stats["defense"] -= 1;
			$stats["resistance"] -= 2;
		break;
		case 'water':
			$stats["magic"] += 1;
			$stats["resistance"] += 2;
			$stats["defense"] -= 1;
			$stats["strength"] -= 2;
		break;
		case 'earth':
			$stats["resistance"] += 1;
			$hp += 2;
			$stats["strength"] -= 1;
			$stats["agility"] -= 2;
		break;
		case 'air':
			$stats["resistance"] += 1;
			$stats["agility"] += 2;
			$hp -= 1;
			$stats["defense"] -= 2;
		break;
	}
	
	mysql_query("INSERT INTO User VALUES('".$user."', 27, 10, 0, 0,".$hp.",'".sha1(md5($pass))."',".implode(",", $stats) . ",'". $element ."')", $conn2);
	foreach($items as $id) {
		mysql_query("INSERT INTO Inventory VALUES('".$user."','".$id."',1)", $conn2);
	}
}
    session_start();
    if($_REQUEST["create"]) {
    	if(!$_REQUEST["username"]){
		echo "<script type='text/javascript'>alert('Please enter valid text for a username'); window.location = 'home.html'; </script>";
	exit;
	} else {
		$create_username = $_REQUEST["username"];
		$password = $_REQUEST["password"];
		$confirm = $_REQUEST["confirm"];
		$class = $_REQUEST["class"];
		$element = $_REQUEST["element"];
		if(!$password || $confirm != $password) {
			echo "<script type='text/javascript'>alert('Passwords do not match'); window.location = 'create_user.html'; </script>";
			exit;
		}
		if(!$class) {
			echo "<script type='text/javascript'>alert('Please select your class!'); window.location = 'create_user.html'; </script>";
			exit;
		}
		if(!$element) {
			echo "<script type='text/javascript'>alert('Please select your element!'); window.location = 'create_user.html'; </script>";
			exit;
		}
    	}
	} 
    include 'functions.php';


//Password has been removed...
$conn2 = mysql_connect('localhost', 'chefley', '')
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
		create_user($create_username, $password, $class, $element);
		$user = mysql_query("SELECT * FROM User WHERE Username like '".$create_username."'",$conn2);
		$u = mysql_fetch_row($user);
		if($u) {
			echo "<script type='text/javascript'>alert('User has successfully been created'); window.location = 'home.html'; </script>";
			exit;
		} else {
			echo "<script type='text/javascript'>alert('Error: User not created... Try again'); window.location = 'create_user.html'; </script>";
		}
	}	else {
		echo "<script type='text/javascript'>alert('Username is already taken, sorry...'); window.location = 'home.html'; </script>";
		exit;
	}
}

$user = mysql_query("SELECT * FROM User WHERE Username like '".$_REQUEST["username"]."' and Password = '".sha1(md5($_REQUEST["password"]))."'",$conn2);
$u = mysql_fetch_row($user);

if($u[3]){
	echo "<script type='text/javascript'>alert('User is already logged in. Are you logged in on a different computer?'); window.location = 'home.html'; </script>";
	exit;
} else if(!$u[0]) {
	echo "<script type='text/javascript'>alert('No such user found, try again.'); window.location = 'home.html'; </script>";
	exit;		
} else {
	$query = "UPDATE User Set logged_in = 1 WHERE Username LIKE '".$u[0]."'";
	mysql_query($query,$conn2);
}
$result = mysql_query("SELECT * FROM Location, ImageSet WHERE ImageSet.ImageSetId = Location.ImageSetId AND Location_id = ".$u[2],$conn2);
$r = mysql_fetch_row($result);
$_SESSION["username"] = $u[0];
$_SESSION["experience"] = $u[4];
$_SESSION["health"] = $u[5];
$_SESSION["strength"] = $u[7];
$_SESSION["defense"] = $u[8];
$_SESSION["magic"] = $u[9];
$_SESSION["resistance"] = $u[10];
$_SESSION["agility"] = $u[11];

$offset = 9;
$enemyTable = mysql_query("SELECT * FROM enemies");
$myitems =  mysql_query("SELECT * FROM Inventory, Items WHERE ItemID = ID AND UserName = '".$u[0]."'", $conn2);
$i = 0;
$item_record = mysql_fetch_row($myitems);
$items_arr = array();
while ($item_record){
	$items_arr[$i] = $item_record;
	$i++;
	$item_record = mysql_fetch_row($myitems);
}

$numOfEnemies = mysql_num_rows($enemyTable);
$tree = "http://fc02.deviantart.net/fs71/f/2012/171/3/7/37774bfd28fb3a1814046b2b37b18144-d546b3v.png";
$grass = "http://i38.tinypic.com/25ul6hg.jpg";

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
	Echo "<div class = \"box\" id = \"box".$i."\" onClick = \"buttonPresser(".$button.")\">";
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
?>
<script>
var maxEnemies = <? echo $r[0];?>;
var myLoc = <? echo $u[1]; ?>;
var myLocid = <? echo $u[2]; ?>;
var username = <? echo '"'.$_SESSION["username"].'"';?>;
var offset = <? echo $offset; ?>;
var size = <? echo $elementsperrow;?>;
var myHealth = <? echo $u[5]; ?>;
var myStrength = <? echo $u[7]; ?>;
var myDefense = <? echo $u[8]; ?>;
var myMagic = <? echo $u[9]; ?>;
var myResistance = <? echo $u[10]; ?>;
var myAgility = <? echo $u[11]; ?>;
var yourLevel = <? echo $r[2];?>; //update in ajax call on screen change
var myLevel = Math.floor(<? echo $u[4]; ?>/10)+1;
var enemyArray = new Array();
var myitems = <? echo json_encode($items_arr)?>;
var myElem = <? echo "\"".$u[12]."\""; ?>;
var northern = <? echo $r[4];?>;
var southern = <? echo $r[5];?>;
var eastern = <? echo $r[6];?>;
var western = <? echo $r[7];?>;
</script>
<script src="eecs_647.js"></script>
<style>
.box{
	width: <? echo $percentelement?>%; 
	height: <? echo $percentelement;?>%;
	background-image: url(<? echo $grass; ?>);
}
</style>