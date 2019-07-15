<?php
	session_start();
	include "checar_sesion.php";
	include "checar_sesion_admin.php";
	include "coneccion.php";
	include "SimpleImage.php";
	$idU=$_SESSION['idU'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="assets/css/main.css" />
        <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		
		<!--Import Google Icon Font-->
      	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      	<!--Import materialize.css-->
      	<link type="text/css" rel="stylesheet" href="assets/css/materialize.min.css"  media="screen,projection"/>
		  
			<script src="assets/js/viaticos.js"></script>
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Viaticos</title>
		<style>
		.Mymodal{
			display:none;
			position:fixed;
			z-index:1;
			top:0;
			left:0;
			width:100%;
			height:100%;
			background-color:rgba(0,0,0,0.4);
		}

		.Mycontainer{
			background-color: #fefefe;
			margin: auto;
			padding: 20px;
			border: 1px solid #888;
			height:90%;
		}
		</style>
    </head>
    <body class="is-loading">
		<!-- Wrapper -->
			<div id="wrapper">
                    <!--Boton regresar-->
					<ul class="visible actions">
            			<li class="visible"><a href="menu_admin.php" class="button special icon fa-undo">Regresar</a></li>
          			</ul>
				    <!-- Header -->
					<header id="header">
						<a class="logo">Bluewolf</a>
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

					<div class="col s12 m12 l12 xl12">
						<a class="btn-floating fixed blue darken-3" style="margin-left:-8%;position: fixed;">
							<i class="material-icons">add</i>
						</a>
					</div>

					<div class="col s12 m12 l12 xl12">
						<ul class="collapsible">
							<li>
								<div class="collapsible-header">PENDIENTES DE APROVAR VIATICOS<span id="badge1" class="badge blue darken-3 white-text">0</span></div>
								<div class="collapsible-body">
									 <!--table pendientes de aprovar viaticos-->
									<table>
										<thead>
											<tr>
												<th>Lugar</th>
												<th>Fecha</th>
											</tr>
										</thead>
										<tbody>
											<?php
												/*buscar los viajes del usuario*/
												$badge1=0;
												$qviajes="SELECT v.id,d.nombre,DATE_FORMAT(v.fecha_inicio,'%Y-%m-%d') as finicio FROM viajes v JOIN destino d ON v.id_destino=d.id WHERE id_usuario='$idU' AND estatus=1";
												$rviajes=mysql_query($qviajes) or die("La consulta: $qviajes" . mysql_error());
												while ($resviajes=mysql_fetch_assoc($rviajes)){
													$badge1++;
											?>
												
												<tr style="cursor:pointer;" onclick="VerViaje('<?php echo $resviajes['id'];?>');">
													<td><? echo $resviajes['nombre'];?></td>
													<td><? echo $resviajes['finicio'];?></td>
												</tr>
												
											<?php
												}
												echo "<script>ActualizarBadge('1','".$badge1."');</script>";
											?>
										</tbody>
									</table>
									<!-- end table pendientes de aprovar viaticos -->
								</div>
							</li>
							<li>
								<div class="collapsible-header">EN CURSO<span id="badge2" class="badge blue darken-3 white-text">0</span></div>
								<div class="collapsible-body">
									<!--table EN CURSO-->
									<table>
										<thead>
											<tr>
												<th>Lugar</th>
												<th>Fecha</th>
											</tr>
										</thead>
										<tbody>
											<?php
												/*buscar los viajes del usuario en curso*/
												$badge2=0;
												$qviajes="SELECT v.id,d.nombre,v.estatus,DATE_FORMAT(v.fecha_inicio,'%Y-%m-%d') as finicio,v.fecha_fin,v.id_usuario,v.estatus FROM viajes v JOIN destino d ON v.id_destino=d.id WHERE id_usuario='$idU'AND estatus=2";
												$rviajes=mysql_query($qviajes) or die("La consulta: $qviajes" . mysql_error());
												while ($resviajes=mysql_fetch_assoc($rviajes))
												{$badge2++;
											?>
												<tr style="cursor:pointer;" onclick="VerViaje('<?php echo $resviajes['id'];?>');">
													<td><? echo $resviajes['nombre'];?></td>
													<td><? echo $resviajes['finicio'];?></td>
												</tr>
											<?php
												}
												echo "<script>ActualizarBadge('2','".$badge2."');</script>";
											?>
										</tbody>
									</table>
									<!-- end table EN CURSO -->
								</div>
							</li>
							<li>
								<div class="collapsible-header">PENDIENTES DE APROVAR GASTOS<span id="badge3" class="badge blue darken-3 white-text">0</span></div>
								<div class="collapsible-body">
									<!--table PENDIENTES DE APROVAR GASTOS-->
									<table>
										<thead>
											<tr>
												<th>Lugar</th>
												<th>Fecha</th>
											</tr>
										</thead>

										<tbody>
											<?php
												/*buscar los viajes del usuario en curso*/
												$badge3=0;
												$qviajes="SELECT v.id,d.nombre,v.estatus,DATE_FORMAT(v.fecha_inicio,'%Y-%m-%d') as finicio,v.fecha_fin,v.id_usuario,v.estatus FROM viajes v JOIN destino d ON v.id_destino=d.id WHERE id_usuario='$idU'AND estatus=3";
												$rviajes=mysql_query($qviajes) or die("La consulta: $qviajes" . mysql_error());
												while ($resviajes=mysql_fetch_assoc($rviajes))
												{$badge3++;
											?>
												<tr style="cursor:pointer;" onclick="VerViaje('<?php echo $resviajes['id'];?>');">
													<td><? echo $resviajes['nombre'];?></td>
													<td><? echo $resviajes['finicio'];?></td>
												</tr>
											<?
												}
												echo "<script>ActualizarBadge('3','".$badge3."');</script>";
											?>
										</tbody>
									</table>
									<!-- end table PENDIENTES DE APROVAR GASTOS -->
								</div>
							</li>

							<li>
								<div class="collapsible-header">FINALIZADOS<span id="badge4" class="badge blue darken-3 white-text">0</span></div>
								<div class="collapsible-body">
									<!--table FINALIZADOS-->
									<table>
										<thead>
											<tr>
												<th>Lugar</th>
												<th>Fecha</th>
											</tr>
										</thead>

										<tbody>
											<?php
												/*buscar los viajes del usuario en curso*/
												$badge4=0;
												$qviajes="SELECT v.id,d.nombre,v.estatus,DATE_FORMAT(v.fecha_inicio,'%Y-%m-%d') as finicio,v.fecha_fin,v.id_usuario,v.estatus FROM viajes v JOIN destino d ON v.id_destino=d.id WHERE id_usuario='$idU'AND estatus=4";
												$rviajes=mysql_query($qviajes) or die("La consulta: $qviajes" . mysql_error());
												while ($resviajes=mysql_fetch_assoc($rviajes))
												{$badge4++;
											?>
												<tr style="cursor:pointer;" onclick="VerViaje('<?php echo $resviajes['id'];?>');">
													<td><? echo $resviajes['nombre'];?></td>
													<td><? echo $resviajes['finicio'];?></td>
												</tr>
											<?
												}
												echo "<script>ActualizarBadge('4','".$badge4."');</script>";
											?>
										</tbody>
									</table>
									<!-- end table FINALIZADOS -->
								</div>
							</li>
						</ul>
					</div>
          			
					<div class="col s12 m12 l12 xl12 Mymodal" onclick="Ocultar();">
						<div class="col s12 m12 l12 xl12 Mycontainer">
							<div class="col s12 m12 l4 xl4">
								<label id="proyecto">Proyecto:</label>
							</div>
						</div>
					</div>
					<footer>
						<ul class="icons alt">
							<li><a href="#" class="icon alt fa-twitter"><span class="label">Twitter</span></a></li>
							<li><a href="#" class="icon alt fa-facebook"><span class="label">Facebook</span></a></li>
							<li><a href="#" class="icon alt fa-instagram"><span class="label">Instagram</span></a></li>

						</ul>
					</footer>
                <!--end main-->
				</div>
			</div><!--end wrapper-->

			<!-- Scripts -->
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
			<script type="text/javascript" src="assets/js/materialize.min.js"></script>
	</body>
</html>