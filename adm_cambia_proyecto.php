<?
session_start();
include "checar_sesion.php";
include "checar_sesion_admin.php";
include "coneccion.php";
//include "SimpleImage.php";
//$adminU=$_SESSION['adminU'];
$id=$_GET["id"];
$tipo=$_SESSION['idA'];
$idusu=$_SESSION['idU'];
/*echo"<script>alert(\"$idusu\");</script>";*/
$consulta11  = "select * from participante_proyectos where id_proyecto=$id";
$resultado11 = mysql_query($consulta11) or die("Error en operacion11: " . mysql_error());
while($res11=mysql_fetch_assoc($resultado11))
{
	$resp=$res11['responsable'];
	if($resp=="Si")
	{
		$idusuario=$res11['id_usuario'];
		/*echo"<script>alert(\"$idusuario\");</script>";*/
		if($idusu==$idusuario)
		{
			
			$true=1;
		}
	}
}

$consulta  = "select * from proyectos where id=$id";
$resultado = mysql_query($consulta) or die("Error en operacion1: " . mysql_error());
if(@mysql_num_rows($resultado)>=1)	{		
	$res=mysql_fetch_assoc($resultado);
}
$consulta2  = "select * from proyectos p join servicios s on p.tipo=s.id where p.id=$id";
$resultado2 = mysql_query($consulta2) or die("Error en operacion1: " . mysql_error());
if(@mysql_num_rows($resultado2)>=1)	{		
	$res2=mysql_fetch_assoc($resultado2);
}

$guardar= $_POST["guardar"];
if($guardar=="Guardar")  
{
	$id=$_POST["id"];
	$nombre= mb_strtoupper($_POST["nombre"],'utf-8');
	$id_cliente= $_POST["id_cliente"];
	$alcance= mb_strtoupper($_POST["alcance"],'utf-8');
	$tipo= $_POST["tipo"];
	$id_area= $_POST["id_area"];
	$id_oficina= $_POST["id_oficina"];
	$fecha_inicio= $_POST["fecha_inicio"];
	$fecha_inicio=date("Y-m-d",strtotime($fecha_inicio));
	$fecha_fin= $_POST["fecha_fin"];
	$fecha_fin=date("Y-m-d",strtotime($fecha_fin));
	$costo_total= mb_strtoupper($_POST["costo_total"],'utf-8');
	$contacto= mb_strtoupper($_POST["contacto"],'utf-8');
	$puesto= mb_strtoupper($_POST["puesto"],'utf-8');
	$email= $_POST["email"];
	$telefono= mb_strtoupper($_POST["telefono"],'utf-8');
	$condiciones= mb_strtoupper($_POST["condiciones"],'utf-8');
	
	$consulta  = "update proyectos set nombre='$nombre', id_cliente='$id_cliente', alcance='$alcance', tipo='$tipo', id_area='$id_area', id_oficina='$id_oficina', fecha_inicio='$fecha_inicio', fecha_fin='$fecha_fin', costo_total='$costo_total', contacto='$contacto', puesto='$puesto', email='$email', telefono='$telefono', condiciones='$condiciones'  where id=$id ";
	$resultado = mysql_query($consulta) or die("Error en operacion1: " . mysql_error());
	$evento=  mysql_insert_id();
	
	//guardar participantes
	$consultau  = "select * from usuarios";
	$resultadou = mysql_query($consultau) or die("Error en operacion consultau: $consultau" . mysql_error());
	while($resu=mysql_fetch_assoc($resultadou)){
	$idu=$resu['id'];
	/*echo"<script>alert(\"id: $idu\");</script>";*/
	
	$consultap  = "select * from participante_proyectos where id_proyecto=$id and id_usuario=$idu";
	$resultadop = mysql_query($consultap) or die("Error en operacion consultau: $consultau" . mysql_error());
	
	$participantes=$_POST['participa'];//obtiene los participantes.
	$admin=$_POST['admin'];
	$demanda=$_POST['demanda'];
	
	$ad="No";
	$p=$participantes[$idu];
	/*echo"<script>alert(\"participante: $p\");</script>";*/
	$count=$p-1;
	$de=$demanda[$count];
	if($p==$admin){
			$ad="Si";
		}
	if(@mysql_num_rows($resultadop)>=1)	{//si existe registro
		if($p!=""){//si esta seleccionado
			
				$consulta  = "update participante_proyectos set responsable='$ad',demanda='$de' where id_proyecto=$id and id_usuario='$idu'";
				$resultado = mysql_query($consulta) or die("Error en consulta insert: $consulta " . mysql_error());
			
		}else{//no esta seleccionado
			$consulta  = "delete from participante_proyectos  where id_proyecto=$id and id_usuario='$idu'";
			$resultado = mysql_query($consulta) or die("Error en consulta insert: $consulta " . mysql_error());
		}
	}else{//si no existe registro
		if($p!=""){//si esta seleccionado
			$consulta  = "insert into participante_proyectos(id_proyecto, id_usuario, responsable,demanda) values($id, '$idu','$ad','$de')";
			$resultado = mysql_query($consulta) or die("Error en consulta insert: $consulta " . mysql_error());
		}
	}
	
		
	}//fin while
	

		//agregar documento
	if(empty($_FILES["archivo"]['name'])){
	/*echo "<script>alert('file vacio');</script>";*/
	}else{
		
	$consulta  = "insert into documentos(id_proyecto, nombre_archivo, fecha) values($id, '".$_POST["nombre_archivo"]."', now())";
	$resultado = mysql_query($consulta) or die("Error en operacion1: " . mysql_error());
	$id_insert=mysql_insert_id();
	
	
		//archivo
			if($resultado){
			if ($_FILES["archivo"]["error"]> 0 )  {
  				//echo "Error imagen: " . $_FILES["archivo"]["error"] . "<br />";	
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
	}
	echo"<script>alert(\"Cambios guardado con exito!!\");</script>";
	/*echo"<script>location.href=\"adm_proyectos.php\"; </script>";*/
	
}
$cerrar= $_POST["terminar"];
if($cerrar=="Cerrar Proyecto")
{
$consulta1  = "update proyectos set estatus=1 where id=$id";
$resultado1 = mysql_query($consulta1) or die("Error en operacion: $consulta1" . mysql_error());	
echo"<script>alert(\"Proyecto Terminado!!\");</script>";
echo"<script>window.location=\"adm_proyectos.php\"; </script>";
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

//eliminar documento
  function borrar(id,nombre,archivo){
        if(confirm('Deseas eliminar el documento '+nombre+'?')){
            var elem = document.createElement('input');
            elem.name='iddoc';
            elem.value = id;
            elem.type = 'hidden';
            $("#edproyecto").append(elem);
			
			var elem = document.createElement('input');
            elem.name='archivo';
            elem.value = archivo;
            elem.type = 'hidden';
            $("#edproyecto").append(elem);
			
			
            $("#edproyecto").attr('action','elimina_documento.php');
            $("#edproyecto").submit();
        }
    }
	
	//validar checkbox
	function cambiarPestanna(pestana){
		document.getElementById(pestana).style.background="#345678";
	}
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
					
					<!-- Nav pestanas-->
					<div class="12u 12u(xsmall)">
					<nav id="navegador" >
						<ul class="links">
							<li class="active"><a>Portada</a></li>
							<li><a href="cobros.php?id=<? echo $id;?>">Pendientes Facturar</a></li>
							<li><a href="facturas.php?id=<? echo $id;?>">Facturas</a></li>
							<li><a href="gasto.php?id=<? echo $id;?>">Gastos</a></li>
						</ul>
					</nav>
					</div>
				<!-- Main -->
				<div id="main">
				<!--<div id="pestanas">
                <ul id=lista>
                    <li id="pestana1"><a href='javascript:cambiarPestanna(pestana1);'>HTML</a></li>
                    <li id="pestana2"><a href='javascript:cambiarPestanna(pestana2);'>CSS</a></li>
					<li id="pestana1"><a href='javascript:cambiarPestanna(pestana1);'>HTML</a></li>
                    <li id="pestana2"><a href='javascript:cambiarPestanna(pestana2);'>CSS</a></li>
				</ul>	
		</div>-->
					<form class="alt" name="edproyecto" id="edproyecto" method="post" enctype="multipart/form-data">			
						<h3>Editar Proyecto</h3>
						<div class="box">
						<div class="row uniform">
							<div class="6u 12u(xsmall)">
								<label for="nombre">Nombre</label>
								<input class="upper" type="text" name="nombre" id="nombre" value="<? echo $res['nombre'];?>" required/>
								<input name="id" type="hidden" id="id" value="<? echo"$id";?>" />
							</div>
							<div class="6u 12u(xsmall)">
								<label for="id_cliente">Cliente</label>
								<select name="id_cliente" id="id_cliente">
                          <option value="">SELECCIONAR</option>
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
								<label for="alcance">Alcance</label>
								<textarea class="upper" name="alcance" id="alcance" rows="2" cols="6"><? echo $res['alcance'];?></textarea>
							</div>
							<div class="6u 12u(xsmall)">
								<label for="tipo">Servicio</label>
								<select name="tipo" id="tipo">
                          <option value="">SELECCIONAR</option>
                          <? $query = "SELECT id,nombre FROM servicios";
                            $result = mysql_query($query) or print("<option value=\"ERROR\">".mysql_error()."</option>");
                            while($servicio = mysql_fetch_assoc($result)){?>
                          <option value="<? echo $servicio['id']?>" <? echo $res2['tipo']==$servicio['id']?"selected":""; ?> ><? echo $servicio['nombre']?></option>
						  
                          <?
                            }
                            ?>
                        </select>
							</div>
							<div class="6u 12u(xsmall)">
								<label for="id_area">Unidades de Negocio </label>
								<select name="id_area" id="id_area">
                          <option value="">SELECCIONAR</option>
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
                          <option value="">SELECCIONAR</option>
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
  			$consulta4  = "select usuarios.nombre as consultor,usuarios.id as id from  usuarios WHERE id<>12";
			$resultado4 = mysql_query($consulta4) or die("La consulta fall&oacute;P1: $consulta4" . mysql_error());
			$count=1;
			$c=0;
			
			while($res4=mysql_fetch_assoc($resultado4)){
			$idusuario=$res4['id'];
			$consulta3  = "select * from participante_proyectos where id_proyecto=$id AND id_usuario=$idusuario";
			$resultado3 = mysql_query($consulta3) or die("Error en operacion1: " . mysql_error());
			$res3=mysql_fetch_assoc($resultado3);
			$usuario=$res3['id_usuario'];

  ?>
								<tbody>
								<?
						if ($count%2==0){$c++
						?>	
							<tr style="background-color:#CCCCCC">
								<td colspan="3"><? echo $res4['consultor']?></td>
    							<td colspan="3"><input type="checkbox" id="participa<? echo $c; ?>" name="participa[<? echo $res4['id'];?>]" value="<? echo $res4['id'];?>" <? echo $usuario==$res4['id']?"checked":"";?> onChange="validarcheck(this.value)"/>
								<label for="participa<? echo $c; ?>"></label></td>
								<td colspan="3"><input  type="radio" id="admin<? echo $c; ?>" name="admin" value="<? echo $c; ?>" <? echo $res3['responsable']=="Si"?"checked":"";?>/><label for="admin<? echo $c; ?>"></label></td>
								<td colspan="3">
									<select name="demanda[]" id="demanda<? echo $c; ?>">
										<option value="0" <? echo $res3['demanda']=="0"?"selected":"";?>>Nada</option>
										<option value="1"<? echo $res3['demanda']=="1"?"selected":"";?>>Baja</option>
										<option value="2"<? echo $res3['demanda']=="2"?"selected":"";?>>Media</option>
										<option value="3"<? echo $res3['demanda']=="3"?"selected":"";?>>Alta</option>
									</select>								</td>
							</tr>
						<?
						}else{$c++;
						?>		
							<tr style="background-color:#FFFFFF">
								<td colspan="3"><? echo $res4['consultor']?></td>
    							<td colspan="3"><input type="checkbox" id="participa<? echo $c; ?>" name="participa[<? echo $res4['id'];?>]" value="<? echo $res4['id'];?>"<? echo $usuario==$res4['id']?"checked":"";?>><label for="participa<? echo $c; ?>"></label></td>
								<td colspan="3"><input type="radio" id="admin<? echo $c; ?>" name="admin" value="<? echo $c; ?>"<? echo $res3['responsable']=="Si"?"checked":"";?>/><label for="admin<? echo $c; ?>"></label></td>
								<td colspan="3">
									<select name="demanda[]" id="demanda<? echo $c; ?>">
										<option value="0" <? echo $res3['demanda']=="0"?"selected":"";?>>Nada</option>
										<option value="1"<? echo $res3['demanda']=="1"?"selected":"";?>>Baja</option>
										<option value="2"<? echo $res3['demanda']=="2"?"selected":"";?>>Media</option>
										<option value="3"<? echo $res3['demanda']=="3"?"selected":"";?>>Alta</option>
									</select>								</td>
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
								<input name="fecha_inicio" id="fecha_inicio" type="text"  value="<? echo date("d-m-Y",strtotime($res['fecha_inicio']));?>" readonly=""/>
							</div>
							<div class="6u 12u(xsmall)">
								<label for="fecha_fin">Fecha Fin </label>
								<input name="fecha_fin" id="fecha_fin" type="text"  value="<? echo date("d-m-Y",strtotime($res['fecha_fin']));?>" readonly=""/>
							</div>
							<div class="6u 12u(xsmall)">
								<label for="costo_total">Valor Total</label>
								<input type="text" name="costo_total" id="costo_total" value="<? echo $res['costo_total'];?>" />
							</div>
							<div class="6u 12u(xsmall)">
								<label for="contacto">Contacto</label>
								<input class="upper" type="text" name="contacto" id="contacto" value="<? echo $res['contacto'];?>" />
							</div>
							<div class="6u 12u(xsmall)">
								<label for="puesto">Puesto</label>
								<input class="upper" type="text" name="puesto" id="puesto" value="<? echo $res['puesto'];?>" />
							</div>
							<div class="6u 12u(xsmall)">
								<label for="email">Email</label>
								<input type="text" name="email" id="email" value="<? echo $res['email'];?>" />
							</div>
							<div class="6u 12u(xsmall)">
								<label for="telefono">Telefono</label>
								<input type="text" name="telefono" id="telefono" value="<? echo $res['telefono'];?>" />
							</div>
							<div class="6u 12u(xsmall)">
								<label for="condiciones">Condiciones</label>
								<textarea class="upper" name="condiciones" id="condiciones" rows="2" cols="6"><? echo $res['condiciones'];?></textarea>
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
						
						<h3>Archivos</h3>
						
						
							<table>
								<thead>
								<th>No.</th>
							  <th colspan="4">Nombre</th>
									<th colspan="4">Archivo</th>
									<th colspan="4">Fecha</th>
								</thead>
								 <?
								 $contador=0;
  								$consulta5  = "select * from documentos where id_proyecto=$id";
								$resultado5 = mysql_query($consulta5) or die("La consulta fall&oacute;P1: $consulta5" . mysql_error());
								while($res5=mysql_fetch_assoc($resultado5)){
								$contador++;
  								?>
								<tbody>	
								<td><? echo $contador;?></td>
							  <td colspan="4"><? echo $res5['nombre_archivo']?></td>
									<td colspan="4"><a href="docs/<? echo $res5['archivo']?>" target="_blank" class="texto_contenido"><? echo $res5['archivo']?></a></td>
									<td colspan="4"><? echo $res5['fecha']?></td>
									<td><a href="javascript:borrar(<? echo $res5['id']?>, '<? echo $res5['nombre_archivo']?>', '<? echo $res5['archivo']?>');"><i class="fa fa-trash-o fa-lg"></i></a></td>
								</tbody>
								<?
								}
								?>
							</table>
						
						<div class="row">
							<ul class="actions fit">
								<li><input class="button special fit" type="submit" name="guardar" id="guardar" value="Guardar"/></li>
							</ul>
							<? if ($tipo==1 || $true==1){?>
							<ul class="actions fit">
								<li><input class="button special fit" type="submit" name="terminar" id="terminar" value="Cerrar Proyecto"/></li>
							</ul>
							<? } ?>
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