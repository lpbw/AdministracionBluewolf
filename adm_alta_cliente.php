<?
session_start();
include "checar_sesion.php";
include "checar_sesion_admin.php";
include "coneccion.php";

$cn=$_GET["cn"];//nuevo cliente desde nuevo proyecto.

//para guardar cliente
$guardar= $_POST["guardar"];
if($guardar=="Guardar")  
{
	//$id=$_POST["id"];
	$nombre=  mb_strtoupper($_POST["nombre"],'utf-8');
	$razon= mb_strtoupper($_POST["razon"],'utf-8');
	$rfc= mb_strtoupper($_POST["rfc"],'utf-8');
	$direccion= mb_strtoupper($_POST["direccion"],'utf-8');
	$numero= mb_strtoupper($_POST["numero"],'utf-8');
	$colonia= mb_strtoupper($_POST["colonia"],'utf-8');
	$cp= $_POST["cp"];
	$estado= mb_strtoupper($_POST["estado"],'utf-8');
	$municipio= mb_strtoupper($_POST["municipio"],'utf-8');
	$nombre_recepcion_factura= mb_strtoupper($_POST["nombre_recepcion_factura"],'utf-8');
	$email= $_POST["email"];
	$telefono= mb_strtoupper($_POST["telefono"],'utf-8');
	$departamento= mb_strtoupper($_POST["departamento"],'utf-8');
	$contacto_pago= mb_strtoupper($_POST["contacto_pago"],'utf-8');
	$email_contacto= $_POST["email_contacto"];
	$telefono_contacto= mb_strtoupper($_POST["telefono_contacto"],'utf-8');
	$dias_pago= mb_strtoupper($_POST["dias_pago"],'utf-8');
	$dias_recepcion_factura= mb_strtoupper($_POST["dias_recepcion_factura"],'utf-8');
	$metodo_pago= mb_strtoupper($_POST["metodo_pago"],'utf-8');
	$cuenta= mb_strtoupper($_POST["cuenta"],'utf-8');
	$cfdi= $_POST["cfdi"];
	
	
	$consulta  = "insert into clientes(nombre, razon, rfc, direccion, numero, colonia, cp, estado, municipio, nombre_recepcion_factura, email, telefono, departamento, contacto_pago, email_contacto, telefono_contacto, dias_pago, dias_recepcion_factura, metodo_pago, cuenta,id_cfdi) values('$nombre', '$razon', '$rfc', '$direccion', '$numero', '$colonia', '$cp', '$estado', '$municipio', '$nombre_recepcion_factura', '$email', '$telefono', '$departamento', '$contacto_pago', '$email_contacto', '$telefono_contacto', '$dias_pago', '$dias_recepcion_factura', '$metodo_pago', '$cuenta','$cfdi') ";
	$resultado = mysql_query($consulta) or die("Error en operacion1: " . mysql_error());
	$evento=  mysql_insert_id();
	echo"<script>alert(\"Cliente guardado\");</script>";
	
	
	
	
	
	
	if($cn==1)
	{
		echo"<script>location.href=\"adm_alta_proyecto.php\"; </script>";
	}
	else
	{	
	
		echo"<script>var opcion=confirm(\"Desde agregar un proyecto a este cliente?\");
    if (opcion == true) {
        location.href=\"adm_alta_proyecto.php\";
	} else {
	    location.href=\"adm_cambia_cliente.php?id=$evento\";
	}</script>";
	
	}
	
	
}

?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Clientes</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-loading">

		<!-- Wrapper -->
			<div id="wrapper">
					<ul class="visible actions">
						<li class="visible"><a href="adm_clientes.php" class="button special icon fa-undo">Regresar</a></li>
					</ul>
				<!-- Header -->
					<header id="header">
						<a class="logo" href="http://bluewolf.com.mx/new/" target="_blank">Bluewolf</a>					
					</header>

				<!-- Nav -->
					<nav id="nav">
						<ul class="actions fit">
							<li><a href="menu_admin.php" class="button special fit">Administraci&oacuten </a></li>
							<li><a href="adm_clientes.php" class="button special fit">Clientes</a></li>
							<li><a href="adm_proyectos.php" class="button special fit">Proyectos</a></li>
							<li><a href="buscar_cobros.php" class="button special fit">Facturaci&oacuten </a></li>
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
					<form class="alt" name="edcliente" id="edcliente" method="post">			
						<h3>Nuevo Cliente</h3>
						<div class="box">
						<div class="row uniform">
							<div class="6u 12u(xsmall)">
								<label for="nombre">Nombre</label>
								<input class="upper" type="text" name="nombre" id="nombre" value="" required/>
							</div>
							<div class="6u 12u(xsmall)">
								<label for="razon">Raz&oacuten Social</label>
								<input class="upper" type="text" name="razon" id="razon" value="" />
							</div>
							<div class="6u 12u(xsmall)">
								<label for="rfc">RFC</label>
								<input class="upper" type="text" name="rfc" id="rfc" value="" required/>
							</div>
							<div class="6u 12u(xsmall)">
								<label for="direccion">Direcci&oacuten</label>
								<input class="upper" type="text" name="direccion" id="direccion" value="" />
							</div>
							<div class="6u 12u(xsmall)">
								<label for="numero">N&uacutemero</label>
								<input class="upper" type="text" name="numero" id="numero" value="" />
							</div>
							<div class="6u 12u(xsmall)">
								<label for="colonia">Colonia</label>
								<input class="upper" type="text" name="colonia" id="colonia" value="" />
							</div>
							<div class="6u 12u(xsmall)">
								<label for="cp">C&oacutedigo Postal</label>
								<input class="upper" type="text" name="cp" id="cp" value="" required/>
							</div>
							<div class="6u 12u(xsmall)">
								<label for="estado">Estado</label>
								<input class="upper" type="text" name="estado" id="estado" value="" />
							</div>
							<div class="6u 12u(xsmall)">
								<label for="municipio">Municipio</label>
								<input class="upper" type="text" name="municipio" id="municipio" value="" />
							</div>
							<div class="6u 12u$(xsmall)">
								<label for="metodo_pago">M&eacutetodo Pago</label>
								<input class="upper" type="text" name="metodo_pago" id="metodo_pago" value="" />
							</div>
							<div class="6u 12u$(xsmall)">
								<label for="cuenta">Cuenta</label>
								<input class="upper" type="text" name="cuenta" id="cuenta" value="" />
							</div>
							<div class="6u 12u$(xsmall)">
								<label for="cfdi">uso CFDI</label>
								<select name="cfdi" id="cfdi">
									<option value="0">SELECCIONAR</option>
									<?
										$query="select * from cfdi";
				$resquery=mysql_query($query) or die("La consulta: $query" . mysql_error());
				while($res=mysql_fetch_assoc($resquery))
				{
									?>
									<option value="<? echo $res['id'];?>"><? echo $res['nombre'];?></option>
									<?
									}
									?>
								</select>
							</div>
						</div>
						</div>
						
						<h3>Contacto de Facturaci&oacuten </h3>
						
						<div class="box">
						<div class="row uniform">
							<div class="6u 12u(xsmall)">
								<label for="nombre_recepcion_factura">Nombre</label>
								<input class="upper" type="text" name="nombre_recepcion_factura" id="nombre_recepcion_factura" value="" />
							</div>
							<div class="6u 12u(xsmall)">
								<label for="email">Email</label>
								<input class="upper" type="text" name="email" id="email" value="" />
							</div>
							<div class="6u 12u(xsmall)">
								<label for="telefono">Tel&eacutefono </label>
								<input class="upper" type="text" name="telefono" id="telefono" value="" />
							</div>
							<div class="6u 12u(xsmall)">
								<label for="departamento">Departamento</label>
								<input class="upper" type="text" name="departamento" id="departamento" value="" />
							</div>
							<div class="6u 12u(xsmall)">
								<label for="dias_recepcion_factura">Dias Recepci&oacuten </label>
								<input class="upper" type="text" name="dias_recepcion_factura" id="dias_recepcion_factura" value="" />
							</div>
						</div>
						</div>	
						
						<h3>Contacto de Pago </h3>
						
						<div class="box">
						<div class="row uniform">
							<div class="6u 12u(xsmall)">
								<label for="contacto_pago">Nombre</label>
								<input class="upper" type="text" name="contacto_pago" id="contacto_pago" value="" required/>
							</div>
							<div class="6u 12u(xsmall)">
								<label for="email_contacto">Email</label>
								<input  type="text" name="email_contacto" id="email_contacto" value="" required/>
							</div>
							<div class="6u 12u(xsmall)">
								<label for="telefono_contacto">Tel&eacutefono </label>
								<input class="upper" type="text" name="telefono_contacto" id="telefono_contacto" value="" required/>
							</div>
							<div class="6u 12u(xsmall)">
								<label for="dias_pago">Dias de Pago </label>
								<input type="text" name="dias_pago" id="dias_pago" value="" required/>
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
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>