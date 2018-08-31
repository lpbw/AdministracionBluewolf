<?
	session_start();
	include "checar_sesion.php";
	include "checar_sesion_admin.php";
	include "coneccion.php";
	include "SimpleImage.php";
	$id_e=$_GET["id_e"];
	$tipo=$_SESSION['idA'];
	$hoy=date("Y-m-d");
	$idU=$_SESSION['idU'];

?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Viajes</title>
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
@media screen and (max-width: 480px) {
div.l{margin-top:18%;}
}
		</style>
		<script>
			function calendario() {
				$("#fecha_inicio").datepicker({ dateFormat: 'yy-mm-dd' });
				$("#fecha_fin").datepicker({ dateFormat: 'yy-mm-dd' });
				$("#fecha_gasto").datepicker({ dateFormat: 'yy-mm-dd' });
				$("#inicio").datepicker({ dateFormat: 'yy-mm-dd' });
				$("#fin").datepicker({ dateFormat: 'yy-mm-dd' });
			}
			//buscar en el archivo buscar.php
			function buscar(idv,idu)
			{
				$("#informacion2").empty();
				document.getElementById('validar').value="0";
				if(idv!=0){
			//alert('entro a buscar');
			//alert('idv'+idv);
			//alert('idu'+idu);
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

					var info=document.getElementById('informacion');

					info.innerHTML=resultado;
					var esta=document.getElementById('esta').value;

					switch(esta)
					{
						case "2":
							agregar_gasto(idv);
								$('#enviar3').remove();//agrega el form enviar
				$('#ta').remove();//agrega el input fecha del gasto
				$('#nuevogasto').remove();//agrega el input fecha del gasto
				$('#parcial').remove();//agrega el input fecha del gasto
				$('#todo').remove();//agrega el input fecha del gasto
				document.getElementById('validart').value="0";
								buscar_gastos(idv);

						break;

						case "3":
						agregar_gasto(idv);
							$('#enviar3').remove();//agrega el form enviar
				$('#ta').remove();//agrega el input fecha del gasto
				$('#nuevogasto').remove();//agrega el input fecha del gasto
				$('#parcial').remove();//agrega el input fecha del gasto
				$('#todo').remove();//agrega el input fecha del gasto
				document.getElementById('validart').value="0";
								buscar_gastos(idv);

						break;
					}
			    }
		  	}

				xmlhttp.open("GET","informacion_viajes.php?idv="+idv+"&idu="+idu+"&val=1",true);
				xmlhttp.send();
				//document.getElementById("detalles").style.display = "inline";


				}
				else
				{
					$("#informacion").empty();
				}

			}
			// fin buscar en el archivo buscar.php



			/*funcion para agregar un nuevo gasto*/
			function agregar_gasto()
			{
				var val=document.getElementById('validar').value;
				if(val==0){
				form="<form name='enviar' id='enviar' method='post'  enctype='multipart/form-data'></form>";
				//crea el input fecha gasto
				fecha_gasto="<div class='4u 12u(xsmall)' id='1'><label for='fecha_gasto' id='fgasto'>Fecha del Gasto</label><input name='fecha_gasto' id='fecha_gasto' type='text' class='datepicker' required='true'/></div>";

				//crea el select de tipo de gasto
				tipo_gasto="<div class='4u 12u(xsmall)' id='2'><label for='tipogasto'>Tipo de Gasto</label><select name='tipogasto' id='tipogasto'><? $query="select * from viaticos"; $resultado=mysql_query($query) or die("La consulta: $query" . mysql_error()); while ($res=mysql_fetch_assoc($resultado)){?><option value='<? echo $res['id'] ?>'><? echo $res['concepto'] ?></option><? }?> </select>";

				num_factura="<div class='4u 12u(xsmall)' id='3'><label for='num_factura'>Numero de factura</label><input name='num_factura' id='num_factura' type='text'/></div>";

				descripcion="<div class='4u 12u(xsmall)' id='4'><label for='desc'>Descripcion</label><textarea rows='1' name='desc' id='desc' style='height:45px;' required></textarea></div>";

				subtotal="<div class='4u 12u(xsmall)' id='5'><label for='subtotal'>subtotal</label><input name='subtotal' id='subtotal' type='text' onchange='calcular_total()'/></div>";

				tipo_impuesto="<div class='4u 12u(xsmall)' id='6'><label for='tipo_impuesto'>Impuesto</label><select name='tipo_impuesto' id='tipo_impuesto'  onchange='calcular_total()'><option value='0'>SELECCIONE TIPO DE IMPUESTO</option><option value='1'>IVA</option><option value='2'>HOSPEDAJE</option><option value='3'>ISR</option></select></div>";

				total="<div class='4u 12u(xsmall)' id='7'><label for='menos' id='men' style='display:none;'>IVA</label><input name='menos' id='menos' type='hidden' onchange='calcular_isr()'/><input name='iva' id='iva' type='hidden'/><label for='total'>total</label><input name='total' id='total' type='text'/><input name='iva' id='iva' type='hidden'/></div>";

				foto="<div class='2u 12u(xsmall)' id='8'><input class='inputfile' type='file'  name='foto' id='foto' onchange='color(1)'/><label id='ff' for='foto'><i class='fa fa-camera fa-2x' aria-hidden='true'></i></label></div>";

				pdf="<div class='2u 12u(xsmall)' id='9'><input class='inputfile' type='file'  name='pdf' id='pdf' onchange='color(2)'/><label id='pp' for='pdf'><i class='fa fa-file-pdf-o fa-2x' aria-hidden='true'></i></label></div>";

				xml="<div class='2u 12u(xsmall)' id='10'><input class='inputfile' type='file'  name='xml' id='xml' onchange='color(3)'/><label id='xx' for='xml'><i class='fa fa-file fa-2x' aria-hidden='true'></i></label></div>";

				btn="<div style='margin-top:30px;' class='6u 12u(xsmall)' id='btn'><input class='button special fit' type='submit' name='guardar' id='guardar' value='Agregar' onClick='insertar_gasto(misviajes.value)'/></div>"

				$('#informacion2').append(form);//agrega el form enviar
				$('#informacion2').append(fecha_gasto);//agrega el input fecha del gasto
				$('#informacion2').append(tipo_gasto);//agrega el input tipo de gasto
				$('#informacion2').append(num_factura);//agrega el input numero de factura
				$('#informacion2').append(descripcion);//agrega el textarea descripcion
				$('#informacion2').append(subtotal);//agrega el input subtotal
				$('#informacion2').append(tipo_impuesto);//agrega el select tipo_impuesto
				$('#informacion2').append(total);//agrega el input total
				$('#informacion2').append(foto);//agrega el input foto
				$('#informacion2').append(pdf);//agrega el input pdf
				$('#informacion2').append(xml);//agrega el input xml
				$('#informacion2').append(btn);//agrega el boton guardar
				calendario();
				document.getElementById('validar').value="1";
				}
				else
				{
				$('#enviar').remove();//agrega el form enviar
				$('#1').remove();//agrega el input fecha del gasto
				$('#2').remove();//agrega el input tipo de gasto
				$('#3').remove();//agrega el input numero de factura
				$('#4').remove();//agrega el textarea descripcion
				$('#5').remove();//agrega el input subtotal
				$('#6').remove();//agrega el select tipo_impuesto
				$('#7').remove();//agrega el input total
				$('#8').remove();//agrega el input foto
				$('#9').remove();//agrega el input pdf
				$('#10').remove();//agrega el input xml
				$('#guardar').remove();//agrega el boton guardar
				document.getElementById('validar').value="0";
				}
			}
			/*************************************/
			function color(num)
			{
				if(num==1)
				{
					if(document.getElementById('foto').value!="")
					{
						document.getElementById('ff').style.color="#00FF40";
					}
				}
				if(num==2)
				{
					if(document.getElementById('pdf').value!="")
					{
						document.getElementById('pp').style.color="#00FF40";
					}
				}
				if(num==3)
				{
					if(document.getElementById('xml').value!="")
					{
						document.getElementById('xx').style.color="#00FF40";
					}
				}

			}
			/*funcion para agregar campos de nuevo viaje*/
			function agregar_viaje()
			{
				var val=document.getElementById('validar').value;
				document.getElementById('can').value="0";
				if(val==0)
				{
				form="<form name='enviar2' id='enviar2' method='post' action='informacion_viajes.php?val=4' enctype='multipart/form-data'></form>";
				row="<div class='row uniform'></div>";
				proyecto="<div class='12u 12u(xsmall)' style='height:150px;overflow:scroll;margin-top:-5%;'><!--proyecto--><label for='proyecto'>seleccione Proyecto</label><table class='t'><thead><th>proyecto</th><th>seleccionar</th></thead><tbody><? $query="select * from proyectos";$res=mysql_query($query) or die("La consulta: $query" . mysql_error());$c=9;
while ($resul=mysql_fetch_assoc($res)){$c++; ?><tr><td><? echo $resul['nombre']?></td><td><input type='checkbox' name='check<? echo $resul['id']?>' id='check<? echo $resul['id']?>' value='<? echo $resul['id']?>'><label for='check<? echo $resul['id']; ?>'></label></td></tr><? } ?></tbody></table><input type='hidden' name='maxid' id='maxid' value='<? echo $c;?>'></div><!--fin proyecto-->";

				destino="<div class='4u 12u(xsmall)' style='height: 10px;'><!--destino--><label for='destino'>Destino*</label><input class='upper' list='destino' name='destino' id='dest' type='text' onChange='' required><datalist id='destino'><?	$query = "select * from destino order by nombre";$result = mysql_query($query) or print("<option value=\"ERROR\">".mysql_error()."</option>");while($destino = mysql_fetch_assoc($result)){?><option value='<? echo $destino['nombre']?>'  ><? echo $destino['nombre']?></option><?}?></datalist></div>";

				fecha_inicio="<div class='4u 12u(xsmall) l' style='height: 10px;'><!--fecha inicio--><label for='inicio'>Fecha Inicio*</label><input class='datepicker' type='text' name='inicio' id='inicio' value='' required/></div>";

				fecha_fin="<div class='4u 12u(xsmall) l'><!--fecha fin--><label for='fin'>Fecha fin*</label><input class='datepicker' type='text' name='fin' id='fin' value=''  required/></div>";

				num_personas="<div class='4u 12u(xsmall)'><!--numero de personas--><label for='numper'>N&uacute;mero de personas*</label><input type='text' name='numper' id='numper'  required/></div>";

				personas="<div class='4u 12u(xsmall)'><!--personas--><label for='descrip'>Personas que viajan</label><textarea class='upper' name='descrip' id='descrip' style='height:50px;'></textarea></div>";

				motivo="<div class='4u 12u(xsmall)'><!--motivo--><label for='motivo'>Motivo de viaje</label><textarea class='upper' name='motivo' id='motivo' style='height:45px;'></textarea></div>";

				tabla="<div class='8u 12u(xsmall) table-wrapper'><label>Si requieres un anticipo para tu viaje da click en el (+) y especifica el monto requerido.(Esta no es la comprobación del gasto)</label><i class='fa fa-plus-square fa-2x' id='nuevoanti' onClick='agregarfila()'></i><label>“Caratula de viaje”</label><table><tr><td>Monto</td><td>Concepto</td><td></td></tr></table><table id='tablaanti'><tr><td></td><td></td><td></td></tr><tr><td><label id='totalv'>0</label></td><td></td><td></td></tr></table></div>";

				btn="<div style='margin-top:30px; ' class='6u 12u(xsmall)' id='btn'><input class='button special fit' type='submit' name='guardar' id='guardar' value='Guardar' onClick='insertar_viaje(<? echo $idU?>)'/><label>Para comprobar los gastos de un viaje selecciónalo del listado de viajes en el apartado de “En Curso”</label></div>"

				//div="<div class='12u 12u(xsmall)'></div>";

				$('#informacion').append(form);//agrega el form enviar2
				//$('#informacion').append(row);//agrega el input destino
				$('#informacion').append(proyecto);//agrega el select proyecto
				//$('#informacion').append(row);//agrega el input destino
				$('#informacion').append(destino);//agrega el input destino
				$('#informacion').append(fecha_inicio);//agrega el input fecha_inicio
				$('#informacion').append(fecha_fin);//agrega el input fecha_inicio
				$('#informacion').append(num_personas);//agrega el input numero de personas
				$('#informacion').append(personas);//agrega el textarea personas
				$('#informacion').append(motivo);//agrega el textarea motivo
				$('#informacion').append(tabla);//agrega la tabla
				$('#informacion').append(btn);//agrega la tabla
				document.getElementById('validar').value="1";
				calendario();
				}
				else
				{
				$("#informacion").empty();
				document.getElementById('validar').value="0";
				}
			}
			/********************************************/
			/*funcion insertar nuevo gasto*/
			function insertar_gasto(idv)
			{
			//alert('entro');
			//alert('idv'+idv);
			var foto=document.getElementById('foto').value;
			var pdf=document.getElementById('pdf').value;
			var xml=document.getElementById('xml').value;
			var fgasto=document.getElementById('fecha_gasto').value;
			var tgasto=document.getElementById('tipogasto').value;
			var nfactura=document.getElementById('num_factura').value;
			var desc=document.getElementById('desc').value;
			var subtotal=document.getElementById('subtotal').value;
			var timpuesto=document.getElementById('tipo_impuesto').value;
			var total=document.getElementById('total').value;
			var iva=document.getElementById('iva').value;
			var permitidaf=true;
			var permitidap=true;
			var permitidax=true;

			//alert(foto);
			if(fgasto!="" && tgasto!="" && desc!="")
			{
			//valida la extencion de la imagen
			if(foto!="")
			{
				var fotos = $("#foto")[0].files[0];
				var fotonombre=fotos.name;
				//alert(fotonombre);
				var permitidas_foto = new Array("gif", "jpg", "jpeg", "png");
				var extension_foto = fotonombre.substring(fotonombre.lastIndexOf(".")+1);
				//alert(extension_foto);
				 permitidaf = false;
      				for (var i = 0; i < permitidas_foto.length; i++)
					{
					 	if (permitidas_foto[i] == extension_foto)
						{
					 		permitidaf = true;
					 		break;
					 	}
      				}
			}

			//valilda la extencion del archivo pdf
			if(pdf!="")
			{
				var extension_pdf = (pdf.substring(pdf.lastIndexOf("."))).toLowerCase();
				permitidap = false;
					if (extension_pdf==".pdf")
					{
					 	permitidap = true;

					 }
			}

			//valida la extencion xml
			if(xml!="")
			{
				var extension_xml = (xml.substring(xml.lastIndexOf("."))).toLowerCase();
				permitidax = false;
					if (extension_xml==".xml")
					{
					 	permitidax = true;

					 }
			}

      		if (permitidaf==true && permitidap==true && permitidax==true)
			{
				if(foto=="" && pdf=="" && xml=="")
				{
					var r = confirm("No ha seleccionado ningun archivo desea continuar?");
					if(r==true)
					{
						var fd = new FormData(document.getElementById("enviar"));
						fd.append('fgasto',fgasto);//fecha gasto.
						fd.append('tgasto',tgasto);//tipo gasto.
						fd.append('nfac',nfactura);//num factura.
						fd.append('desc',desc);//descripcion.
						fd.append('sub',subtotal);//subtotal.
						fd.append('imp',timpuesto);//impuesto.
						fd.append('total',total);//total.
						fd.append('iva',iva);//iva.

						$.ajax({
							data:  fd,
							url:   'informacion_viajes.php?val=2&idv='+idv,
							type:  'post',
							cache: false,
            				contentType: false,
            				processData: false,
							beforeSend: function () {
							//$("#informacion2").html("Procesando, espere por favor...");
						},
							success:  function (response) {
								//$("#informacion2").html(response);
								alert('Gasto agregado');
								$('#enviar3').remove();//agrega el form enviar
								$('#t10').remove();
								$('#btn11').remove();
								if(document.getElementById('btn12'))
								{
								$('#btn12').remove();
								}
				$('#ta').remove();//agrega el input fecha del gasto
				$('#nuevogasto').remove();//agrega el input fecha del gasto
				$('#parcial').remove();//agrega el input fecha del gasto
				$('#todo').remove();//agrega el input fecha del gasto
				$('#mensaje').remove();
				$('#mensaje2').remove();
				$('#sstot').remove();
				$('#totvia').remove();
				//$('#t10').remove();
				//
				//$('#btn12').remove();

				document.getElementById('validart').value="0";

				document.getElementById('foto').value="";
				document.getElementById('pdf').value="";
				document.getElementById('xml').value="";
				document.getElementById('fecha_gasto').value="";
				document.getElementById('tipogasto').value="";
				document.getElementById('num_factura').value="";
				document.getElementById('desc').value="";
				document.getElementById('subtotal').value="";
				document.getElementById('tipo_impuesto').value="";
				document.getElementById('total').value="";
				document.getElementById('iva').value="";
								buscar_gastos(idv);
							}
						});
					}

					//buscar_gastos(idv);
			document.getElementById('validar').value="0";
				}
				else
				{
				var fd = new FormData(document.getElementById("enviar"));
					fd.append('foto',$("#foto").prop('files')[0]);
					fd.append('pdf',$("#pdf").prop('files')[0]);
					fd.append('xml',$("#xml").prop('files')[0]);

					fd.append('fgasto',fgasto);//fecha gasto.
						fd.append('tgasto',tgasto);//tipo gasto.
						fd.append('nfac',nfactura);//num factura.
						fd.append('desc',desc);//descripcion.
						fd.append('sub',subtotal);//subtotal.
						fd.append('imp',timpuesto);//impuesto.
						fd.append('total',total);//total.
						fd.append('iva',iva);//iva.

						$.ajax({
							url:   'informacion_viajes.php?val=2&idv='+idv,
							type:  'post',
							dataType: "html",
							data: fd,
							cache: false,
            				contentType: false,
            				processData: false,
							beforeSend: function () {
							//$("#informacion2").html("Procesando, espere por favor...");
						},
							success:  function (response) {
								//$("#informacion2").html(response);
								alert('Gasto agregado');
								$('#enviar3').remove();//agrega el form enviar
								$('#t10').remove();
								$('#btn11').remove();
								if(document.getElementById('btn12'))
								{
								$('#btn12').remove();
								}
				$('#ta').remove();//agrega el input fecha del gasto
				$('#nuevogasto').remove();//agrega el input fecha del gasto
				$('#parcial').remove();//agrega el input fecha del gasto
				$('#todo').remove();//agrega el input fecha del gasto
				$('#mensaje').remove();
				$('#mensaje2').remove();
				$('#sstot').remove();
				$('#totvia').remove();
				//
				//$('#btn11').remove();
				//$('#btn12').remove();
				document.getElementById('validart').value="0";

				document.getElementById('foto').value="";
				document.getElementById('pdf').value="";
				document.getElementById('xml').value="";
				document.getElementById('fecha_gasto').value="";
				document.getElementById('tipogasto').value="";
				document.getElementById('num_factura').value="";
				document.getElementById('desc').value="";
				document.getElementById('subtotal').value="";
				document.getElementById('tipo_impuesto').value="";
				document.getElementById('total').value="";
				document.getElementById('iva').value="";
								buscar_gastos(idv);
							}
						});

				}

				//buscar_gastos(idv);
			document.getElementById('validar').value="0";
			}
			else
			{
				if(permitidaf==false)
				{
					alert('no tiene extencion de imagen valida( gif, jpg, jpeg, png)');
					document.getElementById('foto').value="";
				}
				else if(permitidap==false)
				{
					alert('necesita extencion pdf');
					document.getElementById('pdf').value="";
				}
				else if(permitidax==false)
				{
					alert('necesita extencion xml');
					document.getElementById('xml').value="";
				}
			}
		}
		else
		{
					if(fgasto=="")
					{
						alert('Porfavor llena el campo de fecha de gasto');
					}
					else if(tgasto=="")
					{
						alert('Porfavor llena el campo tipo de gasto');
					}
					else if(desc=="")
					{
						alert('Porfavor llena el campo de descripcion');
					}
		}

	}
			/*****************************/

			//calcula total segun subtotal e iva///
			function calcular_total()
			{

				var subtotal=document.getElementById('subtotal').value;
				var tipo=document.getElementById('tipo_impuesto').value;

				var caliva=0;
				//alert('subtotal'+subtotal);
				//alert('impuesto'+tipo);
				if(subtotal!="0")
				{

					switch(tipo)
					{
						case "0":
						document.getElementById('men').style.display='none';
						document.getElementById('menos').type='hidden';
						document.getElementById('total').value="0";
						break;

						case "1"://cuando es iva
						document.getElementById('men').style.display='none';
						document.getElementById('menos').type='hidden';
						caliva=parseFloat(subtotal)*0.16;
						var total=parseFloat(caliva)+parseFloat(subtotal);
						total = Math.round(total*Math.pow(10,4))/Math.pow(10,4);//redondea a cuatro decimales
						document.getElementById('total').value=total;
						document.getElementById('iva').value=caliva;
						break;

						case "2"://hospedaje
						document.getElementById('men').style.display='none';
						document.getElementById('menos').type='hidden';
						caliva=parseFloat(subtotal)*0.20;
						var total=parseFloat(caliva)+parseFloat(subtotal);
						total = Math.round(total*Math.pow(10,4))/Math.pow(10,4);//redondea a cuatro decimales
						document.getElementById('total').value=total;
						document.getElementById('iva').value=caliva;
						break;

						case "3"://isr

						document.getElementById('men').style.display='block';
						document.getElementById('menos').type='text';
						break;
					}

				}


			}
			/****************************************************/
			function calcular_isr()
			{
				var subtotal=document.getElementById('subtotal').value;
				var menos=document.getElementById('menos').value;
				var total=parseFloat(subtotal)-parseFloat(menos);
				document.getElementById('total').value=total;
				document.getElementById('iva').value=menos;
			}


			/*busca los gastos del viaje*/
			function buscar_gastos(idv)
			{
				//alert(idv);
				var val=document.getElementById('validart').value;
				if(val==0)
				{
				form3="<form name='enviar3' id='enviar3' method='post'  enctype='multipart/form-data'></form>";
				//icon="<i class='fa fa-plus-square fa-2x' id='nuevogasto' onClick='agregar_gasto()' style='margin-left:90%;'></i>";
				tabla3="<div class='12u 12u(xsmall) table-wrapper' id='t10'><table  class='t' id='ta'><thead><th>fecha gasto</th><th>foto</th><th>pdf</th><th>xml</th><th>#factura</th><th>tipo gasto</th><th>descripcion</th><th>subtotal</th><th>impuesto</th><th>total</th><th id='tu'>EDITAR</th></thead><tbody id='tt'></tbody></table><label id='mensaje'>Total Gastos:</label> <label id='sstot'>0</label><label id='mensaje2'>Total Viaticos:</label> <label id='totvia'>0</label></div>";
				btn="<div style='margin-top:30px;' class='6u 12u(xsmall)' id='btn11'><input class='button special fit' type='submit' name='parcial' id='parcial' value='Guardar' onClick='guardar_cambiogastos()'/></div>"
				btn2="<div style='margin-top:30px;' class='6u 12u(xsmall)' id='btn12'><input class='button special fit' type='submit' name='todo' id='todo' value='Guardar y Enviar' onClick='guardar_enviar(misviajes.value)'/></div>"

				$('#informacion2').append(form3);//agrega el form enviar2
				//$('#informacion2').append(icon);//agrega el form enviar2
				$('#informacion2').append(tabla3);//agrega el form enviar2

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
					resultado3=xmlhttp.responseText;

					var info3=document.getElementById('tt');

					info3.innerHTML=resultado3;
					var con=document.getElementById('contador').value;
					var a=document.getElementById('a').value;//foto
					var b=document.getElementById('b').value;
					var c=document.getElementById('c').value;
					var d=document.getElementById('d').value;
					var e=document.getElementById('e').value;
					var f=document.getElementById('f').value;
					var g=document.getElementById('g').value;
					var est=document.getElementById('est').value;
					var sumtot=document.getElementById('sumt').value;
					var sumv=document.getElementById('sumv').value;
				//alert(sumtot);
				var ss=document.getElementById('sstot');
				var totvia=document.getElementById('totvia');
				ss.innerHTML=sumtot;
				totvia.innerHTML=sumv;
				//alert('a='+a+'b='+b+'c='+c+'d='+d+'e='+e+' f='+f+' g='+g);
				//alert(con);
				if(est==2)
				{
					$('#informacion2').append(btn);//agrega el form enviar2
					if(con!=0)
					{
						if(b==con && c==con && d==con && e==con && f==con && g==con)
						{
							$('#informacion2').append(btn2);//agrega el form enviar2
						}
					}

				}
				if(est==3)
				{
				$('#tu').remove();//agrega el form enviar2
					$('#enviar').remove();//agrega el form enviar
				$('#1').remove();//agrega el input fecha del gasto
				$('#2').remove();//agrega el input tipo de gasto
				$('#3').remove();//agrega el input numero de factura
				$('#4').remove();//agrega el textarea descripcion
				$('#5').remove();//agrega el input subtotal
				$('#6').remove();//agrega el select tipo_impuesto
				$('#7').remove();//agrega el input total
				$('#8').remove();//agrega el input foto
				$('#9').remove();//agrega el input pdf
				$('#10').remove();//agrega el input xml
				$('#guardar').remove();//agrega el boton guardar
				$('#mensaje').remove();
				$('#mensaje2').remove();
				$('#sstot').remove();
				$('#totvia').remove();
				//buscar_gastos();
				}

			    }

		  	}

				xmlhttp.open("GET","informacion_viajes.php?idv="+idv+"&val=6",true);
				xmlhttp.send();
				document.getElementById('validart').value="1";

				}
				else
				{
				$('#enviar3').remove();//agrega el form enviar
				$('#ta').remove();//agrega el input fecha del gasto
				$('#nuevogasto').remove();//agrega el input fecha del gasto
				$('#parcial').remove();//agrega el input fecha del gasto
				$('#todo').remove();//agrega el input fecha del gasto
				document.getElementById('validart').value="0";
				}

			}
			/*********************************/

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
				y.innerHTML="<center><input name='m[]' id='m"+c+"' type='text' value='' class='sampletext' onchange='totalv(this.value)'/></center>";
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

			/*insertar nuevo viaje*******************/
			function insertar_viaje(idu)
			{
			//alert('idusuario'+idu);
			var maxid=document.getElementById('maxid').value-1;
			var dest=document.getElementById('dest').value;
			var inicio=document.getElementById('inicio').value;
			var fin=document.getElementById('fin').value;
			var nper=document.getElementById('numper').value;
			var descrip=document.getElementById('descrip').value;
			var motivo=document.getElementById('motivo').value;

			var c=document.getElementById('can').value;
			//alert(maxid);
			var flag=0;
			var co=0;
			var idproyectos=[];
			for(x=9;x<=maxid;x++)
			{
				if(document.getElementById('check'+x).checked)
				{
					//alert('seleccionado: '+x);
					flag=1;
					idproyectos[co]=x;
					co++;
				}
			}
			if(flag==1)
			{
				co=co-1;
				//alert('co: '+co);
				for(y=0;y<=co;y++)
				{
					//alert('proyecto: '+idproyectos[y]);
				}
			}
			if(flag==0)
			{
				idproyectos=0;
			}
			c=parseInt(c);
			/*if(c>1){
				c=parseInt(c)-1;
			}*/

			//alert(c);

			if(c>=1)
			{
			var montos=[];
			var idviaticos=[];
			c=parseInt(c)-1;
			for (i=0;i<=c;i++)
			{
				var monto=document.getElementById('m'+i).value;
				var idviatico=document.getElementById('a'+i).value;
				//alert('monto: '+monto+' id viatico: '+idviatico);
				montos[i]=monto;
				idviaticos[i]=idviatico;
			}
				if(dest!="" && inicio!="" && fin!="" && nper!="")
				{
						var parametros = {
							"pro" : idproyectos,
							"dest" : dest,
							"inicio" : inicio,
							"fin" : fin,
							"nper" : nper,
							"descrip" : descrip,
							"motivo" : motivo,
							"montos" : montos,
							"idviaticos" : idviaticos
						};
						$.ajax({
							data:  parametros,
							url:   'informacion_viajes.php?val=4&idu='+idu,
							type:  'post',
							beforeSend: function () {
							$("#informacion").html("Procesando, espere por favor...");
						},
							success:  function (response) {
								$("#informacion").html(response);
								location.reload();
							}
						});
						document.getElementById('validar').value="0";

					}
					else
					{
						if(dest=="")
						{
							alert('porfavor llene el campo de destino');
						}
						else if(inicio=="")
						{
							alert('porfavor seleccione la fecha de inicio de su viaje');
						}
						else if(fin=="")
						{
							alert('porfavor seleccione la fecha final de su viaje');
						}
						else if(nper=="")
						{
							alert('porfavor llene el campo de numero de personas');
						}
					}
			}
			else
			{
				if(dest!="" && inicio!="" && fin!="" && nper!="")
				{
							var parametros = {
								"pro" : idproyectos,
								"dest" : dest,
								"inicio" : inicio,
								"fin" : fin,
								"nper" : nper,
								"descrip" : descrip,
								"motivo" : motivo
							};
							$.ajax({
								data:  parametros,
								url:   'informacion_viajes.php?val=5&idu='+idu,
								type:  'post',
								beforeSend: function () {
								$("#informacion").html("Procesando, espere por favor...");
							},
								success:  function (response) {
									$("#informacion").html(response);
									location.reload();
								}
							});
				document.getElementById('validar').value="0";

				}
				else
				{
					if(dest=="")
					{
						alert('porfavor llene el campo de destino');
					}
					else if(inicio=="")
					{
						alert('porfavor seleccione la fecha de inicio de su viaje');
					}
					else if(fin=="")
					{
						alert('porfavor seleccione la fecha final de su viaje');
					}
					else if(nper=="")
					{
						alert('porfavor llene el campo de numero de personas');
					}
				}
			}
	}
			/***************************************/

			/*******calcula el total de cada fila***/
			function calcular_totalg(id)
			{
				//alert(id);
				var subt=document.getElementById('sub'+id).value;
				var impuesto=document.getElementById('imp'+id).value;
				var caliva=0;
				//alert(subt);
				//alert(impuesto);

				if(subt!="0")
				{

					switch(impuesto)
					{
						case "0":
						var t=document.getElementById('totv'+id);
						t.innerHTML="0";
						document.getElementById('tot'+id).value="0";
						break;

						case "1"://cuando es iva
							document.getElementById('meno'+id).type='hidden';
							caliva=parseFloat(subt)*0.16;
							var total=parseFloat(caliva)+parseFloat(subt);
							total = Math.round(total*Math.pow(10,4))/Math.pow(10,4);//redondea a cuatro decimales
							document.getElementById('tot'+id).value=total;
							document.getElementById('iv'+id).value=caliva;
							var t=document.getElementById('totv'+id);
							t.innerHTML=total;
						break;

						case "2"://hospedaje
							document.getElementById('meno'+id).type='hidden';
							caliva=parseFloat(subt)*0.19;
							var total=parseFloat(caliva)+parseFloat(subt);
							total = Math.round(total*Math.pow(10,4))/Math.pow(10,4);//redondea a cuatro decimales
							document.getElementById('tot'+id).value=total;
							document.getElementById('iv'+id).value=caliva;
							var t=document.getElementById('totv'+id);
							t.innerHTML=total;
						break;

						case "3"://isr
							document.getElementById('meno'+id).type='text';
						break;
					}

				}
			}
			/*****************************************/

				function calcular_isrt(id)
				{
					var subt=document.getElementById('sub'+id).value;
					var meno=document.getElementById('meno'+id).value;
					var total=parseFloat(subt)-parseFloat(meno);
					document.getElementById('tot'+id).value=total;
					document.getElementById('iv'+id).value=meno;
					var t=document.getElementById('totv'+id);
					t.innerHTML=total;
				}

				function guardar_cambiogastos()
				{
					var contador=document.getElementById('contador').value;
					//alert(contador);
					contador=contador-1;
					//alert(contador);
					var fd = new FormData(document.getElementById("enviar3"));
					var nf="";
					var sub="";
					var imp="";
					var iva="";
					var total="";var ed="";
					for(i=0;i<=contador;i++)
					{
						ed=document.getElementById('edit'+i).value;
						if(ed==1){
						fd.append('foto'+i,$("#fo"+i).prop('files')[0]);
						fd.append('pdf'+i,$("#p"+i).prop('files')[0]);
						fd.append('xml'+i,$("#x"+i).prop('files')[0]);
						nf=document.getElementById('numerofactura'+i).value;
						sub=document.getElementById('sub'+i).value;
						imp=document.getElementById('imp'+i).value;
						//alert(imp);
						if(document.getElementById('iv'+i))
						{
							iva=document.getElementById('iv'+i).value;
							fd.append('iva'+i,iva);
						}
						if(imp==0 && iva!="")
						{
							imp=document.getElementById('i'+i).value;
						}
						total=document.getElementById('tot'+i).value;
						idgv=document.getElementById('idgv'+i).value;
						fd.append('nf'+i,nf);
						fd.append('sub'+i,sub);
						fd.append('imp'+i,imp);
						fd.append('tot'+i,total);
						fd.append('idgv'+i,idgv);
						}
					}
					fd.append('contador',contador);

						$.ajax({
							url:   'informacion_viajes.php?val=7',
							type:  'post',
							dataType: "html",
							data: fd,
							cache: false,
            				contentType: false,
            				processData: false,
							beforeSend: function () {
							//$("#informacion2").html("Procesando, espere por favor...");
						},
							success:  function (response) {
								//$("#informacion2").html(response);
								alert('Datos Guardados Con Exito!!!');
								$('#enviar3').remove();//agrega el form enviar
				$('#ta').remove();//agrega el input fecha del gasto
				$('#nuevogasto').remove();//agrega el input fecha del gasto
				$('#parcial').remove();//agrega el input fecha del gasto
				$('#todo').remove();//agrega el input fecha del gasto
				$('#mensaje').remove();
				$('#mensaje2').remove();
				$('#sstot').remove();
				$('#totvia').remove();
				$('#t10').remove();
				$('#btn11').remove();
				$('#btn12').remove();
				document.getElementById('validart').value="0";
								var idv=document.getElementById('misviajes').value;
								 buscar_gastos(idv);
							}
						});
				}

				function guardar_enviar(idv)
				{
					//alert(idv);
					var idu=document.getElementById('idu').value;
					//alert(idu);
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
					location.reload();

			    }

		  	}

				xmlhttp.open("GET","informacion_viajes.php?idv="+idv+"&idu="+idu+"&val=8",true);
				xmlhttp.send();

				}

				//editar gastos
				function editar_gastos(id)
				{
					//alert(id);
					var ed=document.getElementById('edit'+id).value;
						if(ed==0)
						{
							document.getElementById('edit'+id).value='1';
							document.getElementById('numerofactura'+id).type='text';
							document.getElementById('sub'+id).type='text';
							document.getElementById('imp'+id).style.display='block';
							document.getElementById('fo'+id).disabled=false;
							document.getElementById('p'+id).disabled=false;
							document.getElementById('x'+id).disabled=false;
						}
						else
						{
							document.getElementById('edit'+id).value='0';
							document.getElementById('numerofactura'+id).type='hidden';
							document.getElementById('sub'+id).type='hidden';
							document.getElementById('imp'+id).style.display='none';
							document.getElementById('fo'+id).disabled=true;
							document.getElementById('p'+id).disabled=true;
							document.getElementById('x'+id).disabled=true;
						}
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
					<div class="row uniform"><!--row uniform 1-->
					<input type="hidden" name="idu" id="idu" value="<?echo $idU;?>" >
					<input type="hidden" name="validar" id="validar" value="0">
					<input type="hidden" name="validart" id="validart" value="0">
					<input type="hidden" name="can" id="can" value="0">
					<input type="hidden" name="monto" id="monto" value="0">
						<div class="6u 12u(xsmall)"><!--row uniform 1 div 1-->
							<!--select que contiene todos los viajes echos del usuario logiado actualmente.-->
							<label>Lista De Viajes<i class="fa fa-plus-square fa-2x" id="nuevoviaje" onClick="agregar_viaje()" style="margin-left:50%;"></i></label>
							<select name="misviajes" id="misviajes" onChange="buscar(this.value,<? echo $idU;?>)">
								<option value="0">NINGUNO</option>
								<optgroup label="PENDIENTES DE APROVAR VIATICOS">
								<?
									/*buscar los viajes del usuario*/
									$qviajes="SELECT v.id,d.nombre,DATE_FORMAT(v.fecha_inicio,'%Y-%m-%d') as finicio FROM viajes v JOIN destino d ON v.id_destino=d.id WHERE id_usuario='$idU' AND estatus=1";
									$rviajes=mysql_query($qviajes) or die("La consulta: $qviajes" . mysql_error());
									while ($resviajes=mysql_fetch_assoc($rviajes))
									{
								?>
									<option value="<? echo $resviajes['id'];?>"><? echo $resviajes['nombre']."(".$resviajes['finicio'].")";?></option>
								<?
									}
								?>
								</optgroup>

								<optgroup label="EN CURSO">
								<?
									/*buscar los viajes del usuario en curso*/
									$c=0;
									$qviajes="SELECT v.id,d.nombre,v.estatus,DATE_FORMAT(v.fecha_inicio,'%Y-%m-%d') as finicio,v.fecha_fin,v.id_usuario,v.estatus FROM viajes v JOIN destino d ON v.id_destino=d.id WHERE id_usuario='$idU'AND estatus=2";
									$rviajes=mysql_query($qviajes) or die("La consulta: $qviajes" . mysql_error());
									while ($resviajes=mysql_fetch_assoc($rviajes))
									{$c=1;
								?>
									<option value="<? echo $resviajes['id'];?>"><? echo $resviajes['nombre']."(".$resviajes['finicio'].")";?></option>

								<?
									}
								?>
								</optgroup>
								<optgroup label="PENDIENTES DE APROVAR GASTOS">
								<?
									/*buscar los viajes del usuario en curso*/
									$c=0;
									$qviajes="SELECT v.id,d.nombre,v.estatus,DATE_FORMAT(v.fecha_inicio,'%Y-%m-%d') as finicio,v.fecha_fin,v.id_usuario,v.estatus FROM viajes v JOIN destino d ON v.id_destino=d.id WHERE id_usuario='$idU'AND estatus=3";
									$rviajes=mysql_query($qviajes) or die("La consulta: $qviajes" . mysql_error());
									while ($resviajes=mysql_fetch_assoc($rviajes))
									{$c=1;
								?>
									<option value="<? echo $resviajes['id'];?>"><? echo $resviajes['nombre']."(".$resviajes['finicio'].")";?></option>

								<?
									}
								?>
								</optgroup>
								<optgroup label="FINALIZADOS">
								<?
									/*buscar los viajes del usuario en curso*/
									$c=0;
									$qviajes="SELECT v.id,d.nombre,v.estatus,DATE_FORMAT(v.fecha_inicio,'%Y-%m-%d') as finicio,v.fecha_fin,v.id_usuario,v.estatus FROM viajes v JOIN destino d ON v.id_destino=d.id WHERE id_usuario='$idU'AND estatus=4";
									$rviajes=mysql_query($qviajes) or die("La consulta: $qviajes" . mysql_error());
									while ($resviajes=mysql_fetch_assoc($rviajes))
									{$c=1;
								?>
									<option value="<? echo $resviajes['id'];?>"><? echo $resviajes['nombre']."(".$resviajes['finicio'].")";?></option>

								<?
									}
								?>
								</optgroup>
							</select>
							<!--<input type="text" name="val" id="val" value="<? echo $c;?>"/>-->
						</div><!-- fin row uniform 1 div 1-->



					</div><!--fin row uniform 1-->


					<div class="row uniform" id="detalles" style="display:none;"><!--row uniform 3-->
						<div class="2u 4u(xsmall)">
							<label onClick="buscar(misviajes.value,<? echo $idU;?>)">General</label>

						</div>
						<div class="2u 4u(xsmall)">
							<label onClick="buscar_gastos(misviajes.value)">Gastos</label>
						</div>
					</div>

					<div class="row uniform letra" id="informacion"><!--row uniform 3-->



					</div><!--fin row uniform 3-->
					<div class="row uniform letra" id="informacion2"><!--row uniform 3-->

					</div><!--fin row uniform 3-->

					<footer>
						<ul class="icons alt">
							<li><a href="#" class="icon alt fa-twitter"><span class="label">Twitter</span></a></li>
							<li><a href="#" class="icon alt fa-facebook"><span class="label">Facebook</span></a></li>
							<li><a href="#" class="icon alt fa-instagram"><span class="label">Instagram</span></a></li>

						</ul>
					</footer>

				</div><!--fin main-->

			</div><!--fin wrapper-->


			<!-- Scripts -->
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
	</body>
</html>
