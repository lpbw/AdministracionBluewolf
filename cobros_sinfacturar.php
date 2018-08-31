<?php
    session_start();
    // archivos necesarios
    include "checar_sesion.php";
    include "checar_sesion_admin.php";
    include "coneccion.php";

    //fecha actual dia/mes/anio
    $hoy=date("d-m-Y");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Cobros sin facturar</title>
        <!-- css -->
        <link rel="stylesheet" href="assets/css/main.css" />
        <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
        <!-- jquery -->
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
        
        <!-- iniciar calendario -->
        <script>
            $(function () 
            {
                // inicia el calendario con formato de dia-mes-anio
                $(".datepicker").datepicker({ dateFormat: 'dd-mm-yy' });
            });
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
                <a class="logo" href="http://bluewolf.com.mx/new/" target="_blank">
                    Bluewolf
                </a> 
            </header>
            <!-- Nav -->
            <nav id="nav">
                <ul class="actions fit">
                    <li><a href="menu_admin.php" class="button special fit">Administraci&oacuten</a></li>
                    <li><a href="adm_clientes.php" class="button special fit">Clientes</a></li>
                    <li><a href="adm_proyectos.php" class="button special fit">Proyectos</a></li>
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
                <form class="alt" name="buscarc" id="buscarc" method="post" enctype="multipart/form-data">
                    <div class="box">
			            <ul class="icons">
			 	            <li><a href="facturar.php">Facturar</a>(<a href="facturar.php" class="icon alt fa-plus"></a>)</li>
			            </ul>
                        <div class="row uniform">
                            <div class="6u 12u(xsmall)">
                                <label for="desde">Desde</label>
                                <input class="datepicker" type="text" name="desde" id="desde" value="<? echo $desde?$desde:$hoy;?>" required readonly=""/>
                            </div>
                            <div class="6u 12u(xsmall)">
                                <label for="hasta">Hasta</label>
                                <input class="datepicker" type="text" name="hasta" id="hasta" value="<? echo $hasta?$hasta:$hoy;?>" required readonly=""/>
                            </div>
                            <div class="12u 12u(xsmall)">
                                <ul class="actions fit">
                                    <li>
                                        <input class="button fit special" type="submit" name="buscar" id="buscar" value="Buscar" onClick="buscar()"/>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </form>
			    <form name="enviar" id="enviar" method="post">
			        <div class="table-wrapper">
                        <div class="12u 12u(xsmall)" id="tablafacturas">
                            <table class="t">
                                <thead>
                                    <th >Fecha Cobro</th>
                                    <th >Proyecto</th>
                                    <th >Cliente</th>
                                    <th >Concepto</th>
                                    <th >Monto</th>
                                    <th >Confirmacion</th>
                                    <th >No.Factura</th>
                                    <th >Fecha Emisión</th>
                                    <th >Tipo</th>
                                    <th ></th>
                                </thead>    
                                    <?
                                    
                                            
							                $count=1;
							                $c=0;
							                while($res=mysql_fetch_assoc($resultado)){
                                            if($res['seguro']==1)
                                            {
                                                $seguro="Seguro";
                                            }elseif($res['seguro']==2){
                                                $seguro="Preguntar";
                                            }
                                            $c++
							        ?>
                                <tbody>
                                    <tr>	
                                        <td class="rwd_auto"><? echo $res['fecha'];?><input name="fecha[]" id="fecha<? echo $c; ?>" type="hidden" value="<? echo $res['fecha'];?>"/><input name="de" id="de" value="<? echo $desde;?>" type="hidden"/><input name="ha" id="ha" value="<? echo $hasta;?>" type="hidden"/></td>
                                        <td ><? echo $res['proyecto'];?><input name="proyecto[]" id="proyecto" type="hidden" value="<? echo $res['idp'];?>"/><input name="idcobro[]" id="idcobro" value="<? echo $res['idcobro'];?>" type="hidden"/><input name="rfc[]" id="rfc" type="hidden" value="<? echo $res['rfc'];?>"/></td>
                                        <td><a href="cliente.php?idcl=<? echo $res['idcl'];  ?>" target="_blank"><? echo $res['cliente'];?></a><input name="cliente[]" id="cliente" type="hidden" value="<? echo $res['idcl'];?>"/></td>
                                        <td ><input name="concepto[]" id="concepto" type="text" value="<? echo $res['concepto'];?>"/></td>
                                        <td ><input name="monto[]" id="monto" type="text" value="<? echo $res['monto'];?>"/></td>
                                        <td ><? echo $seguro;?><input name="seg[]" id="seg" type="hidden" value="<? echo $seguro;?>"/></td>
                                        <td align="center"><input name="nof[]" id="nof" type="text" value="0"/></td>
					                    <td ><input class="datepicker" type="text" name="emision[]"  id="emision<? echo $c; ?>" value="<? echo $hoy;?>" /></td>  
                                        <td >
                                            <select name="tipo[]" id="tipo<? echo $c; ?>">
                                                <option value="0">Seleccion</option>
                                                <option value="1">Viáticos</option>
                                                <option value="2">Favores</option>
                                                <option value="3">Normal</option>
                                            </select>
                                        </td>
                                        <td ><input type="checkbox" name="selec[]" id="select<? echo $c; ?>" value="<? echo $c; ?>"/><label for="select<? echo $c; ?>"></label></td>
                                    </tr>
                                </tbody>
                                    <?
                                    }
                                    ?>
                            </table>
                        </div>
                    </div>
			        <? if($desde!="" and $hasta!="")
						{
					?>			
                    <br><br><br>
                    <div class="row">
						<ul class="actions fit">
							<li>
                                <input class="button special fit" type="submit" name="guardar" id="guardar" value="Guardar"/>
                             </li>
						</ul>
					</div>	
					<?
					    }
					?>
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