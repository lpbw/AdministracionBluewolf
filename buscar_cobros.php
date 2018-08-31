<?
session_start();
include "checar_sesion.php";
include "checar_sesion_admin.php";
include "coneccion.php";

$d=$_GET['d'];//fecha desde
$h=$_GET['h'];//fecha hasta

$e=$_GET['e'];
$b=" c.fecha=''";
$hoy=date("d-m-Y");


if($_POST["guardar"]=="Guardar") {
	$select=$_POST['selec'];//checkbox
	$nfactura=$_POST['nof'];//numero de factura.
	$femision=$_POST['emision'];//fecha de emision.
	
	$fcobro=$_POST['fecha'];//fecha de cobro
	$proyecto=$_POST['proyecto'];//proyecto
	$rfc=$_POST['rfc'];//rfc
	$cliente=$_POST['cliente'];//cliente
	$concepto=$_POST['concepto'];
	$monto=$_POST['monto'];
	$iva=16;
	$total=0;
	$cantiva=0;
	$seguro=$_POST['seg'];//seguro/preguntar
	$tipo=$_POST['tipo'];//tipo de factura
	$d=$_POST['de'];//fecha desde
	$h=$_POST['ha'];//fecha hasta
	$idcobro=$_POST['idcobro'];
	$count=0;
	$flag=0;
	$d=$_POST['de'];//fecha desde
$h=$_POST['ha'];//fecha hasta
	foreach($select as $s){
		if($s!=""){
		$flag=1;
		
		$count=$s-1;

		$queryarea = "SELECT id_area FROM proyectos WHERE id=$proyecto[$count]";
		$resarea = mysql_query($queryarea) or die("id area no encontrada bucar_cobreos: $queryarea".mysql_error());
		$resa = mysql_fetch_assoc($resarea);
		$idareap = $resa['id_area'];
		
		$cantiva=($monto[$count]*$iva)/100;
		$total=$monto[$count]+$cantiva;
		$t=$tipo[$count]; 
		$conc=$concepto[$count];
		$conc=strtoupper($conc);//concepto
		$fem=$femision[$count];
		$fem=date("Y-m-d",strtotime($fem));
		$queryactualizar="update cobros set concepto='$conc', monto='$monto[$count]',id_estatus_cobro='2' where id='$idcobro[$count]'";
		$resactualizar = mysql_query($queryactualizar) or die("La actualizacion en cobros fallo: $queryactualizar" . mysql_error());
		$queryfacturas="insert into facturacion (id_cobro,no_factura,fecha_emision,fecha_cobro,fecha_pago,id_proyecto,rfc,id_cliente,concepto,monto,iva,total,estatus_pago,tipo,id_area) values('$idcobro[$count]','$nfactura[$count]','$fem','$fcobro[$count]','','$proyecto[$count]','$rfc[$count]','$cliente[$count]','$conc','$monto[$count]','$cantiva','$total',1,'$tipo[$count]',$idareap) ";
		$resfacturas = mysql_query($queryfacturas) or die("La insersion en facturas fallo: $queryfacturas" . mysql_error());
		}
	}
	
	if($flag==1){
	echo "<script>alert('Las facturas fueron guardadas con exito!!');</script>";
	}

} 
//include "SimpleImage.php";
//$adminU=$_SESSION['adminU'];
	if( $_POST['buscar']=="Buscar")
	{ 
		$desde=date("Y-m-d",strtotime($_POST['desde']));
		$hasta=date("Y-m-d",strtotime($_POST['hasta']));
		
			
	}
	if($d!="" and $h!="")
	{
		$desde=date("Y-m-d",strtotime($d));
		$hasta=date("Y-m-d",strtotime($h));
		
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
		<title>Buscar Cobros</title>
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
            <form class="alt" name="buscarc" id="buscarc" method="post" enctype="multipart/form-data">
              <div class="box">
			   <ul class="icons">
			 	<li><a href="facturar.php">Facturar</a>(<a href="facturar.php" class="icon alt fa-plus"></a>)</li>
			 </ul>
                <div class="row uniform">
                  <div class="6u 12u(xsmall)">
                    <label for="desde">Desde</label>
                    <input class="datepicker" type="text" name="desde" id="desde" value="<? echo $desde?$desde:$hoy;?>" required readonly=""/>
                  </div>
                  <div class="6u 12u(xsmall)">
                    <label for="hasta">Hasta</label>
                    <input class="datepicker" type="text" name="hasta" id="hasta" value="<? echo $hasta?$hasta:$hoy;?>" required readonly=""/>
                  </div>
				  
                  
				   <div class="12u 12u(xsmall)">
                    <ul class="actions fit">
                      <li>
                        <input class="button fit special" type="submit" name="buscar" id="buscar" value="Buscar" onClick="buscar()"/>
                      </li>
                    </ul>
                  </div>
              
				</div>
              </div>
            </form>
			<form name="enviar" id="enviar" method="post">
			<div class="table-wrapper">
            <div class="12u 12u(xsmall)" id="tablafacturas">
            <!-- -->
                <table class="t">
                  <thead>
					<th >Fecha Cobro</th>
                    <th >Proyecto</th>
                    <th >Cliente</th>
                    <th >Concepto</th>
                    <th >Monto</th>
                    <th >Confirmacion</th>
                    <th >No.Factura</th>
                    <th >Fecha Emisión</th>
                    <th >Tipo</th>
                    <th ></th>
                    <?
			if($desde!="" and $hasta!="")
			{
				$b=" c.fecha>='$desde 00:00:00' and c.fecha<='$hasta 00:00:00'";
			}else
			{
				$b=" c.fecha>='$hoy 00:00:00' and c.fecha<='$hoy 00:00:00'";
			}
			
 $consulta  = "SELECT date_format(c.fecha,'%Y/%m/%d') as fecha
 ,c.id as idcobro
 ,p.id as idp
 ,p.nombre as proyecto
 ,cl.id as idcl
 ,cl.nombre as cliente
 ,c.concepto
 ,c.monto
 ,cl.rfc
 ,c.seguro
FROM cobros c 
JOIN proyectos p ON c.id_proyecto=p.id 
JOIN clientes cl ON p.id_cliente=cl.id
where c.id_estatus_cobro=1 AND".$b;
							$resultado = mysql_query($consulta) or die("La consulta: $consulta" . mysql_error());
							$count=1;
							$c=0;
							
							while($res=mysql_fetch_assoc($resultado)){
							if($res['seguro']==1)
							{
							$seguro="Seguro";
							}elseif($res['seguro']==2){
							$seguro="Preguntar";
							}
							
  						?>
                      <? if ($count%2==0){$c++?>
                          <tbody>
                    <tr style="background-color:#CCCCCC">
						
                      <td class="rwd_auto"><? echo $res['fecha'];?><input name="fecha[]" id="fecha<? echo $c; ?>" type="hidden" value="<? echo $res['fecha'];?>"/><input name="de" id="de" value="<? echo $desde;?>" type="hidden"/><input name="ha" id="ha" value="<? echo $hasta;?>" type="hidden"/></td>
                      <td ><? echo $res['proyecto'];?><input name="proyecto[]" id="proyecto" type="hidden" value="<? echo $res['idp'];?>"/><input name="idcobro[]" id="idcobro" value="<? echo $res['idcobro'];?>" type="hidden"/><input name="rfc[]" id="rfc" type="hidden" value="<? echo $res['rfc'];?>"/></td>
                      
                  	  <td><a href="cliente.php?idcl=<? echo $res['idcl'];  ?>" target="_blank"><? echo $res['cliente'];?></a><input name="cliente[]" id="cliente" type="hidden" value="<? echo $res['idcl'];?>"/></td>
                      <td ><input name="concepto[]" id="concepto" type="text" value="<? echo $res['concepto'];?>"/></td>
                      <td ><input name="monto[]" id="monto" type="text" value="<? echo $res['monto'];?>"/></td>
                      <td ><? echo $seguro;?><input name="seg[]" id="seg" type="hidden" value="<? echo $seguro;?>"/></td>
                      <td align="center"><input name="nof[]" id="nof" type="text" value="0"/></td>
					   <td ><input class="datepicker" type="text" name="emision[]"  id="emision<? echo $c; ?>" value="<? echo $hoy;?>" /></td>
                     
                      <td > <select name="tipo[]" id="tipo<? echo $c; ?>">
					  	<option value="0">Seleccion</option>
						<option value="1">Viáticos</option>
						<option value="2">Favores</option>
						<option value="3">Normal</option>
					  </select>					  </td>
                      <td ><input type="checkbox" name="selec[]" id="select<? echo $c; ?>" value="<? echo $c; ?>"/><label for="select<? echo $c; ?>"></label></td>
                    </tr>
                  </tbody>
                  <? }else{$c++?>
                  <tbody>
                    <tr>
                    <td ><? echo $res['fecha'];?><input name="fecha[]" id="fecha<? echo $c; ?>" type="hidden" value="<? echo $res['fecha'];?>"/><input name="de" id="de" value="<? echo $desde;?>" type="hidden"/><input name="ha" id="ha" value="<? echo $hasta;?>" type="hidden"/></td>
                      <td ><? echo $res['proyecto'];?><input name="proyecto[]" id="proyecto" type="hidden" value="<? echo $res['idp'];?>"/><input name="idcobro[]" id="idcobro" value="<? echo $res['idcobro'];?>" type="hidden"/><input name="rfc[]" id="rfc" type="hidden" value="<? echo $res['rfc'];?>"/></td>
                     
                  	  <td><a href="cliente.php?idcl=<? echo $res['idcl'];  ?>" target="_blank"><? echo $res['cliente'];?></a><input name="cliente[]" id="cliente" type="hidden" value="<? echo $res['idcl'];?>"/></td>
                      <td ><input name="concepto[]" id="concepto" type="text" value="<? echo $res['concepto'];?>"/></td>
                      <td ><input name="monto[]" id="monto" type="text" value="<? echo $res['monto'];?>"/></td>
                      <td ><? echo $seguro;?><input name="seg[]" id="seg" type="hidden" value="<? echo $seguro;?>"/></td>
                      <td align="center"><input name="nof[]" id="nof" type="text" value="0"/></td>
					   <td ><input class="datepicker" type="text" name="emision[]"  id="emision<? echo $c; ?>" value="<? echo $hoy;?>" /></td>
                     
                      <td > <select name="tipo[]" id="tipo<? echo $c; ?>">
					  	<option value="0">Seleccion</option>
						<option value="1">Viáticos</option>
						<option value="2">Favores</option>
						<option value="3">Normal</option>
					  </select>					  </td>
                      <td ><input type="checkbox" name="selec[]" id="select<? echo $c; ?>" value="<? echo $c; ?>"/><label for="select<? echo $c; ?>"></label></td>
                    </tr>
                  </tbody>
                  <? }?>
                  <?
						$count++;
						}
						?>
                </table>
              </div>
            </div>
			 <? if($desde!="" and $hasta!="")
									{
								?>
								
			<br><br><br>
			<div class="row">
							<ul class="actions fit">
								
								<li><input class="button special fit" type="submit" name="guardar" id="guardar" value="Guardar"/></li>
								
							</ul>
						</div>	
						<?
									}
								?>
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

