<?php
	session_start();
	include "checar_sesion.php";
	include "checar_sesion_admin.php";
	include "coneccion.php";
	include "SimpleImage.php";
	$id_e=$_GET["id_e"];
	$tipo=$_SESSION['idA'];
	$hoy=date("Y-m-d");
	$idU=$_SESSION['idU'];
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Elements Reference - Massively by HTML5 UP</title>
		<meta charset="utf-8" />
		<!--Import Google Icon Font-->
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    	<!--Import materialize.css-->
 		<link type="text/css" rel="stylesheet" href="assets/css/materialize.min.css"  media="screen,projection"/>
    	<!--Let browser know website is optimized for mobile-->
    	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<style>
			/* Portrait */
			@media screen 
			and (device-width: 320px) 
			and (device-height: 640px) 
			and (-webkit-device-pixel-ratio: 3) 
			and (orientation: portrait) {


				.font-cel{
					font-size:20px;
				}
			}

			/* Landscape */
			@media screen 
			and (device-width: 320px) 
			and (device-height: 640px) 
			and (-webkit-device-pixel-ratio: 3) 
			and (orientation: landscape) {

			}
		</style>
	</head>
	<body class="is-loading">

		<!-- Wrapper -->
			<div id="wrapper">

					<ul class="visible actions"><!--Boton regresar-->
            			<li class="visible"><a href="menu_admin.php" class="button special icon fa-undo">Regresar</a></li>
          			</ul>
					<!-- Header -->
					<header id="header">
						<a class="logo">BLUEWOLF</a>					
					</header>

					<!-- Nav de celular-->
					<nav id="nav">
						<ul class="actions fit">
						  <li><a href="menu_admin.php" class="button special fit">Administraci&oacuten</a></li>
						  <li><a href="adm_clientes.php" class="button special fit">Clientes</a></li>
						  <li><a href="adm_proyectos.php" class="button special fit">Proyectos</a></li>
						  <li><a href="buscar_cobros.php" class="button special fit">Facturaci&oacute;n</a></li>
						  <li><a href="facturas_cobrar.php" class="button special fit">Facturas por Cobrar</a></li>
						  <li><a href="gastos.php" class="button special fit">Gastos</a></li>
						  <?if($tipo==1){?>
						  <li><a href="reportes.php" class="button special fit">Reportes</a></li>
						  <?}?>
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
					
					<div class="row uniform">
						<h4>Mis Viajes</h4>
						<Span><i class="fa fa-plus-square fa-1x" id="nuevoviaje"></i>Nuevo Viaje</Span>
						<table class="responsive-table">
							<thead>
								<th class="font-cel">DESTINO</th>	
								<th>FECHA INICIO</th>
								<th>ESTATUS</th>  
							</thead>
							<tbody>
								<?
									$query_viajes = "SELECT v.id AS id_viaje,d.nombre AS destino,DATE_FORMAT(v.fecha_inicio,'%d/%m/%Y') AS inicio,v.estatus FROM viajes v JOIN destino d ON v.id_destino=d.id WHERE v.id_usuario=$idU";
									$resultado_viaje = mysql_query($query_viajes) or die("Fallo query_viajes: $query_viajes".mysql_error());
									while($resviaje = mysql_fetch_assoc($resultado_viaje))
									{
										switch ($resviaje['estatus']) {
											case '1':
												$estatus = "PENDIENTE DE APROBAR VIATICOS";
											break;
											
											case '2':
												$estatus = "EN CURSO";
											break;

											case '3':
												$estatus = "PENDIENTE DE APROBAR GASTOS";
											break;

											case '4':
												$estatus = "VIAJE FINALIZADO";
											break;
											default:
												$estatus="";
											break;
										}
								?>
										<tr>
											<td><? echo $resviaje['destino']?></td>
											<td><? echo $resviaje['inicio']?></td>
											<td><? echo $estatus;?></td>
										</tr>
								<?
									}
								?>
							</tbody>
						</table>
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
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
			<!--JavaScript at end of body for optimized loading-->
			<script type="text/javascript" src="assets/js/materialize.min.js"></script>

	</body>
</html>