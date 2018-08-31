<?
	session_start();
	include "checar_sesion.php";
	include "checar_sesion_admin.php";
	include "coneccion.php";
	$hoy=date("Y-m-d");
	$idU=$_SESSION['idU'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Agregar Viaje</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="assets/css/main.css" />
	<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	<!-- <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" /> -->
	 <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<!-- <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script> -->
	<style media="screen">
		.cargaimg{
			width: 100%;
			height: auto;
		}
	</style>
<script>
	var c=1;
	$( document ).ready(function() {

		$("#Siguiente").click(function(){

			if(c < 4)
			{
				c++;
				$("#m"+c).show();
				c--;
				$("#m"+c).hide();
				c++;
				//alert(c);
				if (c==4) {
					$("#Guardar").show();
					$("#Siguiente").hide();
				}
					$("#Atras").show();
			}
		});

		$("#Atras").click(function(){

			if(c > 1)
			{
				c--;
				$("#m"+c).show();
				c++;
				$("#m"+c).hide();
				c--;
					$("#Siguiente").show();
					$("#Guardar").hide();
					if (c==1) {
							$("#Atras").hide();
					}
			}
		});

		$("#Guardar").click(function(){

				var c=document.getElementById('can').value;
				var maxid=document.getElementById('maxid').value-1;
				var dest=document.getElementById('destino').value;
				var inicio=document.getElementById('inicio').value;
				var fin=document.getElementById('fin').value;
				var nper=document.getElementById('numper').value;
				var descrip=document.getElementById('descrip').value;
				var motivo=document.getElementById('motivo').value;
				//alert(maxid);

				var flag=0;
				var co=0;
				var idproyectos=[];
				for(x=9;x<=maxid;x++)
				{
					if(document.getElementById('check'+x).checked)
					{
						flag=1;
						idproyectos[co]=x;
						co++;
					}
				}
				if(flag==1)
				{
					co=co-1;
				}
				if(flag==0)
				{
					idproyectos=0;
				}

				// Viaticos
				c=parseInt(c);
				//alert(c);
				if(c>=1)
				{
				var montos=[];
				var idviaticos=[];
				//c=parseInt(c)-1;
				for (i=0;i<=c;i++)
				{
					var monto=document.getElementById('m'+i).value;
					var idviatico=document.getElementById('a'+i).value;
					//alert('monto: '+monto+' id viatico: '+idviatico);
					montos[i]=monto;
					idviaticos[i]=idviatico;
				}
				var parametros = {
					"pro" : idproyectos,
					"dest" : dest,
					"inicio" : inicio,
					"fin" : fin,
					"nper" : nper,
					"descrip" : descrip,
					"motivo" : motivo,
					"montos" : montos,
					"idviaticos" : idviaticos,
					"idu" : <?echo $idU;?>
				};
			}else {
				var parametros = {
					"pro" : idproyectos,
					"dest" : dest,
					"inicio" : inicio,
					"fin" : fin,
					"nper" : nper,
					"descrip" : descrip,
					"motivo" : motivo,
					"idu" : <?echo $idU;?>
				};
			}

				// ======================

			$.ajax({
				url:   'guardarviaje.php',
				type:  'post',
				dataType: "html",
				data: parametros,
				beforeSend: function () {
				$("#m4").hide();
				$("#Atras").hide();
				$("#Siguiente").hide();
				$("#guardar").hide();
				$("#m5").show();
			},
				success:  function (response) {
						//$("#m5").hide();
						location.href="vista_viajes_p.php";
				}
			});
		});

			$(".datepicker").datepicker({ dateFormat: 'yy-mm-dd' });


	});

	function Mensaje(valor){
		if (valor=="destino") {
			alert("Si el destino que busca no existe puede introducirlo");
		}
		if (valor=="inicio") {
			alert("Fecha en que inicia el viaje");
		}
		if (valor=="fin") {
			alert("Fecha en que finaliza el viaje");
		}
	}
	/*agrega una fila a la tablaanti*/
	function agregarfila()
	{
		var c=document.getElementById('can').value;
		var x=document.getElementById('tablaanti').insertRow(0);
		var y=x.insertCell(0);
		var z=x.insertCell(1);
		var z1=x.insertCell(2);
		c=parseInt(c);
		x.id="p"+c;
		y.innerHTML="<center><input name='m[]' id='m"+c+"' type='text' value='0' class='sampletext' onchange='totalv(this.value)'/></center>";
		z.innerHTML="<center><select name='a"+c+"' id='a"+c+"' style='margin-right:-18px;'><? $query="select * from viaticos"; $resultado=mysql_query($query) or die("La consulta: $query" . mysql_error()); while ($res=mysql_fetch_assoc($resultado)){?><option value='<? echo $res['id'] ?>'><? echo $res['concepto'] ?></option><? }?> </select></center>";
		z1.innerHTML="<img src=\"images/close.gif\" alt=\"Eliminar Producto\" name=\"Image50\"  border=\"0\"  id=\"Image50\" onclick=\"deleteRow(this,"+c+")\" width='16px' height='16px'/>";
		c++;
		document.getElementById('can').value=c;
	}
	/***********************************************************/

	/*elimina una fila de la tablaanti*/
	function deleteRow(r,id)
	{
		var monto=document.getElementById('m'+id).value;

		if(monto==""){monto=0;}
		var m=document.getElementById('monto').value;
		m=parseInt(m)-parseInt(monto);
		document.getElementById('monto').value=m;
		var tot=document.getElementById('totalv');
		tot.innerHTML=m;

		var i=r.parentNode.parentNode.rowIndex;
		document.getElementById('tablaanti').deleteRow(i);
		var c=document.getElementById('can').value;
		c=parseInt(c)-1;
		document.getElementById('can').value=c;

	}
	/**********************************/
	/**********calcular el total***********/
	function totalv(monto)
	{

		if(monto==""){monto=0;}
		var m=document.getElementById('monto').value;
		m=parseInt(m)+parseInt(monto);
		document.getElementById('monto').value=m;
		var tot=document.getElementById('totalv');
		tot.innerHTML=m;
	}
	/***************************************/
</script>
<style>
	#m1{margin-top: 8%;margin-left: 4%;}
	#m2{margin-top: 8%;margin-left: 4%;}
	#m3{margin-top: 8%;margin-left: 4%;}
	#m4{margin-top: 15%;margin-left: 4%;}
	/*phone*/
	@media only screen and (max-width: 600px)
	{
		#m1{margin-top: 8%;margin-left: 6%;}
		#m2{margin-top: 8%;margin-left: 6%;}
		#m3{margin-top: 8%;margin-left: 6%;}
		#m4{margin-top: 8%;margin-left: 6%;}
	}
</style>
</head>

<body class="is-loading">
	<div class="main">

		<form  name="nuevoviaje" id="nuevoviaje" method="post">
				<!-- proyectos paso 1-->
				<div class="12u 12u(xsmall)" id="m1">
					<label>Paso 1  "Seleccione el o los proyectos"</label>
						<?
							/*buscar los viajes del usuario*/
							$query="SELECT * FROM proyectos";
							$proy=mysql_query($query) or die("La consulta: $query" . mysql_error());
							$c=9;
							while ($resproy=mysql_fetch_assoc($proy))
							{
								$c++;
						?>
							<div class="12u 12u(xsmall)">
								<input type="checkbox" name="check<? echo $resproy['id']?>" id="check<? echo $resproy['id']?>" value="<? echo $resproy['id']?>"><label for="check<? echo $resproy['id']; ?>"><? echo $resproy['nombre']; ?></label>
							</div>
						<?
							}
							//$c=parseInt($c)-1;
						?>
						<input type="hidden" name="maxid" id="maxid" value="<? echo $c;?>">
			</div>

			<!-- campos paso 2 -->
			<div class="10u 12u(xsmall)" id="m2" style="display:none;">
					<label>Paso 2 "Destino y Fechas"</label>

					<!-- destino -->
					<label for="destino">Destino <i class="fa fa-question-circle fa-2x" onclick="Mensaje('destino');"></i></label>
					<input type="text" name="destino" id="destino" list="destino" required>
					<datalist id="destino">
						<?
							$query = "select * from destino order by nombre";
							$result = mysql_query($query) or print("<option value=\"ERROR\">".mysql_error()."</option>");
							while($destino = mysql_fetch_assoc($result)){
						?>
						<option value="<? echo $destino['nombre']?>"><? echo $destino['nombre']?></option>
						<?
						}
						?>
					</datalist>

					<!-- fecha inicio -->
					<label for="inicio">inicio del viaje <i class="fa fa-question-circle fa-2x" onclick="Mensaje('inicio');"></i></label>
					<input type="text" name="inicio" value="<? echo $hoy;?>" id="inicio" class="datepicker" required>

					<!-- fecha final -->
					<label for="fin">fin del viaje <i class="fa fa-question-circle fa-2x" onclick="Mensaje('fin');"></i></label>
					<input type="text" name="fin" value="<? echo $hoy;?>" id="fin" class="datepicker" required>

			</div>

			<!-- paso 3 -->
			<div class="12u 12u(xsmall)" id="m3" style="display:none;">
					<label>Paso 3  "Personas"</label>
				<!--numero de personas-->
				<label for="numper">N&uacute;mero de personas*</label>
				<input type="text" name="numper" id="numper"  required/>

				<!--personas-->
				<label for="descrip">Personas que viajan</label>
				<textarea name="descrip" id="descrip" style="height:50px;">
				</textarea>

				<!--motivo-->
				<label for="motivo">Motivo de viaje</label>
				<textarea name="motivo" id="motivo" style="height:45px;">
				</textarea>
			</div>


		<!-- paso 4 anticipos -->
		<div class="12u 12u(xsmall) table-wrapper" id="m4" style="display:none;">
			<label>Si requieres un anticipo para tu viaje, da click en el (+) y especifica el monto requerido.(Esta no es la comprobación del gasto)</label>
			<i class="fa fa-plus-square fa-2x" id="nuevoanti" onClick="agregarfila()"></i>
			<label>“Caratula de viaje”</label>
			<table><tr><td>Monto</td><td>Concepto</td><td></td></tr></table>
			<table id="tablaanti"><tr><td></td><td></td><td></td></tr><tr><td>
				<label id="totalv">0</label>
			</td><td></td><td></td></tr>
			</table>
			<input type="hidden" name="can" id="can" value="0">
			<input type="hidden" name="monto" id="monto" value="0">
		</div>

			<div class="12u 12u(xsmall)">
				<div style="margin-left:5%;" class='3u 11u(xsmall)'><input style="display:none;" class='button special fit' type='button' name='Atras' id='Atras' value='Atras'/></div>
				<div style="margin-left:5%;" class='3u 11u(xsmall)'><input class='button special fit' type='button' name='Siguiente' id='Siguiente' value='Siguiente'/></div>
				<div style="margin-left:5%;" class='3u 11u(xsmall)'><input style="display:none;" class='button special fit' type='button' name='Guardar' id='Guardar' value='Guardar'/></div>
			</div>

			<div class="12u 12u(xsmall)" id="m5" style="display:none;">
				<img src="images/logogif.gif" alt="" class="cargaimg">
			</div>
		</form>
	</div>

	<!-- Scripts -->
	<script src="assets/js/jquery.scrollex.min.js"></script>
	<script src="assets/js/jquery.scrolly.min.js"></script>
	<script src="assets/js/skel.min.js"></script>
	<script src="assets/js/util.js"></script>
	<script src="assets/js/main.js"></script>
</body>
</html>
