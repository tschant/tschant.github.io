<? 
$conn = mysql_connect('mysql.eecs.ku.edu', 'tschante', 'monkey08')
	or die('Could not connect: ' . mysql_error());
$conn2 = mysql_connect('mysql.eecs.ku.edu', 'chefley', 'Ug67Ktg8')
	or die('Could not connect: ' . mysql_error());
//echo 'Connected successfully';
mysql_select_db('chefley') or die('Could not select database');

$result = mysql_query("SELECT * FROM Location",$conn2);

$r = mysql_fetch_row($result);
$elementsperrow = mysql_num_fields($result) - 3;
$elementsperrow = sqrt($elementsperrow);
$percentelement = 100/ $elementsperrow;
for($i = 3; $i<mysql_num_fields ($result); $i++){
Echo "<div style=\"background-color: ".$r[$i]."; width: ".$percentelement."%; float: left; height: ".$percentelement."%;\">&nbsp;</div>";
}
?>
<style>
body{
	margin:0;
}
</style>
