<?
session_start();
//include "checar_sesion.php";
//include "checar_sesion_admin.php";
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
		<title>Clientes</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-loading">

		<!-- Wrapper -->
			<div id="wrapper">
					<ul class="visible actions">
						<li class="visible"><a href="menu_admin.php" class="button special icon fa-undo">Regresar</a></li>
					</ul>
				<!-- Header -->
					<header id="header">
						<a href="http://bluewolf.com.mx/new/" target="_blank" class="logo">Bluewolf</a>					
					</header>

				<!-- Nav -->
					<nav id="nav">
						<ul class="actions fit">
							<li><a href="menu_admin.php" class="button special fit">Administraci&oacuten</a></li>
							<li><a href="adm_proyectos.php" class="button special fit">Proyectos</a></li>
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
								
					<h3>Clientes</h3>
						<div class="table-wrapper">
						
							<table class="alt">
								<thead>
									<tr>
										
										<th align="center" colspan="3">Nombre</th>
										<th align="center" colspan="3" class="visible"><a href="adm_alta_cliente.php">Nuevo Cliente</a>(<a href="adm_alta_cliente.php" class="icon alt fa-plus"></a>)</th>
										<th align="center" colspan="3" class="visible2">(<a href="adm_alta_cliente.php" class="icon alt fa-plus"></a>)</th>
									</tr>
								</thead>
						<?	  	
							$consulta  = "select * from clientes order by nombre";
							$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
							$count=1;
							while(@mysql_num_rows($resultado)>=$count)//Mientras haya registros en clientes llena la tabla.
							{
								$res=mysql_fetch_row($resultado);
						?>
								<tbody>
						<?
						if ($count%2==0){
						?>		
									<tr style="background-color:#CCCCCC;">
									<td  colspan="3"><a href="adm_cambia_cliente.php?id=<? echo"$res[0]";?>"><? echo"$res[1]";//nombre de clientes?></a></td>
									<td  colspan="3" class="visible"><a href="adm_cambia_cliente.php?id=<? echo"$res[0]";?>">Editar</a></td>											
									</tr>
						<?
						}else{
						?>		
						<tr style="background-color:#FFFFFF;">
									<td  colspan="3"><a href="adm_cambia_cliente.php?id=<? echo"$res[0]";?>"><? echo"$res[1]";//nombre de clientes?></a></td>
									<td  colspan="3" class="visible"><a href="adm_cambia_cliente.php?id=<? echo"$res[0]";?>">Editar</a></td>											
									</tr>
						<?
						}
						?>
								</tbody>
						<?
							$count++;
							}//finaliza el while que llena la tabla con los nombres de los clientes.
						?>
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

	</body>
</html>