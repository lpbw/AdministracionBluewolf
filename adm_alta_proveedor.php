<?
    session_start();
    include "checar_sesion.php";
    include "checar_sesion_admin.php";
    include "coneccion.php";

    // recibe el id del proveedor que quiere modificar
    $IdProveedor = $_GET["idp"];

    //Cuando se va a editiar un proveedor
    if ($IdProveedor != "")
    {
        $QueryListaproveedores = "SELECT id_lista,servicio,proveedor,telefono,correo,observacion FROM listaproveedores WHERE id_lista=$IdProveedor";
		$ResultadoLista = mysql_query($QueryListaproveedores) or die("Query fallo: $QueryListaproveedores".mysql_error());
		$ResLista = mysql_fetch_assoc($ResultadoLista);
    }

    // guardar el nuevo proveedor
    if($_POST["guardar"]=="Guardar")  
    {
        $Servico = $_POST['servicio'];
        $Proveedor = $_POST['proveedor'];
        $Telefono = $_POST['telefono'];
        $Correo = $_POST['correo'];
        $Observacion = $_POST['observacion'];
        $InsertLista = "INSERT INTO listaproveedores(servicio,proveedor,telefono,correo,observacion)VALUES('$Servico','$Proveedor','$Telefono','$Correo','$Observacion')";
        $ResultadoInsertLista = mysql_query($InsertLista) or die("Query fallo: $InsertLista".mysql_error());
        echo"<script>alert(\"Proveedor Guardado\");</script>";
        echo"<script>window.location=\"adm_proveedores.php\"; </script>";
        
    }

    // guarda el proveedor modificado
    if($_POST["guardar"]=="Modificar")  
    {
        $Servico = $_POST['servicio'];
        $Proveedor = $_POST['proveedor'];
        $Telefono = $_POST['telefono'];
        $Correo = $_POST['correo'];
        $Observacion = $_POST['observacion'];
        $UpdateLista = "UPDATE listaproveedores SET servicio='$Servico',proveedor='$Proveedor',telefono='$Telefono',correo='$Correo',observacion='$Observacion' WHERE id_lista=$IdProveedor";
        $ResultadoUpdateLista = mysql_query($UpdateLista) or die("Query fallo: $UpdateLista".mysql_error());
        echo"<script>alert(\"Proveedor Modificado\");</script>";
        echo"<script>window.location=\"adm_proveedores.php\"; </script>";
    }

?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Proveedor</title>
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
				<li class="visible"><a href="adm_proveedores.php" class="button special icon fa-undo">Regresar</a></li>
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
					<form class="alt" name="ListaProveedor" id="ListaProveedor" method="post" enctype="multipart/form-data">			
						<h3><?echo $IdProveedor!=""?"Editar":"Nuevo";?> Proveedor</h3>	
						<div class="box">
						    <div class="row">

							    <div class="6u 12u(xsmall)">
								    <label for="servicio">Servicio</label>
                                    <textarea class="upper" name="servicio" id="servicio" rows="2" cols="6"><?echo $ResLista['servicio'];?></textarea>
							    </div>

                                <div class="6u 12u(xsmall)">
                                    <label for="proveedor">Proveedor</label>
                                    <input class="upper" type="text" name="proveedor" id="proveedor" value="<?echo $ResLista['proveedor'];?>" required/>
                                </div>

							    <div class="6u 12u(xsmall)">
								    <label for="telefono">Teléfono</label>
                                    <input class="upper" type="text" name="telefono" id="telefono" value="<?echo $ResLista['telefono'];?>" required/>	
							    </div>

						        <div class="6u 12u(xsmall)">
								    <label for="correo">Correo</label>
                                    <input class="upper" type="text" name="correo" id="correo" value="<?echo $ResLista['correo'];?>" required/>	
							    </div>

                                <div class="6u 12u(xsmall)">
								    <label for="observacion">Observacion</label>
                                    <textarea class="upper" name="observacion" id="observacion" rows="2" cols="6"><?echo $ResLista['observacion'];?></textarea>
							    </div>

                                <div class="row">
                                    <ul class="actions fit">
                                        <li><input class="button special fit" type="submit" name="guardar" id="guardar" value="<?echo $IdProveedor!=""?"Modificar":"Guardar";?>"/></li>
                                    </ul>
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