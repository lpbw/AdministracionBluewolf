<?
session_start();
include "checar_sesion.php";
include "checar_sesion_admin.php";
include "coneccion.php";
$id_e=$_GET["id_e"];
$tipo=$_SESSION['idA'];
?>
<!DOCTYPE HTML>
<!--
	Massively by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Administración</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-loading">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header">
						<a class="logo">Administración</a>					</header>

				

				<!-- Main -->
				<div id="main">
					<ul class="actions fit">
						<li><a href="adm_clientes.php" class="button special fit">Clientes</a></li>
						<li><a href="adm_proyectos.php" class="button special fit">Proyectos</a></li>
						<li><a href="buscar_cobros.php" class="button special fit">Facturación</a></li>
					</ul>
					<ul class="actions fit">
				
						<li><a href="facturas_cobrar.php" class="button special fit">Facturas por Cobrar</a></li>
						<li><a href="gastos.php" class="button special fit">Gastos</a></li>
						<?if($tipo==1){?>
						<li><a href="reportes.php" class="button special fit">Reportes</a></li>
						<?}?>
						<li><a href="vista_viajes.php" class="button special fit">Viajes</a></li>
					</ul>
					<ul class="actions fit">
				
						<?if($tipo==1){?>
						<li><a href="anticipos.php" class="button special fit">Viáticos</a></li>
						<?}?>
					</ul>
					<ul class="actions">
						<li><a href="logout.php" class="button icon fa-sign-out">Salir</a></li>
					</ul>
					<footer>
							<ul class="icons alt">
								<li><a href="#" class="icon alt fa-twitter"><span class="label">Twitter</span></a></li>
								<li><a href="#" class="icon alt fa-facebook"><span class="label">Facebook</span></a></li>
								<li><a href="#" class="icon alt fa-instagram"><span class="label">Instagram</span></a></li>
								<li><a href="#" class="icon alt fa-github"><span class="label">GitHub</span></a></li>
							</ul>			
					</footer>
				</div>
				<!-- Copyright -->
					<div id="copyright">
						<ul><li>&copy; Untitled</li><li>Design: <a href="https://html5up.net">Bluewolf</a></li></ul>
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