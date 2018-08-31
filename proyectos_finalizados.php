<?
session_start();
include "checar_sesion.php";
//include "checar_sesion_admin.php";
include "coneccion.php";
$id_e=$_GET["id_e"];
$tipo=$_SESSION['idA'];
$hoy=date("Y-m-d");
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Proyectos Finalizados</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
	</head>
	<body class="is-loading">

		<!-- Wrapper -->
			<div id="wrapper">
					<ul class="visible actions">
						<li class="visible"><a href="adm_proyectos.php" class="button special icon fa-undo">Regresar</a></li>
					</ul>
				<!-- Header -->
					<header id="header">
						<a class="logo" href="http://bluewolf.com.mx/new/" target="_blank">Bluewolf</a>					
					</header>

				<!-- Nav -->
					<nav id="nav">
						<ul class="actions fit">
							<li><a href="menu_admin.php" class="button special fit">Administraci&oacuten</a></li>
							<li><a href="adm_clientes.php" class="button special fit">Clientes</a></li>
							<li><a href="buscar_cobros.php" class="button special fit">Facturaci&oacuten</a></li>
							<li><a href="facturas_cobrar.php" class="button special fit">Facturas por Cobrar </a></li>
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
								
					<h3>Proyectos Finalizados</h3>
						<div class="table-wrapper">
							<table class="t">
								<thead>
									<th>nombre</th>
									<th>cliente</th>
									<th>unidad de negocio</th>
									<th></th>
								</thead>
								<tbody>
								<?	  	
							$consulta  = "select p.id as idp,p.nombre as proyecto,c.nombre as cliente,a.nombre as negocio,p.estatus as est from proyectos p JOIN clientes c ON p.id_cliente=c.id JOIN areas a ON p.id_area=a.id  where p.estatus=1 order by p.id";
							$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
							//$count=1;
							while($res=mysql_fetch_assoc($resultado))//Mientras haya registros en clientes llena la tabla.
							{
								//$res=mysql_fetch_assoc($resultado);
								?>
								<tr style="cursor:pointer;"><td><a href="detalles_finalizados.php?id=<? echo $res['idp'];?>"><? echo $res["proyecto"]; ?></a></td><td><a href="detalles_finalizados.php?id=<? echo $res['idp'];?>"><? echo $res["cliente"]; ?></a></td><td><a href="detalles_finalizados.php?id=<? echo $res['idp'];?>"><? echo $res["negocio"]; ?></a></td><td></td></tr>
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
						<ul><li>&copy; Untitled</li><li>Design: <a href="">Bluewolf</a></li></ul>
					</div>
			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
			<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
			<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
	</body>
</html>