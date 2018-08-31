<?php
	session_start();
	include "coneccion.php";
	include "checar_sesion.php";
	include "checar_sesion_admin.php";
	
	$desde=$_GET['f1'];//fecha desde.
	$hasta=$_GET['f2'];//fecha hasta.
	$tp=$_GET['tp'];//indica si tiene o no No.factura.
	
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

	

	header('Content-type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename=gastos.xls');
	header('Pragma: no-cache');
	header('Expires: 0');
?>
<table border="1">
	<thead>
		<tr>
			<th bgcolor="#CCCCCC">Num</th>
			<th bgcolor="#CCCCCC">Fecha</th>
			<th bgcolor="#CCCCCC">�rea</th>
			<th bgcolor="#CCCCCC">Tipo de Gasto</th>
			<th bgcolor="#CCCCCC">Tipo de Subgasto</th>
			<th bgcolor="#CCCCCC">M�todo Pago</th>
			<th bgcolor="#CCCCCC">Proyecto</th>
			<th bgcolor="#CCCCCC">No.Factura</th>
			<th bgcolor="#CCCCCC">Proveedor</th>
			<th bgcolor="#CCCCCC">Concepto</th>
			<th bgcolor="#CCCCCC">Subtotal</th>
			<th bgcolor="#CCCCCC">Iva</th>
			<th bgcolor="#CCCCCC">Isr</th>
			<th bgcolor="#CCCCCC">Total</th>
		</tr>
	</thead>
<tbody>
<?
$queryhorario="SELECT g.*,p.nombre AS proyecto,a.nombre AS area,tg.nombre AS gasto,mp.tipo AS mpago,pr.nombre AS proveedor FROM gastos g left JOIN proyectos p ON g.id_proyecto=p.id JOIN areas a ON g.id_area=a.id JOIN tipo_gastos tg ON g.tipo_gasto=tg.id JOIN metodo_pago mp ON g.metodo_pago=mp.id JOIN proveedores pr ON g.proveedor=pr.id WHERE".$buscar;
$resultado = mysql_query($queryhorario) or die("Error en consulta horario: $queryhorario " . mysql_error());

$c=0;

$sumsub=0;
$sumiva=0;
$sumisr=0;
$sumtotal=0;


while($resh=mysql_fetch_assoc($resultado)){
$id=$resh['id'];
$subtotal=$resh['subtotal'];
$total=$resh['total'];

$id_subgasto = $resh['tipo_subgasto'];
$querysubg = "SELECT * FROM tipo_subgastos WHERE id=$id_subgasto";
$resultadosubg = mysql_query($querysubg) or die("Error en consulta subgasto: $querydubg " . mysql_error());
$ressubg=mysql_fetch_assoc($resultadosubg);
$tsubgasto=$ressubg['nombre'];

$sumtotal=$sumtotal+$total;
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
	
	
?>
<tr>
<td><? echo $id; ?></td>
<td>
<? echo $resh['fecha'];?><br />
</td>
<td>
<? echo $resh['area'];?>
</td>
<td>
<? echo $resh['gasto'];?>
</td>
<td>
<? echo $tsubgasto;?>
</td>
<td>
<? echo $resh['mpago'];?>
</td>
<td>
<? echo $resh['proyecto'];?>
</td>
<td>
<? echo $resh['factura'];?>
</td>
<td>
<? echo $resh['proveedor'];?>
</td>
<td>
<? echo $resh['concepto'];?>
</td>
<td>
<? echo money_format("$%n",$subtotal);?>
</td>
<td>
<?
echo money_format("$%n",$iva);
?>
</td>
<td>
<?
echo money_format("$%n",$isr);
?>
</td>

<td>
<? echo money_format("$%n",$total);?>
</td>
</tr>

<? 
if($cou>=1)
	{
	//$sumsub=$sumsub-$subtotal;
	$total=0;
	$subtotal=0;
	}
$cou++;
}
	}
?>
<tr><td colspan="9"></td><td><? echo money_format('$%n',$sumsub) ?></td><td><? echo money_format('$%n',$sumiva) ?></td><td><? echo money_format('$%n',$sumisr) ?></td><td><? echo money_format('$%n',$sumtotal) ?></td></tr>
</tbody>		
</table>