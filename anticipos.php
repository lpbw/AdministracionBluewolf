<?
	session_start();
	include "coneccion.php";
	include "checar_sesion.php";
	include "checar_sesion_admin.php";
	$hoy=date("d-m-Y");
?>
<!DOCTYPE HTML>
<!--
	Massively by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Viáticos</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
		<style>
			input[type=text].sampletext {
    background-color: #FFFFFF;
    border: 2px solid #000000;
   	height:20px;
	color:#000000;
    
}
.img {
    max-width: 100%;
    height: auto;
}
		</style>
		<script>
			function calendario() {
				$(".datepicker").datepicker({ dateFormat: 'yy-mm-dd' });
				
			}
			function ver(idv,ide)
			{
				//alert(idv);
				//alert(ide);
				tablap="<div class='12u 12u(xsmall)' id='tbp'><form name='enviart' id='enviart' method='post'><table><thead><th>proyecto</th><th>cantidad</th></th><th>iva</th><th>fecha</th></thead><tbody id='tb'></tbody></table></form></div>";
				
				input="<div style='margin-top:30px;' class='2u 4u(xsmall)' id='input'><label for='anti'>VIATICO ENVIADO</label><input class=\"sampletext\" type=\"anti\" id=\"anti\" name=\"anti\" /><input class='button special fit' type='submit' name='guardar' id='guardar' value='Enviar' onClick='valiar_anticipo(anti.value)'  style='margin-top:30px;'/></div>";
				btn2="<div class='4u 12u(xsmall)' id='btn2'><input class='button special fit' type='submit' name='guardar' id='guardar' value='Enviar' onClick='validar_gasto("+idv+")' /></div>";
				comentario="<div class='4u 12u(xsmall)' id='com'><label for='comentario'>Comentario Rechazo</label><textarea name='comentario' id='comentario'></textarea></div>";
				btn="<div class='4u 12u(xsmall)' id='btn'><input class='button special fit' type='submit' name='rechazar' id='rechazar' value='rechazar' onClick='rechazar_gasto("+idv+")' /></div>";
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
					
					var info=document.getElementById('informacion2');
					
					info.innerHTML=resultado;
					
					if(ide==1)
					{
					$('#informacion2').append(comentario);//agrega el boton guardar
					$('#informacion2').append(input);//agrega el boton guardar
					//$('#informacion2').append(btn2);//agrega el boton guardar
					}
					if(ide==3)
					{
					$('#informacion2').append(tablap);//agrega el boton guardar
					$('#informacion2').append(comentario);//agrega el boton guardar
					$('#informacion2').append(btn2);//agrega el boton guardar
					$('#informacion2').append(btn);//agrega el boton guardar
					llenar_proyectos(idv);
					}
			    }
		  	}
				
				xmlhttp.open("GET","informacion_viajes.php?idv="+idv+"&ide="+ide+"&val=10",true);
				xmlhttp.send();
				
			}
			
			function valiar_anticipo(valor)
			{
				//alert(valor);
				var idv=document.getElementById('idvia').value;
				//alert(idv);
				var idusu=document.getElementById('idusu'+idv).value;
				var comen=document.getElementById('comentario').value;
				//alert(idusu);
				var parametros = {
							"idv" : idv,
							"anti" : valor,
							"idusu" : idusu,
							"comen" : comen
						};
						$.ajax({
							data:  parametros,
							url:   'informacion_viajes.php?val=11',
							type:  'post',
							beforeSend: function () {
							//$("#informacion").html("Procesando, espere por favor...");
						},
							success:  function (response) {
								//$("#informacion").html(response);
								location.reload();
							}
						});	
			}
			
			function llenar_proyectos(idv)
			{
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
						
						var info=document.getElementById('tb');
						
						info.innerHTML=resultado;
						
						
				    }
				}
				
				xmlhttp.open("GET","informacion_viajes.php?idv="+idv+"&val=12",true);
				xmlhttp.send();
			}
			
			//cambia estatus a 2
			function rechazar_gasto(idv)
			{
				var idusu=document.getElementById('idusu'+idv).value;
				var comentario=document.getElementById('comentario').value;
				//alert(idusu);
				//alert(comentario);
				var fd = new FormData(document.getElementById("enviart"));
						fd.append('idusu',idusu);//fecha gasto.
						fd.append('com',comentario);//num factura.
						
						
						$.ajax({
							data:  fd,
							url:   'informacion_viajes.php?val=13&i=0&idv='+idv,
							type:  'post',
							cache: false,
            				contentType: false,
            				processData: false,
							beforeSend: function () {
							//$("#informacion2").html("Procesando, espere por favor...");
						},
							success:  function (response) {
								//$("#informacion2").html(response);
								location.reload();
							}
						});
			}
			
			//cambia estatus a 4
			function validar_gasto(idv)
			{
				var c=document.getElementById('contador').value;
				var idusu=document.getElementById('idusu'+idv).value;
				var total=document.getElementById('total').value;
				//alert(total);
				if(c!=0)
				{
				c=c-1;
				}
				//alert(c);
				var val="";
				var iv="";
				var fd = new FormData(document.getElementById("enviart"));
				for(i=0;i<=c;i++)
				{
					if(document.getElementById('val'+i))
					{
						val=document.getElementById('val'+i).value;
						fd.append('cant'+i,val);//num factura.
						
					}
					if(document.getElementById('iv'+i))
					{
						iv=document.getElementById('iv'+i).value;
						fd.append('iva'+i,iv);//num factura.
						
					}
					if(document.getElementById('fech'+i))
					{
						fech=document.getElementById('fech'+i).value;
						fd.append('fecha'+i,fech);//fecha gasto.
					}
					if(document.getElementById('id'+i))
					{
						pro=document.getElementById('id'+i).value;
						fd.append('idpv'+i,pro);//num factura.
					}
					
					
					
					
					fd.append('idusu',idusu);//id usu.
					
				}
				fd.append('contador',c);//num factura.
				fd.append('total',total);//num factura.		
						
						$.ajax({
							data:  fd,
							url:   'informacion_viajes.php?val=13&i=1&idv='+idv,
							type:  'post',
							cache: false,
            				contentType: false,
            				processData: false,
							beforeSend: function () {
							//$("#informacion2").html("Procesando, espere por favor...");
						},
							success:  function (response) {
								//$("#informacion2").html(response);
								if(document.getElementById('anticipo'))
								{
									var anticipo=document.getElementById('anticipo').value;
								}
								if(document.getElementById('total'))
								{
									var total=document.getElementById('total').value;
								}
								
								
								if(anticipo>total)
								{
									var a=anticipo-total;
									alert('deverias recibir la cantidad de: '+a);
								}
								if(total>anticipo)
								{
									var a=total-anticipo;
									alert('deverias dar la cantidad de: '+a);
								}
								location.reload();
							}
						});
			}
			
			function buscar_usuario(valor,valor2)
			{
			//alert(valor2);
				$('#tt').empty();
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
						
						var info=document.getElementById('tt');
						
						info.innerHTML=resultado;
						
						
				    }
				}
				
				xmlhttp.open("GET","informacion_viajes.php?val=14&idusu="+valor+"&idest="+valor2,true);
				xmlhttp.send();
			}
			/*calcula el iva de la cantidad */
			function cal_iva(val)
			{
				var cant=document.getElementById('val'+val).value;
				var iva=parseFloat(cant)*0.16;
				document.getElementById('iv'+val).value=iva;
			}
		</script>	
		
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
				
				<nav id="nav">
						<ul class="actions fit">
							<li><a href="menu_admin.php" class="button special fit">Administraci&oacuten</a></li>
							<li><a href="adm_clientes.php" class="button special fit">Clientes</a></li>
							<li><a href="adm_proyectos.php" class="button special fit">Proyectos</a></li>
							<li><a href="buscar_cobros.php" class="button special fit">Facturaci&oacuten</a></li>
							<li><a href="facturas_cobrar.php" class="button special fit">Facturas por Cobrar </a></li>
							<li><a href="gastos.php" class="button special fit">Gastos </a></li>
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
					<div class="box">
						<div class="row uniform">
							<div class="4u 12u(xsmall)"><!--reportes.-->
							<input type="hidden" name="validar" id="validar" value="0">
								<label for="usuarios">Lista De Usuarios</label>
							<select name="usuarios" id="usuarios" onChange="buscar_usuario(this.value,estatus.value)">
								<option value="0">NINGUNO</option>
								<? 
								$queryu="select * from usuarios";
								$resuu=mysql_query($queryu) or die("La consulta: $queryu" . mysql_error());
								
								while($resu=mysql_fetch_assoc($resuu))
									{
								?>
								<option value="<? echo $resu['id'];?>"><? echo $resu['nombre'];?></option>
								<?
									}
								?>
							</select>
							</div>	
							<div class="4u 12u(xsmall)"><!--reportes.-->
								<label for="usuarios">Estatus</label>
							<select name="estatus" id="estatus" onChange="buscar_usuario(usuarios.value,this.value)">
								<option value="0">NINGUNO</option>
								<option value="3">PENDIENTES GASTOS</option>
								<option value="1">PENDIENTES VIATICOS</option>
							</select>
							</div>	
						</div>
						
						<div class="row uniform letra" id="informacion">
							<form name='enviar' id='enviar' method='post'>
								<div class='12u 12u(xsmall) table-wrapper'>
									<table  class='t' id='ta'>
										<thead>
											<th>proyecto</th>
											<th>inicio</th>
											<th>fin</th>
											<th>destino</th>
											<th>#personas</th>
											<th>viajeros</th>
											<th>motivo</th>
											<th>usuario</th>
											<th>estatus</th>
										</thead>
										<tbody id='tt'>
											<? 
								$query1="select date_format(fecha_inicio,'%Y-%m-%d') as inicio,date_format(fecha_fin,'%Y-%m-%d') as fin,id_destino,no_personas,viajeros,motivo,estatus,id_usuario,id from viajes where (estatus=1 or estatus=3)";
				$resquery1=mysql_query($query1) or die("La consulta: $query1" . mysql_error());
				while($res=mysql_fetch_assoc($resquery1))
				{
					$proyecto="";
					$idviaje=$res['id'];
						
						$query2="select p.nombre from proyectos p join proyectos_viajes pv on p.id=pv.id_proyecto where pv.id_viaje='$idviaje'";
						$resquery2=mysql_query($query2) or die("La consulta: $query2" . mysql_error());
						while($res2=mysql_fetch_assoc($resquery2))
						{
						$proyecto=$proyecto." ".$res2['nombre'];
						}
						
					//destino
						$iddes=$res['id_destino'];
						$query3="select * from destino where id='$iddes'";
						$resquery3=mysql_query($query3) or die("La consulta: $query3" . mysql_error());
						$res3=mysql_fetch_assoc($resquery3);
						$destino=$res3['nombre'];
						
						if($res['estatus']==1)
						{
							$estatus="PENDIENTE VIATICOS";
						}
						if($res['estatus']==3)
						{
							$estatus="PENDIENTE GASTOS";
						}
						$idestatus=$res['estatus'];
						$idusu=$res['id_usuario'];
						$query4="select nombre from usuarios where id='$idusu'";
						$resquery4=mysql_query($query4) or die("La consulta: $query4" . mysql_error());
						$res4=mysql_fetch_assoc($resquery4);
						$usuario=$res4['nombre'];
						
						
								?>
									<tr onClick="ver('<? echo $idviaje;?>','<? echo $idestatus;?>');" style="cursor:pointer;"><td><? echo $proyecto;?></td><td><? echo $res['inicio'];?></td><td><? echo $res['fin'];?></td><td><? echo $destino;?></td><td><? echo $res['no_personas'];?></td><td><? echo $res['viajeros'];?></td><td><? echo $res['motivo'];?></td><td><? echo $usuario;?><input type="hidden" name="idusu<?echo $idviaje?>" id="idusu<?echo $idviaje?>" value="<? echo $idusu?>"/></td><td><? echo $estatus;?></td></tr>
								<?
									}
								?>	
										</tbody>
									</table>
								</div>
								
							</form>
						</div>
					</div>	
					
					<div class="row uniform letra" id="informacion2">
					
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
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main2.js"></script>

	</body>
</html>			
