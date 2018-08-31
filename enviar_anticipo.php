<?
include "coneccion.php";
$idu=$_GET["idu"];//id de usuario
$idv=$_GET["idv"];// id viaje
$enviado=$_GET['total'];// total de anticipo enviado

	$queryusu="SELECT * FROM usuarios WHERE id='$idu'";
	$resusu=mysql_query($queryusu) or die("La consulta: $queryusu" . mysql_error());
	$res=mysql_fetch_assoc($resusu);
	$correo=$res['email']."@bluewolf.com.mx";
	$nombre=$res['nombre'];
	//echo $correo;
	
	$query="UPDATE viajes SET anticipo_total='$enviado',fecha_anti=now(),estatus=2 WHERE id='$idv'";
	$resq=mysql_query($query) or die("La consulta: $query" . mysql_error());
	
	$resultado=mail($correo,"Anticipo Depositado","$nombre se te a depositado para viatico:".money_format("$%n",$enviado),"From: info@bluewolf.com.mx"); 

 	if ($resultado ==true) 
	{ 
    	echo "Enviado";  
	} 
	else
	{ 
		echo "error"; 
	}  
?>
