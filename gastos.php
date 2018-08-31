<?
session_start();
include "checar_sesion.php";
include "checar_sesion_admin.php";
include "coneccion.php";
$hoy=date("d-m-Y");
$hoy2=date("Y-m-d");
$idU=$_SESSION['idU'];
$tp=1;



if($_POST['guardar']=="Guardar")//if guardar
{


	if($_POST['total']!=0)//if total
	{

	
		if($_POST['idarea']!="")
		{
		
			//cuando se selecciono un proyecto.
			$area=$_POST['idarea'];
		}
		
		else
		{
			//no tiene proyecto.
			$area=$_POST['area'];
		}
		
		$proyecto=$_POST['idproyecto'];
		$gasto=mb_strtoupper($_POST['gasto'],'utf-8');
		$mpago=$_POST['mpago'];
		
		/*echo "<script>alert('fecha antes: $fecha');</script>";*/
		
		/*echo "<script>alert('fecha despues: $fechad');</script>";*/
		$nof=$_POST['nof'];
		$proveedor=mb_strtoupper($_POST['proveedor'],'utf-8');
		$concepto=mb_strtoupper($_POST['concepto'],'utf-8');
		$subtotal=$_POST['subtotal'];
		
		$total=$_POST['total'];
		
		$ct=$_POST['ct'];
		$pres=0;
		$retencion=0;
		/*echo "<script>alert('ct: $ct');</script>";*/
		
		
		/*if($tipo=="3")//cuando es isr
		{
			$retencion=$iva;
			$iva=0;
		}*/

		if($_POST['pres']!="")//cuando es presupuestado
		{
			$pres=1;
			$fecha=$_POST['fecha'];
			if($fecha=="00-00-0000")
			{
			$fechad="";
			}
			$fechap=$_POST['fechap'];
			/*echo "<script>alert('fechap: $fechap');</script>";*/
			$fechab=date("Y-m-d",strtotime($fechap));
			$fechad=date("Y-m-d",strtotime($fecha));
		}
		else
		{
			$fechab="";
			$fecha=$_POST['fecha'];
			/*echo "<script>alert('fecha: $fecha');</script>";*/
			$fechad=date("Y-m-d",strtotime($fecha));
		}
		
		//busca el id del tipo de gasto.
		$querygasto="SELECT id FROM tipo_gastos WHERE nombre='$gasto'";
		$resgasto = mysql_query($querygasto) or die("Error: querygasto, file:gastos.php: $querygasto" . mysql_error());
		$residg = mysql_fetch_assoc($resgasto);
		$idgasto=$residg['id'];
		
		//cuando es un nuevo tipo de gasto inserta en la tabla
		if($idgasto=="")
		{
			$insertgasto="INSERT INTO tipo_gastos (nombre) value('$gasto')";
			$resgasto = mysql_query($insertgasto) or die("Error: insertgasto, file:gastos.php: $insertgasto" . mysql_error());
			$idgasto=mysql_insert_id();
		}
		
		//busca el id del proveedor.
		$queryproveedor="SELECT id FROM proveedores WHERE nombre='$proveedor'";
		$resprov = mysql_query($queryproveedor) or die("Error: queryproveedor, file:gastos.php: $queryproveedor" . mysql_error());
		$residprov = mysql_fetch_assoc($resprov);
		$idprov=$residprov['id'];
		
		//cuando es un nuevo tipo de gasto inserta en la tabla
		if($idprov=="")
		{
			$insertprov="INSERT INTO proveedores (nombre) value('$proveedor')";
			$resprov = mysql_query($insertprov) or die("Error: insertprov, file:gastos.php: $insertprov" . mysql_error());
			$idprov=mysql_insert_id();
			
		}
		
		$insertgastos="INSERT INTO gastos (id_usuario,factura,proveedor,concepto,subtotal,id_tipo_impuesto,iva,ish,retencion_isr,total,tipo_gasto,tipo_subgasto,deducible,id_proyecto,fecha,id_area,metodo_pago,presupuestado,fecha_presupuestado) values ('$idU','$nof','$idprov','$concepto','$subtotal',0,'0','0','0','$total','$idgasto','0','No','$proyecto','$fechad','$area','$mpago','$pres','$fechab')";
		$resgastos = mysql_query($insertgastos) or die("Error: insertgastos, file:gastos.php: $insertgastos" . mysql_error());
		$idg=mysql_insert_id();
		for($x=0;$x<=$ct;$x++)//guarda los tipos de impuestos
		{
			$tipo=$_POST['tipo'.$x];
			$iva=$_POST['iva'.$x];
			$ish=$_POST['ish'.$x];
			if($tipo=="3")//cuando es isr
			{	
				$retencion=$iva;
				$iva=0;
			}
			else
			{
				$retencion=0;
			}
			
			if($tipo!=0)
			{
				$impgasto="INSERT INTO impuestos_gastos (id_tipo_impuesto,id_gasto,iva,ish,retencion_isr) value('$tipo','$idg','$iva','$ish','$retencion')";
				$resimpgastos = mysql_query($impgasto) or die("Error: impgasto, file:gastos.php: $impgasto" . mysql_error());
			}
			
			/*echo "<script>alert('tipo: $tipo');</script>";*/
		}
		echo "<script>alert('Gasto guardado exitosamente!!!');</script>";
		
	}//fin if total
}//fin if guardar

if($_POST['guardarcam']=="Guardar Cambio")//if guardar
{
	$iddd=$_POST['idc'];
	foreach($iddd as $i) 
	{
		/*echo "<script>alert('$i');</script>";*/
		$fac=$_POST['nof'.$i];
		$fech=$_POST['fecha'.$i];
		/*echo "<script>alert('$fac');</script>";*/
		$querynof="SELECT factura,fecha FROM gastos WHERE id=$i";
		$resnof = mysql_query($querynof) or die("Error: insertgastos, file:gastos.php: $querynof" . mysql_error());
		$resn = mysql_fetch_assoc($resnof);
		$factura=$resn['factura'];
		/*echo "<script>alert('$factura');</script>";*/
			if($factura=="" and $fac!="")//solo actualiza si no tiene factura guardada anterior mente
			{
				$upnof="UPDATE gastos SET factura='$fac',fecha='$fech' WHERE id=$i";
				$resupnof = mysql_query($upnof) or die("Error: upnof, file:gastos.php: $upnof" . mysql_error());
				$r=1;
			}
			
	}
	if($r==1)
		{
			echo "<script>alert('Cambios guardados exitosamente!!!');</script>";
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
		<title>Gastos</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
			<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
		
		<script>
			//formato a los calendarios
			function calendario() {
				$("#fecha").datepicker({ dateFormat: 'yy-mm-dd' });
				$("#fechap").datepicker({ dateFormat: 'yy-mm-dd' });
				
			}
			
			function calendario2(val) {
				$("#fecha"+val).datepicker({ dateFormat: 'yy-mm-dd' });
				
			}
			
			$(function () {
				$("#fecha").datepicker({ dateFormat: 'dd-mm-yy' });
				$("#fechap").datepicker({ dateFormat: 'dd-mm-yy' });
				$("#desde").datepicker({ dateFormat: 'yy-mm-dd' });
				$("#hasta").datepicker({ dateFormat: 'yy-mm-dd' });
				
			});
			
			//selecciona el area segun el proyecto seleccionado
			function selectarea(cadena)
			{	
			
			var anterior = document.getElementById('idarea').value;
			$("#area option[value="+anterior+"]").prop("selected",false);
			
				if(cadena!="0")
				{
					elementos= cadena.split("|");
					if(elementos[0]!="")
					{ 
					
						var valor=elementos[1];
						$("#area option[value="+ valor +"]").prop("selected",true);
						document.getElementById('idarea').value=valor;
						document.getElementById('idproyecto').value=elementos[0]; 
						$("#area").prop("disabled",true);
						
					}	
				}
				else if(cadena=="0")
					{
					
						var v="0";
						$("#area option[value="+v+"]").prop("selected",true);
						document.getElementById('idarea').value=v;
						document.getElementById('idproyecto').value="0"; 
						$("#area").prop("disabled",false);
					}	 
					
			}
			//selecciona el area cuando no ahi proyecto
			function selectarea2(cadena)
			{	
			
				document.getElementById('idarea').value=cadena;
					
			}
			
			//calcular total del sub
			function calcular()
			{
				var ct=document.getElementById('ct').value;// campo contador de tp
				for(i=0;i<=ct;i++)
				{
					calcular_total(i);
				}
			}
			//calcula total segun subtotal e iva
			function calcular_total(idimp)
			{
				//alert('idimp: '+idimp);
				var subt=document.getElementById('subtotal').value;//campo subtotal
				if(document.getElementById('iva'+idimp))
				{
				var iva=document.getElementById('iva'+idimp).value;// campo impuesto
				}
				var total=document.getElementById('total').value;// campo total
				var ct=document.getElementById('ct').value;// campo contador de tp
				var tipo=document.getElementById('tipo'+idimp).value;//campo tipo de impuesto seleccionado
				var caliva=0;//
				var tot=0;//
				var menos=0;//
				var imp=0;//impuesto 
				
				//alert('total: '+total);
				//alert('iva: '+iva);
				switch(tipo)
				{
					case "0":
						if(ct==0)//cuando solo ahi un campo de tipo de impuesto
						{
							document.getElementById('iva'+idimp).value="0";
							document.getElementById('i'+idimp).value="0";
							document.getElementById('ish'+idimp).value="0";
							document.getElementById('t'+idimp).value="0";
							document.getElementById('total').value="0";
						}
						else
						{
							var i=document.getElementById('i'+idimp).value;
							var total2=parseFloat(total)-parseFloat(i);
							if(total!=0)
							{
								if(total2==subt)
								{
									document.getElementById('total').value="0";
								}
								else
								{
									document.getElementById('total').value=total2;
								}
							}
							else
							{
								document.getElementById('total').value="0";
							}
							document.getElementById('iva'+idimp).value="0";
							document.getElementById('i'+idimp).value="0";
							document.getElementById('t'+idimp).value="0";
						}
					break;
					case "1":
						if(ct==0)//cuando solo ahi un campo de tipo de impuesto
						{
							caliva=parseFloat(subt)*0.16;
							tot=caliva+parseFloat(subt);
							document.getElementById('iva'+idimp).value=caliva;
							document.getElementById('i'+idimp).value=caliva;
							document.getElementById('ish'+idimp).value="0";
							document.getElementById('t'+idimp).value=tipo;
							document.getElementById('total').value=tot;
						}
						else//si ahi mas de un campo de tipo de impuesto
						{
							var t=document.getElementById('t'+idimp).value;
							if(t==2)
							{
								var i=document.getElementById('i'+idimp).value;
								caliva2=parseFloat(total)-parseFloat(i);
								document.getElementById('total').value=caliva2;
								var total=document.getElementById('total').value;// campo total
								caliva=parseFloat(subt)*0.16;
								if(total!=0)
								{
									tot=caliva+parseFloat(total);
								}
								else
								{
									tot=caliva+parseFloat(subt);
								}
								document.getElementById('iva'+idimp).value=caliva;
								document.getElementById('i'+idimp).value=caliva;
								document.getElementById('ish'+idimp).value="0";
								document.getElementById('t'+idimp).value=tipo;
								document.getElementById('total').value=tot;
							}
							if(t==3)
							{
								var i=document.getElementById('i'+idimp).value;
								caliva2=parseFloat(total)+parseFloat(i);
								document.getElementById('total').value=caliva2;
								var total=document.getElementById('total').value;// campo total
								caliva=parseFloat(subt)*0.16;
								if(total!=0)
								{
									tot=caliva+parseFloat(total);
								}
								else
								{
									tot=caliva+parseFloat(subt);
								}
								document.getElementById('iva'+idimp).value=caliva;
								document.getElementById('i'+idimp).value=caliva;
								document.getElementById('t'+idimp).value=tipo;
								document.getElementById('total').value=tot;
							}
							caliva=parseFloat(subt)*0.16;
								if(total!=0)
								{
									tot=caliva+parseFloat(total);
								}
								else
								{
									tot=caliva+parseFloat(subt);
								}
							document.getElementById('iva'+idimp).value=caliva;
							document.getElementById('i'+idimp).value=caliva;
							document.getElementById('t'+idimp).value=tipo;
							document.getElementById('total').value=tot;
						}
					break;
					case "2":
						if(ct==0)//cuando solo ahi un campo de tipo de impuesto
						{
							caliva=parseFloat(subt)*0.16;//calcular el iva(16%).
							calish=parseFloat(subt)*0.04;//calcular el impuesto sobre hospedaje (4%).
							imp=caliva+calish;
							tot=caliva+calish+parseFloat(subt);
							document.getElementById('iva'+idimp).value=imp;
							document.getElementById('ish'+idimp).value=calish;
							document.getElementById('i'+idimp).value=imp;
							document.getElementById('t'+idimp).value=tipo;
							document.getElementById('total').value=tot;
						}
						else//si ahi mas de un campo de tipo de impuesto
						{
							var t=document.getElementById('t'+idimp).value;
							if(t==1)
							{
								var i=document.getElementById('i'+idimp).value;
								caliva2=parseFloat(total)-parseFloat(i);
								document.getElementById('total').value=caliva2;
								var total=document.getElementById('total').value;// campo total
								caliva=parseFloat(subt)*0.16;//calcular el iva(16%).
								calish=parseFloat(subt)*0.04;//calcular el impuesto sobre hospedaje (4%).
								imp=caliva+calish;//impuesto total
								if(total!=0)
								{
									tot=caliva+calish+parseFloat(total);
								}
								else
								{
									tot=caliva+calish+parseFloat(subt);
								}
								document.getElementById('iva'+idimp).value=imp;
								document.getElementById('ish'+idimp).value=calish;
								document.getElementById('i'+idimp).value=imp;
								document.getElementById('t'+idimp).value=tipo;
								document.getElementById('total').value=tot;
							}
							if(t==3)
							{
								var i=document.getElementById('i'+idimp).value;
								caliva2=parseFloat(total)+parseFloat(i);
								document.getElementById('total').value=caliva2;
								var total=document.getElementById('total').value;// campo total
								caliva=parseFloat(subt)*0.16;//calcular el iva(16%).
								calish=parseFloat(subt)*0.04;//calcular el impuesto sobre hospedaje (4%).
								imp=caliva+calish;//impuesto total
								if(total!=0)
								{
									tot=caliva+calish+parseFloat(total);
								}
								else
								{
									tot=caliva+calish+parseFloat(subt);
								}
								document.getElementById('iva'+idimp).value=imp;
								document.getElementById('ish'+idimp).value=calish;
								document.getElementById('i'+idimp).value=imp;
								document.getElementById('t'+idimp).value=tipo;
								document.getElementById('total').value=tot;
							}
								caliva=parseFloat(subt)*0.16;//calcular el iva(16%).
								calish=parseFloat(subt)*0.04;//calcular el impuesto sobre hospedaje (4%).
								imp=caliva+calish;//impuesto total
								if(total!=0)
								{
									tot=caliva+calish+parseFloat(total);
								}
								else
								{
									tot=caliva+calish+parseFloat(subt);
								}
							document.getElementById('iva'+idimp).value=imp;
							document.getElementById('ish'+idimp).value=calish;
							document.getElementById('i'+idimp).value=imp;
							document.getElementById('t'+idimp).value=tipo;
							document.getElementById('total').value=tot;
						}
					break;
					case "3":
						if(ct==0)//cuando solo ahi un campo de tipo de impuesto
						{
							var t=document.getElementById('t'+idimp).value;
							if(t==1 || t==2)//cuando biene de tipo impuesto (iva o hospedaje)
							{
								document.getElementById('iva'+idimp).value="0";
								iva=document.getElementById('iva'+idimp).value;// campo impuesto
								caliva=parseFloat(iva);
								tot=parseFloat(subt)-caliva;
								document.getElementById('iva'+idimp).value=caliva;
								document.getElementById('i'+idimp).value=caliva;
								document.getElementById('ish'+idimp).value="0";
								document.getElementById('ish'+idimp).value="0";
								document.getElementById('t'+idimp).value=tipo;
								document.getElementById('total').value=tot;
							}
							else
							{
								caliva=parseFloat(iva);
								tot=parseFloat(subt)-caliva;
								document.getElementById('iva'+idimp).value=caliva;
								document.getElementById('i'+idimp).value=caliva;
								document.getElementById('t'+idimp).value=tipo;
								document.getElementById('total').value=tot;
							}
						}
						else
						{
							var t=document.getElementById('t'+idimp).value;
							if(t==1 || t==2)//cuando biene de tipo impuesto (iva o hospedaje)
							{
								var i=document.getElementById('i'+idimp).value;
								tot=parseFloat(total)-parseFloat(i);
								document.getElementById('total').value=tot;
								document.getElementById('iva'+idimp).value="0";
								document.getElementById('i'+idimp).value="0";
								document.getElementById('ish'+idimp).value="0";
								document.getElementById('t'+idimp).value="3";
							}
							 total=document.getElementById('total').value;
								if(total!=0)
								{
									if(iva==0)
									{
										tot=parseFloat(total);
									}
									else
									{
										var i=document.getElementById('i'+idimp).value;
										tot=parseFloat(total)+parseFloat(i);
										document.getElementById('total').value=tot;
										total=document.getElementById('total').value;
										caliva=parseFloat(iva);
										tot=parseFloat(total)-caliva;	
									}
									
									
								}
								else
								{
									if(iva==0)
									{
										tot=parseFloat(total);
									}
									else
									{
										caliva=parseFloat(iva);
										tot=parseFloat(subt)-caliva;	
									}
									
								}
							document.getElementById('iva'+idimp).value=caliva;
							document.getElementById('i'+idimp).value=caliva;
							document.getElementById('t'+idimp).value=tipo;
							document.getElementById('total').value=tot;
						}
					break;
				}
			}
			
			//agrega valor a iva/isr segun la seleccion
			function selec_tipo(valor,idimp)
			{
//alert(idimp);
				switch(valor)
				{
					case "0":
					//document.getElementById('iva'+idimp).value="0";
					calcular_total(idimp);
					break;
					
					case "1"://cuando es iva
					//document.getElementById('iva'+idimp).value="16";
					calcular_total(idimp);
					break;
					
					case "2"://hospedaje
					//document.enviargasto.iva+idimp.value="19";
					//document.getElementById('iva'+idimp).value="19";
					calcular_total(idimp);
					break;
					
					case "3"://isr
					//document.enviargasto.iva+idimp.value="0";
					document.getElementById('iva'+idimp).value="0";
					calcular_total(idimp);
					break;
				}
			
			}
			//quitar required de No.factura
			function quitar_required()
			{
				//fechap="<input type='text' class='datepicker' name='fechap' id='fechap'  value='<? echo $hoy?>'  required/>"
				//fecha="<input type='text' class='datepicker' name='fecha' id='fecha'  value='<? echo $hoy?>'  required/>"
				if( $('#pres').prop('checked') ) {
					document.enviargasto.nof.value="";
					$("#nof").prop("disabled",true);
					 $('#nof').removeAttr("required");
					 $('#fecha').removeAttr("required");
					  $('#fechap').prop("required", true);
						//$('#fecha').remove();
						//$('#fechas').append(fechap);//agrega el input monto
						//calendario();
				  }
				 else
				 {
				 	$("#nof").prop("disabled",false);
				 	 $('#nof').prop("required", true);
					 $('#fechap').removeAttr("required");
					  $('#fecha').prop("required", true);
					 //$('#fechap').remove();
						//$('#fechas').append(fecha);//agrega el input monto
						//calendario();
				 }
				
			}
			
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
					
					var m=document.getElementById('tablagastos');
					
					m.innerHTML=resultado;
				
			    }
		  	}
				var desde=document.getElementById('desde').value;
				var hasta=document.getElementById('hasta').value;
				var tp=document.getElementById('tipogasto').value;
				var r="";
				var b="";
				if(tp==3)
			{
				if(document.getElementById('rfac1').checked)
				{
					r=document.getElementById('rfac1').value;
				}
				if(document.getElementById('rfac2').checked)
				{
					r=document.getElementById('rfac2').value;
				}
				if(document.getElementById('rfac3').checked)
				{
					r=document.getElementById('rfac3').value;
				}
				b="buscar.php?desde="+desde+"&hasta="+hasta+"&tp="+tp+"&radio="+r+"&val=2"
			}
			else
			{
				b="buscar.php?desde="+desde+"&hasta="+hasta+"&tp="+tp+"&val=2";
			}
				link();
				xmlhttp.open("GET",b,true);
				xmlhttp.send();
				
		}	
		
		//llama la funcion buscar al cargar la pagina para traer los registros de hoy
		window.onload=function() {
			buscar();
		}
		
		function filtro()
		{
			var val=document.getElementById('vali').value;
			
			campo1="<div class='4u 12u(xsmall)' id='r1'><input type='radio' name='rfac' id='rfac1' value='0' onclick='link()' checked='checked'/><label for='rfac1'>TODOS</label></div>";
			campo2="<div class='4u 12u(xsmall)' id='r2'><input type='radio' name='rfac' id='rfac2' value='1' onclick='link()'/><label for='rfac2'>SIN FACTURA</label></div>";
			campo3="<div class='4u 12u(xsmall)' id='r3'><input type='radio' name='rfac' id='rfac3' value='2' onclick='link()'/><label for='rfac3'>CON FACTURA</label></div>";
			var tp=document.getElementById('tipogasto').value;
			
			if(tp==3)
				{
					if(val==0)
					{
						$('#informacion2').append(campo1);//agrega el boton guardar
						$('#informacion2').append(campo2);//agrega el boton guardar
						$('#informacion2').append(campo3);//agrega el boton guardar
						var val=document.getElementById('vali').value="1";
					}	
				}
				else
				{
					if(document.getElementById('r1'))
					{
						$('#r1').remove();
					}
					if(document.getElementById('r2'))
					{
						$('#r2').remove();
					}
					if(document.getElementById('r3'))
					{
						$('#r3').remove();
					}
					var val=document.getElementById('vali').value="0";
				}
				
		}
		//cambia el link
		function link()
		{
			
			filtro();
			var desde=document.getElementById('desde').value;
			var hasta=document.getElementById('hasta').value;
			var tp=document.getElementById('tipogasto').value;
			var a = document.getElementById('link');
			var r="";
			
			if(tp==3)
			{
				if(document.getElementById('rfac1').checked)
				{
					r=document.getElementById('rfac1').value;
				}
				if(document.getElementById('rfac2').checked)
				{
					r=document.getElementById('rfac2').value;
				}
				if(document.getElementById('rfac3').checked)
				{
					r=document.getElementById('rfac3').value;
				}
				a.setAttribute("href", "exportar_gastos.php?f1="+desde+"&f2="+hasta+"&tp="+tp+"&radio="+r);
			}
			else
			{
				a.setAttribute("href", "exportar_gastos.php?f1="+desde+"&f2="+hasta+"&tp="+tp);
			}	
		}
		
		//grega campos para un nuevo impuesto
		function agregar_imp()
		{
			
			var valor = document.getElementById('ct').value;
			//alert(valor);
			valor=parseInt(valor)+1;
campo1="<div class='4u 12u(xsmall)' id='imp"+valor+"'><label for='tipo"+valor+"' id='m"+valor+"'>Tipo de Impuesto(<i class='fa fa-minus' onClick='eliminar_imp("+valor+")'></i>)</label><select name='tipo"+valor+"' id='tipo"+valor+"' onChange='selec_tipo(this.value,"+valor+")'><option value='0'>SELECCIONE TIPO DE IMPUESTO</option><? $queryi="select * from tipo_impuesto";$resuli = mysql_query($queryi) or print("<option value=\"ERROR\">".mysql_error()."</option>");while ($impuestos = mysql_fetch_assoc($resuli)){?><option value='<? echo $impuestos['id']?>'><? echo $impuestos['concepto']?></option><? }?></select></div>";
campo2="<div class='4u 12u(xsmall)' id='iv"+valor+"'><label for='iva"+valor+"'>Impuesto</label><input type='text' name='iva"+valor+"' id='iva"+valor+"'  value='' onChange='calcular_total("+valor+")'/><input type='hidden' name='ish"+valor+"' id='ish"+valor+"'  value='0'/></div><div class='4u 12u(xsmall)' id='ivas"+valor+"'><input type='hidden' name='i"+valor+"' id='i"+valor+"' value='0'><input type='hidden' name='t"+valor+"' id='t"+valor+"'></div><div class='12u 12u(xsmall)' id='pp"+valor+"'></div>";
			$('#info').append(campo1);//agrega el input monto
			$('#info').append(campo2);//agrega el input monto
			document.getElementById('ct').value=valor;
		}
		 function eliminar_imp(idimp)
		{
			var ct=document.getElementById('ct').value;
			var iva=document.getElementById('iva'+idimp).value;
			var i=document.getElementById('i'+idimp).value;
			var t=document.getElementById('t'+idimp).value;
			var total=document.getElementById('total').value;
			if(t==3 || t==0)
			{
				var tot=parseFloat(total)+parseFloat(i);
			}
			else
			{
				var tot=parseFloat(total)-parseFloat(i);
			}
			
			document.getElementById('total').value=tot;
			//ct=parseInt(ct)-1;
			//document.getElementById('ct').value=ct;
			//alert(idimp);
			//elimina campo 1
			$('#imp'+idimp).remove();//elimina div
			$('#m'+idimp).remove();//elimina label
			$('#tipo'+idimp).remove();//elimina label
			/*******/
			//elimina campo 2
			$('#iv'+idimp).remove();
			$('#iva'+idimp).remove();
			$('#ivas'+idimp).remove();
			$('#i'+idimp).remove();
			$('#t'+idimp).remove();
			$('#pp'+idimp).remove();
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
						<a class="logo">Bluewolf</a>					</header>

					 <!-- Nav de celular-->
					  <nav id="nav">
						<ul class="actions fit">
						  <li><a href="menu_admin.php" class="button special fit">Administraci&oacuten</a></li>
						  <li><a href="adm_clientes.php" class="button special fit">Clientes</a></li>
						  <li><a href="adm_proyectos.php" class="button special fit">Proyectos</a></li>
						  <li><a href="buscar_cobros.php" class="button special fit">Facturación</a></li>
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
					<form name="enviargasto" id="enviargasto" method="post">
						<div class="box" style="margin-left:-5%">
						<div class="row uniform" id="info">
						
								<div class="4u 12u(xsmall)"><!--Proyecto.-->
									<label for="proyecto">Proyecto</label>
									<select name="proyecto" id="proyecto" onChange="selectarea(this.value)">
										<option value="0">NINGUNO</option>
										 <? $query = "SELECT id,nombre,id_area FROM proyectos";
                            				$result = mysql_query($query) or print("<option value=\"ERROR\">".mysql_error()."</option>");
                            				while($areas = mysql_fetch_assoc($result)){
										 ?>
                         				<option value="<? echo $areas['id']?>|<? echo $areas['id_area']?>"><? echo $areas['nombre']?></option>
						  				<?
                            				}
                            			?>
									</select>
									<input type="hidden" name="idarea" id="idarea" value=""/>
									<input type="hidden" name="idproyecto" id="idproyecto" value=""/>
								</div>	
						
								<div class="4u 12u(xsmall)"><!--select contenedora de area.-->
									<label for="area">&aacute;rea</label>
									<select name="area" id="area" onChange="selectarea2(this.value)" required>
										<option value="0">SELECCIONE &Aacute;REA</option>
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
								
								<div class="4u 12u(xsmall)"><!--Tipo de Gasto.-->
									<label for="gasto">Tipo de Gasto</label>
									<input class="upper" list="gasto" name="gasto" type="text" required>
									<datalist id="gasto">
										<?	
											$query = "select * from tipo_gastos order by id";
											$result = mysql_query($query) or print("<option value=\"ERROR\">".mysql_error()."</option>");
											while($cliente = mysql_fetch_assoc($result))
										{
										?>
											<option value="<? echo $cliente['nombre']?>"  ><? echo $cliente['nombre']?></option>
										<?
										}
										?>
									</datalist>
								</div>
								
								<div class="4u 12u(xsmall)"><!--Metodo de Pago.-->
									<label for="mpago">Método de Pago</label>
									<select name="mpago" id="mpago" required>
										<option value="0">SELECCIONE MÉTODO DE PAGO</option>
										 <? $query = "SELECT id,tipo FROM metodo_pago";
                            				$result = mysql_query($query) or print("<option value=\"ERROR\">".mysql_error()."</option>");
                            				while($metodo = mysql_fetch_assoc($result)){
										 ?>
                         				<option value="<? echo $metodo['id']?>" <? echo $metodo['id']==1?"selected":"";?> ><? echo $metodo['tipo']?></option>
						  				<?
                            				}
                            			?>
									</select>
								</div>
								
								<div class="4u 12u(xsmall)" id="fechas"><!--fecha.-->
									<label for="fecha">Fecha Gasto</label>
									<input type="text" class="datepicker" name="fecha" id="fecha"  value="00-00-0000"  required/>
								</div>	
								<div class="4u 12u(xsmall)" id="fechas"><!--fecha.-->
									<label for="fecha">Fecha Presupuestado</label>
									<input type="text" class="datepicker" name="fechap" id="fechap"  value="00-00-0000"/>
								</div>	
								
								<div class="1u 12u(xsmall)"><!--presupuestado-->
									<label style="font-size:10px;">Presupuestado</label>
									<input type="checkbox" name="pres" id="pres" onClick="quitar_required()"/>
									<label for="pres" style="color:#000000; font-size:12px;"></label>
								</div>
								
								<div class="3u 12u(xsmall)"><!--No.Factura.-->
									<label for="nof" id="nfa">No.Factura</label>
									<input type="text" name="nof" id="nof" required/>
								</div>	
								
								<div class="4u 12u(xsmall)"><!--Proveedor.-->
									<label for="proveedor">Proveedor</label>
									<input class="upper" list="proveedor" name="proveedor" type="text" required>
									<datalist id="proveedor">
										<?	
											$query = "select * from proveedores order by id";
											$result = mysql_query($query) or print("<option value=\"ERROR\">".mysql_error()."</option>");
											while($cliente = mysql_fetch_assoc($result))
										{
										?>
											<option value="<? echo $cliente['nombre']?>"  ><? echo $cliente['nombre']?></option>
										<?
										}
										?>
									</datalist>
								</div>
								
								<div class="4u 12u(xsmall)"><!--Concepto.-->
									<label for="concepto">Concepto</label>
									<input class="upper" type="text" name="concepto" id="concepto" value="" required/>
								</div>
								
								<div class="4u 12u(xsmall)"><!--subtotal.-->
									<label for="subtotal">Subtotal</label>
									<input type="text" name="subtotal" id="subtotal" value="0" onChange="calcular()" required/>
								</div>
								
								<div class="4u 12u(xsmall)"><!--Tipo.-->
									<label for="tipo">Típo de Impuesto(<i class="fa fa-plus" onClick="agregar_imp()"></i>)</label>
									<select name="tipo0" id="tipo0" onChange="selec_tipo(this.value,0)">
										<option value="0">SELECCIONE TIPO DE IMPUESTO</option>
										<?
										$queryi="select * from tipo_impuesto";
										$resuli = mysql_query($queryi) or print("<option value=\"ERROR\">".mysql_error()."</option>");
										while($impuestos = mysql_fetch_assoc($resuli))
										{
										?>
											<option value="<? echo $impuestos['id']?>"  ><? echo $impuestos['concepto']?></option>
										<?
										}
										?>
									</select>
									<input type="hidden" name="ct" id="ct" value="0" />
								</div>
								
								<div class="4u 12u(xsmall)"><!--iva.-->
									<label for="iva">Impuesto</label>
									<input type="text" name="iva0" id="iva0"  value="0" onChange="calcular_total('0')"/>
									<input type="hidden" name="ish0" id="ish0"  value="0"/>
									<input type="hidden" name="i0" id="i0"/>
									<input type="hidden" name="t0" id="t0" value="0"/>
								</div>
								
								<div class="4u 12u(xsmall)"><!--Total.-->
									<label for="total">TOTAL</label>
									<input type="text" name="total" id="total"  value="0" required/>
								</div>
						</div>	
						</div>
						
						<div class="row"><!--Boton Guardar-->
							<input class="button special fit" type="submit" name="guardar" id="guardar" value="Guardar"/>
						</div>	
					</form>
					
					<!--<form name="buscar" id="buscar" method="post">-->
						<div class="box">
						<label style="margin-left:45%;"><h4>BUSCAR GASTOS</h4></label>
						  <div class="row uniform" id="informacion2">
							
							<!--filtro por tipo-->
							<div class="4u 12u(xsmall)">
								<label for="tipogasto">Tipo Gasto</label>
								<select name="tipogasto" id="tipogasto" onChange="link()">
									<option value="1" <? echo $tp==1?"selected":"";?>>TODOS</option>
									<option value="2" <? echo $tp==2?"selected":"";?>>GASTOS</option>
									<option value="3" <? echo $tp==3?"selected":"";?>>GASTOS PRESUPUESTADOS</option>
								</select>
								<input type="hidden" name="vali" id="vali" value="0"/>
							</div>
							<!--fin-->
							
							<div class="4u 12u(xsmall)"><!--desde.-->
								<label for="hasta">Desde</label>
								<input type="text"  name="desde" id="desde" readonly="" value="<? echo $desde!=""?$desde:$hoy2?>" onChange="link()"/>
							</div>
							
							<div class="4u 12u(xsmall)"><!--hasta.-->
								<label for="hasta">Hasta</label>
								<input type="text" name="hasta" id="hasta" readonly="" value="<? echo $hasta!=""?$hasta:$hoy2?>" onChange="link()"/>
							</div>
							
							
								
							
						  </div>
						  
						   <div class="row uniform">
						   		<div class="4u 12u(xsmall)"><!--boton buscar.-->
									<input class="button special fit" type="submit" name="busca" id="busca" value="Buscar" onClick="buscar()"/>
								</div>
							</div>	
						</div>
						
						
						<a style="height:0px; text-decoration:none;" href="" id="link"><img src="images/descarga.png" width="46" height="46" border="0" title="Exportar"></a>
					<!--</form>-->
					
						<div class="table-wrapper" id="tablagastos">
							<!--aqui se carga la tabla-->
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
			<script src="assets/js/main.js"></script>

	</body>
</html>
