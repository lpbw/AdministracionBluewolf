<?
session_start();
include "checar_sesion.php";
include "checar_sesion_admin.php";
include "coneccion.php";
$id_e=$_GET["id_e"];
$tipo=$_SESSION['idA'];
$hoy=date("d-m-Y");
$idU=$_SESSION['idU'];


$queryusuario="SELECT * FROM usuarios WHERE id=$idU";
$resq=mysql_query($queryusuario) or die("La consulta: $queryusuario" . mysql_error());
$res=mysql_fetch_assoc($resq);
$usuario=mb_strtoupper($res['nombre'],'utf-8');
//$correo=$res['email']."@bluewolf.com.mx";
//guardar viaje
if($_POST['solicitar']=="Solicitar")  
{
	$idpro=$_POST['proyecto'];
	$destino=mb_strtoupper($_POST['destino'],'utf-8');
	$inicio=date("Y-m-d",strtotime($_POST['inicio']));
	$fin=date("Y-m-d",strtotime($_POST['fin']));
	$npersonas=$_POST['numper'];
	$descripcion=mb_strtoupper($_POST['descrip'],'utf-8');
	$anticipo=$_POST['anticipo'];
	$motivo=mb_strtoupper($_POST['motivo'],'utf-8');
	$total=$_POST['total'];
	
	
	/*echo"<script>alert('');</script>";
	echo"<script>alert('');</script>";*/
	
	$queryd="select id from destino where nombre='$destino'";
	$resq=mysql_query($queryd) or die("La consulta: $queryd" . mysql_error());
	$res=mysql_fetch_assoc($resq);
	$iddes=$res['id'];//id del destino
	/*echo"<script>alert('$iddes');</script>";*/
	
	if($iddes=="")//cuando es nuevo el destino
	{
		$insertdestino="INSERT INTO destino (nombre) value('$destino')";
		$resgasto = mysql_query($insertdestino) or die("Error: insertdestino, file:viaje.php: $insertdestino" . mysql_error());
		$iddes=mysql_insert_id();
	}
	
		
		
	if($anticipo==1)
	{
		$insertviaje="INSERT INTO viajes (id_proyecto,fecha_inicio,fecha_fin,id_destino,no_personas,viajeros,anticipo,anticipo_total,fecha_anti,gasto_total,estatus,fecha_peticion,id_usuario,motivo) value('$idpro','$inicio','$fin','$iddes','$npersonas','$descripcion','$anticipo','0','','0','1',now(),'$idU','$motivo')";
		
		$resviaje = mysql_query($insertviaje) or die("Error: insertviaje, file:viaje.php: $insertviaje" . mysql_error());
		$idviaje=mysql_insert_id();
		
		$monto=$_POST['m'];
		$concepto=$_POST['con'];
		$count=0;
		foreach($monto as $m)
		{
			$con=mb_strtoupper($concepto[$count],'utf-8');
			/*echo"<script>alert('monto: $m');</script>";
			echo"<script>alert('concepto: $con');</script>";*/
			$insertanticipo="INSERT INTO anticipos (id_viaje,monto,concepto) value('$idviaje','$m','$con')";
			$resanticipo = mysql_query($insertanticipo) or die("Error: insertanticipo, file:viaje.php: $insertanticipo" . mysql_error());
			$count++;
		}
	}
	else
	{
			$insertviaje="INSERT INTO viajes (id_proyecto,fecha_inicio,fecha_fin,id_destino,no_personas,viajeros,anticipo,anticipo_total,fecha_anti,gasto_total,estatus,fecha_peticion,id_usuario,motivo) value('$idpro','$inicio','$fin','$iddes','$npersonas','$descripcion','$anticipo','0','','0','2',now(),'$idU','$motivo')";
		
		$resviaje = mysql_query($insertviaje) or die("Error: insertviaje, file:viaje.php: $insertviaje" . mysql_error());
		$idviaje=mysql_insert_id();
	}
	
	
	
	
	
	if($anticipo==1)
	{
	$queryp="SELECT * FROM proyectos WHERE id=$idpro";
	$resp=mysql_query($queryp) or die("La consulta: $queryp" . mysql_error());
	$res=mysql_fetch_assoc($resp);
	$body="<label>LA SIGUIENTE PERSONA SOLICITO ANTICIPO: ".$usuario."</label><br><label>PROYECTO: ".$res['nombre']."</label><br><label>FECHA INICIO: ".$inicio."</label><br><label>FECHA FIN: ".$fin."</label><br><label>DESTINO: ".$destino."</label><br><label>CANTIDAD DE PERSONAS: ".$npersonas."</label><br><label>VIAJANTES: ".$descripcion."</label><br><label>MOTIVO: ".$motivo."</label><br>";
	
	$body=$body."<table border=\"1\"><thead><tr><td>MONTO</td><td>CONCEPTO</td></tr></thead><tbody>";
	$queryanticipos="SELECT * FROM anticipos WHERE id_viaje=$idviaje";
	$resanti=mysql_query($queryanticipos) or die("La consulta: $queryanticipos" . mysql_error());
	while($res=mysql_fetch_assoc($resanti))
	{
		$body=$body."<tr><td>".$res['monto']."</td><td>".$res['concepto']."</td></tr>";
	}
	$body=$body."</table></tbody>";
	/*$body=$body."<form action=\"http://bluewolf.com.mx/admon/new/guardartotal.php\" method=\"post\" name=\"enviartotal\"><label for=\"valor\">TOTAL ANTICIPO</label><input name=\"valor\" type=\"text\"/><br><label for=\"fecha\">FECHA ANTICIPO</label><input class=\"datepicker\" name=\"fecha\" type=\"text\"/>(dd/mm/yyyy)<br><input class=\"button special fit\" type=\"submit\" name=\"enviar\" id=\"enviar\" value=\"ENVIAR\" /><input  name=\"idviaje\" type=\"text\" value=".$idviaje." /></form>";*/
	
	mail("Administracion@bluewolf.com.mx", "VIÁTICOS", $body, "From:<info@bluewolf.com.mx>\nContent-type: text/html; charset=utf-8\n");
	}
	echo"<script>alert('Viaje guardado exitosamente!!!');</script>";
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
		<title>Viaje</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
			<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
		<script>
		
		//formato de calendarios
		$(function () {
		$("#inicio").datepicker({ dateFormat: 'dd-mm-yy' });
		$("#fin").datepicker({ dateFormat: 'dd-mm-yy' });
		});	
		
		//anticipo
		function anti()
		{
			campo1="<div class='6u 12u(xsmall)' id='anti'><label for='monto' id='m'>Monto</label><input name='monto' id='monto' type='text'/><input name='can' id='can' type='hidden' value='0'/></div>";
			campo2="<div class='6u 12u(xsmall)' id='con'><label for='concepto'>Concepto(Desglose)</label><textarea class='upper' name='concepto' id='concepto' rows='1' ></textarea></div>";
			btn="<div style='margin-top:30px;' class='6u 6u(xsmall)' id='btn'><input class='button special fit' type='button' name='agregar' id='agregar' value='Agregar' onClick='agregarfila()'/></div>";
			/*tabla="<div class='4u 12u(xsmall)' id='tabla' style='width:360px; height:100px; overflow:auto;'><table><tr><td width='30%'>Monto</td><td width='35%'>Concepto</td><td width='30%'></td></tr></table><table id='mytable' ><tr><td width='30%'></td><td width='35%'></td><td width='30%'></td></tr></table></div>";*/
			var ant=document.getElementById('anticipo').value;
			if(ant==1)
			{
				$('#solicitar').append(campo2);//agrega el input monto
				$('#solicitar').append(campo1);//agrega el input concepto
				$('#solicitar').append(btn);//agrega boton agregar
				//$('#solicitar').append(tabla);//agrega tabla
				document.getElementById("tabla1").style.display = "block";
			}
			else
			{
				$("div").remove("#anti");
				$("div").remove("#con");
				$("div").remove("#btn");
				//$("div").remove("#tabla");
				$('#mytable tr').remove();
				document.getElementById('total').value="";
				var tot=document.getElementById('tot');
				tot.innerHTML="";
				document.getElementById("tabla1").style.display = "none";
			}
		}
		
		//valida se los campos tienen datos
		function validar()
		{
		$("div").remove("#btn2");
		btn="<div class='6u 12u(xsmall)' id='btn2'><input class='button special fit' type='submit' name='solicitar' id='solicitar' value='Solicitar' onClick='buscar()'/></div>";
			var proyecto=document.getElementById('proyecto').value;
			var f1=document.getElementById('inicio').value;
			var f2=document.getElementById('fin').value;
			var numper=document.getElementById('numper').value;
			if($("input[name=destino]").val()!="" && f1!="" && f1!="" && numper!="")
			{
				$('#boton').append(btn);//agrega  el boton solicitar
			}
			else
			{
				$("div").remove("#btn2");
			}
		}
		
		//buscar en el archivo agregaranticipo.php	
			function agregarfila()
			{
				var c=document.getElementById('can').value;
				var total=document.getElementById('total').value;
				var monto=document.getElementById('monto').value;
				var concepto=document.getElementById('concepto').value;
				if (monto!="" && concepto!="")
				{
				var x=document.getElementById('mytable').insertRow(0);
				var y=x.insertCell(0);
				var z=x.insertCell(1);
				var z1=x.insertCell(2);
				x.id="p"+c;
				y.innerHTML="<center>"+monto+"<input name='m[]' id='m"+c+"' type='hidden' value='"+monto+"' /></center>";
				z.innerHTML="<center>"+concepto+"<input name='con[]' id='con"+c+"' type='hidden' value='"+concepto+"' /></center>";
				z1.innerHTML="<img src=\"images/close.gif\" alt=\"Eliminar Producto\" name=\"Image50\"  border=\"0\"  id=\"Image50\" onclick=\"deleteRow(this,"+monto+")\"/>";
				c=parseInt(c)+1;
				total=parseInt(total)+parseInt(monto);
				document.getElementById('can').value=c;
				document.getElementById('monto').value="";
				document.getElementById('concepto').value="";
				var tot=document.getElementById('tot');
				document.getElementById('total').value=total;
				tot.innerHTML=total;
				}
				else
				{
				alert('Porfavor ingrese datos en monto y concepto');
				}
			}	
			
			//funcion para eliminar una fila
			function deleteRow(r,monto)
			{
			
				var i=r.parentNode.parentNode.rowIndex;
				document.getElementById('mytable').deleteRow(i);
				var c=document.getElementById('can').value;
				c=parseInt(c)-1;
				document.getElementById('can').value=c;
				var total=document.getElementById('total').value;
				total=parseInt(total)-parseInt(monto);
				document.getElementById('total').value=total;
				var tot=document.getElementById('tot');
				tot.innerHTML=total;
			}
		</script>
		
			
	</head>
	
	<body class="is-loading">

		<!-- Wrapper -->
			<div id="wrapper">
			
					<ul class="visible actions"><!--Boton regresar-->
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
					<form class="alt" name="enviarsolicitud" id="enviarsolicitud" method="post" enctype="multipart/form-data">
						
						<div class="row uniform" id="solicitar">
						
							<div class="6u 12u(xsmall)"><!--proyecto-->
								<label for="proyecto">Proyecto</label>
								<select name="proyecto" id="proyecto">
									<option value="0">NINGUNO</option>
									<?
									$query="select * from proyectos";
									$res=mysql_query($query) or die("La consulta: $query" . mysql_error());
									while ($resul=mysql_fetch_assoc($res))
									{
									?>
									<option value="<?echo $resul['id'];?>"><?echo $resul['nombre'];?></option>
									<?
									}
									?>
								</select>
							</div><!--fin proyecto-->
							
							<div class="6u 12u(xsmall)"><!--destino-->
								<label for="destino">Destino*</label>
								<input class="upper" list="destino" name="destino" type="text" onChange="validar()" required>
								<datalist id="destino">
								<?	
								$query = "select * from destino order by nombre";
								$result = mysql_query($query) or print("<option value=\"ERROR\">".mysql_error()."</option>");
								while($destino = mysql_fetch_assoc($result))
								{
								?>
								<option value="<? echo $destino['nombre']?>"  ><? echo $destino['nombre']?></option>
								<?
								}
								?>
								</datalist>
							</div>
														
							<div class="6u 12u(xsmall)"><!--fecha inicio-->
								<label for="inicio">Fecha Inicio*</label>
								<input class="datepicker" type="text" name="inicio" id="inicio" value="<?echo $hoy?>" onChange="validar()" required/>
							</div>
							
							<div class="6u 12u(xsmall)"><!--fecha fin-->
								<label for="fin">Fecha fin*</label>
								<input class="datepicker" type="text" name="fin" id="fin" value="<?echo $hoy?>" onChange="validar()" required/>
							</div>
							
							<div class="6u 12u(xsmall)"><!--numero de personas-->
								<label for="numper">N&uacute;mero de personas*</label>
								<input type="text" name="numper" id="numper" onChange="validar()" required/>
							</div>
							
							<div class="6u 12u(xsmall)"><!--descripcion-->
								<label for="descrip">Personas que viajan</label>
								<textarea class="upper" name="descrip" id="descrip" rows="1"></textarea>
							</div>
							
							<div class="6u 12u(xsmall)"><!--descripcion-->
								<label for="motivo">Motivo de viaje</label>
								<textarea class="upper" name="motivo" id="motivo" style="height:45px;padding:1px;"></textarea>
							</div>
							
							<div class="6u 12u(xsmall)"><!--anticipo-->
								<label for="anticipo">Viáticos</label>
								<select name="anticipo" id="anticipo" onChange="anti()">
									<option value="0">No</option>
									<option value="1">Si</option>
								</select>
							</div>
							
						
							
							
							
						
						</div><!--fin row-->
						<div class="row uniform">
							<div  class="12u 12u(xsmall)" style="overflow-x:hidden;overflow-y:scroll; width:100%; height:300px;display:none;" id="tabla1"><!--anticipo-->
								<table width="50%">
            						<tr>
										<td width="30%">Monto</td>
										<td width="35%">Concepto</td>
										<td width="30%"></td>
									</tr>
					   			</table>
					   			<table width="50%"  id="mytable">
									<tr>
										<td width="30%"></td>
										<td width="35%"></td>
										<td width="30%"></td>
									</tr>
					   	   		</table>
		   				   	</div>
							<div class="6u 12u(xsmall)"><!--total-->
								<label id="t" style="font-size:16px;">TOTAL</label>
								<label id="tot" style="font-size:16px;color:#FF0000;"></label>
								<input name="total" id="total" type="hidden" value="0"/>
							</div>
						</div>
						<div class="row uniform" id="boton">
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
						<ul><li>&copy; <a href="https://html5up.net">Bluewolf</a></li></ul>
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

