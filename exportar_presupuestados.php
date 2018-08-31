<?
include "coneccion.php";
$gasto = $_GET['gasto'];
$subgasto = $_GET['subgasto'];
$desde = $_GET['desdeb'];
$hasta = $_GET['hastab'];
$aniodesde = $_GET['aniodesde'];
$aniohasta = $_GET['aniohasta'];
$where="";
$tabla = "";
$tr = "";
if($aniodesde==$aniohasta)
{
	$where = " where anio='$aniodesde'";
}
elseif($aniodesde<$aniohasta)
{
	$where = " where anio>='$aniodesde' AND anio<='$aniohasta'";
}
elseif($aniodesde>$aniohasta)
{
	$where = "";
}
if($gasto != 0)
{
	$where .= " AND tipo_gasto=$gasto";
}
if($subgasto != 0)
{
	$where .= " AND tipo_subgasto=$subgasto";
}
if($desde != 0 && $hasta !=0)
{
		if($desde==$hasta)
		{
			$where .= " AND mes=$desde";
		}
		elseif($desde<$hasta)
		{
			$where .= " AND mes>='$desde' AND mes<='$hasta'";
		}
		elseif($desde>$hasta)
		{
			$where = "";
		}
}
	header('Content-type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename=presupuestados.xls');
	header('Pragma: no-cache');
	header('Expires: 0');
?>
<table border="1">
	<thead>
		<tr>
			<th bgcolor="#CCCCCC">TIPO GASTO</th>
			<th bgcolor="#CCCCCC">TIPO SUBGASTO</th>
			<th bgcolor="#CCCCCC">MES</th>
			<th bgcolor="#CCCCCC">AÑO</th>
			<th bgcolor="#CCCCCC">MONTO</th>
			<th bgcolor="#CCCCCC">DESCRIPCION</th>
		</tr>
	</thead>
<tbody>
<?
$queryimp="SELECT pr.*,tp.nombre AS tipogasto,tps.nombre As tiposubgasto FROM presupuestados pr JOIN tipo_gastos tp ON pr.tipo_gasto=tp.id JOIN tipo_subgastos tps ON pr.tipo_subgasto=tps.id".$where;

$resultadoimp = mysql_query($queryimp) or die("Error en consulta queryimp: $queryimp " . mysql_error());
$count=0;
$mes = "";
while($resimp=mysql_fetch_assoc($resultadoimp))
{
	$mes = $resimp['mes'];
	setlocale(LC_TIME, 'spanish');  
 $nmes=strftime("%B",mktime(0, 0, 0, $mes, 1, 2000)); 
	
	$mtotal = $mtotal+$resimp['monto'];
?>
<tr>
<td>
<? echo $resimp['tipogasto'];?>
</td>
<td>
<? echo $resimp['tiposubgasto'];?>
</td>
<td>
<? echo $nmes;?>
</td>
<td>
<? echo $resimp['anio'];?>
</td>
<td>
<? echo money_format("$%n",$resimp['monto']);?>
</td>
<td>
<?
echo $resimp['descripcion'];
?>
</td>
</tr>
<?
}
?>
<tr>
<td colspan="4"></td>
<td><? echo money_format("$%n",$mtotal);?></td>
<td></td>
</tr>
</tbody>
</table>