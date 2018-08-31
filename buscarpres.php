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

$tabla = "<table><thead><th>TIPO GASTO</th><th>TIPO SUBGASTO</th><th>MES</th><th>A&Ntilde;O</th><th>MONTO</th><th>DESCRIPCION</th></thead><tbody>";

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
	
	$tr = $tr."<tr><td>".$resimp['tipogasto']."</td><td>".$resimp['tiposubgasto']."</td><td>".$nmes."</td><td>".$resimp['anio']."</td><td>".$resimp['monto']."</td><td>".$resimp['descripcion']."</td></tr>";
}
$tabla = $tabla.$tr."<tr><td colspan=\"4\"></td><td>$mtotal</td><td></td></tr></tbody></table>";
echo "$tabla";
?>
