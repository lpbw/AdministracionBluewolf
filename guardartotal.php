<?php
include "coneccion.php";
$total=$_POST['valor'];
$fecha=$_POST['fecha'];
$fecha=date("Y-m-d",strtotime($fecha));
$idviaje=$_POST['idviaje'];
echo "total ".$total." fecha: ".$fecha." idviaje: ".$idviaje;

$queryup="UPDATE viajes SET anticipo_total='$total',fecha_anti='$fecha' WHERE id=$idviaje";
$resp=mysql_query($queryup) or die("La consulta: $queryup" . mysql_error());
echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
?>