<?
	session_start();
	include "checar_sesion.php";
	include "checar_sesion_admin.php";
	include "coneccion.php";
	include "SimpleImage.php";
	$idv=$_GET["idv"];
	$idu=$_GET["idu"];
	$valor=$_GET["val"];
	/*saber que se realizara
	valor=1 cuando se realiza la busqueda de la informacion de un viaje pedido.
	valor=2 cuando se inserta un nuevo gasto.
	valor=3 mostrar la tabla de gastos.
	valor=4 cuando se inserta un nuevo viaje con anticipos.
	valor=5 cuando se inserta un nuevo viaje sin anticipos.
	valor=6 cuando se actualizan los gastos.
	*/
	
	//inicialisar variables.
	$proyecto="";
	$fecha_inicio="";
	$fecha_fin="";
	$destino="";
	$n_personas="";
	$viajeros="";
	$anticipo_total="";
	$fecha_anticipo="";
	$gasto_total="";
	$estatus="";
	$fecha_peticion="";
	$motivo="";
	///////////////////////
	
	//buscar el viaje segun su id y el id del usuario.
	$queryviaje="SELECT date_format(fecha_inicio,'%Y-%m-%d') AS fecha_inicio,date_format(fecha_fin,'%Y-%m-%d') AS fecha_fin,id_destino,no_personas,viajeros,motivo,date_format(fecha_peticion,'%Y-%m-%d') AS fecha_peticion,estatus,gasto_total,fecha_anti,anticipo_total FROM viajes WHERE id='$idv' AND id_usuario='$idu'";
	$resvia=mysql_query($queryviaje) or die("La consulta: $queryviaje" . mysql_error());
	$resv=mysql_fetch_assoc($resvia);
	//$idproyecto=$resv['id_proyecto'];
	$fecha_inicio=$resv['fecha_inicio'];
	$fecha_fin=$resv['fecha_fin'];
	$iddestino=$resv['id_destino'];
	$n_personas=$resv['no_personas'];
	$viajeros=$resv['viajeros'];
	$anticipo_total=$resv['anticipo_total'];
	$fecha_anticipo=$resv['fecha_anti'];
	$gasto_total=$resv['gasto_total'];
	$idestatus=$resv['estatus'];
	$fecha_peticion=$resv['fecha_peticion'];
	$motivo=$resv['motivo'];
	
	switch($idestatus)
	{
		case 1:
		$estatus="ESPERANDO APROBACION DE VIATICOS";
		break;
		
		case 2:
		$estatus="EN CURSO";
		break;
		
		case 3:
		$estatus="ESPERANDO APROBACION DE GASTOS";
		break;
		
		case 3:
		$estatus="FINALIZADO";
		break;
	}
	/********************************************************/
	
	switch($valor)//switch  valor
	{
		case 1:
			$querypv="SELECT * FROM proyectos_viajes WHERE id_viaje='$idv'";
				$respv=mysql_query($querypv) or die("La consulta: $querypv" . mysql_error());
				while($respp=mysql_fetch_assoc($respv)){
				$idproyecto=$respp['id_proyecto'];
				if($idproyecto!=0)
				{
				$queryproyecto="SELECT id,nombre FROM proyectos WHERE id='$idproyecto'";
				$respro=mysql_query($queryproyecto) or die("La consulta: $queryproyecto" . mysql_error());
				$resp=mysql_fetch_assoc($respro);
				$proyecto=$proyecto.$resp['nombre'].".<br>";
				}
				}
			
			//encontrar el nombre del proyecto si tiene un proyecto.
			/*if($idproyecto!=0)
			{
				$queryproyecto="SELECT id,nombre FROM proyectos WHERE id='$idproyecto'";
				$respro=mysql_query($queryproyecto) or die("La consulta: $queryproyecto" . mysql_error());
				while($resp=mysql_fetch_assoc($respro)){
				$proyecto=$proyecto.$resp['nombre']." <br>";
				}
			}*/
			///////////////////////////////////////////////////////
			
			//encontrar el nombre del destino.
				$querydestino="SELECT id,nombre FROM destino WHERE id='$iddestino'";
				$resdes=mysql_query($querydestino) or die("La consulta: $querydestino" . mysql_error());
				$resd=mysql_fetch_assoc($resdes);
				$destino=$resd['nombre'].".";
			///////////////////////////////////////////////////////
			
			
			
			//crea el div de proyecto.
			$div_proyecto="<div class=\"4u 12u(xsmall)\"><div class=\"box\"><label style=\"font-size:12px;\">PROYECTO:</label>".$proyecto."</div></div>";
			/*****************************/
			
			//crea el div de fecha inicio.
			$div_inicio="<div class=\"4u 12u(xsmall)\"><div class=\"box\"><label style=\"font-size:12px;\">FECHA INICIO:</label>".$fecha_inicio."</div></div>";
			/*************************************************************************/
			
			//crea el div de fecha fin.
			$div_fin="<div class=\"4u 12u(xsmall)\" ><div class=\"box\"><label style=\"font-size:12px;\" >FECHA FIN</label>".$fecha_fin."</div></div>";
			/*************************************************************************/
			
			/*************crea el div de destino.****************/
			$div_destino="<div class=\"4u 12u(xsmall)\"><div class=\"box\"><label style=\"font-size:12px;\" >DESTINO</label>".$destino."</div></div>";
			/***************************************************/
			
			/*************crea el div de destino.****************/
			$div_personas="<div class=\"4u 12u(xsmall)\" ><div class=\"box\"><label style=\"font-size:12px;\">NUMERO DE PERSONAS</label>".$n_personas."</div></div>";
			/***************************************************/
			
			/*************crea el div de viajeros.****************/
			$div_viajeros="<div class=\"4u 12u(xsmall)\" ><div class=\"box\"><label style=\"font-size:12px;\" >VIAJEROS</label>".$viajeros."</div></div>";
			/***************************************************/
			
			/*************crea el div de motivo.****************/
			$div_motivos="<div class=\"4u 12u(xsmall)\" ><div class=\"box\"><label style=\"font-size:12px;\" >MOTIVO DE VIAJE</label>".$motivo."</div></div>";
			/***************************************************/
			
			/*************crea el div de fecha peticion.****************/
			$div_fecha_peticion="<div class=\"4u 12u(xsmall)\" ><div class=\"box\"><label  style=\"font-size:12px;\">FECHA PETICION</label>".$fecha_peticion."<!--row uniform 2 div 8--></div></div>";
			/***************************************************/
			
			/*************crea el div de estatus.****************/
			$div_estatus="<div class=\"4u 12u(xsmall)\" ><div class=\"box\"><label  style=\"font-size:12px;\">ESTATUS</label>".$estatus."<!--row uniform 2 div 8--></div><input type=\"hidden\" name=\"esta\" id=\"esta\" value=\"$idestatus\"/></div>";
			/***************************************************/
			
			
			
		
	echo $div_proyecto.$div_inicio.$div_fin.$div_destino.$div_personas.$div_viajeros.$div_motivos.$div_fecha_peticion.$div_estatus;
		break;//fin case 1
		
		/*insertar nuevo gasto*/
		case 2:
		$fgasto=$_POST['fgasto'];
		$tgasto=$_POST['tgasto'];
		$nfac=$_POST['nfac'];
		$desc=mb_strtoupper($_POST['desc'],'utf-8');
		$sub=$_POST['sub'];
		$imp=$_POST['imp'];
		$total=$_POST['total'];
		$iva=$_POST['iva'];
		$rutaf="";
		$rutap="";
		$rutax="";
		
		if($_FILES["foto"]!="")
		{
			$nombrefoto=$_FILES["foto"]["name"];
			$rutaf="fotos/".$nombrefoto;
			if (move_uploaded_file($_FILES['foto']['tmp_name'], $ruta)){ 
				
			}else{ 
				
			} 	 			
		}
		
		if($_FILES["pdf"]!="")
		{
			$nombrepdf=$_FILES["pdf"]["name"];
			$rutap="pdf/".$nombrepdf;
			if (move_uploaded_file($_FILES['pdf']['tmp_name'], $ruta)){ 
				
			}else{ 
				
			} 	 			
		}
		
		if($_FILES["xml"]!="")
		{
			$nombrexml=$_FILES["xml"]["name"];
			$rutax="xml/".$nombrexml;
			if (move_uploaded_file($_FILES['xml']['tmp_name'], $ruta)){ 
			
			}else{ 
				
			} 	 			
		}
		
		
			$query="insert into gastos_viaje (id_viaje,fecha_gasto,num_factura,id_tipo_gasto,descripcion,subtotal,impuesto,iva,total,foto,factura,xml)values('$idv','$fgasto','$nfac','$tgasto','$desc','$sub','$imp','$iva','$total','$rutaf','$rutap','$rutax')";
			$resqery=mysql_query($query) or die("La consulta: $query" . mysql_error());
			
			echo "Su gasto se a guardado exitosamente!!!";
			
		break;	
		
		/*mostrar tabla de gastos*/
		case 3:
		$queryvi="SELECT estatus FROM viajes where id='$idv'";
		$resqueryvi=mysql_query($queryvi) or die("La consulta: $query" . mysql_error());
		$resvi=mysql_fetch_assoc($resqueryvi);
		$estatus=$resvi['estatus'];
		
		if($estatus==2)
		{
		
		$tablagastos="<i class=\"fa fa-plus-square fa-2x\" id=\"nuevogasto\" onClick=\"agregar_gasto()\"></i><div class=\"12u 12u(xsmall) table-wrapper\"><table  class=\"t\"><thead><th>fecha gasto</th><th>foto</th><th>pdf</th><th>xml</th><th>#factura</th><th>tipo gasto</th><th>descripcion</th><th>subtotal</th><th>tipo gasto</th><th>total</th></thead><tbody>";
			$query="SELECT gv.*,date_format(gv.fecha_gasto,'%Y-%m-%d') as fecha,v.concepto as nombrev,gv.id as idgv FROM gastos_viaje gv join viaticos v where gv.id_viaje='$idv'";
			$resquery=mysql_query($query) or die("La consulta: $query" . mysql_error());
			$count=0;
			while($res=mysql_fetch_assoc($resquery))
			{
				$idgv=$res['idgv'];
				//checa si tiene numero de factura
				if($res['num_factura']!="")
				{
					$nf=$res['num_factura'];
					
					$numfactura=$nf."<input type=\"hidden\" name=\"numerofactura$count\" id=\"numerofactura$count\" class=\"sampletext\" value=\"$nf\"/><input type=\"hidden\" name=\"idgv$count\" id=\"idgv$count\" class=\"sampletext\" value=\"$idgv\"/>";
				}
				else
				{
					$numfactura="<input type=\"text\" name=\"numerofactura$count\" id=\"numerofactura$count\" class=\"sampletext\"/><input type=\"hidden\" name=\"idgv$count\" id=\"idgv$count\" class=\"sampletext\" value=\"$idgv\"/>";
				}
				
				//checa si tiene subtotal
				if($res['subtotal']!=0)
				{
					$sub=$res['subtotal'];
					$subtotal=$sub."<input type=\"hidden\" name=\"sub\" id=\"sub$count\" class=\"sampletext\" value=\"$sub\"/>";
				}
				else
				{
					$subtotal="<input type=\"text\" name=\"sub\" id=\"sub$count\" class=\"sampletext\" onchange='calcular_totalg($count)'/>";
				}
				
				//checa si tiene impuesto
				if($res['impuesto']!=0)
				{
					$imp=$res['impuesto'];
					switch($imp)
					{
						case 1:
							$impu="IVA";
						break;
						
						case 2:
							$impu="HOSPEDAJE";
						break;
						
						case 3:
							$impu="ISR";
						break;
					
					}
					
					$impuesto=$impu."<input type=\"hidden\" name=\"imp\" id=\"imp$count\" class=\"sampletext\" value=\"$imp\"/>";
				}
				else
				{
					$impuesto="<input type=\"hidden\" name=\"meno\" id=\"meno$count\" class=\"sampletext\" onchange=\"calcular_isrt($count)\"/><select name=\"imp$count\" id=\"imp$count\" onchange='calcular_totalg($count)' style=\"margin-left:-5px;width:100px;\"><option value=\"0\">SELECCIONE</option><option value=\"1\">IVA</option><option value=\"2\">HOSPEDAJE</option><option value=\"3\">ISR</option></select>";
				}
				
				//checar si tiene total
				if($res['total']!=0)
				{
					$tot=$res['total'];
					$total=$tot."<input type=\"hidden\" name=\"tot$count\" id=\"tot$count\" class=\"sampletext\" value=\"$tot\"/>";
				}
				else
				{
					$total="<label id=\"totv$count\" >0</label><input type=\"hidden\" name=\"tot$count\" id=\"tot$count\" class=\"sampletext\"/><input type=\"hidden\" name=\"iv$count\" id=\"iv$count\" class=\"sampletext\"/>";
				}
				
				//checa si tiene foto
				if($res['foto']!="")
				{
					$fo=$res['foto'];
					$foto="<input class='inputfile' type='file'  name='fo$count' id='fo$count'/><label for='fo$count'><i class='fa fa-camera' aria-hidden='true' style=\"color:#00CC00\"></i></label>";
				}
				else
				{
					$foto="<input class='inputfile' type='file'  name='fo$count' id='fo$count'/><label for='fo$count' ><i class='fa fa-camera' aria-hidden='true'></i></label>";
				}
				
				//checa si tiene pdf
				if($res['factura']!="")
				{
					$fa=$res['factura'];
					$pdf="<input class='inputfile' type='file'  name='p$count' id='p$count'/><label for='p$count'><i class='fa fa-file-pdf-o' aria-hidden='true' style=\"color:#00CC00\"></i></label>";
				}
				else
				{
					$pdf="<input class='inputfile' type='file'  name='p$count' id='p$count'/><label for='p$count' ><i class='fa fa-file-pdf-o ' aria-hidden='true'></i></label>";
				}
				
				//checa si tiene xml
				if($res['xml']!="")
				{
					$x=$res['xml'];
					$xml="<input class='inputfile' type='file'  name='x$count' id='x$count'/><label for='x$count'><i class='fa fa-file' aria-hidden='true' style=\"color:#00CC00\"></i></label>";
				}
				else
				{
					$xml="<input class='inputfile' type='file'  name='x$count' id='x$count'/><label for='x$count' ><i class='fa fa-file' aria-hidden='true'></i></label>";
				}
				
				$tablagastos=$tablagastos."<tr><td>".$res['fecha']."</td><td width=\"10%\">".$foto."</td><td width=\"15%\">".$pdf."</td><td width=\"10%\">".$xml."</td><td>".$numfactura."</td><td>".$res['nombrev']."</td><td>".$res['descripcion']."</td><td>".$subtotal."</td><td>".$impuesto."</td><td>".$total."</td></tr>";
				
				$count++;
			}
			$tablagastos=$tablagastos."</tbody></table><input type=\"submit\" name=\"parcial\" id=\"parcial\" value=\"Guardar\" onclick=\"guardar_cambiogastos()\"/></form><input type=\"hidden\" name=\"contador\" id=\"contador\" value=\"$count\"/></div>";
			
			echo $tablagastos;
		}//fin if estuatus.
		
			
		break;
		
		/*insertar nuevo viaje*/
		case 4:
			$pro=$_POST['pro'];
			$dest=$_POST['dest'];
			$inicio=$_POST['inicio'];
			$fin=$_POST['fin'];
			$nper=$_POST['nper'];
			$personas=mb_strtoupper($_POST['descrip'],'utf-8');
			$motivo=mb_strtoupper($_POST['motivo'],'utf-8');
			$montos=$_POST['montos'];
			$idviaticos=$_POST['idviaticos'];
			$c=0;
			
			$queryd="select id from destino where nombre='$dest'";
			$resq=mysql_query($queryd) or die("La consulta: $queryd" . mysql_error());
			$res=mysql_fetch_assoc($resq);
			$iddes=$res['id'];//id del destino
			
	
			if($iddes=="")//cuando es nuevo el destino
			{
				$insertdestino="INSERT INTO destino (nombre) value('$dest')";
				$resgasto = mysql_query($insertdestino) or die("Error: insertdestino, file:viaje.php: $insertdestino" . mysql_error());
				$iddes=mysql_insert_id();
			}
	
			$query="insert into viajes (id_proyecto,fecha_inicio,fecha_fin,id_destino,no_personas,viajeros,anticipo,anticipo_total,fecha_anti,gasto_total,estatus,fecha_peticion,id_usuario,motivo)values(0,'$inicio','$fin','$iddes','$nper','$personas','1','','','','1',now(),'$idu','$motivo')";
			$resquery=mysql_query($query) or die("La consulta: $query" . mysql_error());
			$idviaje=mysql_insert_id();	
			
			foreach($montos as $m)
			{
				$query="insert into anticipos (id_viaje,monto,id_viatico)values('$idviaje','$m','$idviaticos[$c]')";
				$resquery=mysql_query($query) or die("La consulta: $query" . mysql_error());
				$c++;
			}
			
			if($pro!=0)
			{
				foreach($pro as $p)
				{
					//$vv=$vv." ".$p;
					$query3="insert into proyectos_viajes (id_viaje,id_proyecto,monto)values('$idviaje','$p',0)";
					$resquery3=mysql_query($query3) or die("La consulta: $query3" . mysql_error());
				}
			}
			else
			{
					//$vv=0;
					$query3="insert into proyectos_viajes (id_viaje,id_proyecto,monto)values('$idviaje','$pro',0)";
					$resquery3=mysql_query($query3) or die("La consulta: $query3" . mysql_error());
			}
			
			$pro_nombre="";
			
			if($pro!=0)
			{
				$queryp="SELECT p.nombre FROM proyectos_viajes pv join proyectos p on pv.id_proyecto=p.id WHERE id_viaje=$idviaje";
				$resp=mysql_query($queryp) or die("La consulta: $queryp" . mysql_error());
				while($res=mysql_fetch_assoc($resp))
				{
				$pro_nombre=$pro_nombre." ".$res['nombre'];
				}
			}
			
			$queryu="SELECT * FROM usuarios WHERE id=$idu";
	$resuu=mysql_query($queryu) or die("La consulta: $queryu" . mysql_error());
	$resu=mysql_fetch_assoc($resuu);
	$usuario=$resu['nombre'];
	
	$body="<label>LA SIGUIENTE PERSONA SOLICITO VIATICOS: ".$usuario."</label><br><label>PROYECTO: ".$pro_nombre."</label><br><label>FECHA INICIO: ".$inicio."</label><br><label>FECHA FIN: ".$fin."</label><br><label>DESTINO: ".$dest."</label><br><label>CANTIDAD DE PERSONAS: ".$nper."</label><br><label>VIAJANTES: ".$personas."</label><br><label>MOTIVO: ".$motivo."</label><br>";
	
	$body=$body."<table border=\"1\"><thead><tr><td>MONTO</td><td>CONCEPTO</td></tr></thead><tbody>";
	$queryanticipos="SELECT a.monto,v.concepto FROM anticipos a JOIN viaticos v ON a.id_viatico=v.id WHERE id_viaje='$idviaje'";
	$resanti=mysql_query($queryanticipos) or die("La consulta: $queryanticipos" . mysql_error());
	while($res=mysql_fetch_assoc($resanti))
	{
		$body=$body."<tr><td>".$res['monto']."</td><td>".$res['concepto']."</td></tr>";
	}
	$body=$body."</table></tbody>";
	
			mail("administracion@bluewolf.com.mx", "VIATICOS", $body, "From:<info@bluewolf.com.mx>\nContent-type: text/html; charset=utf-8\n");
			echo "Su viaje se a guardado exitosamente!!!";
			
		break;
		
		case 5:
			$pro=$_POST['pro'];
			$dest=$_POST['dest'];
			$inicio=$_POST['inicio'];
			$fin=$_POST['fin'];
			$nper=$_POST['nper'];
			$personas=mb_strtoupper($_POST['descrip'],'utf-8');
			$motivo=mb_strtoupper($_POST['motivo'],'utf-8');

			$queryd="select id from destino where nombre='$dest'";
			$resq=mysql_query($queryd) or die("La consulta: $queryd" . mysql_error());
			$res=mysql_fetch_assoc($resq);
			$iddes=$res['id'];//id del destino
			
			
			
			if($iddes=="")//cuando es nuevo el destino
			{
				$insertdestino="INSERT INTO destino (nombre) value('$dest')";
				$resgasto = mysql_query($insertdestino) or die("Error: insertdestino, file:viaje.php: $insertdestino" . mysql_error());
				$iddes=mysql_insert_id();
			}
			
			$query="insert into viajes (id_proyecto,fecha_inicio,fecha_fin,id_destino,no_personas,viajeros,anticipo,anticipo_total,fecha_anti,gasto_total,estatus,fecha_peticion,id_usuario,motivo,comentario)values(0,'$inicio','$fin','$iddes','$nper','$personas','0','','','','2',now(),'$idu','$motivo','')";
			$resquery=mysql_query($query) or die("La consulta: $query" . mysql_error());
			$idviaje=mysql_insert_id();
			/*echo "<script>alert('Su viaje se a guardado exitosamente!!!');</script>";*/
			if($pro!=0)
			{
			foreach($pro as $p)
			{
				$query3="insert into proyectos_viajes (id_viaje,id_proyecto,monto)values('$idviaje','$p',0)";
				$resquery3=mysql_query($query3) or die("La consulta: $query3" . mysql_error());
			}
			}
			else
			{
				$query3="insert into proyectos_viajes (id_viaje,id_proyecto,monto)values('$idviaje','$pro',0)";
				$resquery3=mysql_query($query3) or die("La consulta: $query3" . mysql_error());
			}
			
		break;
		
		case 6:
		
		$queryvi="SELECT estatus,anticipo_total FROM viajes where id='$idv'";
		$resqueryvi=mysql_query($queryvi) or die("La consulta: $query" . mysql_error());
		$resvi=mysql_fetch_assoc($resqueryvi);
		$estatus=$resvi['estatus'];
		$totv=$resvi['anticipo_total'];
		if($estatus==2 or $estatus==3)
		{
		$query="SELECT gv.*,date_format(gv.fecha_gasto,'%Y-%m-%d') as fecha,v.concepto as nombrev,gv.id as idgv FROM gastos_viaje gv join viaticos v where gv.id_viaje='$idv'";
			$resquery=mysql_query($query) or die("La consulta: $query" . mysql_error());
			$count=0;$a=0;$b=0;$c=0;$d=0;$e=0;$f=0;$g=0;
			while($res=mysql_fetch_assoc($resquery))
			{
				$idgv=$res['idgv'];
				//checa si tiene numero de factura
				if($res['num_factura']!="")
				{
					$nf=$res['num_factura'];
					$d++;
					$numfactura=$nf."<input type=\"hidden\" name=\"numerofactura$count\" id=\"numerofactura$count\" class=\"sampletext\" value=\"$nf\"/><input type=\"hidden\" name=\"idgv$count\" id=\"idgv$count\" class=\"sampletext\" value=\"$idgv\"/>";
				}
				else
				{
					$numfactura="<input type=\"hidden\" name=\"numerofactura$count\" id=\"numerofactura$count\" class=\"sampletext\"/><input type=\"hidden\" name=\"idgv$count\" id=\"idgv$count\" class=\"sampletext\" value=\"$idgv\"/>";
				}
				//checa si tiene subtotal
				if($res['subtotal']!=0)
				{
					$e++;
					$sub=$res['subtotal'];
					$subtotal=$sub."<input type=\"hidden\" name=\"sub\" id=\"sub$count\" class=\"sampletext\" value=\"$sub\"/>";
				}
				else
				{
					$subtotal="<input type=\"hidden\" name=\"sub\" id=\"sub$count\" class=\"sampletext\" onchange='calcular_totalg($count)'/>";
				}
				
				//checa si tiene impuesto
				if($res['impuesto']!=0)
				{
					$imp=$res['impuesto'];
					$iva=$res['iva'];
					switch($imp)
					{
						case 1:
							$impu="IVA";
						break;
						
						case 2:
							$impu="HOSPEDAJE";
						break;
						
						case 3:
							$impu="ISR";
						break;
					
					}
					$f++;
					$impuesto=$iva."<input type=\"hidden\" name=\"iv$count\" id=\"iv$count\" value=\"$iva\" class=\"sampletext\"/><input type=\"hidden\" name=\"meno\" id=\"meno$count\" class=\"sampletext\" onchange=\"calcular_isrt($count)\"/><select name=\"imp$count\" id=\"imp$count\" onchange='calcular_totalg($count)' style=\"margin-left:-5px;width:100px;display:none;\"><option value=\"0\">SELECCIONE</option><option value=\"1\">IVA</option><option value=\"2\">HOSPEDAJE</option><option value=\"3\">ISR</option></select><input type=\"hidden\" name=\"i$count\" id=\"i$count\" value=\"$imp\" class=\"sampletext\"/>";
				}
				else
				{
					$impuesto="<input type=\"hidden\" name=\"meno\" id=\"meno$count\" class=\"sampletext\" onchange=\"calcular_isrt($count)\"/><select name=\"imp$count\" id=\"imp$count\" onchange='calcular_totalg($count)' style=\"margin-left:-5px;width:100px;display:none;\"><option value=\"0\">SELECCIONE</option><option value=\"1\">IVA</option><option value=\"2\">HOSPEDAJE</option><option value=\"3\">ISR</option></select><input type=\"hidden\" name=\"i$count\" id=\"i$count\" value=\"$imp\" class=\"sampletext\"/>";
				}
				
				//checar si tiene total
				if($res['total']!=0)
				{
					$g++;
					$tot=$res['total'];
					$sumt=$sumt+$tot;
					$total="<label id=\"totv$count\" >$tot</label><input type=\"hidden\" name=\"tot$count\" id=\"tot$count\" class=\"sampletext\" value=\"$tot\"/><input type=\"hidden\" name=\"edit$count\" id=\"edit$count\" class=\"sampletext\" value=\"0\"/>";
				}
				else
				{
					$total="<label id=\"totv$count\" >0</label><input type=\"hidden\" name=\"tot$count\" id=\"tot$count\" class=\"sampletext\"/><input type=\"hidden\" name=\"iv$count\" id=\"iv$count\" class=\"sampletext\"/><input type=\"hidden\" name=\"edit$count\" id=\"edit$count\" class=\"sampletext\" value=\"0\"/>";
				}
				
				//checa si tiene foto
				if($res['foto']!="")
				{
					$a++;
					$fo=$res['foto'];
					if($estatus==3){
						$foto="<i class='fa fa-camera' aria-hidden='true' style=\"color:#00CC00\" disabled></i>";
					}
					else
					{
					$foto="<input class='ta inputfile' type='file'  name='fo$count' id='fo$count' disabled/><label for='fo$count'><i class='fa fa-camera fa-lg' aria-hidden='true' style=\"color:#00CC00\"></i></label>";
					}
				}
				else
				{
					$foto="<input class='inputfile' type='file'  name='fo$count' id='fo$count' disabled/><label for='fo$count' ><i class='fa fa-camera' aria-hidden='true'></i></label>";
				}
				
				//checa si tiene pdf
				if($res['factura']!="")
				{
					$b++;
					$fa=$res['factura'];
					if($estatus==3)
					{
						$pdf="<i class='fa fa-file-pdf-o' aria-hidden='true' style=\"color:#00CC00\"></i>";
					}
					else
					{
					$pdf="<input class='ta inputfile' type='file'  name='p$count' id='p$count' disabled/><label for='p$count'><i class='fa fa-file-pdf-o' aria-hidden='true' style=\"color:#00CC00\"></i></label>";
					}
				}
				else
				{
					$pdf="<input class='inputfile' type='file'  name='p$count' id='p$count' disabled/><label for='p$count' ><i class='fa fa-file-pdf-o ' aria-hidden='true'></i></label>";
				}
				
				//checa si tiene xml
				if($res['xml']!="")
				{
					$c++;
					$x=$res['xml'];
					if($estatus==3)
					{
						$xml="<i class='fa fa-file' aria-hidden='true' style=\"color:#00CC00\"></i>";
					}
					else
					{
					$xml="<input class='ta inputfile' type='file'  name='x$count' id='x$count' disabled/><label for='x$count'><i class='fa fa-file' aria-hidden='true' style=\"color:#00CC00\"></i></label>";
					}
				}
				else
				{
					$xml="<input class='inputfile' type='file'  name='x$count' id='x$count' disabled/><label for='x$count' ><i class='fa fa-file' aria-hidden='true'></i></label>";
				}
				if($estatus==3)
					{
					$td=$td."<tr><td>".$res['fecha']."</td><td  width=\"10%\">$foto</td><td  width=\"10%\" >$pdf</td><td  width=\"10%\">$xml</td><td>$numfactura</td><td>".$res['nombrev']."</td><td>".$res['descripcion']."</td><td>$subtotal</td><td>$impuesto</td><td>$total</td></tr>";
					}
					else
					{
			$td=$td."<tr><td>".$res['fecha']."</td><td  width=\"10%\">$foto</td><td  width=\"10%\" >$pdf</td><td  width=\"10%\">$xml</td><td>$numfactura</td><td>".$res['nombrev']."</td><td>".$res['descripcion']."</td><td>$subtotal</td><td>$impuesto</td><td>$total</td><td><i class='fa fa-pencil fa-2x' style='cursor:pointer;' onclick='editar_gastos($count);'></i></td></tr>";
					}
			$count++;
			}
			echo $td."<input type=\"hidden\" name=\"contador\" id=\"contador\" value=\"$count\"/><input type=\"hidden\" name=\"a\" id=\"a\" value=\"$a\"/><input type=\"hidden\" name=\"b\" id=\"b\" value=\"$b\"/><input type=\"hidden\" name=\"c\" id=\"c\" value=\"$c\"/><input type=\"hidden\" name=\"d\" id=\"d\" value=\"$d\"/><input type=\"hidden\" name=\"e\" id=\"e\" value=\"$e\"/><input type=\"hidden\" name=\"f\" id=\"f\" value=\"$f\"/><input type=\"hidden\" name=\"g\" id=\"g\" value=\"$g\"/><input type=\"hidden\" name=\"est\" id=\"est\" value=\"$estatus\"/><input type=\"hidden\" name=\"sumt\" id=\"sumt\" value=\"$sumt\"/><input type=\"hidden\" name=\"sumv\" id=\"sumv\" value=\"$totv\"/>";
		}
			
		break;
		
		case 7:
			$c=$_POST['contador'];
			
			for($i=0;$i<=$c;$i++)
			{
				//guardar fotos en servidor
				if($_FILES['foto'.$i]!="")
				{
					$nombrefoto=$_FILES['foto'.$i]['name'];
					$rutaf="fotos/".$nombrefoto;
					$fotos=" ,foto='$rutaf'";
					if (move_uploaded_file($_FILES['foto'.$i]['tmp_name'], $rutaf))
					{ 
						
					}
					else
					{ 
					}	 	
					 	
				}
				else
				{
					$fotos="";
				}
				
				//guardar pdf en servidor
				if($_FILES['pdf'.$i]!="")
				{
					$nombrepdf=$_FILES['pdf'.$i]['name'];
					$rutap="pdf/".$nombrepdf;
					$pdfs=" ,factura='$rutap'";
					if (move_uploaded_file($_FILES['pdf'.$i]['tmp_name'], $rutap))
					{ 
						
					}
					else
					{ 
					}	 	 	
				}
				else
				{
					$pdfs="";
				}
				//guardar xml en servidor
				if($_FILES['xml'.$i]!="")
				{
					$nombrexml=$_FILES['xml'.$i]['name'];
					$rutax="xml/".$nombrexml;
					$xmls=" ,xml='$rutax'";
					if (move_uploaded_file($_FILES['xml'.$i]['tmp_name'], $rutax))
					{ 
						
					}
					else
					{ 
					}	 	 	
				}
				else
				{
					$xmls="";
				}
				
				$nf=$_POST['nf'.$i];//numero de factura
				$sub=$_POST['sub'.$i];//subtotal
				$imp=$_POST['imp'.$i];//impuesto
				$iva=$_POST['iva'.$i];//iva
				$total=$_POST['tot'.$i];//total
				$idgv=$_POST['idgv'.$i];//id gasto viaje
				$t=$t." ".$idgv;
				
				$queryup="update gastos_viaje set num_factura='$nf',impuesto='$imp',subtotal='$sub',iva='$iva',total='$total'".$fotos."".$pdfs."".$xmls." where id='$idgv'";
				$resqueryup=mysql_query($queryup) or die("La consulta: $queryup" . mysql_error());
			}//fin for
			
			
		break;
		
		case 8://terminar viaje
			$queryup="update viajes set estatus='3' where id='$idv'";
			$resqueryup=mysql_query($queryup) or die("La consulta: $queryup" . mysql_error());
				
			$query1="select * from usuarios where id='$idu'";
			$resquery1=mysql_query($query1) or die("La consulta: $query1" . mysql_error());
			$res1=mysql_fetch_assoc($resquery1);
			$usuario=$res1['nombre'];
			
			$query2="select d.nombre from viajes v join destino d on v.id_destino=d.id where v.id='$idv'";
			$resquery2=mysql_query($query2) or die("La consulta: $query2" . mysql_error());
			$res2=mysql_fetch_assoc($resquery2);
			$destino=$res2['nombre'];
			
			$body="<label>$usuario HA GUARDADO SUS GASTOS DEL VIAJE HA $destino PORFAVOR NO OLVIDES CHECARLOS</label>";
			
			mail("luis.perez@bluewolf.com.mx", "APROVACION DE GASTOS", $body, "From:<info@bluewolf.com.mx>\nContent-type: text/html; charset=utf-8\n");
				//echo $usuario;
		break;
		
		
		//llena la tabla de viaticos 
		case 9:
				
				$query1="select id_proyecto,date_format(fecha_inicio,'%Y-%m-%d') as inicio,date_format(fecha_fin,'%Y-%m-%d') as fin,id_destino,no_personas,viajeros,motivo from viajes where id_usuario='$idu' and estatus=1";
				$resquery1=mysql_query($query1) or die("La consulta: $query1" . mysql_error());
				while($res=mysql_fetch_assoc($resquery1))
				{
					$proyecto="";
					if($res['id_proyecto']!=0)
					{
						$idp=$res['id_proyecto'];
						$query2="select * from proyectos where id='$idp'";
						$resquery2=mysql_query($query2) or die("La consulta: $query2" . mysql_error());
						$res2=mysql_fetch_assoc($resquery2);
						$proyecto=$res2['nombre'];
					}
					//destino
						$iddes=$res['id_destino'];
						$query3="select * from destino where id='$iddes'";
						$resquery3=mysql_query($query3) or die("La consulta: $query3" . mysql_error());
						$res3=mysql_fetch_assoc($resquery3);
						$destino=$res3['nombre'];
				
					$td=$td."<tr><td>".$proyecto."</td><td>".$res['inicio']."</td><td>".$res['fin']."</td><td>".$destino."</td><td>".$res['no_personas']."</td><td>".$res['viajeros']."</td><td>".$res['motivo']."</td></tr>";
				}
				echo $td;
		break;
		
		/*
		archivo: anticipos.php.
		funcion js: ver.
		crea las tablas de viaticos o gastos segun el estatus.
		*/
		case 10:
			$ide=$_GET['ide'];//recibe el estatus
			
			if($ide==1)//pendiente de viaticos.
			{
				$tr=$tr."<form name=\"enviar\" id=\"enviar\" method=\"post\"><div class=\"12u 12u(xsmall) table-wrapper\"><table  class=\"t\" id=\"ta\"><thead><th>Monto</th><th>Concepto</th></thead><tbody id=\"tt\">";
				$query="select a.monto,v.concepto from anticipos a join viaticos v on a.id_viatico=v.id where id_viaje='$idv'";
				$resquery=mysql_query($query) or die("La consulta: $query" . mysql_error());
				while($res=mysql_fetch_assoc($resquery))
				{
				$tr=$tr."<tr><td>".$res['monto']."</td><td>".$res['concepto']."</td></tr>";
				$total=$total+$res['monto'];
				}
				$tr=$tr."<td>TOTAL: ".$total."</td><td id=\"boto\"></td></tbody></table><input class=\"sampletext\" type=\"hidden\" id=\"idvia\" name=\"idvia\" value=\"$idv\"/></div></form>";
				echo $tr;
			}
			
			if($ide==3)//pendientes gastos
			{
				$tr=$tr."<form name=\"enviar2\" id=\"enviar2\" method=\"post\"><div class=\"12u 12u(xsmall) table-wrapper\"><table  class=\"t\" id=\"ta2\"><thead><th>fecha_gasto</th><th>#factura</th><th>tipo gasto</th><th>descripcion</th><th>subtotal</th><th>total</th><th>foto</th><th>pdf</th><th>xml</th></thead><tbody id=\"tt2\">";
				$query="select date_format(gv.fecha_gasto,'%Y-%m-%d') as fecha_gasto,gv.num_factura,v.concepto,gv.descripcion,gv.subtotal,gv.total,gv.foto,gv.factura,gv.xml from gastos_viaje gv join viaticos v on gv.id_tipo_gasto=v.id where id_viaje='$idv'";
				$resquery=mysql_query($query) or die("La consulta: $query" . mysql_error());
				while($res=mysql_fetch_assoc($resquery))
				{
				$foto=$res['foto'];
				$factura=$res['factura'];
				$xml=$res['xml'];
				$tr=$tr."<tr><td>".$res['fecha_gasto']."</td><td>".$res['num_factura']."</td><td>".$res['concepto']."</td><td>".$res['descripcion']."</td><td>".$res['subtotal']."</td><td>".$res['total']."</td><td><a href=\"$foto\" target=\"_blank\"><i class=\"fa fa-eye\" aria-hidden=\"true\"></i></a></td><td><a href=\"$factura\" target=\"_blank\"><i class=\"fa fa-eye\" aria-hidden=\"true\"></i></a></td><td><a href=\"$xml\" target=\"_blank\"><i class=\"fa fa-eye\" aria-hidden=\"true\"></i></a></td></tr>";
				$total=$total+$res['total'];
				}
				$query2="select anticipo_total from viajes where id='$idv'";
			$resquery2=mysql_query($query2) or die("La consulta: $query2" . mysql_error());
			$res2=mysql_fetch_assoc($resquery2);
			$anticipo=$res2['anticipo_total'];
			
			$tab="<table class=\"t\" width=\"20px\"><thead><th width=\"10%\">total viaticos</th><th width=\"10%\">total gastos</th></thead><tbody><td width=\"10%\">$anticipo<input name=\"anticipo\" id=\"anticipo\" type=\"hidden\" class=\"sampletext\" value=\"$anticipo\"></td><td width=\"10%\">$total<input name=\"total\" id=\"total\" type=\"hidden\" class=\"sampletext\" value=\"$total\"></td></tbody></table>";
			
				$tr=$tr."</tbody></table></div><input class=\"sampletext\" type=\"hidden\" id=\"idvia\" name=\"idvia\" value=\"$idv\"/></div></form>".$tab;
				echo $tr;
			}
			
		break;
		
		/*
		archivo: anticipos.php.
		funcion js: validar_anticipo.
		actualiza registros pendientes de viaticos.
		*/
		case 11:
			$idv=$_POST['idv'];
			$anti=$_POST['anti'];
			$idusu=$_POST['idusu'];
			$comentario=$_POST['comen'];
			$comentario=mb_strtoupper($comentario,'utf-8');
			$query="update viajes set anticipo_total='$anti',fecha_anti=now(),estatus=2,comentario='$comentario' where id='$idv'";
			$resquery=mysql_query($query) or die("La consulta: $query" . mysql_error());
			
			$query1="select * from usuarios where id='$idusu'";
			$resquery1=mysql_query($query1) or die("La consulta: $query1" . mysql_error());
			$res1=mysql_fetch_assoc($resquery1);
			$email=$res1['email']."@bluewolf.com.mx";
			
			$query2="select d.nombre from viajes v join destino d on v.id_destino=d.id where v.id='$idv'";
			$resquery2=mysql_query($query2) or die("La consulta: $query2" . mysql_error());
			$res2=mysql_fetch_assoc($resquery2);
			$destino=$res2['nombre'];
			$body="<label>EL ANTICIPO PARA TU VIAJE HA $destino SE HA REALIZADO POR LA CANTIDAD DE: $".$anti."</label>";
			if($comentario!="")
			{
				$body="<label>EL ANTICIPO PARA TU VIAJE HA $destino SE HA REALIZADO POR LA CANTIDAD DE: $".$anti."</label><br><label>COMENTARIO: ".$comentario."</label>";
			}
			
			
			mail($email, "DEPOSITO VIATICOS", $body, "From:<info@bluewolf.com.mx>\nContent-type: text/html; charset=utf-8\n");
		break;
		
		case 12:
			$query2="select p.nombre,pv.id from proyectos p join proyectos_viajes pv on p.id=pv.id_proyecto where pv.id_viaje='$idv'";
			$resquery2=mysql_query($query2) or die("La consulta: $query2" . mysql_error());
			$c=0;
			while($res2=mysql_fetch_assoc($resquery2))
			{
			$proyecto=$res2['nombre'];
			$id=$res2['id'];
			$tr=$tr."<tr><td>$proyecto</td><td><input name=\"val$c\" id=\"val$c\" type=\"text\" class=\"sampletext\" onchange=\"cal_iva('$c')\"><input name=\"id$c\" id=\"id$c\" type=\"hidden\" class=\"sampletext\" value=\"$id\"></td><td><input name=\"iv$c\" id=\"iv$c\" type=\"text\" class=\"sampletext\"></td><td><input name=\"fech$c\" id=\"fech$c\" type=\"text\" class=\"sampletext  datepicker\" onclick=\"calendario()\"></td></tr>";
			$c++;
			}
			echo $tr."<input name=\"contador\" id=\"contador\" type=\"hidden\" class=\"sampletext\" value=\"$c\">";
		break;
		
		case 13:
			$i=$_GET['i'];
			if($i==0)
			{
			$idusu=$_POST['idusu'];
			$com=$_POST['com'];
				$query="update viajes set estatus=2 where id='$idv'";
				$resquery=mysql_query($query) or die("La consulta: $query" . mysql_error());
				
				$query2="select * from usuarios where id='$idusu'";
			$resquery2=mysql_query($query2) or die("La consulta: $query2" . mysql_error());
			$res2=mysql_fetch_assoc($resquery2);
			$email=$res2['email']."@bluewolf.com.mx";
			
			
			$query3="select d.nombre from viajes v join destino d on v.id_destino=d.id where v.id='$idv'";
			$resquery3=mysql_query($query3) or die("La consulta: $query3" . mysql_error());
			$res3=mysql_fetch_assoc($resquery3);
			$destino=$res3['nombre'];
			
			$body="<label>LOS GASTOS DE TU VIAJE HA $destino HAN SIDO RECHAZADOS.</label>";
			
			mail($email, "GASTOS RECHAZADOS", $body, "From:<info@bluewolf.com.mx>\nContent-type: text/html; charset=utf-8\n");
			}
				
			
			if($i==1)
			{
				$idusu=$_POST['idusu'];
				$c=$_POST['contador'];
				$total=$_POST['total'];
				$sum=0;
				
					for($x=0;$x<=$c;$x++)
					{
						$pro=$_POST['idpv'.$x];
						$cant=$_POST['cant'.$x];
						$iva=$_POST['iva'.$x];
						$fecha=$_POST['fecha'.$x];
						$sum=$sum+$cant;
						
						
						if($pro=="")
						{
							
							$query="update proyectos_viajes set monto='$total',iva='$iva', fecha=now() where id_viaje='$idv'";
							$resquery=mysql_query($query) or die("La consulta: $query" . mysql_error());
						}
						else
						{
							$query="update proyectos_viajes set monto='$cant',iva='$iva', fecha='$fecha' where id='$pro'";
							$resquery=mysql_query($query) or die("La consulta: $query" . mysql_error());
						}
					}
				
				if($sum==0)
				{
					$sum=$total;
				}
				$query1="update viajes set estatus=4,gasto_total='$sum' where id='$idv'";
				$resquery1=mysql_query($query1) or die("La consulta: $query1" . mysql_error());
				
				$query2="select * from usuarios where id='$idusu'";
			$resquery2=mysql_query($query2) or die("La consulta: $query2" . mysql_error());
			$res2=mysql_fetch_assoc($resquery2);
			$email=$res2['email']."@bluewolf.com.mx";
			
			$query3="select d.nombre from viajes v join destino d on v.id_destino=d.id where v.id='$idv'";
			$resquery3=mysql_query($query3) or die("La consulta: $query3" . mysql_error());
			$res3=mysql_fetch_assoc($resquery3);
			$destino=$res3['nombre'];
			
			$body="<label>LOS GASTOS DE TU VIAJE HA $destino HAN SIDO APROVADOS.</label>";
			
			mail($email, "GASTOS APROVADOS", $body, "From:<info@bluewolf.com.mx>\nContent-type: text/html; charset=utf-8\n");
			//echo $pro;
			}
		break;
		
		case 14:
			$val=$_GET['idusu'];
			$val2=$_GET['idest'];
			if($val==0 and $val2==0)
			{
				$buscar="";
			}
			elseif($val!=0 and $val2==0)
			{
				$buscar=" where (estatus=1 or estatus=3) and id_usuario='$val'";
			}
			elseif($val==0 and $val2!=0)
			{
				$buscar=" where estatus='$val2'";
			}
			elseif($val!=0 and $val2!=0)
			{
				$buscar=" where estatus='$val2' and id_usuario='$val'";
			}
			$query1="select date_format(fecha_inicio,'%Y-%m-%d') as inicio,date_format(fecha_fin,'%Y-%m-%d') as fin,id_destino,no_personas,viajeros,motivo,estatus,id_usuario,id from viajes".$buscar;
				$resquery1=mysql_query($query1) or die("La consulta: $query1" . mysql_error());
				while($res=mysql_fetch_assoc($resquery1))
				{
					$proyecto="";
					$idviaje=$res['id'];
						
						$query2="select p.nombre from proyectos p join proyectos_viajes pv on p.id=pv.id_proyecto where pv.id_viaje='$idviaje'";
						$resquery2=mysql_query($query2) or die("La consulta: $query2" . mysql_error());
						while($res2=mysql_fetch_assoc($resquery2))
						{
						$proyecto=$proyecto." ".$res2['nombre'];
						}
						
					//destino
						$iddes=$res['id_destino'];
						$query3="select * from destino where id='$iddes'";
						$resquery3=mysql_query($query3) or die("La consulta: $query3" . mysql_error());
						$res3=mysql_fetch_assoc($resquery3);
						$destino=$res3['nombre'];
						
						if($res['estatus']==1)
						{
							$estatus="PENDIENTE VIATICOS";
						}
						if($res['estatus']==3)
						{
							$estatus="PENDIENTE GASTOS";
						}
						$idestatus=$res['estatus'];
						$idusu=$res['id_usuario'];
						$query4="select nombre from usuarios where id='$idusu'";
						$resquery4=mysql_query($query4) or die("La consulta: $query4" . mysql_error());
						$res4=mysql_fetch_assoc($resquery4);
						$usuario=$res4['nombre'];
						
						$tr=$tr."<tr onClick=\"ver('$idviaje','$idestatus')\"><td>$proyecto</td><td>".$res['inicio']."</td><td>".$res['fin']."</td><td>$destino</td><td>".$res['no_personas']."</td><td>".$res['viajeros']."</td><td>".$res['motivo']."</td><td>$usuario<input type=\"hidden\" name=\"idusu$idviaje\" id=\"idusu$idviaje\" value=\"$idusu\"/></td><td>$estatus</td></tr>";
				}
			echo $tr;
		break;
	}//fin switch valor	
?>
