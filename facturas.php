<?
session_start();
include "checar_sesion.php";
include "checar_sesion_admin.php";
include "coneccion.php";
$id=$_GET['id'];
$pf=$_GET['pf'];	
?>
<!DOCTYPE HTML>
<!--
	Massively by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Facturas</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
</head>

	<body class="is-loading">
		
		
		<!-- Wrapper -->
		<div id="wrapper">
          <ul class="visible actions">
            <li class="visible"><? if($pf==1){?><a href="proyectos_finalizados.php" class="button special icon fa-undo">Regresar</a><? }else{?><a href="adm_proyectos.php" class="button special icon fa-undo">Regresar</a><? }?></li>
          </ul>
		  <!-- Header -->
          <header id="header"> <a class="logo" href="http://bluewolf.com.mx/new/" target="_blank">Bluewolf</a> </header>
          <!-- Nav -->
          <nav id="nav">
            <ul class="actions fit">
              <li><a href="menu_admin.php" class="button special fit">Administraci&oacuten</a></li>
              <li><a href="adm_clientes.php" class="button special fit">Clientes</a></li>
              <li><a href="adm_proyectos.php" class="button special fit">Proyectos</a></li>
			  <li><a href="buscar_cobros.php" class="button special fit">Facturaci&oacute;n</a></li>
			  <li><a href="facturas_cobrar.php" class="button special fit">Facturas por Cobrar </a></li>
            </ul>
            <ul class="icons">
              <li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
              <li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
              <li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
              <li><a href="#" class="icon fa-github"><span class="label">GitHub</span></a></li>
            </ul>
          </nav>
		  <!-- Nav pestanas-->
					<div class="12u 12u(xsmall)">
					<nav id="navegador" >
						<ul class="links">
							<li><? if($pf==1){?><a href="detalles_finalizados.php?id=<? echo $id;?>">Portada</a><? }else{?><a href="adm_cambia_proyecto.php?id=<? echo $id;?>">Portada</a><? }?></li>
							<? if($pf==1){}else{?><li><a href="cobros.php?id=<? echo $id;?>">Pendientes Facturar</a></li><? }?>
							<li class="active"><a>Facturas</a></li>
							<li><? if($pf==1){?><a href="gasto.php?id=<? echo $id;?>&pf=1">Gastos</a><? }else{?><a href="gasto.php?id=<? echo $id;?>">Gastos</a><? }?></li>
						</ul>
					</nav>
					</div>
          <!-- Main -->
          <div id="main">
			<form name="enviar" id="enviar" method="post">
			<div class="12u 12u(xsmall) table-wrapper">
			<div class="box ">
			<div class="">
			 
			 
			 
    			<table width="70%" align="center" class="faccobro">
					<thead>
						<tr>
							<th width="10%">Fecha Emision</th>
							<th width="10%">#Factura</th>
							<th width="12%">Concepto</th>
							<th width="10%">Monto</th>
							<th width="25%">Fecha Pago</th>
							<th width="17%">Estatus</th>
							<th width="16%">Tipo</th>
						</tr>
					</thead>
					<tbody>
					<?
					$queryfacturas="SELECT f.id,date_format(f.fecha_emision,'%Y/%m/%d') as fecha_e,f.concepto,f.monto,date_format(f.fecha_pago,'%Y/%m/%d') as fecha_p,f.tipo,e.nombre,f.no_factura FROM facturacion f JOIN cobros c ON f.id_cobro=c.id JOIN estatus_pago e ON f.estatus_pago=e.id WHERE f.id_proyecto=$id";
					$resultado2 = mysql_query($queryfacturas) or die("fallo queryfacturas: $queryfacturas" . mysql_error());
					$count=1;
					$c=0;
					while($res2=mysql_fetch_assoc($resultado2)){
					if($res2['tipo']==1)
							{
							$seguro="Viáticos";
							}elseif($res2['tipo']==2){
							$seguro="Favores";
							}elseif($res2['tipo']==3){
							$seguro="Normal";
							}
					?>
					
						<tr>
							<td><? echo $res2['fecha_e'];?></td>
							<td><? echo $res2['no_factura'];?></td>
							<td><? echo $res2['concepto'];?></td>
							<td><? echo $res2['monto'];?></td>
							<td><? echo $res2['fecha_p'];?></td>
							<td><? echo $res2['nombre'];?></td>
							<td><? echo $seguro;?></td>
						</tr>
					
					<?	$c++;
						$count++;
						}
					?>
					</tbody>
				</table>
			</div>	
		  </div>
		  </div>
			</form>	
		
	
	
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
            <ul>
              <li>&copy; Untitled</li>
              <li>Design: <a href="https://html5up.net">Bluewolf</a></li>
            </ul>
          </div>
    </div>
		<!-- Scripts -->
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>


