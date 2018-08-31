<?
include "coneccion.php";
$monto=$_GET["m"];
$concepto=$_GET["c"];

$insert="insert into anticipos (id_viaje,monto,concepto)values('','$monto','$concepto')";
//$resultado = mysql_query($insert) or die("Error en consulta insert: $insert " . mysql_error());
$idanticipo=mysql_insert_id();

$tabla="<tr><td>aqui</td><td>no</td></tr>";
echo $tabla;
?>
