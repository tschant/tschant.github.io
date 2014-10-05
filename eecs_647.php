<? 
$conn = mysql_connect('mysql.eecs.ku.edu', 'tschante', 'monkey08')
	or die('Could not connect: ' . mysql_error());
//echo 'Connected successfully';
mysql_select_db('tschante') or die('Could not select database');

$result = mysql_query("SELECT * FROM CRUISE",$conn);

while($r = mysql_fetch_row($result)){
	print_r($r);
	print_r( "<br/>yo.");
}
?>
