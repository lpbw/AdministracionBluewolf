<?
session_start();
include "checar_sesion.php";
include "checar_sesion_admin.php";
include "coneccion.php";

$d=$_POST['de'];//fecha desde
$h=$_POST['ha'];//fecha hasta

$b=" f.fecha_emision=''";
$hoy=date("Y-m-d");
		
if($_POST["guardar"]=="Guardar") {
	$fpago=$_POST['fpago'];
	//$fpago=date("Y-m-d",strtotime($fpago));
	$estatus=$_POST['estatus'];
	$idfa=$_POST['idf'];
	$monto = $_POST['montos'];
	$iva=16;
	$total=0;
	$cantiva=0;
	$c=0;
	foreach($estatus as $e){
	$f=$fpago[$c];
	/*echo "<script>alert('Fecha de pago: $f');</script>";*/
    $idfac=$idfa[$c];
    
	//if no tiene fecha de pago no se guarda
	if($f!="dd/mm/yyyy"){
	$f=date("Y-m-d",strtotime($f));
    $mo = $monto[$c];
    $cantiva=($mo*$iva)/100;
    $total=$mo+$cantiva;
    // echo "<script>alert('total: $total, idf=$idfac');</script>";
		/*echo "<script>alert('Estatus: $e, Fecha de pago: $f, ID: $idfac');</script>";*/
		$queryactualizar="update facturacion set estatus_pago='$e',fecha_pago='$f',monto='$mo',iva='$cantiva',total='$total' where id='$idfac'";
		$resactualizar = mysql_query($queryactualizar) or die("La actualizacion en doc:facturas_cobrar:linea:39 fallo: $queryactualizar" . mysql_error());
	}
	$c++;
	}
}	
?>
<!DOCTYPE HTML>
<!--
	Massively by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Facturas Por Cobrar</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script>
$(function () {
$("#desde").datepicker({ dateFormat: 'yy-mm-dd' });
$("#hasta").datepicker({ dateFormat: 'yy-mm-dd' });
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
          <header id="header"> <a class="logo" href="http://bluewolf.com.mx/new/" target="_blank">Bluewolf</a> </header>
          <!-- Nav -->
          <nav id="nav">
            <ul class="actions fit">
              <li><a href="menu_admin.php" class="button special fit">Administraci&oacuten</a></li>
              <li><a href="adm_clientes.php" class="button special fit">Clientes</a></li>
              <li><a href="adm_proyectos.php" class="button special fit">Proyectos</a></li>
			  <li><a href="buscar_cobros.php" class="button special fit">Facturaci�n</a></li>
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

			<form name="enviar" id="enviar" method="post">
			<!-- <div class="">-->
			  <div class="12u 12u(xsmall) table-wrapper">
    			<table style="width:95%;" align="center" class="faccobro">

					<thead>
						<tr>
							<th width="20%">Fecha Emision</th>
							<th width="5%">No.Factura</th>
							<th width="10%">Cliente</th>
							<th width="12%">Concepto</th>
							<th width="5%">Monto</th>
							<th width="20%">Fecha Pago</th>
							<th width="17%">Estatus</th>
							<th width="11%">Tipo</th>
						</tr>
					</thead>
					<tbody>
					<?
					
							$queryfacturas="SELECT f.id as idf,date_format(f.fecha_emision,'%Y-%m-%d') AS fecha_e,f.concepto,f.monto,f.estatus_pago,f.tipo,f.no_factura,cl.nombre as cliente FROM facturacion f JOIN cobros c ON f.id_cobro=c.id JOIN clientes cl ON f.id_cliente=cl.id WHERE f.estatus_pago=1 ORDER BY f.no_factura";
							$resultado2 = mysql_query($queryfacturas) or die("fallo queryfacturas: $queryfacturas" . mysql_error());
							$count=1;
							$c=0;
							while($res2=mysql_fetch_assoc($resultado2)){
							if($res2['tipo']==1)
							{
							$seguro="VIÁTICOS";
							}elseif($res2['tipo']==2){
							$seguro="FAVORES";
							}elseif($res2['tipo']==3){
							$seguro="NORMAL";
							}
					?>
					
						<tr>
							<td><? echo $res2['fecha_e'];?></td>
							<td><? echo $res2['no_factura'];?></td>
							<td><? echo $res2['cliente'];?></td>
							<td><? echo $res2['concepto'];?></td>
							
							<td>
								<input name="montos[]" id="montos<? echo $c;?>" type="text" value="<? echo $res2['monto'];?>"/>
								<!-- <input name="montof[]" id="montof" value="<? echo $res2['monto'];?>" type="hidden"/> -->
							</td>

							<td>
								<input style="width:100%;" class="datepicker" name="fpago[]" id="fpago<? echo $c;?>" type="text" readonly="true" value="dd/mm/yyyy"/>
								<input name="idf[]" id="idf" value="<? echo $res2['idf'];?>" type="hidden"/>
							</td>
							<td>
								<select name="estatus[]" id="estatus" style="width:100%; margin-left:-7px;">
					  				<?
									$queryestatus="SELECT * FROM estatus_pago";
									$resultado3 = mysql_query($queryestatus) or die("fallo queryestatus: $queryestatus" . mysql_error());
									while($res3=mysql_fetch_assoc($resultado3)){
									?>
									<option value="<? echo $res3['id']?>"><? echo $res3['nombre']?></option>
									<?
									}
									?>
					  			</select>		
							</td>
							<td><? echo $seguro;?>
							<input name="de" id="de" value="<? echo $desde;?>" type="hidden"/>
							<input name="ha" id="ha" value="<? echo $hasta;?>" type="hidden"/>
							</td>
						</tr>
					
					<?	$c++;
						$count++;
						}
					?>
					</tbody>
				</table>
			<!--</div>	-->
		  </div>				
			<br><br><br>
			<div class="row">
				<ul class="actions fit">
					<li><input class="button special fit" type="submit" name="guardar" id="guardar" value="Guardar"/></li>
				</ul>
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
        <!--<script src="assets/js/jquery.min.js"></script>falla picker-->
<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>


