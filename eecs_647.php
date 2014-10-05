<? 
$conn = mysql_connect('mysql.eecs.ku.edu', 'tschante', 'monkey08')
	or die('Could not connect: ' . mysql_error());
$conn2 = mysql_connect('mysql.eecs.ku.edu', 'chefley', 'Ug67Ktg8')
	or die('Could not connect: ' . mysql_error());
//echo 'Connected successfully';
mysql_select_db('chefley') or die('Could not select database');

$result = mysql_query("SELECT * FROM Location",$conn2);

$r = mysql_fetch_row($result);

print_r($r(0));

?>
