<?
session_start();
//include "checar_sesion.php";
//include "checar_sesion_admin.php";
include "coneccion.php";
$id_e=$_GET["id_e"];
$tipo=$_SESSION['idA'];
$hoy=date("Y-m-d");
?>
<!DOCTYPE HTML>
<!--
	Massively by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Proyectos</title>
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
								
					<h3>Proyectos</h3><a href="proyectos_finalizados.php" style=""><label style="margin-left:60%;cursor:pointer;text-decoration:none;width:10%;">Proyectos Finalizados<i  class="icon alt fa-archive"></i></label></a>
						<div class="visible2">(<a href="adm_alta_proyecto.php" class="icon alt fa-plus">Nuevo</a>)</div>
						<div class="table-wrapper">
						
							<table class="t">
								<thead>
									<tr>
										
										<th>Nombre</th>
										<th>Cliente</th>
										<th>Unidad de Negocio</th>
										<th class="visible">
											<a href="adm_alta_proyecto.php">Nuevo Proyecto</a>(<a href="adm_alta_proyecto.php" class="icon alt fa-plus">
											</a>)
										</th>
										<th >
											Facturas sin pagar
										</th>
										<th>Cobros pendientes</th>
										
									</tr>
								</thead>
								<tbody>
						<?	  	
							$consulta  = "select p.id as idp,p.nombre as proyecto,c.nombre as cliente,a.nombre as negocio,p.estatus as est from proyectos p JOIN clientes c ON p.id_cliente=c.id JOIN areas a ON p.id_area=a.id  where p.estatus=0 order by p.id";
							$resultado = mysql_query($consulta) or die("La consulta fall&oacute;P1: " . mysql_error());
							$count=1;
							while(@mysql_num_rows($resultado)>=$count)//Mientras haya registros en clientes llena la tabla.
							{
								$res=mysql_fetch_assoc($resultado);
								$idpro=$res['idp'];
								$estatus=$res['est'];
						?>
								
									<tr>
										<td >
											<a href="adm_cambia_proyecto.php?id=<? echo"$res[idp]";?>"><? echo"$res[proyecto]";//nombre de clientes?>
											</a>
										</td>
										<td >
											<a href="adm_cambia_proyecto.php?id=<? echo"$res[idp]";?>"><? echo"$res[cliente]";//nombre de clientes?>
											</a>
										</td>
										<td  >
											<a href="adm_cambia_proyecto.php?id=<? echo"$res[idp]";?>"><? echo"$res[negocio]";//nombre de clientes?>
											</a>
										</td>
										<td class="visible">
											<a href="adm_cambia_proyecto.php?id=<? echo"$res[idp]";?>">Editar
											</a>
										</td>
										<td>
											<?  
											$querycontar  = "SELECT count(id) FROM facturacion WHERE id_proyecto='$idpro' AND estatus_pago=1";
											$rescontar = mysql_query($querycontar) or die("La consulta fall&oacute;$querycontar: " . mysql_error());
											if(@mysql_num_rows($rescontar)>=1)//Mientras haya registros en clientes llena la tabla.
											{
											$resc=mysql_fetch_row($rescontar);
											echo "($resc[0])";
											}
											?>
										</td>
										<td>
											<?
											$s=0;
											$querycobros  = "SELECT * FROM cobros c WHERE c.fecha>'$hoy 00:00:00' AND c.id_estatus_cobro=1 AND id_proyecto=$idpro";
											$rescobros = mysql_query($querycobros) or die("La consulta fall&oacute;$querycobros: " . mysql_error());
											while($resc=mysql_fetch_assoc($rescobros))
											{
												$s++;	
											}
											if($s==0 and $estatus==0)
											{
											?>
											<img style="margin-top:9px;" src="images/admiracion.png" width="30px" height="30px" title="no tienes plan de cobros"/>
											<?
											}
											if($estatus==1)
											{
											echo "TERMINADO";
											}
											?>
										</td>
									</tr>
								
						<?
							$count++;
							}//finaliza el while que llena la tabla con los nombres de los clientes.
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

	</body>
</html>