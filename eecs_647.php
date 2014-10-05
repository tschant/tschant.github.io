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

for($i = 3; $i<mysql_num_fields ($result); $i++){
	if($u[1] == $i){
		Echo "<div style=\"background-color: ".$r[$i]."; width: ".$percentelement."%; float: left; height: ".$percentelement."%;\"><div style=\"background-color:white; width:50%; height:50%;margin:auto;position:relative; top:25%;\">&nbsp;</div></div>";
	}else{
Echo "<div style=\"background-color: ".$r[$i]."; width: ".$percentelement."%; float: left; height: ".$percentelement."%;\">&nbsp;</div>";
}
		
	}
?>
<script>
document.onkeypress = function(evt) {
    evt = evt || window.event;
    var charCode = evt.keyCode || evt.which;
    var charStr = String.fromCharCode(charCode);
    if (charCode == 97){
    	alert(charCode);
    }
};
</script>
<style>
body{
	margin:0;
}
</style>
