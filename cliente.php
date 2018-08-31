<?
include "coneccion.php";
include "checar_sesion.php";
include "checar_sesion_admin.php";
$idcl=$_GET['idcl'];//id del cliente.
$d=$_GET['de'];//fecha desde
$h=$_GET['ha'];//fecha hasta

$querycliente="SELECT * FROM clientes where id='$idcl'";
$rescliente = mysql_query($querycliente) or die("la consulta a clientes fallo: $querycliente" . mysql_error());
$rescli=mysql_fetch_assoc($rescliente);

?>
<!DOCTYPE HTML>
<!--
	Massively by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Cliente</title>
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
         <!-- <ul class="visible actions">
            <li class="visible"><a href="buscar_cobros.php?d=<? echo $d;?>&h=<? echo $h;?>" class="button special icon fa-undo">Regresar</a></li>
          </ul>-->
		  <!-- Header -->
          <header id="header"> <a class="logo" href="http://bluewolf.com.mx/new/" target="_blank">Bluewolf</a> </header>
          <!-- Nav -->
          <nav id="nav">
            <ul class="actions fit">
              <li><a href="menu_admin.php" class="button special fit">Administraci&oacuten</a></li>
              <li><a href="adm_clientes.php" class="button special fit">Clientes</a></li>
              <li><a href="adm_proyectos.php" class="button special fit">Proyectos</a></li>
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
				<form name="cliente" id="cliente" method="post">
					<div class="box">
                		<div class="row uniform">
							<div class="4u 12u(xsmall)">
								<label for="nombre">Nombre</label>
                    			<input type="text" name="nombre" id="nombre" value="<? echo $rescli['nombre'];?>" readonly=""/>
							</div>
							<div class="4u 12u(xsmall)">
								<label for="razon">Raz&oacute;n Social</label>
                    			<input type="text" name="razon" id="razon" value="<? echo $rescli['razon'];?>" readonly=""/>
							</div>
							<div class="4u 12u(xsmall)">
								<label for="rfc">RFC</label>
                    			<input type="text" name="rfc" id="rfc" value="<? echo $rescli['rfc'];?>" readonly=""/>
							</div>
						</div>
						
						<div class="row uniform">
							<div class="4u 12u(xsmall)">
								<label for="direccion">Direcci&oacute;n</label>
                    			<input type="text" name="direccion" id="direccion" value="<? echo $rescli['direccion'];?>" readonly=""/>
							</div>
							<div class="4u 12u(xsmall)">
								<label for="cp">C&oacute;digo Postal</label>
                    			<input type="text" name="cp" id="cp" value="<? echo $rescli['cp'];?>" readonly=""/>
							</div>
							<div class="4u 12u(xsmall)">
								<label for="correo">Correo</label>
                    			<input type="text" name="correo" id="correo" value="<? echo $rescli['email'];?>" readonly=""/>
							</div>
						</div>
						
						<div class="row uniform">
							<div class="4u 12u(xsmall)">
								<label for="telcontacto">Tel&eacute;fono Cotacto</label>
                    			<input type="text" name="telcontacto" id="telcontacto" value="<? echo $rescli['telefono_contacto'];?>" readonly=""/>
							</div>
							<div class="4u 12u(xsmall)">
								<label for="cuenta">Cuenta</label>
                    			<input type="text" name="cuenta" id="cuenta" value="<? echo $rescli['cuenta'];?>" readonly=""/>
							</div>
							<div class="4u 12u(xsmall)">
								<label for="mp">M&eacute;todo de Pago</label>
                    			<input type="text" name="mp" id="mp" value="<? echo $rescli['metodo_pago'];?>" readonly=""/>
							</div>
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
            <ul>
              <li>&copy; Untitled</li>
              <li>Design: <a href="https://html5up.net">Bluewolf</a></li>
            </ul>
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

