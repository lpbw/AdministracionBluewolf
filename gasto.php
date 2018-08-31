<?
session_start();
include "checar_sesion.php";
include "checar_sesion_admin.php";
include "coneccion.php";
//include "SimpleImage.php";
//$adminU=$_SESSION['adminU'];
$id=$_GET["id"];
$pf=$_GET['pf'];
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
	$nombre= $_POST["nombre"];
	$id_cliente= $_POST["id_cliente"];
	$alcance= $_POST["alcance"];
	$tipo= $_POST["tipo"];
	$id_area= $_POST["id_area"];
	$id_oficina= $_POST["id_oficina"];
	$fecha_inicio= $_POST["fecha_inicio"];
	$fecha_fin= $_POST["fecha_fin"];
	$costo_total= $_POST["costo_total"];
	$contacto= $_POST["contacto"];
	$puesto= $_POST["puesto"];
	$email= $_POST["email"];
	$telefono= $_POST["telefono"];
	$condiciones= $_POST["condiciones"];;
	
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
	  							$nom="docs/".$id_insert."_".$_FILES['archivo']['name'];
								
	 							$nom2="".$id_insert."_".$_FILES["archivo"]["name"];
								
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
$("#fecha_inicio").datepicker({ dateFormat: 'yy-mm-dd' });
$("#fecha_fin").datepicker({ dateFormat: 'yy-mm-dd' });
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
						<li class="visible"><? if($pf==1){?><a href="proyectos_finalizados.php" class="button special icon fa-undo">Regresar</a><? }else{?><a href="adm_proyectos.php" class="button special icon fa-undo">Regresar</a><? }?></li>
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
							<li><? if($pf==1){?><a href="detalles_finalizados.php?id=<? echo $id;?>">Portada</a><? }else{?><a href="adm_cambia_proyecto.php?id=<? echo $id;?>">Portada</a><? }?></li>
							<? if($pf==1){}else{?><li><a href="cobros.php?id=<? echo $id;?>">Pendientes Facturar</a></li><? }?>
							<li><? if($pf==1){?><a href="facturas.php?id=<? echo $id;?>&pf=1">Facturas</a><? }else{?><a href="facturas.php?id=<? echo $id;?>">Facturas</a><? }?></li>
							<li class="active"><a>Gastos</a></li>
						</ul>
					</nav>
					</div>
				<!-- Main -->
				<div id="main">
					<div class="table-wrapper">
							<table class="t">
								<thead>
									<tr>
										<th>Proyecto</th>
										<th>Área</th>
										<th>Tipo de Gasto</th>
										<th>Método Pago</th>
										<th>Fecha</th>
										<th>No.Factura</th>
										<th>Proveedor</th>
										<th>Concepto</th>
										<th>Subtotal</th>
										<th>IVA/ISR</th>
										<th>Total</th>
									</tr>
								</thead>
							<tbody>
							<?	
							$queryhorario="SELECT g.*,p.nombre AS proyecto,a.nombre AS area,tg.nombre AS gasto,mp.tipo AS mpago,pr.nombre AS proveedor FROM gastos g left JOIN proyectos p ON g.id_proyecto=p.id JOIN areas a ON g.id_area=a.id JOIN tipo_gastos tg ON g.tipo_gasto=tg.id JOIN metodo_pago mp ON g.metodo_pago=mp.id JOIN proveedores pr ON g.proveedor=pr.id WHERE g.id_proyecto='$id'";
							$resultado = mysql_query($queryhorario) or die("Error en consulta horario: $queryhorario " . mysql_error());
							while($resh=mysql_fetch_assoc($resultado)){
							?>
							<tr>
								<td>
									<? echo $resh['proyecto'];?>
								</td>
								<td>
									<? echo $resh['area'];?>
								</td>
								<td>
									<? echo $resh['gasto'];?>
								</td>
								<td>
									<? echo $resh['mpago'];?>
								</td>
								<td>
									<? echo $resh['fecha'];?>
								</td>
								<td>
									<? echo $resh['factura'];?>
								</td>
								<td>
									<? echo $resh['proveedor'];?>
								</td>
								<td>
									<? echo $resh['concepto'];?>
								</td>
								<td>
									<? echo $resh['subtotal'];?>
								</td>
								<td>
									<?
									if($resh['iva']!=0)
									{	 
									echo $resh['iva'];
									}
									elseif($resh['retencion_iva']!=0)
									{
									echo $resh['retencion_iva'];
									}
									elseif($resh['retencion_isr']!=0)
									{
									echo $resh['retencion_isr'];
									}
									?>
								</td>
								<td>
									<? echo $resh['total'];?>
								</td>
							</tr>
							<? }?>
							</tbody>		
							</table>
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
