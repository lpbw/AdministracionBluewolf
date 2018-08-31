<?

session_start();
	include "coneccion.php";
	include "checar_sesion.php";
	include "checar_sesion_admin.php";
$hoy=date("d-m-Y");
?>
<!DOCTYPE HTML>
<!--
	Massively by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Reportes</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
		<script>
			function calendario() {
				$("#fecha").datepicker({ dateFormat: 'dd-mm-yy' });
				$(".datepicker").datepicker({ dateFormat: 'dd-mm-yy' });
			}
			function link()
		{
			var desde=document.getElementById('desde').value;
			var hasta=document.getElementById('hasta').value;
			var val=document.getElementById('tipo_reporte').value;
			var a = document.getElementById('link');
			a.setAttribute("href", "exportar_reportes.php?f1="+desde+"&f2="+hasta+"&val="+val);
		}
			
			function reportes(valor)
			{
				
						campo1="<div class='3u 12u(xsmall)' ><label for='desde'>Desde</label><input class='datepicker' name='desde' id='desde' value='<?echo $hoy?>' readonly onChange='link()'/></div>";
						campo2="<div class='3u 12u(xsmall)' ><label for='hasta'>Hasta</label><input class='datepicker' name='hasta' id='hasta' value='<?echo $hoy?>' readonly onChange='link()'/></div>";
						linke="<div class='3u 12u(xsmall)' ><a style='height:0px; text-decoration:none;' href='' id='link'><img src='images/descarga.png' width='46' height='46' border='0' title='Exportar'></a></div>";
						btn="<div class='3u 12u(xsmall)' ><input class='button special fit' type='submit' name='busca' id='busca' value='Buscar' onClick='buscar()'/></div>";
				switch(valor)		
				{
					case "0":
				
					$('#campos').empty();
					break;
					
					case "1":
						
						
						$('#campos').append(campo1);//agrega el input desde
						$('#campos').append(campo2);//agrega el input hasta
						$('#campos').append(btn);//agrega el boton buscar
						$('#campos').append(linke);//agrega el link
						calendario();
						link();
					break;
				}
			}
			
			//buscar en el archivo buscar.php	
			function buscar(){
				if (window.XMLHttpRequest)
		  		{// code for IE7+, Firefox, Chrome, Opera, Safari
		  			xmlhttp=new XMLHttpRequest();
		  		}
				else
		  		{// code for IE6, IE5
		  			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  		}
					xmlhttp.onreadystatechange=function()
		  		{
					
		  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					resultado=xmlhttp.responseText;
					
					var m=document.getElementById('tabla');
					
					m.innerHTML=resultado;
				
			    }
		  	}
				var desde=document.getElementById('desde').value;
				var hasta=document.getElementById('hasta').value;
				var val=document.getElementById('tipo_reporte').value;
				
				
				xmlhttp.open("GET","buscar.php?desde="+desde+"&hasta="+hasta+"&val="+val,true);
				xmlhttp.send();
		}	
		</script>
	</head>
	<body class="is-loading">

		<!-- Wrapper -->
			<div id="wrapper">
				 <ul class="visible actions">
            		<li class="visible"><a href="menu_admin.php" class="button special icon fa-undo">Regresar</a></li>
          		 </ul>
				<!-- Header -->
					<header id="header">
						<a class="logo" href="http://bluewolf.com.mx/new/" target="_blank">Bluewolf</a>	

					</header>
				
				<nav id="nav">
						<ul class="actions fit">
							<li><a href="menu_admin.php" class="button special fit">Administraci&oacuten</a></li>
							<li><a href="adm_clientes.php" class="button special fit">Clientes</a></li>
							<li><a href="adm_proyectos.php" class="button special fit">Proyectos</a></li>
							<li><a href="buscar_cobros.php" class="button special fit">Facturaci&oacuten</a></li>
							<li><a href="facturas_cobrar.php" class="button special fit">Facturas por Cobrar </a></li>
							<li><a href="gastos.php" class="button special fit">Gastos </a></li>
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
					<div class="box">
						<div class="row uniform">
							<div class="4u 12u(xsmall)"><!--reportes.-->
								<label for="tipo_reportes">Reporte</label>
								<select name="tipo_reporte" id="tipo_reporte" onChange="reportes(this.value)">
									<option value="0">Seleccione reporte</option>
									<option value="1">Reporte de Facturas</option>
								</select>
							</div>	
						</div>
					</div>	
					<div class="box">
						<div class="row uniform" id="campos">
							
								
								
								
						</div>
					</div>	
					<div class="box">
						<div class="row uniform table-wrapper" id="tabla">
							
								
								
								
						</div>
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
			<script src="assets/js/main2.js"></script>

	</body>
</html>