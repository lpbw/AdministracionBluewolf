<?
session_start();
include "coneccion.php";
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Lista Proveedores</title>
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
				<h3>Proveedores</h3>
				<div class="visible">(<a href="adm_alta_proveedor.php" class="icon alt fa-plus">Nuevo</a>)</div>
				<div class="table-wrapper">	
					<table class="t">
						<thead>
							<tr>
								<th>Servicio</th>
								<th>Proveedor</th>
								<th>teléfono</th>
								<th>Correo</th>
								<th>Observacion</th>
							</tr>
						</thead>
						<tbody>
							<?
								$QueryListaproveedores = "SELECT id_lista,servicio,proveedor,telefono,correo,observacion FROM listaproveedores ORDER BY proveedor";
								$ResultadoLista = mysql_query($QueryListaproveedores) or die("Query fallo: $QueryListaproveedores".mysql_error());
								while($ResLista = mysql_fetch_assoc($ResultadoLista))
								{
							?>
									<tr>
										<td><a href="adm_alta_proveedor.php?idp=<?echo $ResLista['id_lista'];?>"><?echo $ResLista['servicio'];?></a></td>
										<td><a href="adm_alta_proveedor.php?idp=<?echo $ResLista['id_lista'];?>"><?echo $ResLista['proveedor'];?></a></td>
										<td><a href="adm_alta_proveedor.php?idp=<?echo $ResLista['id_lista'];?>"><?echo $ResLista['telefono'];?></a></td>
										<td><a href="adm_alta_proveedor.php?idp=<?echo $ResLista['id_lista'];?>"><?echo $ResLista['correo'];?></a></td>
										<td><a href="adm_alta_proveedor.php?idp=<?echo $ResLista['id_lista'];?>"><?echo $ResLista['observacion'];?></a></td>
										<td><a href="eliminar_proveedores.php?idp=<?echo $ResLista['id_lista'];?>"><img src="images/close.gif" alt=""></a></td>	
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

	</body>
</html>