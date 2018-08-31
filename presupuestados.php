<?
	session_start();
	include "checar_sesion.php";
	include "checar_sesion_admin.php";
	include "coneccion.php";
	$idU=$_SESSION['idU'];
	$mes = date("n");
	$anio = date("Y");
	if($_POST['guardar']=="Guardar")//if guardar
	{
			$monto = $_POST['monto'];
			$descripcion = mb_strtoupper($_POST['descripcion'],'utf-8');
			$gasto = mb_strtoupper($_POST['gasto'],'utf-8');
			$subgasto = mb_strtoupper($_POST['subgasto'],'utf-8');
			$desde = $_POST['desde'];
			$hasta = $_POST['hasta'];
			$aniodesde = $_POST['aniodesde'];
			$aniohasta = $_POST['aniohasta'];
			
			/*
			Buscar y/o crear nuevo gasto
			=========================================================
			*/
			$querygasto="SELECT id FROM tipo_gastos WHERE nombre='$gasto'";
			$resgasto = mysql_query($querygasto) or die("Error: querygasto, file:gastos.php: $querygasto" . mysql_error());
			$residg = mysql_fetch_assoc($resgasto);
			$idgasto=$residg['id'];
			
			//cuando es un nuevo tipo de gasto inserta en la tabla
			if($idgasto=="")
			{
				$insertgasto="INSERT INTO tipo_gastos (nombre) value('$gasto')";
				$resgasto = mysql_query($insertgasto) or die("Error: insertgasto, file:gastos.php: $insertgasto" . mysql_error());
				$idgasto=mysql_insert_id();
			}
			/*======================================================*/
			
			/*
			Buscar y/o crear nuevo subgasto
			=========================================================
			*/
			
			//busca el id del tipo de subgastogasto.
			$querysubgasto="SELECT id FROM tipo_subgastos WHERE nombre='$subgasto'";
			$ressubgasto = mysql_query($querysubgasto) or die("Error: querysubgasto, file:gastos.php: $querysubgasto" . mysql_error());
			$residsubg = mysql_fetch_assoc($ressubgasto);
			$idsubgasto=$residsubg['id'];
			
			//cuando es un nuevo tipo de gasto inserta en la tabla
			if($idsubgasto=="")
			{
				$insertsubgasto="INSERT INTO tipo_subgastos (id_gastos,nombre) value('$idgasto','$subgasto')";
				$resgasto = mysql_query($insertsubgasto) or die("Error: insertsubgasto, file:gastos.php: $insertsubgasto" . mysql_error());
				$idsubgasto=mysql_insert_id();
			}
			
			/*======================================================*/
			
			if($aniodesde==$aniohasta)
			{
					if($desde>hasta)
					{
							echo "</script>console.log('el mes desde debe ser menor al mes hasta');</script>";
					}
					else
					{
						for($i=$desde;$i<=$hasta;$i++)
						{
							$query = "insert into presupuestados(tipo_gasto,tipo_subgasto,mes,anio,monto,descripcion) values('$idgasto','$idsubgasto','$i','$aniodesde','$monto','$descripcion')";
							$result = mysql_query($query) or print("fallo query: $query" .mysql_error());
						}
						echo "</script>alert('Presupuestos guardados');</script>";
					}
			}
			elseif($aniodesde<$aniohasta)
			{
					//anio desde
					for($i=$desde;$i<=12;$i++)
					{
							$query = "insert into presupuestados(tipo_gasto,tipo_subgasto,mes,anio,monto,descripcion) values('$idgasto','$idsubgasto','$i','$aniodesde','$monto','$descripcion')";
							$result = mysql_query($query) or print("fallo query: $query" .mysql_error());
							
					}
					//anio hasta
					for($i=1;$i<=$hasta;$i++)
					{
							$query = "insert into presupuestados(tipo_gasto,tipo_subgasto,mes,anio,monto,descripcion) values('$idgasto','$idsubgasto','$i','$aniohasta','$monto','$descripcion')";
							$result = mysql_query($query) or print("fallo query: $query" .mysql_error());
					}
					echo "</script>alert('Presupuestos guardados');</script>";
			}
			elseif($aniodesde>$aniohasta)
			{
					echo "</script>alert('el año desde debe ser menor al año hasta');</script>";
			}
			
	}
?>
<!DOCTYPE HTML>
<html>
	<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title>Gastos</title>
			<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
			<link rel="stylesheet" href="assets/css/main.css" />
			<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
			<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
			<link rel="stylesheet" href="colorbox.css" />
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
			<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
			<script src="colorbox/jquery.colorbox-min.js" type="text/javascript"></script>
			<script>
				/*=====================================
				funcion buscar
				busca los registros de la tabla presupuestados
				=====================================*/
				function buscarp(){
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
					
					var m=document.getElementById('tablapresupuestos');
					
					m.innerHTML=resultado;
					}
		  	}
				var gasto = $('#gastob').val();
				var subgasto = $('#subgastob').val();
				var desde = $('#desdeb').val();
				var hasta = $('#hastab').val();
				var aniodesde = $('#aniodesdeb').val();
				var aniohasta = $('#aniohastab').val();
				
				b="buscarpres.php?gasto="+gasto+"&subgasto="+subgasto+"&desdeb="+desde+"&hastab="+hasta+"&aniodesde="+aniodesde+"&aniohasta="+aniohasta;
				link();
				xmlhttp.open("GET",b,true);
				xmlhttp.send();
				
		}	
		/*================================================================================================*/
		
		/*=====================================
				funcion  link
				cambia el link para exportar
				=====================================*/
		function link()
		{
			
			var gasto = $('#gastob').val();
			var subgasto = $('#subgastob').val();
			var desde = $('#desdeb').val();
			var hasta = $('#hastab').val();
			var aniodesde = $('#aniodesdeb').val();
			var aniohasta = $('#aniohastab').val();
			var a = document.getElementById('link');
			a.setAttribute("href", "exportar_presupuestados.php?gasto="+gasto+"&subgasto="+subgasto+"&desdeb="+desde+"&hastab="+hasta+"&aniodesde="+aniodesde+"&aniohasta="+aniohasta);
			
		}
		
			</script>		
	</head>
	
	<body class="is-loading">

		<!-- Wrapper -->
			<div id="wrapper">
			
					<ul class="visible actions"><!--Boton regresar-->
            			<li class="visible"><a href="menu_admin.php" class="button special icon fa-undo">Regresar</a></li>
          			</ul>
				<!-- Header -->
					<header id="header">
						<a class="logo">Bluewolf</a>					</header>

					 <!-- Nav de celular-->
					  <nav id="nav">
						<ul class="actions fit">
						  <li><a href="menu_admin.php" class="button special fit">Administracion</a></li>
						  <li><a href="adm_clientes.php" class="button special fit">Clientes</a></li>
						  <li><a href="adm_proyectos.php" class="button special fit">Proyectos</a></li>
						  <li><a href="buscar_cobros.php" class="button special fit">Facturacion</a></li>
						  <li><a href="facturas_cobrar.php" class="button special fit">Facturas por Cobrar </a></li>
						</ul>
						<ul class="icons">
						  <li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
						  <li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
						  <li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
						  <li><a href="#" class="icon fa-github"><span class="label">GitHub</span></a></li>
						</ul>
					  </nav>
						
						
						
					<!--========================== Pestañas =====================================-->
					<div class="12u 12u(xsmall)">
					<nav id="navegador" >
						<ul class="links">
							<li><a href="gastos_p.php">Gastos</a></li>
							<li class="active"><a>Presupuestar Gasto</a></li>
						</ul>
					</nav>
					</div>
				<!--===========================================================================-->
				
				<!-- Main -->
				<div id="main">
					
					<!--======================= form presu ===============================================-->
					<form name="presu" id="presu" method="post">
						<div class="row uniform">
						
								<!--================================== Tipo de gasto ==========================-->				
									<div class="4u 12u(xsmall)">
											<label for="gasto">Tipo de Gasto</label>
											<input class="upper" list="gasto" name="gasto" type="text" required>
											<datalist id="gasto">
												<?	
													$query = "select * from tipo_gastos order by id";
													$result = mysql_query($query) or print("<option value=\"ERROR\">".mysql_error()."</option>");
													while($cliente = mysql_fetch_assoc($result))
												{
												?>
													<option value="<? echo $cliente['nombre']?>"><? echo $cliente['nombre']?></option>
												<?
												}
												?>
											</datalist>
									</div>
								<!--===========================================================================-->
								
								<!--================================== Tipo de subgasto ==========================-->
															
									<div class="4u 12u(xsmall)">
										<label for="gasto">Tipo de Subgasto</label>
										<input class="upper" list="subgasto" name="subgasto" type="text" >
										<datalist id="subgasto">
											<?	
												$query = "select * from tipo_subgastos order by id";
												$result = mysql_query($query) or print("<option value=\"ERROR\">".mysql_error()."</option>");
												while($subgastos = mysql_fetch_assoc($result))
											{
											?>
												<option value="<? echo $subgastos['nombre']?>"  ><? echo $cliente['nombre']?></option>
											<?
											}
											?>
										</datalist>
									</div>
								
								<!--===========================================================================-->
								
								<!--================================== Monto ==================================-->
									<div class="4u 12u(xsmall)">
											<label for="monto">Monto</label>
											<input type="text" name="monto" id="monto" required/>
									</div>
								
								<!--============================================================================-->
								
								<!--================================== Monto ==================================-->
									<div class="4u 12u(xsmall)">
											<label for="descripcion">Descripcion</label>
											<textarea name="descripcion" id="descripcion">
											</textarea>
									</div>
								
								<!--============================================================================-->
								
								
								<!--================================== Mes desde ==========================-->
															
									<div class="4u 12u(xsmall)">
											<label for="desde">Desde</label>
											<select name="desde" id="desde" required>
												<option value="0" selected="selected">SELECCIONE MES DE INICIO</option>
												<option value="1" <? echo $mes==1?"selected":"";?>>ENERO</option>
												<option value="2" <? echo $mes==2?"selected":"";?>>FEBRERO</option>
												<option value="3" <? echo $mes==3?"selected":"";?>>MARZO</option>
												<option value="4" <? echo $mes==4?"selected":"";?>>ABRIL</option>
												<option value="5" <? echo $mes==5?"selected":"";?>>MAYO</option>
												<option value="6" <? echo $mes==6?"selected":"";?>>JUNIO</option>
												<option value="7" <? echo $mes==7?"selected":"";?>>JULIO</option>
												<option value="8" <? echo $mes==8?"selected":"";?>>AGOSTO</option>
												<option value="9" <? echo $mes==9?"selected":"";?>>SEPTIEMBRE</option>
												<option value="10" <? echo $mes==10?"selected":"";?>>OCTUBRE</option>
												<option value="11" <? echo $mes==11?"selected":"";?>>NOVIEMBRE</option>
												<option value="12" <? echo $mes==12?"selected":"";?>>DICIEMBRE</option>
											</select>
									</div>
								
								<!--============================================================================-->
								
								
								<!--================================== Mes hasta ==========================-->
															
									<div class="4u 12u(xsmall)">
											<label for="hasta">HASTA</label>
											<select name="hasta" id="hasta" required>
												<option value="0" selected="selected">SELECCIONE MES DE TERMINO</option>
												<option value="1" <? echo $mes==1?"selected":"";?>>ENERO</option>
												<option value="2" <? echo $mes==2?"selected":"";?>>FEBRERO</option>
												<option value="3" <? echo $mes==3?"selected":"";?>>MARZO</option>
												<option value="4" <? echo $mes==4?"selected":"";?>>ABRIL</option>
												<option value="5" <? echo $mes==5?"selected":"";?>>MAYO</option>
												<option value="6" <? echo $mes==6?"selected":"";?>>JUNIO</option>
												<option value="7" <? echo $mes==7?"selected":"";?>>JULIO</option>
												<option value="8" <? echo $mes==8?"selected":"";?>>AGOSTO</option>
												<option value="9" <? echo $mes==9?"selected":"";?>>SEPTIEMBRE</option>
												<option value="10" <? echo $mes==10?"selected":"";?>>OCTUBRE</option>
												<option value="11" <? echo $mes==11?"selected":"";?>>NOVIEMBRE</option>
												<option value="12" <? echo $mes==12?"selected":"";?>>DICIEMBRE</option>
											</select>
									</div>
								
								<!--============================================================================-->
								
								<!--=================================anio desde=======================================-->
									<div class="4u 12u(xsmall)">
										<label for="aniodesde">a&ntilde;o desde</label>
										<select name="aniodesde" id="aniodesde">
											<option value="<? echo $anio;?>"><? echo $anio;?></option>
											<option value="<? echo $anio+1;?>"><? echo $anio+1;?></option>
										</select>
									</div>
								<!--==================================================================================-->
								
								<!--==================================anio hasta======================================-->
									<div class="4u 12u(xsmall)">
										<label for="aniohasta">a&ntilde;o hasta</label>
										<select name="aniohasta" id="aniohasta">
											<option value="<? echo $anio;?>"><? echo $anio;?></option>
											<option value="<? echo $anio+1;?>"><? echo $anio+1;?></option>
										</select>
									</div>
								<!--==================================================================================-->
								
								
								<!--============================ Boton guardar ==============================-->
									<div class="4u 12u(xsmall)" style="margin-top:10%;">
											<input class="button special fit" type="submit" name="guardar" id="guardar" value="Guardar"/>
									</div>
								
								<!--=========================================================================-->
						</div>
					</form>
				<!--	======================= fin form presu ===========================================-->
				
				<!--======================= buscador ===========================================-->
						<form name="buscar" id="buscar" method="post">
							<div class="row uniform">
								<!--================================== Tipo de gasto ==========================-->				
									<div class="4u 12u(xsmall)">
											<label for="gasto">Tipo de Gasto</label>
										<select name="gastob" id="gastob">
										<option value="0">SELECCIONA GASTO</option>
											<?	
												$query = "select * from tipo_gastos order by id";
												$result = mysql_query($query) or print("<option value=\"ERROR\">".mysql_error()."</option>");
												while($gastos = mysql_fetch_assoc($result))
											{
											?>
												<option value="<? echo $gastos['id']?>"  ><? echo $gastos['nombre']?></option>
											<?
											}
											?>
										</select>
									</div>
								<!--===========================================================================-->
								
								<!--================================== Tipo de subgasto ==========================-->
															
									<div class="4u 12u(xsmall)">
										<label for="gastob">Tipo de Subgasto</label>
										<select name="subgastob" id="subgastob">
											<option value="0">SELECCIONA SUBGASTO</option>
											<?	
												$query = "select * from tipo_subgastos order by id";
												$result = mysql_query($query) or print("<option value=\"ERROR\">".mysql_error()."</option>");
												while($subgastos = mysql_fetch_assoc($result))
											{
											?>
												<option value="<? echo $subgastos['id']?>"  ><? echo $subgastos['nombre']?></option>
											<?
											}
											?>
										</select>	
									</div>
								
								<!--===========================================================================-->
								
								<!--================================== Mes desde ==========================-->
															
									<div class="4u 12u(xsmall)">
											<label for="desdeb">Desde</label>
											<select name="desdeb" id="desdeb">
												<option value="0" selected="selected">SELECCIONE MES DE INICIO</option>
												<option value="1" <? echo $mes==1?"selected":"";?>>ENERO</option>
												<option value="2" <? echo $mes==2?"selected":"";?>>FEBRERO</option>
												<option value="3" <? echo $mes==3?"selected":"";?>>MARZO</option>
												<option value="4" <? echo $mes==4?"selected":"";?>>ABRIL</option>
												<option value="5" <? echo $mes==5?"selected":"";?>>MAYO</option>
												<option value="6" <? echo $mes==6?"selected":"";?>>JUNIO</option>
												<option value="7" <? echo $mes==7?"selected":"";?>>JULIO</option>
												<option value="8" <? echo $mes==8?"selected":"";?>>AGOSTO</option>
												<option value="9" <? echo $mes==9?"selected":"";?>>SEPTIEMBRE</option>
												<option value="10" <? echo $mes==10?"selected":"";?>>OCTUBRE</option>
												<option value="11" <? echo $mes==11?"selected":"";?>>NOVIEMBRE</option>
												<option value="12" <? echo $mes==12?"selected":"";?>>DICIEMBRE</option>
											</select>
									</div>
								
								<!--============================================================================-->
								
								
								<!--================================== Mes hasta ==========================-->
															
									<div class="4u 12u(xsmall)">
											<label for="hastab">HASTA</label>
											<select name="hastab" id="hastab">
												<option value="0" selected="selected">SELECCIONE MES DE TERMINO</option>
												<option value="1" <? echo $mes==1?"selected":"";?>>ENERO</option>
												<option value="2" <? echo $mes==2?"selected":"";?>>FEBRERO</option>
												<option value="3" <? echo $mes==3?"selected":"";?>>MARZO</option>
												<option value="4" <? echo $mes==4?"selected":"";?>>ABRIL</option>
												<option value="5" <? echo $mes==5?"selected":"";?>>MAYO</option>
												<option value="6" <? echo $mes==6?"selected":"";?>>JUNIO</option>
												<option value="7" <? echo $mes==7?"selected":"";?>>JULIO</option>
												<option value="8" <? echo $mes==8?"selected":"";?>>AGOSTO</option>
												<option value="9" <? echo $mes==9?"selected":"";?>>SEPTIEMBRE</option>
												<option value="10" <? echo $mes==10?"selected":"";?>>OCTUBRE</option>
												<option value="11" <? echo $mes==11?"selected":"";?>>NOVIEMBRE</option>
												<option value="12" <? echo $mes==12?"selected":"";?>>DICIEMBRE</option>
											</select>
									</div>
								
								<!--============================================================================-->
								
								<!--=================================anio desde=======================================-->
									<div class="4u 12u(xsmall)">
										<label for="aniodesdeb">a&ntilde;o desde</label>
										<select name="aniodesdeb" id="aniodesdeb">
											<option value="<? echo $anio;?>"><? echo $anio;?></option>
											<option value="<? echo $anio+1;?>"><? echo $anio+1;?></option>
										</select>
									</div>
								<!--==================================================================================-->
								
								<!--==================================anio hasta======================================-->
									<div class="4u 12u(xsmall)">
										<label for="aniohastab">a&ntilde;o hasta</label>
										<select name="aniohastab" id="aniohastab">
											<option value="<? echo $anio;?>"><? echo $anio;?></option>
											<option value="<? echo $anio+1;?>"><? echo $anio+1;?></option>
										</select>
									</div>
								<!--==================================================================================-->
								
								<!--==================== boton buscar ================================================-->
						   	<div class="4u 12u(xsmall)"><!--boton buscar.-->
									<input class="button special fit" type="button" name="busca" id="busca" value="Buscar" onClick="buscarp()"/>
								</div>
								<!--======================================================================================-->
								
								<!--==================== Exportar ====================================================-->
								
									<a style="height:0px; text-decoration:none;" href="" id="link"><img src="images/descarga.png" width="46" height="46" border="0" title="Exportar"></a>
								
								<!--==================================================================================-->
							</div>
						</form>
					<!--======================================================================================-->
					
					<!--======================= tabla de registros ===========================================-->
					<div class="table-wrapper" id="tablapresupuestos">
							<!--aqui se carga la tabla-->
					</div>
					<!--======================================================================================-->
					
					<!--========================== Pie de pagina =====================================-->	
					<footer>
							<ul class="icons alt">
								<li><a href="#" class="icon alt fa-twitter"><span class="label">Twitter</span></a></li>
								<li><a href="#" class="icon alt fa-facebook"><span class="label">Facebook</span></a></li>
								<li><a href="#" class="icon alt fa-instagram"><span class="label">Instagram</span></a></li>
								<li><a href="#" class="icon alt fa-github"><span class="label">GitHub</span></a></li>
							</ul>			
					</footer>
					<!--===================== fin pie de pagina ======================================-->
					
				</div><!--main-->
				
				<!-- Copyright -->
					<div id="copyright">
						<ul><li>&copy; Untitled</li><li>Design: <a href="https://html5up.net">Bluewolf</a></li></ul>
					</div>
					
			</div><!--wrapper-->

		<!-- Scripts -->
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>
