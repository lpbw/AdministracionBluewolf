<?
session_start();
include "checar_sesion.php";
include "checar_sesion_admin.php";
include "coneccion.php";
$hoy=date("d-m-Y");

if($_POST["guardar"]=="Guardar")  
{
	$fac= mb_strtoupper($_POST['fac'],'utf-8');
	$pro=$_POST['idproyecto'];
	$idcliente=$_POST['idcliente'];
	$tipo=$_POST['tipo'];
	$monto=$_POST['monto'];
	$concepto= mb_strtoupper($_POST['concepto'],'utf-8');
	$fecha=date("Y-m-d",strtotime($_POST['fecha']));
	$iva=16;
	$total=0;
	$cantiva=0;
	$cantiva=($monto*$iva)/100;
	$total=$monto+$cantiva;
	/*echo "<script>alert('idcliente: $idcliente');</script>";*/
	/*echo"<script>alert('factura: $fac, proyecto: $pro, tipo: $tipo, monto: $monto, concepto: $concepto, fecha: $fecha.');</script>";*/
	$querysel="select rfc from  clientes where id=$idcliente";
	$resultado = mysql_query($querysel) or die("Error en : $querysel " . mysql_error());
	$res=mysql_fetch_assoc($resultado);
	$rfc=$res['rfc'];
	

	//guarda en cobros un nuevo registro
	$queryinsert="insert into cobros (id_proyecto,concepto,monto,id_estatus_cobro,fecha,seguro) values ('$pro','$concepto','$monto','2','$fecha','1')";
	$resultado = mysql_query($queryinsert) or die("Error en consulta insert cobros: $queryinsert " . mysql_error());
	$idc=mysql_insert_id();
	
	/*echo "<script>alert('proyecto: $pro');</script>";*/
	if($pro=="" or $pro==0)
	{
		$idarea=$_POST['idarea'];
		/*echo "<script>alert('idarea: $idarea');</script>";*/
		$queryfacturas="insert into facturacion (id_cobro,no_factura,fecha_emision,fecha_cobro,fecha_pago,id_proyecto,rfc,id_cliente,concepto,monto,iva,total,estatus_pago,tipo,id_area) values('$idc','$fac','$fecha','$fecha','','$pro','$rfc','$idcliente','$concepto','$monto','$cantiva','$total',1,'$tipo','$idarea')";
		$resfacturas = mysql_query($queryfacturas) or die("La insersion en facturas fallo: $queryfacturas" . mysql_error());
		echo "<script>alert('Factura guardada con exito!!!');</script>";
	}
	else
	{
	//guarda en facturas un nuevo registro
		$queryfacturas="insert into facturacion (id_cobro,no_factura,fecha_emision,fecha_cobro,fecha_pago,id_proyecto,rfc,id_cliente,concepto,monto,iva,total,estatus_pago,tipo,id_area) values('$idc','$fac','$fecha','$fecha','','$pro','$rfc','$idcliente','$concepto','$monto','$cantiva','$total',1,'$tipo',0)";
	$resfacturas = mysql_query($queryfacturas) or die("La insersion en facturas fallo: $queryfacturas" . mysql_error());
		echo "<script>alert('Factura guardada con exito!!!');</script>";
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
		<title>Facturar</title>
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
		});	
		
		//buscar en el archivo buscar.php	
			function buscar(){
				if (window.XMLHttpRequest)
		  		{// code for IE7+, Firefox, Chrome, Opera, Safari
		  			xmlhttp=new XMLHttpRequest();
		  		}
				else
		  		{// code for IE6, IE5
		  			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  		}
					xmlhttp.onreadystatechange=function()
		  		{
					
		  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					resultado=xmlhttp.responseText;
					
					var m=document.getElementById('mensaje');
					
					m.innerHTML=resultado;
				
			    }
		  	}
				var fac=document.getElementById('fac').value;
				
				xmlhttp.open("GET","buscar.php?f="+fac+"&val=3",true);
				xmlhttp.send();
				
		}	
		
		//selecciona el proyecto segun el cliente seleccionado
			function selectproyecto(cadena)
			{	
				
				var anterior = document.getElementById('idcliente').value;
				var anterior2 = document.getElementById('idarea').value;
				$("#cliente option[value="+anterior+"]").prop("selected",false);
				$("#area option[value="+anterior2+"]").prop("selected",false);
				
				if(cadena!="0")
				{
					elementos= cadena.split("|");
					if(elementos[0]!="")
					{ 
						var valor=elementos[2];
						$("#cliente option[value="+elementos[1]+"]").prop("selected",true);
						$("#area option[value="+valor+"]").prop("selected",true);
						document.getElementById('idproyecto').value=elementos[0];
						document.getElementById('idcliente').value=elementos[1];
						document.getElementById('idarea').value=valor;
						$("#cliente").prop("disabled",true);
						$("#area").prop("disabled",true);
					}
				}	
				else if(cadena=="0")
					{
					
						var v="0";
						$("#cliente option[value="+v+"]").prop("selected",true);
						$("#area option[value="+v+"]").prop("selected",true);
						document.getElementById('idarea').value=v;
						document.getElementById('idproyecto').value="0"; 
						document.getElementById('idcliente').value="0";
						$("#cliente").prop("disabled",false);
						$("#area").prop("disabled",false);
					}	 
			}
			
			function id_cliente(valor)
			{	
				document.getElementById('idcliente').value=valor;
			}
			function id_area(valor)
			{	
				document.getElementById('idarea').value=valor;
			}
		</script>
	</head>

	<body class="is-loading">
		
		
		<!-- Wrapper -->
			<div id="wrapper">
					
					<ul class="visible actions">
						<li class="visible"><a href="buscar_cobros.php" class="button special icon fa-undo">Regresar</a></li>
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
							<li><a href="adm_proyectos.php" class="button special fit">Proyectos</a></li>
							<li><a href="buscar_cobros.php" class="button special fit">Facturaci�n</a></li>
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
					<form class="alt" name="enviarfactura" id="enviarfactura" method="post" enctype="multipart/form-data">			
						
						<div class="box">
						<div class="row uniform">
							
							<div class="6u 12u(xsmall)">
								<label for="fac">N&Uacute;MERO DE FACTURA</label>
								<input  class="upper" type="text" name="fac" id="fac" value="" required onChange="buscar();"/>
								<label id="mensaje" style="color:#FF0000;"></label>
							</div>
							
							<div class="6u 12u(xsmall)">
								<label for="proyecto">Proyecto</label>
								<select name="proyecto" id="proyecto" onChange="selectproyecto(this.value)" >
									<option value="0">NINGUNO</option>
									<?
									$query="select * from proyectos";
									$res=mysql_query($query) or die("La consulta: $query" . mysql_error());
									while ($resul=mysql_fetch_assoc($res))
									{
									?>
									<option value="<?echo $resul['id'];?>|<?echo $resul['id_cliente'];?>|<?echo $resul['id_area'];?>"><?echo $resul['nombre'];?></option>
									<?
									}
									?>
								</select>
								<input type="hidden" name="idarea" id="idarea" value="0"/>
								<input type="hidden" name="idproyecto" id="idproyecto" value=""/>
								<input type="hidden" name="idcliente" id="idcliente" value=""/>
							</div>
							
							
							<div class="6u 12u(xsmall)">
							<label for="cliente">Cliente</label>
								<select name="cliente" id="cliente" required onChange="id_cliente(this.value)">
									<option value="0">NINGUNO</option>
									<? $query = "SELECT id,nombre FROM clientes";
                            		   $result = mysql_query($query) or print("<option value=\"ERROR\">".mysql_error()."</option>");
                            			while($areas = mysql_fetch_assoc($result)){
									?>
                         			<option value="<? echo $areas['id']?>"><? echo $areas['nombre']?></option>
						  			<?
                            		}
                            		?>
								</select>
								
							</div>
							
							<div class="6u 12u(xsmall)">
								<label for="area">&Aacute;rea</label>
								<select name="area" id="area" required onChange="id_area(this.value)">
									<option value="0">NINGUNO</option>
									<? $query = "SELECT id,nombre FROM areas";
                            		   $result = mysql_query($query) or print("<option value=\"ERROR\">".mysql_error()."</option>");
                            			while($areas = mysql_fetch_assoc($result)){
									?>
                         			<option value="<? echo $areas['id']?>"><? echo $areas['nombre']?></option>
						  			<?
                            		}
                            		?>
								</select>
							</div>
							
							<div class="6u 12u(xsmall)">
								<label for="monto">Monto</label>
								<input type="text"  name="monto" id="monto" required/>
							</div>
							
							<div class="6u 12u(xsmall)">
								<label for="tipo">Tipo de Factura</label>
								<select name="tipo" id="tipo">
								<option value="0">SELECCIONE TIPO</option>
								<option value="1">VI&Aacute;TICOS</option>
								<option value="2">FAVORES</option>
								<option value="3">NORMAL</option>
								</select>	
					  		</div>
								
							<div class="6u 12u(xsmall)">
								<label for="fecha">Fecha Emision</label>
								<input class="datepicker" type="text" name="fecha" id="fecha" value="<?echo $hoy?>" required/>
							</div>
							
							<div class="6u 12u(xsmall)">
								<label for="concepto">Concepto</label>
								<textarea class="upper" name="concepto" id="concepto" rows="2" cols="6"></textarea>
							</div>
							
							
						</div>
						</div>
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
						<ul><li>&copy; Untitled</li><li>Design: <a href="https://html5up.net">Bluewolf</a></li></ul>
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

