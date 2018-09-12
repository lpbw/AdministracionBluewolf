<?	
	session_start();
	include "coneccion.php";
	include "checar_sesion.php";
	include "checar_sesion_admin.php";
	
	$desde=date("Y-m-d",strtotime($_GET['f1']));//fecha desde.
	$hasta=date("Y-m-d",strtotime($_GET['f2']));//fecha hasta.
	$sumsub=0;
	$sumiva=0;
	$sumtotal=0;
	$sumpagados=0;
	$total1=0;
	/*val=1 facturas*/
	$val=$_GET['val'];

	switch($val)
{
	case 1:
	header('Content-type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename=Reporte_de_Facturas.xls');
	header('Pragma: no-cache');
	header('Expires: 0');
?>

<table border="1">
	<thead>
		<tr>
			<th bgcolor="#CCCCCC" colspan="12">Fecha Reporte de Facturas BW del <? echo $desde; ?> al <? echo $hasta; ?></th>
		</tr>	
		
		<tr>
			<th bgcolor="#CCCCCC" colspan="6"></th>
			<th bgcolor="#CCCCCC" colspan="3">Facturada en el periodo</th>
			<th bgcolor="#CCCCCC" colspan="3"></th>
		</tr>
			
		<tr>
			<th bgcolor="#CCCCCC">Fecha</th>
			<th bgcolor="#CCCCCC">No.Factura</th>
			<th bgcolor="#CCCCCC">Cliente</th>
			<th bgcolor="#CCCCCC">Concepto</th>
			<th bgcolor="#CCCCCC">Área de Venta</th>
			<th bgcolor="#CCCCCC">Saldo Anterior</th>
			<th bgcolor="#CCCCCC">Subtotal</th>
			<th bgcolor="#CCCCCC">IVA</th>
			<th bgcolor="#CCCCCC">Total</th>
			<th bgcolor="#CCCCCC">Saldo</th>
			<th bgcolor="#CCCCCC">Estatus</th>
			<th bgcolor="#CCCCCC">Fecha de pago</th>
		</tr>
	</thead>
	<tbody>
	<?
		$queryp="select id,id_proyecto,no_factura from facturacion where fecha_emision>='$desde 00:00:00' and fecha_emision<='$hasta 00:00:00' order by no_factura";
		$resultadop = mysql_query($queryp) or die("Error en consulta horario: $queryp " . mysql_error());
		while($reshp=mysql_fetch_assoc($resultadop))//while 1
		{
			$id_factura=$reshp['id'];
			$id_proyecto=$reshp['id_proyecto'];

			// llenar los registros de complementos de pago
			$QueryComplemento="SELECT com.id_complemento,date_format(fac.fecha_emision,'%Y-%m-%d') AS emision,com.no_complemento,c.nombre AS cliente,com.concepto,com.monto,fac.estatus_pago AS estatus,date_format(fac.fecha_pago,'%Y-%m-%d') AS pago FROM complemento com JOIN facturacion fac ON com.id_factura=fac.id JOIN clientes c ON fac.id_cliente=c.id WHERE fac.id=$id_factura";
			$ResultadoComplemento = mysql_query($QueryComplemento) or die("Error en consulta complemento: $QueryComplemento " . mysql_error());
			$ResCom = mysql_fetch_assoc($ResultadoComplemento);
			$TablaComplemento.="<tr><td>".$ResCom['emision']."</td><td>".$ResCom['no_complemento']."</td><td>".$ResCom['cliente']."</td><td>".$ResCom['concepto']."</td><td>".$ResCom['area']."</td><td></td><td>".money_format("$%n",$ResCom['monto'])."</td><td>".money_format("$%n",$ResCom['monto'])."</td><td>".money_format("$%n",$ResCom['monto'])."</td><td>".money_format("$%n",$ResCom['monto'])."</td><td>PAGADO</td><td>".$ResCom['pago']."</td></tr>";
			// fin de complementos de pago

			if($id_proyecto==0)
			{//sin proyecto
				$query="select f.estatus_pago,date_format(f.fecha_emision,'%Y-%m-%d') as emision,f.no_factura,c.nombre as cliente,f.concepto,a.nombre as area,f.monto,f.iva,f.total,ep.nombre as estatus,date_format(f.fecha_pago,'%Y-%m-%d') AS pago from facturacion f join clientes c on f.id_cliente=c.id join areas a on f.id_area=a.id join estatus_pago ep on f.estatus_pago=ep.id where f.id='$id_factura' order by f.no_factura";
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
				if($res['no_factura']!="")
				{
	?>	
				<tr>
					<td><? echo $res['emision'];?></td>
					<td><? echo $res['no_factura'];?></td>
					<td><? echo $res['cliente'];?></td>
					<td><? echo $res['concepto'];?></td>
					<td><? echo $res['area'];?></td>
					<td></td>
					<td><? echo money_format("$%n",$monto1);?></td>
					<td><? echo money_format("$%n",$iva1);?></td>
					<td><? echo money_format("$%n",$total1);?></td>
					<td><? echo money_format("$%n",$t);?></td>
					<td><? echo $res['estatus'];?></td>
					<td><? echo $res['pago'];?></td>
				</tr>
	<?
	}
		}
		else
		{
		$query="select f.estatus_pago,date_format(f.fecha_emision,'%Y-%m-%d') as emision,f.no_factura,c.nombre as cliente,f.concepto,a.nombre as area,f.monto,f.iva,f.total,ep.nombre as estatus,date_format(f.fecha_pago,'%Y-%m-%d') AS pago from facturacion f join clientes c on f.id_cliente=c.id join proyectos p on f.id_proyecto=p.id join areas a on p.id_area=a.id join estatus_pago ep on f.estatus_pago=ep.id where f.id='$id_factura' order by f.no_factura";
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
	?>	
		<tr>
					<td><? echo $res['emision'];?></td>
					<td><? echo $res['no_factura'];?></td>
					<td><? echo $res['cliente'];?></td>
					<td><? echo $res['concepto'];?></td>
					<td><? echo $res['area'];?></td>
					<td></td>
					<td><? echo money_format("$%n",$monto1);?></td>
					<td><? echo money_format("$%n",$iva1);?></td>
					<td><? echo money_format("$%n",$total1);?></td>
					<td><? echo money_format("$%n",$t);?></td>
					<td><? echo $res['estatus'];?></td>
					<td><? echo $res['pago'];?></td>
				</tr>
	<?	
		}
			}//fin while
			
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
	?>			
		<tr>
					<td><? echo $res['emision'];?></td>
					<td><? echo $res['no_factura'];?></td>
					<td><? echo $res['cliente'];?></td>
					<td><? echo $res['concepto'];?></td>
					<td><? echo $res['area'];?></td>
					<td><? echo money_format("$%n",$res['total']);?></td>
					<td></td>
					<td></td>
					<td></td>
					<td><? echo money_format("$%n",$res['total']);?></td>
					<td><? echo $res['estatus'];?></td>
					<td><? echo $res['fecha_pago'];?></td>
				</tr>
			
	<?
	}
	else
	{
	$query="select date_format(f.fecha_emision,'%Y-%m-%d') as emision,f.no_factura,c.nombre as cliente,f.concepto,a.nombre as area,f.monto,f.iva,f.total,ep.nombre as estatus,f.fecha_pago from facturacion f join clientes c on f.id_cliente=c.id join proyectos p on f.id_proyecto=p.id join areas a on p.id_area=a.id join estatus_pago ep on f.estatus_pago=ep.id where f.id='$id_factura' order by f.no_factura";
				$resultado = mysql_query($query) or die("Error en consulta horario: $query " . mysql_error());
				$res=mysql_fetch_assoc($resultado);
				$saldoant=$saldoant+$res['total'];
				$total1=$total1+$res['total'];
	?>
	<tr>
					<td><? echo $res['emision'];?></td>
					<td><? echo $res['no_factura'];?></td>
					<td><? echo $res['cliente'];?></td>
					<td><? echo $res['concepto'];?></td>
					<td><? echo $res['area'];?></td>
					<td><? echo money_format("$%n",$res['total']);?></td>
					<td></td>
					<td></td>
					<td></td>
					<td><? echo money_format("$%n",$res['total']);?></td>
					<td><? echo $res['estatus'];?></td>
					<td><? echo $res['fecha_pago'];?></td>
				</tr>
	<?
	}
		}//fin while 2
		
		//formato de moneda
			$saldoant=money_format("$%n",$saldoant);
			$sumsub=money_format("$%n",$sumsub);
			$sumiva=money_format("$%n",$sumiva);
			$sumtotal=money_format("$%n",$sumtotal);
			$total1=money_format("$%n",$total1);
			//$sumpagados=money_format("$%n",$sumpagos);
			echo $TablaComplemento;		
	?>		
	<tr><td colspan="5"></td><td><? echo $saldoant;?></td><td><?echo$sumsub;?></td><td><?echo$sumiva;?></td><td><?echo$sumtotal;?></td><td><?echo$total1;?></td><td></td><td></td></tr>
	</tbody>		
</table>
<?
break;
}
?>