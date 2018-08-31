<?
session_start();
include "checar_sesion.php";
include "checar_sesion_admin.php";
include "coneccion.php";
//include "SimpleImage.php";
//$adminU=$_SESSION['adminU'];
$hoy=date("d-m-Y");
$guardar= $_POST["guardar"];
$id_e=$_GET["id_e"];
if($guardar=="Guardar")  
{
	$nombre= mb_strtoupper($_POST["nombre"],'utf-8');
	$id_cliente= $_POST["id_cliente"];
	$alcance= mb_strtoupper($_POST["alcance"],'utf-8');
	$tipo= mb_strtoupper($_POST["tipo"],'utf-8');
	$id_area= $_POST["id_area"];
	$id_oficina= $_POST["id_oficina"];
	$fecha_inicio= $_POST["fecha_inicio"];
	$fecha_inicio=date("Y-m-d",strtotime($fecha_inicio));
	$fecha_fin= $_POST["fecha_fin"];
	$fecha_fin=date("Y-m-d",strtotime($fecha_fin));
	$costo_total= $_POST["costo_total"];
	$contacto= mb_strtoupper($_POST["contacto"],'utf-8');
	$puesto= mb_strtoupper($_POST["puesto"],'utf-8');
	$email= $_POST["email"];
	$telefono= mb_strtoupper($_POST["telefono"],'utf-8');
	$condiciones= mb_strtoupper($_POST["condiciones"],'utf-8');
	
	
	$consulta  = "insert into proyectos(nombre, id_cliente, alcance, tipo, id_area, id_oficina, fecha_inicio, fecha_fin, costo_total, contacto, puesto, email, telefono, condiciones, fecha_proyecto) values('$nombre', '$id_cliente', '$alcance', '$tipo', '$id_area', '$id_oficina', '$fecha_inicio', '$fecha_fin', '$costo_total', '$contacto', '$puesto', '$email', '$telefono', '$condiciones', now()) ";
	
	$resultado = mysql_query($consulta) or die("Error en operacion1: " . mysql_error());
	$id_p=  mysql_insert_id();
	
	//guardar participantes
	$participantes=$_POST['participa'];//obtiene los participantes.
	$admin=$_POST['admin'];
	$demanda=$_POST['demanda'];
	$count=0;
	
	foreach($participantes as $p){
	$count=$p-1;
	$ad="No";
		if($p!=""){
		$de=$demanda[$count];
		switch ($de){
			case 0:
			$dem="Nada";
			break;
			case 1:
			$dem="Baja";
			break;
			case 2:
			$dem="Media";
			break;
			case 3:
			$dem="Alta";
			break;
		}
		
			if($p==$admin){
				
				$ad="Si";
			}
			
				$consulta  = "insert into participante_proyectos(id_proyecto, id_usuario, responsable,demanda) values($id_p, '$p','$ad','$de')";
				$resultado = mysql_query($consulta) or die("Error en consulta insert: $consulta " . mysql_error());
		
			
			
		}
		}
		
	//guardar archivo
	$consulta  = "insert into documentos(id_proyecto, nombre_archivo, fecha) values($id_p, '".$_POST["nombre_archivo"]."', now())";
	$resultado = mysql_query($consulta) or die("Error en operacion1: " . mysql_error());
	$id_insert=mysql_insert_id();
	
		//archivo
			if($resultado){
			if ($_FILES["archivo"]["error"]> 0 )  {
  				echo "Error imagen: " . $_FILES["archivo"]["error"] . "<br />";	
  			}else {	  
 	 					 		$allowed_ext = array("jpeg", "jpg", "gif", "png");
	  							$ext=pathinfo($_FILES["archivo"]['name']);
								$ext=$ext['extension'];
	  							$nom="docs/".$id_insert."_"."Propuesta.".$ext;
								
	 							$nom2="".$id_insert."_"."Propuesta.".$ext;
								
								if(move_uploaded_file($_FILES["archivo"]['tmp_name'], $nom)){
								
								$consulta1  = "update documentos set archivo='$nom2' where id=$id_insert";
								$resultado1 = mysql_query($consulta1) or die("Error en operacion: $consulta1" . mysql_error());	
								
								}else{
									echo"Error uploading archive";
								}	
  				}
			}//archivo
	
	echo"<script>alert(\"Proyecto Guardado\");</script>";
	echo"<script>window.location=\"adm_cambia_proyecto.php?id=$id_p\"; </script>";
	
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
		<title>Proyectos</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script>
$(function () {
$("#fecha_inicio").datepicker({ dateFormat: 'dd-mm-yy' });
$("#fecha_fin").datepicker({ dateFormat: 'dd-mm-yy' });
});

</script>
	</head>

	<body class="is-loading">

		<!-- Wrapper -->
			<div id="wrapper">
					<ul class="visible actions">
						<li class="visible"><a href="adm_proyectos.php" class="button special icon fa-undo">Regresar</a></li>
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
							<li><a href="buscar_cobros.php" class="button special fit">Facturaci&oacuten</a></li>
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
						<div class="6u 6u(xsmall)" style="float:right;"><a href="adm_alta_cliente.php?cn=1" class="label icon fa fa-user" style="cursor:pointer;"> (Nuevo Cliente)</a></div>
					<form class="alt" name="edproyecto" id="edproyecto" method="post" enctype="multipart/form-data">			
						<h3>Nuevo Proyecto</h3>	
						<div class="box">
						<div class="row">
							<div class="6u 12u(xsmall)">
								<label for="id_cliente">Cliente</label>
								<select name="id_cliente" id="id_cliente">
                          <option value="">--Selecciona--</option>
                          <? $query = "SELECT id,nombre FROM clientes";
                            $result = mysql_query($query) or print("<option value=\"ERROR\">".mysql_error()."</option>");
                            while($cliente = mysql_fetch_assoc($result)){?>
                          <option value="<? echo $cliente['id']?>" <? echo $res['id_cliente']==$cliente['id']?"selected":""; ?> ><? echo $cliente['nombre']?></option>
						  
                          <?
                            }
                            ?>				
                        </select>
							</div>
							<div class="6u 12u(xsmall)">
								<label for="nombre">Nombre</label>
								<input class="upper" type="text" name="nombre" id="nombre" value="" required/>
							</div>
							<div class="6u 12u(xsmall)">
								<label for="alcance">Alcance</label>
								<textarea class="upper" name="alcance" id="alcance" rows="2" cols="6"></textarea>
								
							</div>
						  <div class="6u 12u(xsmall)">
								<label for="tipo">Servicio</label>
								<select name="tipo" id="tipo">
                          <option value="">--Selecciona--</option>
                          <? $query = "SELECT id,nombre FROM servicios";
                            $result = mysql_query($query) or print("<option value=\"ERROR\">".mysql_error()."</option>");
                            while($servicio = mysql_fetch_assoc($result)){?>
                          <option value="<? echo $servicio['id']?>" <? echo $res['id']==$servicio['id']?"selected":""; ?> ><? echo $servicio['nombre']?></option>
						  
                          <?
                            }
                            ?>
							
                        </select>
								
							</div>
							<div class="6u 12u(xsmall)">
								<label for="id_area">Unidad de Negocio </label>
								<select name="id_area" id="id_area">
                          <option value="">--Selecciona--</option>
                          <? $query = "SELECT id,nombre FROM areas";
                            $result = mysql_query($query) or print("<option value=\"ERROR\">".mysql_error()."</option>");
                            while($areas = mysql_fetch_assoc($result)){?>
                          <option value="<? echo $areas['id']?>" <? echo $res['id_area']==$areas['id']?"selected":""; ?> ><? echo $areas['nombre']?></option>
						  
                          <?
                            }
                            ?>
							
                        </select>
							</div>
							<div class="6u 12u(xsmall)">
								<label for="id_oficina">Oficina</label>
								<select name="id_oficina" id="id_oficina" >
                          <option value="">--Selecciona--</option>
                          <? $query = "SELECT id,nombre FROM oficinas";
                            $result = mysql_query($query) or print("<option value=\"ERROR\">".mysql_error()."</option>");
                            while($oficinas = mysql_fetch_assoc($result)){?>
                          <option value="<? echo $oficinas['id']?>" <? echo $res['id_oficina']==$oficinas['id']?"selected":""; ?> ><? echo $oficinas['nombre']?></option>
						  
                          <?
                            }
                            ?>
							
                        </select>
							</div>
							
							
							<div class="12u 12u(xsmall)">
							<h3>Participantes</h3>
						<div class="table-wrapper">
							<table width="100%">
								<thead>
									<tr>
										<th colspan="3">Nombre</th>
										<th colspan="3">Participantes</th>
										<th colspan="3">Administrador</th>
										<th colspan="3">Demanda</th>
									</tr>
								</thead>
								 <?
  								$consulta4  = "select usuarios.nombre as consultor,usuarios.id as id from  usuarios WHERE id <>12";
								$resultado4 = mysql_query($consulta4) or die("La consulta fall&oacute;P1: $consulta4" . mysql_error());
								$count=1;
								$c=0;
								while($res4=mysql_fetch_assoc($resultado4)){
  								?>
								<tbody>
								<?
									if ($count%2==0){$c++
								?>	
							<tr style="background-color:#CCCCCC">
								<td colspan="3"><? echo $res4['consultor']?></td>
    							<td colspan="3"><input type="checkbox" id="participa<? echo $c; ?>" name="participa[]" value="<? echo $res4['id'];?>"/>
								<label for="participa<? echo $c; ?>"></label></td>
								<td colspan="3"><input  type="radio" id="admin<? echo $c; ?>" name="admin" value="<? echo $c; ?>"/><label for="admin<? echo $c; ?>"></label></td>
								<td colspan="3">
									<select name="demanda[]" id="demanda<? echo $c; ?>">
										<option value="0">Nada</option>
										<option value="1">Baja</option>
										<option value="2">Media</option>
										<option value="3">Alta</option>
									</select>
								</td>
							</tr>
						<?
						}else{$c++;
						?>		
							<tr style="background-color:#FFFFFF">
								<td colspan="3"><? echo $res4['consultor']?></td>
    							<td colspan="3"><input type="checkbox" id="participa<? echo $c; ?>" name="participa[]" value="<? echo $res4['id'];?>"><label for="participa<? echo $c; ?>"></label></td>
								<td colspan="3"><input type="radio" id="admin<? echo $c; ?>" name="admin" value="<? echo $c; ?>"/><label for="admin<? echo $c; ?>"></label></td>
								<td colspan="3">
									<select name="demanda[]" id="demanda<? echo $c; ?>">
										<option value="0">Nada</option>
										<option value="1">Baja</option>
										<option value="2">Media</option>
										<option value="3">Alta</option>
									</select>
								</td>
							</tr>
						<?
						}
						?>	
								</tbody>
								<?
								$count++;
								}
								?>
					  </table>
						</div>
						</div>
							<div class="6u 12u(xsmall)">
								<label for="fecha_inicio">Fecha Inicio </label>
								<input name="fecha_inicio" id="fecha_inicio" type="text"  value="<?echo $hoy?>" />
							</div>
							<div class="6u 12u(xsmall)">
								<label for="fecha_fin">Fecha Fin </label>
								<input name="fecha_fin" id="fecha_fin" type="text"  value="<?echo $hoy?>" />
							</div>
							<div class="6u 12u(xsmall)">
								<label for="costo_total">Valor Total</label>
								<input type="number" name="costo_total" id="costo_total" value="0" min="0" step="0.01"/>
							</div>
							<div class="6u 12u(xsmall)">
								<label for="contacto">Contacto</label>
								<input class="upper" type="text" name="contacto" id="contacto" value="" />
							</div>
							<div class="6u 12u(xsmall)">
								<label for="puesto">Puesto</label>
								<input class="upper" type="text" name="puesto" id="puesto" value="" />
							</div>
							<div class="6u 12u(xsmall)">
								<label for="email">Email</label>
								<input type="text" name="email" id="email" value="" onChange="validarcorreo(this.value)" />
							</div>
							<div class="6u 12u(xsmall)">
								<label for="telefono">Telefono</label>
								<input type="text" name="telefono" id="telefono" value="" />
							</div>
							<div class="6u 12u(xsmall)">
								<label for="condiciones">Condiciones</label>
								<textarea class="upper" name="condiciones" id="condiciones" rows="2" cols="6"></textarea>
							</div>
						</div>
						</div>		
						
						<h3>Agregar Archivo</h3>
						<div class="box">
						<div class="row uniform">
						<div class="6u 12u(xsmall)">
								<label for="nombre_archivo">Nombre</label>
								<input class="upper" name="nombre_archivo" type="text" id="nombre_archivo"  size="10"/>
						  </div>
							<div class="6u 12u(xsmall)">
								<label for="archivo">Archivo</label>
								<input name="archivo" type="file"  id="archivo"  size="10"/>
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