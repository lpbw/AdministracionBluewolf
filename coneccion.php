<?
	$enlace = mysql_connect('localhost', 'root', '');
	mysql_set_charset('utf8',$enlace);
	if (!$enlace) { 
    die('Could not connect: ' . mysql_error()); 
	} 

	mysql_select_db("bluewol5_admon") or die("No pudo seleccionarse la BD.");
?>
