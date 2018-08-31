<?
	session_start();
	include "coneccion.php";
	include "checar_sesion.php";
	include "checar_sesion_admin.php";
	$hoy=date("d-m-Y");
?>
<!DOCTYPE HTML>
<!--
	Massively by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Anticipos</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
		<script>
			$(function () {
				$("#fecha").datepicker({ dateFormat: 'dd-mm-yy' });
				$(".datepicker").datepicker({ dateFormat: 'dd-mm-yy' });	
			});
		</script>	
</head>
	<body class="is-loading">

		<!-- Wrapper -->
			<div id="wrapper">
				 <ul class="visible actions">
            		<li class="visible"><a href="menu_admin.php" class="button special icon fa-undo">Regresar</a></li>
          		 </ul>
				<!-- Header -->
					<header id="header">
						<a class="logo" href="http://bluewolf.com.mx/new/" target="_blank">Bluewolf</a>	

					</header>
				
				<nav id="nav">
						<ul class="actions fit">
							<li><a href="menu_admin.php" class="button special fit">Administraci&oacuten</a></li>
							<li><a href="adm_clientes.php" class="button special fit">Clientes</a></li>
							<li><a href="adm_proyectos.php" class="button special fit">Proyectos</a></li>
							<li><a href="buscar_cobros.php" class="button special fit">Facturaci&oacuten</a></li>
							<li><a href="facturas_cobrar.php" class="button special fit">Facturas por Cobrar </a></li>
							<li><a href="gastos.php" class="button special fit">Gastos </a></li>
						</ul>
						
						<ul class="icons">
							<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
							<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
							<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
							<li><a href="#" class="icon fa-github"><span class="label">GitHub</span></a></li>
						</ul>
					</nav>
				<!-- Main -->
				<div id="main">
					<div class="box">
						<div class="row uniform">
							<div class="12u 12u(xsmall)"><!--reportes.-->
								<table>
									<thead>
										<th>prueba</th>
										<th><a class="fa fa-plus"></a></th>
									</thead>
								</table>
							</div>	
						</div>
					</div>	
					<div class="box">
						<div class="row uniform" id="campos">
							
								
								
								
						</div>
					</div>	
					<div class="box">
						<div class="row uniform table-wrapper" id="tabla">
							
								
								
								
						</div>
					</div>
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
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main2.js"></script>

	</body>
</html>			
