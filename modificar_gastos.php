<?
include "coneccion.php";
$idup=$_GET['idup'];//id mandado en el colorbox
$idu=$_GET['idu'];

/*
=================================================================================================================================
Guardar modificaciones
=================================================================================================================================
*/
	if($_POST['guardar']=="Guardar")//if guardar
	{
			$proyecto = $_POST['idproyecto'];
			$fecha = $_POST['fecha'];
			$gasto=mb_strtoupper($_POST['gasto'],'utf-8');
			$subgasto=mb_strtoupper($_POST['subgasto'],'utf-8');
			$mpago = $_POST['mpago'];
			$nof = $_POST['nof'];
			$proveedor=mb_strtoupper($_POST['proveedor'],'utf-8');
			$concepto=mb_strtoupper($_POST['concepto'],'utf-8');
			$subtotal = $_POST['subtotal'];
			$total = $_POST['total'];
			
			
			$fechad=date("Y-m-d",strtotime($fecha));
			
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
			
			/*
			Buscar y/o crear nuevo gasto
			=========================================================
			*/
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
			/*======================================================*/
			
			/*
			Buscar y/o crear nuevo subgasto
			=========================================================
			*/
			
			//busca el id del tipo de subgastogasto.
			$querysubgasto="SELECT id FROM tipo_subgastos WHERE nombre='$subgasto'";
			$ressubgasto = mysql_query($querysubgasto) or die("Error: querysubgasto, file:gastos.php: $querysubgasto" . mysql_error());
			$residsubg = mysql_fetch_assoc($ressubgasto);
			$idsubgasto=$residsubg['id'];
			
			//cuando es un nuevo tipo de gasto inserta en la tabla
			if($idsubgasto=="")
			{
				$insertsubgasto="INSERT INTO tipo_subgastos (id_gastos,nombre) value('$idgasto','$subgasto')";
				$resgasto = mysql_query($insertsubgasto) or die("Error: insertsubgasto, file:gastos.php: $insertsubgasto" . mysql_error());
				$idsubgasto=mysql_insert_id();
			}
			
			/*======================================================*/
			
			/*
			Buscar y/o crear nuevo proveedor
			=========================================================
			*/
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
			/*======================================================*/
			
			$update_gastos="UPDATE gastos SET id_usuario='$idu', factura='$nof', proveedor='$idprov', concepto='$concepto',subtotal='$subtotal', total='$total', tipo_gasto='$idgasto', tipo_subgasto='$idsubgasto', id_proyecto='$proyecto', fecha='$fechad', id_area='$area',metodo_pago='$mpago' WHERE id=$idup";
			$res_gastos = mysql_query($update_gastos) or die("Error: update_gastos, file:modificar_gastos.php: $update_gastos" . mysql_error());
		
			$query_impuestos = "SELECT * FROM impuestos_gastos WHERE id_gasto=$idup";
			$resultado_impuestos = mysql_query($query_impuestos) or die("Error en consulta de impuestos: $query_impuestos " . mysql_error());
				while($res_imp=mysql_fetch_assoc($resultado_impuestos))
				{
						$idimp = $res_imp['id'];
						$tipo=$_POST['tipo'.$idimp];
						$iva=$_POST['iva'.$idimp];
						$ish=$_POST['ish'.$idimp];
						
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
							$impgasto="UPDATE impuestos_gastos SET id_tipo_impuesto='$tipo', iva='$iva', ish='$ish', retencion_isr='$retencion' WHERE id=$idimp";
							$resimpgastos = mysql_query($impgasto) or die("Error: impgasto, file:gastos.php: $impgasto" . mysql_error());
						}
				}
				echo "<script>alert('Registro Modificado');</script>";
				echo"<script>window.parent.location=\"gastos.php\"</script>";
	}
/*===============================================================================================================================*/

/*===============================================================================================================================
Eliminar Registro de gasto e impuestos del gasto
=================================================================================================================================*/

	if($_POST['eliminar']=="Eliminar")
	{
			$borrar_impuestos = "DELETE FROM impuestos_gastos WHERE id_gasto=$idup";
			$resultado_impuestos = mysql_query($borrar_impuestos) or die("Error en consulta de  borrar impuestos: $borrar_impuestos " . mysql_error());
			
			$borrar_gastos= "DELETE FROM gastos WHERE id=$idup";
			$resultado_gastos = mysql_query($borrar_gastos) or die("Error en consulta de  borrar gastos: $borrar_gastos" . mysql_error());
			
			echo "<script>alert('Registro Eliminado');</script>";
			echo"<script>window.parent.location=\"gastos.php\"</script>";
	}
/*===============================================================================================================================*/


/*
=================================================================================================================================
Busca los datos del registro
=================================================================================================================================
*/
$tsubg = "";
if($idup != "")
{
	$queryp = "SELECT tipo_subgasto FROM gastos WHERE id=$idup";
	$resultadop = mysql_query($queryp) or die("Error en consulta horario: $queryhorario " . mysql_error());
	$resp = mysql_fetch_assoc($resultadop);
	$tsubg = $resp['tipo_subgasto']; 
}

if($tsubg == "")
{
//JOIN tipo_subgastos tsg ON g.tipo_subgasto=tsg.id   ,tsg.nombre AS subgasto
$queryhorario="SELECT g.*,p.id AS proyecto,a.id AS area,tg.nombre AS gasto,mp.id AS mpago,pr.nombre AS proveedor FROM gastos g left JOIN proyectos p ON g.id_proyecto=p.id JOIN areas a ON g.id_area=a.id JOIN tipo_gastos tg ON g.tipo_gasto=tg.id JOIN metodo_pago mp ON g.metodo_pago=mp.id JOIN proveedores pr ON g.proveedor=pr.id WHERE g.id=$idup";
$resultado = mysql_query($queryhorario) or die("Error en consulta horario: $queryhorario " . mysql_error());
$resh=mysql_fetch_assoc($resultado);
}
else
{
//JOIN tipo_subgastos tsg ON g.tipo_subgasto=tsg.id   ,tsg.nombre AS subgasto
$queryhorario="SELECT g.*,p.id AS proyecto,a.id AS area,tg.nombre AS gasto,mp.id AS mpago,pr.nombre AS proveedor ,tsg.nombre AS subgasto FROM gastos g left JOIN proyectos p ON g.id_proyecto=p.id JOIN areas a ON g.id_area=a.id JOIN tipo_gastos tg ON g.tipo_gasto=tg.id JOIN metodo_pago mp ON g.metodo_pago=mp.id JOIN proveedores pr ON g.proveedor=pr.id JOIN tipo_subgastos tsg ON g.tipo_subgasto=tsg.id WHERE g.id=$idup";
$resultado = mysql_query($queryhorario) or die("Error en consulta horario: $queryhorario " . mysql_error());
$resh=mysql_fetch_assoc($resultado);
}
/*===============================================================================================================================*/

/*
========================================================================================
Busca cuantos impuestos tiene
========================================================================================
*/
$query_impuestos = "SELECT * FROM impuestos_gastos WHERE id_gasto=$idup";
$resultado_impuestos = mysql_query($query_impuestos) or die("Error en consulta de impuestos: $query_impuestos " . mysql_error());
//$numero_impuestos=mysql_num_rows($resultado_impuestos);
/*======================================================================================*/


$fecha=date("d-m-Y",strtotime($resh['fecha']));
?>

<!DOCTYPE HTML>
<html>
	<head>
			<title>Modificar Gastos</title>
			<meta charset="utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
			<link rel="stylesheet" href="assets/css/main.css" />
			<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
			<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
			<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
			<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
			<script>
			
					/*================== Iniciar calendarios =====================*/
					$(document).ready(function(){
							$(".datepicker").datepicker({ dateFormat: 'dd-mm-yy' });					
					});
					/*============================================================*/
					
					/*=================== Selecciona el tipo de impuesto==========*/
						function selec_tipo(valor,idimp)
						{
							switch(valor)
							{
								case "0":
								calcular_total(idimp);
								break;
								
								case "1"://cuando es iva
								calcular_total(idimp);
								break;
								
								case "2"://hospedaje
								calcular_total(idimp);
								break;
								
								case "3"://isr
								document.getElementById('iva'+idimp).value="0";
								calcular_total(idimp);
								break;
							}
			
						}
					/*============================================================*/
					
					/*==================== Calcula el total de gastos ============*/
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
					/*============================================================*/
					
					/*============= Selecciona el area segun el proyecto =========*/
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
					/*============================================================*/
					
					/*=== select area 2(selecciona area cuando no ahi proyecto) ==*/
						function selectarea2(cadena)
						{	
						
							document.getElementById('idarea').value=cadena;
								
						}
					/*============================================================*/
					
					
			</script>
	</head>

	<body class="is-loading">
			<div id="wrapper">
					<header id="header"> <a class="logo" href="http://bluewolf.com.mx/new/" target="_blank">Bluewolf</a> </header>
					<div id="main">
							<form name="cliente" id="cliente" method="post">
										<div class="row uniform">			
													<!--================================== Proyecto ==========================-->													
														<div class="4u 12(xsmall)">
																<label for="proyecto">Proyecto</label>
																<select name="proyecto" id="proyecto" onChange="selectarea(this.value)" required>
																			<option value="0">NINGUNO</option>
																		 	<? $query = "SELECT id,nombre,id_area FROM proyectos";
																										$result = mysql_query($query) or print("<option value=\"ERROR\">".mysql_error()."</option>");
																										while($areas = mysql_fetch_assoc($result)){
																		 	?>
																			<option value="<? echo $areas['id']?>|<? echo $areas['id_area']?>" <? echo $resh['proyecto']==$areas['id']?"selected":"";?> ><? echo $areas['nombre']?></option>
																			<?
																				}
																			?>
																	</select>
																	<input type="hidden" name="idarea" id="idarea" value=""/>
																	<input type="hidden" name="idproyecto" id="idproyecto" value=""/>
														</div>
																											
													<!--============================================================================-->
													
													<!--================================== Area ===================================-->
													
															<div class="4u 12u(xsmall)">
																	<label for="area">area</label>
																	<select name="area" id="area" onChange="selectarea2(this.value)" required>
																			<option value="0">SELECCIONE AREA</option>
																			<? $query = "SELECT id,nombre FROM areas";
																										$result = mysql_query($query) or print("<option value=\"ERROR\">".mysql_error()."</option>");
																										while($areas = mysql_fetch_assoc($result)){
																			?>
																			<option value="<? echo $areas['id']?>" <? echo $resh['area']== $areas['id']?"selected":"";?> > <? echo $areas['nombre']?></option>
																			<?
																				}
																			?>
																	</select>
															</div>
													
													<!--===========================================================================-->
													
													<!--================================== Tipo de gasto ==========================-->
													
														<div class="4u 12u(xsmall)">
																<label for="gasto">Tipo de Gasto</label>
																<input class="upper" list="gasto" name="gasto" type="text"  value="<? echo $resh['gasto'];?>" required>
																<datalist id="gasto">
																	<?	
																		$query = "select * from tipo_gastos order by id";
																		$result = mysql_query($query) or print("<option value=\"ERROR\">".mysql_error()."</option>");
																		while($cliente = mysql_fetch_assoc($result))
																	{
																	?>
																		<option value="<? echo $cliente['nombre']?>"><? echo $cliente['nombre']?></option>
																	<?
																	}
																	?>
																</datalist>
														</div>
													
													<!--===========================================================================-->
													
													<!--================================== Tipo de subgasto ==========================-->
													
														<div class="4u 12u(xsmall)">
															<label for="gasto">Tipo de Subgasto</label>
															<input class="upper" list="subgasto" name="subgasto" type="text" value="<? echo $resh['subgasto'];?>">
															<datalist id="subgasto">
																<?	
																	$query = "select * from tipo_subgastos order by id";
																	$result = mysql_query($query) or print("<option value=\"ERROR\">".mysql_error()."</option>");
																	while($subgastos = mysql_fetch_assoc($result))
																{
																?>
																	<option value="<? echo $subgastos['nombre']?>"  ><? echo $cliente['nombre']?></option>
																<?
																}
																?>
															</datalist>
														</div>
													
													<!--===========================================================================-->

													<!--================================== Metodo de pago ==========================-->
													
														<div class="4u 12u(xsmall)">
																<label for="mpago">Metodo de Pago</label>
																<select name="mpago" id="mpago" required>
																	<option value="0">SELECCIONE M?TODO DE PAGO</option>
																	 <? $query = "SELECT id,tipo FROM metodo_pago";
																									$result = mysql_query($query) or print("<option value=\"ERROR\">".mysql_error()."</option>");
																									while($metodo = mysql_fetch_assoc($result)){
																	 ?>
																							<option value="<? echo $metodo['id']?>" <? echo $resh['mpago']==$metodo['id']?"selected":"";?> ><? echo $metodo['tipo']?></option>
																		<?
																			}
																		?>
																</select>
														</div>
													
													<!--============================================================================-->
													
													<!--========================== fecha gasto ===================================-->
													
															<div class="4u 12u(xsmall)">
																	<label for="fecha">Fecha Gasto</label>
																	<input type="text" class="datepicker" name="fecha" id="fecha"  value="<? echo $fecha;?>"  required/>
															</div>
													
													<!--===========================================================================-->
													
													<!--================================== Numero de factura ==========================-->
														<div class="4u 12u(xsmall)">
																<label for="nof">No.Factura</label>
																<input type="text" name="nof" id="nof" value="<? echo $resh['factura']?>" required/>
														</div>
													
													<!--===============================================================================-->
													
													<!--================================== Proveedor ==========================-->
														<div class="4u 12u(xsmall)">
																<label for="proveedor">Proveedor</label>
																<input class="upper" list="proveedor" name="proveedor" type="text" value="<? echo $resh['proveedor'];?>" required>
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
													
													<!--=======================================================================-->
													
													<!--================================== Concepto ==========================-->
														<div class="4u 12u(xsmall)">
															<label for="concepto">Concepto</label>
															<input class="upper" type="text" name="concepto" id="concepto" value="<? echo $resh['concepto'];?>" required/>
														</div>
														
													<!--======================================================================-->
													
													<!--================================== Subtotal ==========================-->
														<div class="4u 12u(xsmall)">
															<label for="subtotal">Subtotal</label>
															<input type="text" name="subtotal" id="subtotal" value="<? echo $resh['subtotal'];?>" onChange="calcular()" required/>
														</div>
													
													<!--======================================================================-->
													
													
													<!--============================================================================================
													crea los campos tipo impuesto e impuesto segun el numero de impuestos que tenga el registro
													=============================================================================================-->
													<?
														while($res_impuestos=mysql_fetch_assoc($resultado_impuestos))
														{
																if($res_impuestos['id_tipo_impuesto'] == 3)
																{
																		$impuesto=$res_impuestos['retencion_isr'];
																}
																else
																{
																		$impuesto=$res_impuestos['iva'];
																}		
													?>
													<!--=========================================================================================-->
													
													<!--================================== Tipo de impuesto ==========================-->
														<div class="4u 12u(xsmall)">
																<label for="tipo">Tipo de Impuesto</label>
																<select name="tipo<? echo $res_impuestos['id'];?>" id="tipo<? echo $res_impuestos['id'];?>" onChange="selec_tipo(this.value,'<? echo $res_impuestos['id'];?>')">
																	<option value="0">SELECCIONE TIPO DE IMPUESTO</option>
																	<?
																	$queryi="select * from tipo_impuesto";
																	$resuli = mysql_query($queryi) or print("<option value=\"ERROR\">".mysql_error()."</option>");
																	while($impuestos = mysql_fetch_assoc($resuli))
																	{
																	?>
																		<option value="<? echo $impuestos['id']?>" <? echo $res_impuestos['id_tipo_impuesto']==$impuestos['id']?"selected":"";?> ><? echo $impuestos['concepto']?></option>
																	<?
																	}
																	?>
																</select>
																<input type="hidden" name="ct" id="ct" value="0" />
														</div>
													<!--==============================================================================-->
													
													<!--================================== Impuesto ==========================-->
														<div class="4u 12u(xsmall)">
																<label for="iva">Impuesto</label>
																<input type="text" name="iva<? echo $res_impuestos['id'];?>" id="iva<? echo $res_impuestos['id'];?>"  value="<? echo $impuesto;?>" onChange="calcular_total('<? echo $res_impuestos['id'];?>')"/>
																<input type="hidden" name="ish<? echo $res_impuestos['id'];?>" id="ish<? echo $res_impuestos['id'];?>"  value="0"/>
																<input type="hidden" name="i<? echo $res_impuestos['id'];?>" id="i<? echo $res_impuestos['id'];?>"/>
																<input type="hidden" name="t<? echo $res_impuestos['id'];?>" id="t<? echo $res_impuestos['id'];?>" value="0"/>
														</div>
													<!--======================================================================-->
													
													
													<!--=======================================================================================
													finaliza el ciclo para crear los campos tipo impuesto e impuesto
													========================================================================================-->
													<?
															}
													?>
													<!--====================================================================================-->
													
													
													
													<!--================================== Total ==========================-->
														<div class="4u 12u(xsmall)"><!--Total.-->
															<label for="total">Total</label>
															<input type="text" name="total" id="total"  value="<? echo $resh['total'];?>" required/>
														</div>
													
													<!--===================================================================-->
													
													<!--============================ Boton guardar ==============================-->
														<div class="4u 12u(xsmall)" style="margin-top:10%;">
																<input class="button special fit" type="submit" name="guardar" id="guardar" value="Guardar"/>
														</div>
													
													<!--=========================================================================-->
													
													<!--============================ Boton eliminar =============================-->
														<div class="4u 12u(xsmall)" style="margin-top:10%;">
																<input class="button special fit" type="submit" name="eliminar" id="eliminar" value="Eliminar"/>
														</div>
													
													<!--=========================================================================-->
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
					</div><!--main-->
					
					<!-- Copyright -->
					<div id="copyright">
					<ul>
					<li>&copy; Untitled</li>
					<li>Design: <a href="https://html5up.net">Bluewolf</a></li>
					</ul>
					</div>
			</div><!--wrapper-->
			<!-- Scripts -->
			<!--<script src="assets/js/jquery.min.js"></script>falla picker-->
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main2.js"></script>

	</body>
</html>

