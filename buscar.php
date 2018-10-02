<?
include "coneccion.php";
include "funciones.php";
$desde=date("Y-m-d",strtotime($_GET["desde"]));
$hasta=date("Y-m-d",strtotime($_GET["hasta"]));
$fac=mb_strtoupper($_GET['f'],'utf-8');
$tp=$_GET["tp"];
	$sumsub=0;
	$sumiva=0;
	$sumtotal=0;
	$sumpagados=0;
	$total1=0;
/*
val=1 recibido de el archivo reportes.php
val=2 recibido de el archivo gastos.php
val=3 recibido de el archivo facturar.php
*/
$valor=$_GET["val"];
$total=0;


switch($valor)
{
	case 1:
		$TablaComplemento;
		$tabla="<table class=\"t\"><thead><tr><th colspan=\"12\">Fecha Reporte de Facturas BW del  $desde al  $hasta </th></tr><tr><th colspan=\"6\"></th><th colspan=\"3\">Facturada en el periodo</th><th  colspan=\"3\"></th></tr><tr><th >Fecha</th><th >No.Factura</th><th >Cliente</th><th >Concepto</th><th >&Aacute;rea de Venta</th><th >Saldo Anterior</th><th >Subtotal</th><th >IVA</th><th >Total</th><th >Saldo</th><th >Estatus</th><th >Fecha de pago</th></tr></thead><tbody>";

		$queryp="select id,id_proyecto,no_factura from facturacion where fecha_emision>='$desde 00:00:00' and fecha_emision<='$hasta 00:00:00' order by no_factura";
		$resultadop = mysql_query($queryp) or die("Error en consulta horario: $queryp " . mysql_error());

		while($reshp=mysql_fetch_assoc($resultadop))//while 1
		{
		$id_factura=$reshp['id'];
		$id_proyecto=$reshp['id_proyecto'];

		

			/*echo"<script>alert('factura: $id_factura, proyecto: $id_proyecto');</script>";*/
			if($id_proyecto==0){//sin proyecto

				// llenar los registros de complementos de pago
				$QueryComplemento="SELECT com.id_complemento,com.fecha AS emision,com.no_complemento,c.nombre AS cliente,com.concepto,com.monto,fac.estatus_pago AS estatus,fac.fecha_pago AS pago FROM complemento com JOIN facturacion fac ON com.id_factura=fac.id JOIN clientes c ON fac.id_cliente=c.id WHERE fac.id=$id_factura";
				$ResultadoComplemento = mysql_query($QueryComplemento) or die("Error en consulta complemento: $QueryComplemento " . mysql_error());
				while($ResCom = mysql_fetch_assoc($ResultadoComplemento))
				{
					$TablaComplemento.="<tr><td>".$ResCom['emision']."</td><td>".$ResCom['no_complemento']."</td><td>".$ResCom['cliente']."</td><td>".$ResCom['concepto']."</td><td>".$ResCom['area']."</td><td></td><td>".money_format("$%n",$ResCom['monto'])."</td><td>".money_format("$%n",$ResCom['monto'])."</td><td>".money_format("$%n",$ResCom['monto'])."</td><td>".money_format("$%n",$ResCom['monto'])."</td><td>PAGADO</td><td>".$ResCom['pago']."</td></tr>";
				}
				// fin de complementos de pago

				$query="select f.estatus_pago,date_format(f.fecha_emision,'%Y-%m-%d') as emision,f.no_factura,c.nombre as cliente,f.concepto,a.nombre as area,f.monto,f.iva,f.total,ep.nombre as estatus,f.fecha_pago from facturacion f join clientes c on f.id_cliente=c.id join areas a on f.id_area=a.id join estatus_pago ep on f.estatus_pago=ep.id where f.id='$id_factura' order by f.no_factura";
				$resultado = mysql_query($query) or die("Error en consulta horario: $query " . mysql_error());
				$res=mysql_fetch_assoc($resultado);


				$monto1=$res['monto'];
				$iva1=$res['iva'];
				$total1=$res['total'];
				if($res['estatus_pago']==2)
				{
					$t=0;
				}
				elseif($res['estatus_pago']==3)
				{
					$t=0;
					$monto1=0;
					$iva1=0;
					$total1=0;
				}
				elseif($res['estatus_pago']==4)
				{
					$t=0;
					$monto1=0;
					$iva1=0;
					$total1=0;
				}
				else
				{
					$t=$res['total'];
							$total1=$t;
				}

				$sumsub=$sumsub+$monto1;
				$sumiva=$sumiva+$iva1;
				$sumtotal=$sumtotal+$total1;
				if($res['emision']!="")
				{
				$tabla=$tabla."<tr><td>".$res['emision']."</td><td>".$res['no_factura']."</td><td>".$res['cliente']."</td><td>".$res['concepto']."</td><td>".$res['area']."</td><td></td><td>".money_format("$%n",$monto1)."</td><td>".money_format("$%n",$iva1)."</td><td>".money_format("$%n",$total1)."</td><td>".money_format("$%n",$t)."</td><td>".$res['estatus']."</td><td>".$res['fecha_pago']."</td></tr>";
				}
			}

			else
			{
				
				// llenar los registros de complementos de pago
				$QueryComplemento="SELECT com.id_complemento,fac.fecha_emision AS emision,com.no_complemento,c.nombre AS cliente,com.concepto,com.monto,fac.estatus_pago AS estatus,fac.fecha_pago AS pago FROM complemento com JOIN facturacion fac ON com.id_factura=fac.id JOIN clientes c ON fac.id_cliente=c.id WHERE fac.id=$id_factura";
				$ResultadoComplemento = mysql_query($QueryComplemento) or die("Error en consulta complemento: $QueryComplemento " . mysql_error());
				while($ResCom = mysql_fetch_assoc($ResultadoComplemento))
				{
					$TablaComplemento.="<tr><td>".$ResCom['emision']."</td><td>".$ResCom['no_complemento']."</td><td>".$ResCom['cliente']."</td><td>".$ResCom['concepto']."</td><td>".$ResCom['area']."</td><td></td><td>".money_format("$%n",$ResCom['monto'])."</td><td>".money_format("$%n",$ResCom['monto'])."</td><td>".money_format("$%n",$ResCom['monto'])."</td><td>".money_format("$%n",$ResCom['monto'])."</td><td>PAGADO</td><td>".$ResCom['pago']."</td></tr>";
				}
				// fin de complementos de pago

			$query="select f.estatus_pago,date_format(f.fecha_emision,'%Y-%m-%d') as emision,f.no_factura,c.nombre as cliente,f.concepto,a.nombre as area,f.monto,f.iva,f.total,ep.nombre as estatus,f.fecha_pago from facturacion f join clientes c on f.id_cliente=c.id join proyectos p on f.id_proyecto=p.id join areas a on p.id_area=a.id join estatus_pago ep on f.estatus_pago=ep.id where f.id='$id_factura' order by f.no_factura";
				$resultado = mysql_query($query) or die("Error en consulta horario: $query " . mysql_error());
				$res=mysql_fetch_assoc($resultado);

				/*$sumsub=$sumsub+$res['monto'];
				$sumiva=$sumiva+$res['iva'];
				$sumtotal=$sumtotal+$res['total'];*/
				$monto1=$res['monto'];
				$iva1=$res['iva'];
				$total1=$res['total'];
				if($res['estatus_pago']==2)
				{
					$t=0;
				}
				elseif($res['estatus_pago']==3)
				{
					$t=0;
					$monto1=0;
					$iva1=0;
					$total1=0;
				}
				elseif($res['estatus_pago']==4)
				{
					$t=0;
					$monto1=0;
					$iva1=0;
					$total1=0;
				}
				else
				{
					$t=$res['total'];
					$total1=$t;
				}

				$sumsub=$sumsub+$monto1;
				$sumiva=$sumiva+$iva1;
				$sumtotal=$sumtotal+$total1;

				if($res['emision']!="")
				{
				$tabla=$tabla."<tr><td>".$res['emision']."</td><td>".$res['no_factura']."</td><td>".$res['cliente']."</td><td>".$res['concepto']."</td><td>".$res['area']."</td><td></td><td>".money_format("$%n",$monto1)."</td><td>".money_format("$%n",$iva1)."</td><td>".money_format("$%n",$total1)."</td><td>".money_format("$%n",$t)."</td><td>".$res['estatus']."</td><td>".$res['fecha_pago']."</td></tr>";
				}
			}

		}//fin while 1


		//encontrar pendientes antes y despues.
		$queryp="select id,id_proyecto,no_factura from facturacion where  estatus_pago=1 and fecha_emision<'$desde 00:00:00' or fecha_emision>'$hasta 00:00:00'  order by no_factura";
		$resultadop = mysql_query($queryp) or die("Error en consulta horario: $queryp " . mysql_error());

		while($reshp=mysql_fetch_assoc($resultadop))//while 2
		{

			$id_factura=$reshp['id'];
		$id_proyecto=$reshp['id_proyecto'];
			/*echo"<script>alert('factura: $id_factura, proyecto: $id_proyecto');</script>";*/
			if($id_proyecto==0){//sin proyecto
				$query="select date_format(f.fecha_emision,'%Y-%m-%d') as emision,f.no_factura,c.nombre as cliente,f.concepto,a.nombre as area,f.monto,f.iva,f.total,ep.nombre as estatus,f.fecha_pago from facturacion f join clientes c on f.id_cliente=c.id join areas a on f.id_area=a.id join estatus_pago ep on f.estatus_pago=ep.id where f.id='$id_factura' order by f.no_factura";
				$resultado = mysql_query($query) or die("Error en consulta horario: $query " . mysql_error());
				$res=mysql_fetch_assoc($resultado);
				$saldoant=$saldoant+$res['total'];
				$total1=$total1+$res['total'];
				if($res['emision']!="")
				{
				$tabla=$tabla."<tr><td>".$res['emision']."</td><td>".$res['no_factura']."</td><td>".$res['cliente']."</td><td>".$res['concepto']."</td><td>".$res['area']."</td><td>".money_format("$%n",$res['total'])."</td><td></td><td></td><td></td><td>".money_format("$%n",$res['total'])."</td><td>".$res['estatus']."</td><td>".$res['fecha_pago']."</td></tr>";
				}
			}

			else
			{
			$query="select date_format(f.fecha_emision,'%Y-%m-%d') as emision,f.no_factura,c.nombre as cliente,f.concepto,a.nombre as area,f.monto,f.iva,f.total,ep.nombre as estatus,f.fecha_pago from facturacion f join clientes c on f.id_cliente=c.id join proyectos p on f.id_proyecto=p.id join areas a on p.id_area=a.id join estatus_pago ep on f.estatus_pago=ep.id where f.id='$id_factura' order by f.no_factura";
				$resultado = mysql_query($query) or die("Error en consulta horario: $query " . mysql_error());
				$res=mysql_fetch_assoc($resultado);
				$saldoant=$saldoant+$res['total'];
	$total1=$total1+$res['total'];
	if($res['emision']!="")
				{
				$tabla=$tabla."<tr><td>".$res['emision']."</td><td>".$res['no_factura']."</td><td>".$res['cliente']."</td><td>".$res['concepto']."</td><td>".$res['area']."</td><td>".money_format("$%n",$res['total'])."</td><td></td><td></td><td></td><td>".money_format("$%n",$res['total'])."</td><td>".$res['estatus']."</td><td>".$res['fecha_pago']."</td></tr>";
				}
			}
		}//fin while 2

			//formato de moneda
			$saldoant=money_format("$%n",$saldoant);
			$sumsub=money_format("$%n",$sumsub);
			$sumiva=money_format("$%n",$sumiva);
			$sumtotal=money_format("$%n",$sumtotal);
			$total1=money_format("$%n",$total1);
			//$sumpagados=money_format("$%n",$sumpagos);

			$tabla=$tabla.$TablaComplemento;
			$tabla=$tabla."<tr><td colspan=\"5\"></td><td>".$saldoant."</td><td>".$sumsub."</td><td>".$sumiva."</td><td>".$sumtotal."</td><td>".$total1."</td><td></td><td></td></tr>";
			$tabla=$tabla."</tbody></table>";
			
	echo $tabla;
	break;


/*========================================== TABLA DE GASTOS ============================================================*/
	case 2:

	switch($tp)
	{
		case 1:
			$buscar=" (g.fecha>='$desde' AND g.fecha<='$hasta') OR (g.fecha_presupuestado>='$desde' AND g.fecha_presupuestado<='$hasta')";
		break;

		case 2:
			$buscar=" (g.fecha>='$desde' AND g.fecha<='$hasta') AND g.presupuestado!=1";
		break;

		case 3:
			$radio=$_GET['radio'];
			if($radio==0)
			{
				$buscar="(g.fecha_presupuestado>='$desde' AND g.fecha_presupuestado<='$hasta') AND g.presupuestado=1";
			}
			elseif($radio==1)
			{
				$buscar="(g.fecha_presupuestado>='$desde' AND g.fecha_presupuestado<='$hasta') AND g.presupuestado=1 AND g.factura=''";
			}
			elseif($radio==2)
			{
				$buscar="(g.fecha_presupuestado>='$desde' AND g.fecha_presupuestado<='$hasta') AND g.presupuestado=1 AND g.factura!=''";
			}
		break;
	}

$tabla="<html><head><meta charset=\"utf-8\" /><meta name=\"viewport\" content=\"width=device-width, initial-scale=1, user-scalable=no\" /></head>";

$tabla="<form name=\"envia\" id=\"envia\" method=\"post\"><table class=\"t\"><thead><tr><th>num</th><th>Fecha</th><th>&Aacute;rea</th><th>Tipo de Gasto</th><th>Tipo de Subgasto</th><th>Metodo de Pago</th><th>Proyecto</th><th>No.Factura</th><th>Proveedor</th><th>Concepto</th><th>Subtotal</th><th>Iva</th><th>Isr</th><th>Total</th></tr></thead><tbody>";

$queryhorario="SELECT g.*,p.nombre AS proyecto,a.nombre AS area,tg.nombre AS gasto,mp.tipo AS mpago,pr.nombre AS proveedor FROM gastos g left JOIN proyectos p ON g.id_proyecto=p.id JOIN areas a ON g.id_area=a.id JOIN tipo_gastos tg ON g.tipo_gasto=tg.id JOIN metodo_pago mp ON g.metodo_pago=mp.id JOIN proveedores pr ON g.proveedor=pr.id WHERE".$buscar;

$resultado = mysql_query($queryhorario) or die("Error en consulta horario: $queryhorario " . mysql_error());

$c=0;

$sumsub=0;
$sumiva=0;
$sumisr=0;
$sumtotal=0;
while($resh=mysql_fetch_assoc($resultado)){

$proyecto=$resh['proyecto'];
$area=$resh['area'];
$tgasto=$resh['gasto'];

$mp=$resh['mpago'];
$fecha=$resh['fecha'];
$nof=$resh['factura'];
$proveedor=$resh['proveedor'];
$concepto=$resh['concepto'];
$subtotal=$resh['subtotal'];
$presupuestado=$resh['presupuestado'];
$id=$resh['id'];
$cou=0;
$tr2="";
$id_subgasto = $resh['tipo_subgasto'];
$querysubg = "SELECT * FROM tipo_subgastos WHERE id=$id_subgasto";
$resultadosubg = mysql_query($querysubg) or die("Error en consulta subgasto: $querydubg " . mysql_error());
$ressubg=mysql_fetch_assoc($resultadosubg);
$tsubgasto=$ressubg['nombre'];
$total=$resh['total'];

$sumtotal=$sumtotal+$total;
if($nof=="")
{
$com="<input class=\"datepicker\" name=\"fecha$id\" id=\"fecha$id\" type=\"text\" value=\"$fecha\" onclick=\"calendario2($id)\">";
$com2="<input  name=\"nof$id\" id=\"nof$id\" type=\"text\" value=\"$nof\">";
$com3="<input class=\"button special fit\" type=\"submit\" name=\"guardarcam\" id=\"guardarcam\" value=\"Guardar Cambio\"/>";
}
else
{
$com="$fecha";
$com2="$nof";
$com3="";
}

$queryimp="SELECT id as idimp,id_tipo_impuesto as tp,id_gasto as idg,iva as iva1,retencion_isr as isr1 FROM impuestos_gastos WHERE id_gasto='$id'";
$resultadoimp = mysql_query($queryimp) or die("Error en consulta queryimp: $queryimp " . mysql_error());
while($resimp=mysql_fetch_assoc($resultadoimp))
{

	if($resimp['tp']==0)
	{
	$iva=0;
	$isr=0;
	}
	elseif($resimp['tp']==1)
	{
	$iva=$resimp['iva1'];
	$isr=0;
	}
	elseif($resimp['tp']==3)
	{
	$iva=0;
	$isr=$resimp['isr1'];
	}
	elseif($resimp['tp']==2)
	{
	$iva=$resimp['iva1'];
	$isr=0;
	}
	$sumsub=$sumsub+$subtotal;
	$sumiva=$sumiva+$iva;
	$sumisr=$sumisr+$isr;

	if($cou>=1)
	{
	$sumsub=$sumsub-$subtotal;
	$total=0;
	$subtotal=0;
	}
	$tr2=$tr2."<tr onclick=\"colorbox1('$id');\" class=\"iframe3\" style=\"cursor:pointer;\"><td>$id</td><td>".$com."<input  name=\"idc[]\" id=\"idc\" type=\"hidden\" value=\"$id\"></td><td>$area</td><td>$tgasto</td><td>$tsubgasto</td><td>$mp</td><td>$proyecto</td><td>".$com2."</td><td>$proveedor</td><td>$concepto</td><td>".money_format('$%n',$subtotal)."</td><td>".money_format('$%n',$iva)."</td><td>".money_format('$%n',$isr)."</td><td>".money_format('$%n',$total)."</td></tr>";




	$cou++;
}




$tabla=$tabla.$tr2;/*"<tr><td>".$com."<input  name=\"idc[]\" id=\"idc\" type=\"hidden\" value=\"$id\"></td><td>$area</td><td>$tgasto</td><td>$mp</td><td>$proyecto</td><td>".$com2."</td><td>$proveedor</td><td>$concepto</td><td>".money_format('$%n',$subtotal)."</td><td>".money_format('$%n',$iva)."</td><td>".money_format('$%n',$isr)."</td><td>".money_format('$%n',$total)."</td></tr>";*/

	/*if($tp==2)//prerupuestad
	{
	$tabla=$tabla."<tr><td>".$com."<input  name=\"idc[]\" id=\"idc\" type=\"hidden\" value=\"$id\"></td><td>$area</td><td>$tgasto</td><td>$mp</td><td>$proyecto</td><td>".$com2."</td><td>$proveedor</td><td>$concepto</td><td>".money_format('$%n',$subtotal)."</td><td>".money_format('$%n',$iva)."</td><td>".money_format('$%n',$isr)."</td><td>".money_format('$%n',$total)."</td></tr>";
	}
	else if($tp==3) //con factura
	{
	$tabla=$tabla."<tr><td>".$com."<input  name=\"idc[]\" id=\"idc\" type=\"hidden\" value=\"$id\"></td><td>$area</td><td>$tgasto</td><td>$mp</td><td>$proyecto</td><td>".$com2."</td><td>$proveedor</td><td>$concepto</td><td>".money_format('$%n',$subtotal)."</td><td>".money_format('$%n',$iva)."</td><td>".money_format('$%n',$isr)."</td><td>".money_format('$%n',$total)."</td></tr>";
	}*/
}
$tabla=$tabla."<tr><td colspan=\"8\"></td><td></td><td>".money_format('$%n',$sumsub)."</td><td>".money_format('$%n',$sumiva)."</td><td>".money_format('$%n',$sumisr)."</td><td>".money_format('$%n',$sumtotal)."</td></tr></tbody></table>".$com3."</form></html>";
echo $tabla;
	break;
/*==============================================================================================================*/



	case 3:

	$queryf="select * from facturacion where no_factura='$fac'";
	$resultado = mysql_query($queryf) or die("Error en : $queryf " . mysql_error());
	$numero_filas = mysql_num_rows($resultado);

	if($numero_filas>=1)
	{

		echo "El numero de factura ya existe";

	}
	break;




/*========================= reporte ingresos =========================================================================*/
	case 4:
		// separar fecha desde en anio, mes, dia
		$datedesde = explode("-",$desde);
		$yeardesde = (int)$datedesde[0];//Yeardesde
		$monthdesde = (int)$datedesde[1];//monthdesde
		$daydesde = (int)$datedesde[2];//daydesde
		// separar fecha hasta en anio, mes, dia
		$datehasta = explode("-",$hasta);
		$yearhasta = (int)$datehasta[0];//Yearhasta
		$monthasta = (int)$datehasta[1];//monthhasta
		$dayhasta = (int)$datehasta[2];//dayhasta
		$total1=0;
		$total2=0;
		$tabla = "<table class=\"t\"><thead><tr><th colspan=\"12\">Reporte de Ingresos BW del $desde al $hasta  </th></tr>";
		$tab = "<tr><th>Areá</th>";
		
		$count=0;
		$val1 = $monthdesde;
		$val2 = $monthasta;
		$td = "";
		//head tabla
		for ($x=$yeardesde; $x <= $yearhasta ; $x++) {
			if ($x == $yearhasta) {
				$val2=$monthasta;
				if ($count > 0 ) {
					$val1=1;
				}
			}else {
				$val2=12;
				if ($count > 0 ) {
					$val1=1;
				}
			}
			//recorre los meses.
			for ($i=$val1; $i <=$val2  ; $i++) { 
				$month = EncontrarMes($i);//nombre del mes.
				$tab .= "<th>$month/$x</th>";
				$totalareas = CalcularTotalIngresos($x,$i);
				$td .= "<td>".money_format('$%n',$totalareas)."</td>";
				$total1=$total1+$totalareas;
			}
			
			$count++;
		}
		$tab .= "<th>total general</th></tr></thead>";
		//body tabla
		$tab1 = "<tbody>";
		$val1 = $monthdesde;
		$val2 = $monthasta;
		$totalgeneral = 0;
		//area
		for ($w=1; $w <=7 ; $w++) {
			$count=0;
			$totalgeneralmes=0;
			$total2 = 0;
			$tab1 .="<tr>";
			$tab1 .= EncontrarArea($w);//nombre area
			for ($x=$yeardesde; $x <= $yearhasta ; $x++) {
				if ($x < $yearhasta) {
					if ($count == 1) {
						$val1 = 1;
						$val2 = 12;
					}else {
						$val2 = 12;
						$val1 = $monthdesde;
					}
					
				}elseif ($x == $yearhasta) {

					//si ya entro una vez en el for de year
					if ($count == 1) {
						$val1 = 1;
						$val2 = $monthasta;
					}else {
						$val1 = $monthdesde;
						$val2 = $monthasta;
					}
					
				}
				//recorre los meses.
				for ($i=$val1; $i <=$val2  ; $i++) { 
					$tab1 .= CalculaIngresosMes($x,$i,$w);//year,month,area
					$totalgeneralmes = $totalgeneralmes + TotalGeneralarea($x,$i,$w);//year,month,area
					
				}
				$totalgeneral = $totalgeneral + $totalgeneralmes;
				$total2 = $total2 + $totalgeneral;
				$count=1;
			}
			$tab1 .="<td>".money_format('$%n',$totalgeneralmes)."</td></tr>";
			 
			if ($w == 7) {
				
				if ((int)$total1 == (int)$total2) {
					$tab2 = "<tr><td>TOTAL GENERAL</td>".$td."<td>".money_format('$%n',$total1)."</td></tr>";
				}elseif((int)$total1 != (int)$total2) {
					
					$tab2 = "<tr><td>TOTAL GENERAL</td>".$td."<td>Las cantidades no coinciden</td></tr>";
				}	
			}
		}		
		$tab1 .= $tab2;
		$tab1 .= "</tbody></table>";
		
		$tabla .= $tab.$tab1;
		echo $tabla;
	break;
/*====================================================================================================================*/

/*==============================================================================================================*/



case 3:

$queryf="select * from facturacion where no_factura='$fac'";
$resultado = mysql_query($queryf) or die("Error en : $queryf " . mysql_error());
$numero_filas = mysql_num_rows($resultado);

if($numero_filas>=1)
{

	echo "El numero de factura ya existe";

}
break;




/*========================= reporte egresos =========================================================================*/
case 5:
	// separar fecha desde en anio, mes, dia
	$datedesde = explode("-",$desde);
	$yeardesde = (int)$datedesde[0];//Yeardesde
	$monthdesde = (int)$datedesde[1];//monthdesde
	$daydesde = (int)$datedesde[2];//daydesde
	// separar fecha hasta en anio, mes, dia
	$datehasta = explode("-",$hasta);
	$yearhasta = (int)$datehasta[0];//Yearhasta
	$monthasta = (int)$datehasta[1];//monthhasta
	$dayhasta = (int)$datehasta[2];//dayhasta
	$total1=0;
	$total2=0;
	$tabla = "<table class=\"t\"><thead><tr><th colspan=\"12\">Reporte de Egresos BW del $desde al $hasta  </th></tr>";
	$tab = "<tr><th>Areá</th>";
	
	$count=0;
	$val1 = $monthdesde;
	$val2 = $monthasta;
	$td = "";
	//head tabla
	for ($x=$yeardesde; $x <= $yearhasta ; $x++) {
		if ($x == $yearhasta) {
			$val2=$monthasta;
			if ($count > 0 ) {
				$val1=1;
			}
		}else {
			$val2=12;
			if ($count > 0 ) {
				$val1=1;
			}
		}
		//recorre los meses.
		for ($i=$val1; $i <=$val2  ; $i++) { 
			$month = EncontrarMes($i);//nombre del mes.
			$tab .= "<th>$month/$x</th>";
			$totalareas = CalcularTotalIngresosGasto($x,$i);
			$td .= "<td>".money_format('$%n',$totalareas)."</td>";
			$total1=$total1+$totalareas;
		}
		
		$count++;
	}
	$tab .= "<th>total general</th></tr></thead>";
	//body tabla
	$tab1 = "<tbody>";
	$val1 = $monthdesde;
	$val2 = $monthasta;
	$totalgeneral = 0;
	//area
	for ($w=1; $w <=7 ; $w++) {
		$count=0;
		$totalgeneralmes=0;
		$total2 = 0;
		$tab1 .="<tr>";
		$tab1 .= EncontrarArea($w);//nombre area
		for ($x=$yeardesde; $x <= $yearhasta ; $x++) {
			if ($x < $yearhasta) {
				if ($count == 1) {
					$val1 = 1;
					$val2 = 12;
				}else {
					$val2 = 12;
					$val1 = $monthdesde;
				}
				
			}elseif ($x == $yearhasta) {

				//si ya entro una vez en el for de year
				if ($count == 1) {
					$val1 = 1;
					$val2 = $monthasta;
				}else {
					$val1 = $monthdesde;
					$val2 = $monthasta;
				}
				
			}
			//recorre los meses.
			for ($i=$val1; $i <=$val2  ; $i++) { 
				$tab1 .= CalculaIngresosMesGasto($x,$i,$w);//year,month,area
				$totalgeneralmes = $totalgeneralmes + TotalGeneralareaGasto($x,$i,$w);//year,month,area
				
			}
			$totalgeneral = $totalgeneral + $totalgeneralmes;
			$total2 = $total2 + $totalgeneral;
			$count=1;
		}
		$tab1 .="<td>".money_format('$%n',$totalgeneralmes)."</td></tr>";
		 
		if ($w == 7) {
			
			if ((int)$total1 == (int)$total2) {
				$tab2 = "<tr><td>TOTAL GENERAL</td>".$td."<td>".money_format('$%n',$total1)."</td></tr>";
			}elseif((int)$total1 != (int)$total2) {
				
				$tab2 = "<tr><td>TOTAL GENERAL</td>".$td."<td>Las cantidades no coinciden</td></tr>";
			}	
		}
	}		
	$tab1 .= $tab2;
	$tab1 .= "</tbody></table>";
	
	$tabla .= $tab.$tab1;
	echo $tabla;
break;
/*====================================================================================================================*/

}//fin switch

?>
