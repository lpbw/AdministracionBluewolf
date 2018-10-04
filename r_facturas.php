<?
session_start();
	include "coneccion.php";
	include "checar_sesion.php";
	include "checar_sesion_admin.php";
$hoy=date("d-m-Y");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Reporte Facturas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>

    <script>
    $(document).ready(function(){
      $(".datepicker").datepicker({ dateFormat: 'dd-mm-yy' });
      link();
      buscar();
    });
    function link()
  {
    var desde=document.getElementById('desde').value;
    var hasta=document.getElementById('hasta').value;
    var val=1;
    var a = document.getElementById('link');
    a.setAttribute("href", "exportar_facturas.php?f1="+desde+"&f2="+hasta);
    buscar();
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
    var val=1;


    xmlhttp.open("GET","buscar.php?desde="+desde+"&hasta="+hasta+"&val="+val,true);
    xmlhttp.send();
}
    </script>
  </head>
  <body class="is-loading">
    <!-- Wrapper -->
			<div id="wrapper">
				 <ul class="visible actions">
            		<li class="visible"><a href="reportes_p.php" class="button special icon fa-undo">Regresar</a></li>
          		 </ul>
				<!-- Header -->
					<header id="header">
						<a class="logo" href="http://bluewolf.com.mx/" target="_blank">Bluewolf</a>

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
						</ul>
					</nav>
				<!-- Main -->
				<div id="main">

					<h3 style="margin-left:40%;">Reporte Facturas</h3>
					<div class="box">
						<div class="row uniform">
							<div class="4u 12u(xsmall)"><!--reportes.-->
									<label for='desde'>Desde</label><input class='datepicker' name='desde' id='desde' value='<?echo $hoy?>' onchange='link()'/>
							</div>
							<div class="4u 12u(xsmall)"><!--reportes.-->
									<label for='hasta'>Hasta</label><input class='datepicker' name='hasta' id='hasta' value='<?echo $hoy?>' onChange='link()'/>
							</div>
							<div class="4u 12u(xsmall)"><!--reportes.-->
									<a style='height:0px; text-decoration:none;' href='' id='link'><img src='images/descarga.png' width='46' height='46' border='0' title='Exportar'></a>
							</div>
						</div>

            <br>
              <div class="box">

                  <div class="row uniform table-wrapper" id="tabla">





                  </div>

              </div>




					</div>

					<footer>
							<ul class="icons alt">
								<li><a href="#" class="icon alt fa-twitter"><span class="label">Twitter</span></a></li>
								<li><a href="#" class="icon alt fa-facebook"><span class="label">Facebook</span></a></li>
								<li><a href="#" class="icon alt fa-instagram"><span class="label">Instagram</span></a></li>
							</ul>
					</footer>
				</div>
				<!-- Copyright -->
					<div id="copyright">
						<ul><li>&copy; Untitled</li><li>Design: <a href="http://bluewolf.com.mx/">Bluewolf</a></li></ul>
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
