<?
	session_start();
	include "checar_sesion.php";
	include "checar_sesion_admin.php";
	include "coneccion.php";
	$idp=$_GET['id'];//id del proyecto
	
	$consulta  = "select * from proyectos where id=$idp";
	$resultado = mysql_query($consulta) or die("Error en operacion1: " . mysql_error());
	if(@mysql_num_rows($resultado)>=1)
	{		
		$res=mysql_fetch_assoc($resultado);
	}
?>

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
	</head>

	<body class="is-loading">
		
		
		<!-- Wrapper -->
			<div id="wrapper">
					<ul class="visible actions">
						<li class="visible"><a href="proyectos_finalizados.php" class="button special icon fa-undo">Regresar</a></li>
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
							<li><a href="facturas.php?id=<? echo $idp;?>&pf=1">Facturas</a></li>
							<li><a href="gasto.php?id=<? echo $idp;?>&pf=1">Gastos</a></li>
						</ul>
					</nav>
					</div>
				<!-- Main -->
				<div id="main">
					<form class="alt" name="edproyecto" id="edproyecto" method="post" enctype="multipart/form-data">			
						<h3>Detalles</h3>
						<div class="box">
						<div class="row uniform">
							<div class="6u 12u(xsmall)">
								<label for="nombre">Nombre</label>
								<input class="upper" type="text" name="nombre" id="nombre" value="<? echo $res['nombre'];?>" disabled="disabled"/>
								<input name="id" type="hidden" id="id" value="<? echo"$id";?>" />
							</div>
							<div class="6u 12u(xsmall)">
								<label for="id_cliente">Cliente</label>
								<select name="id_cliente" id="id_cliente" disabled="disabled">
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
								<textarea class="upper" name="alcance" id="alcance" rows="2" cols="6" disabled="disabled"><? echo $res['alcance'];?></textarea>
							</div>
							<div class="6u 12u(xsmall)">
								<label for="tipo">Servicio</label>
								<select name="tipo" id="tipo" disabled="disabled">
                          <option value="">SELECCIONAR</option>
                          <? $query = "SELECT id,nombre FROM servicios";
                            $result = mysql_query($query) or print("<option value=\"ERROR\">".mysql_error()."</option>");
                            while($servicio = mysql_fetch_assoc($result)){?>
                          <option value="<? echo $servicio['id']?>" <? echo $res['tipo']==$servicio['id']?"selected":""; ?> ><? echo $servicio['nombre']?></option>
						  
                          <?
                            }
                            ?>
                        </select>
							</div>
							<div class="6u 12u(xsmall)">
								<label for="id_area">Unidades de Negocio </label>
								<select name="id_area" id="id_area" disabled="disabled">
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
								<select name="id_oficina" id="id_oficina" disabled="disabled">
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
										<th colspan="3">Administrador</th>
										<th colspan="3">Demanda</th>
									</tr>
								</thead>
								<tbody>
								<?
									$querypart = "SELECT pp.id,pp.id_proyecto,pp.id_usuario,pp.responsable,pp.demanda,u.nombre as usuario FROM participante_proyectos pp JOIN usuarios u ON pp.id_usuario=u.id WHERE id_proyecto=$idp";
                            		$resultpart = mysql_query($querypart) or print("error $queryparticipantes".mysql_error());
									while($respart = mysql_fetch_assoc($resultpart))
									{
								?>
										<td colspan="3"><? echo $respart['usuario'];?></td>
										<td colspan="3"><? echo $respart['responsable'];?></td>
										<td colspan="3"><select name="demanda" id="demanda" style="color:#000000;margin-left:40%;" disabled="disabled">
										<option value="0" <? echo $respart['demanda']=="0"?"selected":"";?>>Nada</option>
										<option value="1"<? echo $respart['demanda']=="1"?"selected":"";?>>Baja</option>
										<option value="2"<? echo $respart['demanda']=="2"?"selected":"";?>>Media</option>
										<option value="3"<? echo $respart['demanda']=="3"?"selected":"";?>>Alta</option>
									</select>	</td>
								<?
									}
								?>		
								</tbody>
					  </table>
						</div>	
						</div>
						
							<div class="6u 12u(xsmall)">
								<label for="fecha_inicio">Fecha Inicio </label>
								<input name="fecha_inicio" id="fecha_inicio" type="text"  value="<? echo date("d-m-Y",strtotime($res['fecha_inicio']));?>" disabled="disabled"/>
							</div>
							<div class="6u 12u(xsmall)">
								<label for="fecha_fin">Fecha Fin </label>
								<input name="fecha_fin" id="fecha_fin" type="text"  value="<? echo date("d-m-Y",strtotime($res['fecha_fin']));?>" disabled="disabled"/>
							</div>
							<div class="6u 12u(xsmall)">
								<label for="costo_total">Valor Total</label>
								<input type="text" name="costo_total" id="costo_total" value="<? echo $res['costo_total'];?>" disabled="disabled"/>
							</div>
							<div class="6u 12u(xsmall)">
								<label for="contacto">Contacto</label>
								<input class="upper" type="text" name="contacto" id="contacto" value="<? echo $res['contacto'];?>" disabled="disabled"/>
							</div>
							<div class="6u 12u(xsmall)">
								<label for="puesto">Puesto</label>
								<input class="upper" type="text" name="puesto" id="puesto" value="<? echo $res['puesto'];?>" disabled="disabled"/>
							</div>
							<div class="6u 12u(xsmall)">
								<label for="email">Email</label>
								<input type="text" name="email" id="email" value="<? echo $res['email'];?>" disabled="disabled"/>
							</div>
							<div class="6u 12u(xsmall)">
								<label for="telefono">Telefono</label>
								<input type="text" name="telefono" id="telefono" value="<? echo $res['telefono'];?>" disabled="disabled"/>
							</div>
							<div class="6u 12u(xsmall)">
								<label for="condiciones">Condiciones</label>
								<textarea class="upper" name="condiciones" id="condiciones" rows="2" cols="6" disabled="disabled"><? echo $res['condiciones'];?></textarea>
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
  								$consulta5  = "select * from documentos where id_proyecto=$idp";
								$resultado5 = mysql_query($consulta5) or die("La consulta fall&oacute;P1: $consulta5" . mysql_error());
								while($res5=mysql_fetch_assoc($resultado5)){
								$contador++;
  								?>
								<tbody>	
								<td><? echo $contador;?></td>
							  <td colspan="4"><? echo $res5['nombre_archivo']?></td>
									<td colspan="4"><a href="docs/<? echo $res5['archivo']?>" target="_blank" class="texto_contenido"><? echo $res5['archivo']?></a></td>
									<td colspan="4"><? echo $res5['fecha']?></td>
								</tbody>
								<?
								}
								?>
							</table>
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