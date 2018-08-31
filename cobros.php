<?
session_start();
include "checar_sesion.php";
include "checar_sesion_admin.php";
include "coneccion.php";
//include "SimpleImage.php";
//$adminU=$_SESSION['adminU'];

$id=$_GET["id"];//id proyecto

//guardar
$guardar= $_POST["guardar"];
if($guardar=="Guardar")  
{
	$count=0;
	$recurrente=$_POST['recurrente'];
	$monto=$_POST['monto'];
	$concepto= mb_strtoupper($_POST['concepto'],'utf-8');
	$fecha=$_POST['fecha'];
	$estatus=$_POST['estatus'];
	$seguro=$_POST['seg'];
	if($idco!=""){//actualizar
		$queryupdate="update cobros set concepto='$concepto',monto='$monto',id_estatus_cobro=$estatus,fecha='$fecha',$seguro='$seguro' where id=$idco";
		$resultado = mysql_query($queryupdate) or die("Error en consulta actualizar cobros: $queryupdate " . mysql_error());
		echo "<script>alert('Actualizacion realizada con exito!!');</script>";
		echo"<script>location.href='buscar_cobros.php?d=$desde&h=$hasta'; </script>";
	}else{//nuevo
	
	if($recurrente==1){
	$count=$_POST['mes'];
	$count=$count-1;
	}
	
	for($i=0;$i<=$count;$i++){
		$queryinsert="insert into cobros (id_proyecto,concepto,monto,id_estatus_cobro,fecha,seguro) values ('$id','$concepto','$monto','1','$fecha','$seguro')";
		$resultado = mysql_query($queryinsert) or die("Error en consulta insert cobros: $queryinsert " . mysql_error());
		$fecha = strtotime ( '+1 month' , strtotime ( $fecha ) ) ;
		$fecha = date ( 'Y-m-j' , $fecha );
		
	  }//for
	  echo "<script>alert('Cobro agregado con exito!!');</script>";
	}//else
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
$("#fecha").datepicker({ dateFormat: 'yy-mm-dd' });
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
	function habilitar(){
		var r=document.getElementById('recurrente').checked;
		if(r==true){
			document.getElementById('mes').disabled=false;
			document.getElementById('mes').style.display="block";
			
		}else{
			document.getElementById('mes').disabled=true;
			document.getElementById('mes').style.display="none";
		}
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
					
					<!-- Nav pestanas-->
					<div class="12u 12u(xsmall)">
					<nav id="navegador" >
						<ul class="links">
							<li><a href="adm_cambia_proyecto.php?id=<? echo $id;?>">Portada</a></li>
							<li class="active"><a>Pendientes Facturar</a></li>
							<li><a href="facturas.php?id=<? echo $id;?>">Facturas</a></li>
							<li><a href="gasto.php?id=<? echo $id;?>">Gastos</a></li>
						</ul>
					</nav>
					</div>
				<!-- Main -->
				<div id="main">
					<form class="alt" name="enviarcobros" id="enviarcobros" method="post" enctype="multipart/form-data">			
						
						<div class="box">
						<div class="row uniform">
							<div class="6u 12u(xsmall)">
								<label for="concepto">Concepto</label>
								<textarea class="upper" name="concepto" id="concepto" rows="2" cols="6"><? echo $resco['concepto'];?></textarea>
								<input name="id" type="hidden" id="id" value="<? echo $res['id'];?>" />
							</div>
							<div class="6u 12u(xsmall)">
								<label for="monto">Monto</label>
								<input type="number" step="0.10" name="monto" id="monto" value="<? echo $resco['monto'];?>" required/>
							</div>
							<div class="6u 12u(xsmall)">
								<label for="fecha">Fecha</label>
								<input class="datepicker" type="text" name="fecha" id="fecha" value="<? echo $resco['fecha'];?>" required/>
							</div>
							<div class="6u 12u(xsmall)">
								<input type="checkbox" name="recurrente" id="recurrente" value="1" onChange="habilitar()"/>
								<label for="recurrente">Recurrente</label>
							</div>
							<div class="6u 12u(xsmall)">
								<label for="seg">CONFIRMAR</label>
								<select name="seg" id="seg">
									<option value="0">SELECCIONAR</option>
									<option value="1">SEGURO</option>
									<option value="2">PREGUNTAR</option>
								</select>
								<br>
								
							</div>
							<div class="6u 12u(xsmall)">
								<select name="mes" id="mes" disabled="disabled" style="display:none;"/>
									<option value="0">SELECCIONAR</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
								</select>
							</div>
							<a href="buscar_cobros.php">IR A FACTURAR<i class="fa fa-angle-double-right"></i></a>
						</div>
						</div>
						<div class="row">
							<ul class="actions fit">
								<li><input class="button special fit" type="submit" name="guardar" id="guardar" value="Guardar"/></li>
							</ul>
						</div>	
						<div class="12u 12u(xsmall)">
					<div class="table-wrapper">
					<table class="t">
						<thead>
							<th>Proyecto</th>
							<th>Concepto</th>
							<th>Monto</th>
							<th>Fecha</th>
							<th>Estatus</th>
							<th>Confirmar</th>
						</thead>
						<tbody>
						<?			
 $consulta  = "select c.*,p.nombre,p.id as idp,e.nombre as estatus,DATE_FORMAT(c.fecha, '%Y/%m/%d') as fecha,c.id,e.id as idestatus  from cobros c join proyectos p on c.id_proyecto=p.id join estatus_cobro e on c.id_estatus_cobro=e.id where p.id=$id and c.id_estatus_cobro=1";
							$resultado = mysql_query($consulta) or die("La consulta: $consulta" . mysql_error());
							$count=1;
							while($res=mysql_fetch_assoc($resultado)){
							if($res['seguro']==1)
							{
							$seguro="Seguro";
							}elseif($res['seguro']==2){
							$seguro="Preguntar";
							}
  						?>
						
							<tr>
							<td><? echo $res['nombre'];?></td>
							<td><? echo $res['concepto'];?></td>
							<td><? echo $res['monto'];?></td>
							<td><? echo $res['fecha'];?></td>
							<td><? echo $res['estatus'];?></td>
							<td><? echo $seguro;?></td>
							</tr>
						
					
		
						<?
						$count++;
						}
						?>
						</tbody>	
					</table>
					</div>
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
