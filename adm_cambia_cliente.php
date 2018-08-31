<?
// Valores recibidos de la liga enviada al cliente, sirven para identificar si es un cliente.
$f=0;
$val=0;
$f=$_GET["f"];//valor recibido de la liga para el cliente
$val=$_GET["val"];//valor recibido de la liga para el cliente

session_start();
//si los valores $f y $val estan en 0 es un administrador
if($f==0 and $val==0){
include "checar_sesion.php";
include "checar_sesion_admin.php";
$tipo=$_SESSION['idA'];
}

include "coneccion.php";

$id=$_GET["id"];//recibe id cuando el usuario es administrador
$p=0;
$id2=$_GET["mor"];//recibe el id de la variable mor enviada en la liga del cliente.
$id2=substr($id2,0,3);//extrai el numero enviado en la cadena de caracteres de la variable mor

for ($i=100;$i<=999;$i++)
{

	if($id2==$i)
	{
		$p=$id2;
		break;
	}
}
if($p==0)
{
	
	$id2=substr($id2,0,2);//extrai el numero enviado en la cadena de caracteres de la variable mor
	for ($i=10;$i<=99;$i++)
	{
	
		if($id2==$i)
		{
			$p=$id2;
			break;
		}
	}
}

if($p==0)
{
	$id2=substr($id2,0,1);//extrai el numero enviado en la cadena de caracteres de la variable mor
	
	for ($i=0;$i<=9;$i++)
	{
	
		if($id2==$i)
		{
			$p=$id2;
			break;
		}
	}
}
//if la variable $id2 tiene valor llena la pagina con los valores de ese cliente.
if($id2!=""){
$consulta  = "select * from clientes where id=$p";
$resultado = mysql_query($consulta) or die("Error en operacion1: " . mysql_error());
if(@mysql_num_rows($resultado)>=1)	{		
	$res=mysql_fetch_assoc($resultado);
 }
}else{//si no tiene llena la pagina con el $id 
$consulta  = "select * from clientes where id=$id";
$resultado = mysql_query($consulta) or die("Error en operacion1: " . mysql_error());
if(@mysql_num_rows($resultado)>=1)	{		
	$res=mysql_fetch_assoc($resultado);
 }
}

//para guardar cambios en cliente
$guardar= $_POST["guardar"];
if($guardar=="Guardar")  
{
	$id=$_POST["id"];
	$nombre= mb_strtoupper($_POST["nombre"],'utf-8');
	$razon= mb_strtoupper($_POST["razon"],'utf-8');
	$rfc= mb_strtoupper($_POST["rfc"],'utf-8');
	$direccion= mb_strtoupper($_POST["direccion"],'utf-8');
	$numero= $_POST["numero"];
	$colonia= mb_strtoupper($_POST["colonia"],'utf-8');
	$cp= mb_strtoupper($_POST["cp"],'utf-8');
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
	if($p!=0){$id=$p;}
	$consulta  = "update clientes set nombre='$nombre', razon='$razon', rfc='$rfc', direccion='$direccion', numero='$numero', colonia='$colonia', cp='$cp', estado='$estado', municipio='$municipio', nombre_recepcion_factura='$nombre_recepcion_factura', email='$email', telefono='$telefono', departamento='$departamento', contacto_pago='$contacto_pago', email_contacto='$email_contacto', telefono_contacto='$telefono_contacto', dias_pago='$dias_pago', dias_recepcion_factura='$dias_recepcion_factura', metodo_pago='$metodo_pago', cuenta='$cuenta', id_cfdi='$cfdi' where id=$id ";
	$resultado = mysql_query($consulta) or die("Error en operacion1: " . mysql_error());
	$evento=  mysql_insert_id();
	
	if($f==0 and $val==0){//administrador
	echo"<script>alert(\"Cliente guardado\");</script>";
	echo"<script>location.href=\"adm_clientes.php\"; </script>";
	}else{//cliente
	$up=$id+30;
	echo"<script>alert(\"Informacion guardada gracias!!\");</script>";
    echo"<script>location.href='adm_cambia_cliente.php?val=1&id=$up&mdl=345&f=1&mor=".$p."kj".$up."lk';</script>";
	}
	
	
	
}//fin if guardar

//eliminar un cliente
$borrar= $_POST["eliminar"];
if($borrar=="Eliminar")  
{
	$id=$_POST["id"];
	
	$consulta  = "delete from clientes where id=$id ";
	$resultado = mysql_query($consulta) or die("Error en operacion1: " . mysql_error());
	echo"<script>alert(\"Cliente borrado\");</script>";
	echo"<script>location.href=\"adm_clientes.php\"; </script>";
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
		<script>
			function copiar(){
				var playButton = $('#copiar'); 
				var linke=document.getElementById("link").value;
				copyToClipboard(linke);
			}
			
		function copyToClipboard(linke) {
        $("body").append("<input type='text' id='temp'>"); // Acá se crea un input dinamicamente con un id para luego asignarle un valor sombreado
        $("#temp").val(linke).select(); // Acá se obtiene el id del boton que hemos creado antes y se le agrega un valor y luego se le sombrea con select(). Para agregar lo que se quiere copiar editas val("EDITAESTOAQUÍ")
        document.execCommand("copy"); // document.execCommand("copy") manda a copiar el texto seleccionado en el documento
        $("#temp").remove();
		alert('link copiado');
    }
		</script>
	</head>
	<body class="is-loading">

		<!-- Wrapper -->
			<div id="wrapper">
			<? if($f==0 and $val==0){//administrador?>
					<ul class="visible actions">
						<li class="visible"><a href="adm_clientes.php" class="button special icon fa-undo">Regresar</a></li>
					</ul>
			<? }?>		
				<!-- Header -->
					<header id="header">
						<a href="http://bluewolf.com.mx/new/" target="_blank"  class="logo">Bluewolf</a>					
					</header>
				
				<!-- Nav -->
					<nav id="nav">
						<ul class="actions fit">
							<li><a href="menu_admin.php" class="button special fit">Administraci&oacuten</a></li>
							<li><a href="adm_clientes.php" class="button special fit">Clientes</a></li>
							<li><a href="#" class="button special fit">Proyectos</a></li>
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
					<form class="alt" name="edcliente" id="edcliente" method="post">			
						<h3>Editar Cliente</h3>
						<div class="box">
						<div class="row uniform">
						
							<div class="6u 12u(xsmall)">
								<label for="nombre">Nombre</label>
								<input  required class="upper" type="text" name="nombre" id="nombre" value="<? echo $res['nombre'];?>" <? echo $val==1?"readonly":""; ?> />
								<input name="id" type="hidden" id="id" value="<? echo"$id";?>"  />
							</div>
							
							<!--razon social-->
							<div class="6u 12u(xsmall)">
								<label for="razon">Raz&oacuten Social</label>
								<input class="upper" type="text" name="razon" id="razon" value="<? echo $res['razon'];?>" />
							</div>
							
							<div class="6u 12u(xsmall)">
								<label for="rfc">RFC</label>
								<input class="upper" type="text" name="rfc" id="rfc" value="<? echo $res['rfc'];?>" />
							</div>
							
							<!--direccion-->
							<div class="6u 12u(xsmall)">
								<label for="direccion">Direcci&oacuten</label>
								<input class="upper" type="text" name="direccion" id="direccion" value="<? echo $res['direccion'];?>" />
							</div>
							
							<!--numero-->
							<div class="6u 12u(xsmall)">
								<label for="numero">N&uacutemero</label>
								<input type="text" name="numero" id="numero" value="<? echo $res['numero'];?>" />
							</div>
							
							<div class="6u 12u(xsmall)">
								<label for="colonia">Colonia</label>
								<input class="upper" type="text" name="colonia" id="colonia" value="<? echo $res['colonia'];?>" />
							</div>
							
							<!--codigo postal-->
							<div class="6u 12u(xsmall)">
								<label for="cp">C&oacutedigo Postal</label>
								<input class="upper" type="text" name="cp" id="cp" value="<? echo $res['cp'];?>" />
							</div>
							
							<div class="6u 12u(xsmall)">
								<label for="estado">Estado</label>
								<input class="upper" type="text" name="estado" id="estado" value="<? echo $res['estado'];?>" />
							</div>
							
							<div class="6u 12u(xsmall)">
								<label for="municipio">Municipio</label>
								<input class="upper" type="text" name="municipio" id="municipio" value="<? echo $res['municipio'];?>" />
							</div>
							
							<!--metoodo de pago-->
							<div class="6u 12u$(xsmall)">
								<label for="metodo_pago">M&eacutetodo Pago</label>
								<input class="upper" type="text" name="metodo_pago" id="metodo_pago" value="<? echo $res['metodo_pago'];?>" />
							</div>
							
							<div class="6u 12u$(xsmall)">
								<label for="cuenta">Cuenta</label>
								<input class="upper" type="text" name="cuenta" id="cuenta" value="<? echo $res['cuenta'];?>" />
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
								<input class="upper" type="text" name="nombre_recepcion_factura" id="nombre_recepcion_factura" value="<? echo $res['nombre_recepcion_factura'];?>" />
							</div>
							
							<div class="6u 12u(xsmall)">
								<label for="email">Email</label>
								<input type="text" name="email" id="email" value="<? echo $res['email'];?>" />
							</div>
							
							<div class="6u 12u(xsmall)">
								<label for="telefono">Tel&eacutefono </label>
								<input type="text" name="telefono" id="telefono" value="<? echo $res['telefono'];?>" />
							</div>
							
							<div class="6u 12u(xsmall)">
								<label for="departamento">Departamento</label>
								<input class="upper" type="text" name="departamento" id="departamento" value="<? echo $res['departamento'];?>" />
							</div>
							
							<div class="6u 12u(xsmall)">
								<label for="dias_recepcion_factura">Dias Recepci&oacuten </label>
								<input class="upper" type="text" name="dias_recepcion_factura" id="dias_recepcion_factura" value="<? echo $res['dias_recepcion_factura'];?>" />
							</div>
							
						</div>
						</div>	
						
						<h3>Contacto de Pago </h3>
						
						<div class="box"><!--box 3-->
						<div class="row uniform"><!-- row 3-->
						
							<div class="6u 12u(xsmall)">
								<label for="contacto_pago">Nombre</label>
								<input class="upper" type="text" name="contacto_pago" id="contacto_pago" value="<? echo $res['contacto_pago'];?>" />
							</div>
							
							<div class="6u 12u(xsmall)">
								<label for="email_contacto">Email</label>
								<input type="text" name="email_contacto" id="email_contacto" value="<? echo $res['email_contacto'];?>" />
							</div>
							
							<div class="6u 12u(xsmall)">
								<label for="telefono_contacto">Tel&eacutefono </label>
								<input type="text" name="telefono_contacto" id="telefono_contacto" value="<? echo $res['telefono_contacto'];?>" />
							</div>
							
							<div class="6u 12u(xsmall)">
								<label for="dias_pago">Dias de Pago </label>
								<input class="upper" type="text" name="dias_pago" id="dias_pago" value="<? echo $res['dias_pago'];?>" />
							</div>
							
						</div><!--row 3-->
						</div><!--box 3-->
						
						<div class="row">
							<ul class="actions fit">
								<li><input class="button special fit" type="submit" name="guardar" id="guardar" value="Guardar"/></li>
								<? if($f==0 and $val==0){?>
								<li><input class="button special fit" type="submit" name="eliminar" id="eliminar" value="Eliminar"/></li>
								<? }?>
							</ul>
						</div>
						
					</form>	
					<? if($f==0 and $val==0){$up=$id+30;?>
					
					
					<div class="row">
					<input type="text" name="link" id="link" value="http://bluewolf.com.mx/admon/new/adm_cambia_cliente.php?val=1&id=<? echo $up;?>&mdl=345&f=1&mor=<? echo $id."kj".$up."lk";?>"  readonly=""/>
					<input type="button" name="copiar" id="copiar" onClick="copiar()" value="Copiar Link"/>
					</div>
					<? }?>
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
			<? if($f==0 and $val==0){?>
			<script src="assets/js/main.js"></script>
			<? } else{?>
			<script src="assets/js/main2.js"></script>
			<? }?>
	</body>
</html>
