<?
session_start();

include "coneccion.php";

?>
<!DOCTYPE HTML>
<!--
	Massively by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Elements Reference - Massively by HTML5 UP</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
<?

if($_POST["login"]!="")
{
	$pass=$_POST["pass"];
	$usuario=$_POST["usuario"];
		$consulta  = "SELECT * from usuarios where email='$usuario' and password='$pass' ";
		$resultado = mysql_query($consulta) or die("La consulta: $consulta" );//. mysql_error()
		
		if(@mysql_num_rows($resultado)>=1)
		{
			$res=mysql_fetch_row($resultado);
			$id=$res[0];
			$nombre=$res[1];
			$tipo=$res[4];

				//session_register('idU');
				$_SESSION['idU']=$id;
				$_SESSION['idA']=$tipo;
				$_SESSION['idNombre']=$nombre;
				

			
				echo"<script>window.location=\"menu_admin.php\"</script>";
		}else
		{
			echo"<script>alert(\"Usuario o password invalido\");</script>";
		}
	
}


?>
	<body class="is-loading">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header">
						<a href="http://bluewolf.com.mx/new/" target="_blank" class="logo">BLUEWOLF</a>					</header>

				<!-- Nav -->
					

				<!-- Main -->
				<div id="main">
				<section>
							<form id="form1" name="form1" method="post" action="">
								<div class="field">
									<label for="name">Usuario</label>
									<input type="text" name="usuario" id="usuario" />
								</div>
								<div class="field">
									<label for="email">password</label>
									<input type="password" name="pass" id="pass" />
								</div>
							  <div class="field">
								  <label for="message"></label>
								</div>
								<ul class="actions">
									<li><input  class="button special fit" name="login" type="submit" id="login" value="Entrar" />
									</li>
								</ul>
							</form>
						</section>
				</div>	

				<!-- Footer -->
					<footer id="footer">					</footer>

				<!-- Copyright -->
					<div id="copyright">
						<ul>
						  <li>&copy; administraciÓn </li>
						  <li></li>
						</ul>
					</div>
			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main2.js"></script>

	</body>
</html>