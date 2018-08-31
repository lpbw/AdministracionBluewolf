<?php 
session_start();


if ($_SESSION['idU']=="" || !$_SESSION['idU'] ){

	include "login.php";

exit();

}/*else
{
	if($_SESSION['idA']!="1")
	{
	echo"<script>alert(\"Aplicacion no permitida\");</script>";
	$_SESSION="";
	session_destroy();
	header("Location: login.php");
	include "login.php";
	exit();
	}
}*/

?>