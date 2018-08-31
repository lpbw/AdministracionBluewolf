<?
    session_start();
	include "coneccion.php";
	include "checar_sesion.php";
    include "checar_sesion_admin.php";
	include "funciones.php";
	
    $desde=date("Y-m-d",strtotime($_GET["f1"]));
	$hasta=date("Y-m-d",strtotime($_GET["f2"]));
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reporte Facturas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<!-- <link rel="stylesheet" href="assets/css/main.css" /> -->
		<!-- <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript> -->
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
        <style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
</head>
<body>
<?
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
			$tab1 .="<tr border=\"1\">";
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
        //echo $tabla;
    header('Pragma: public');
    header('Expires: 0');
    header('Content-type: application/x-msdownload');
	header('Content-Disposition: attachment;filename=Reporte Ingresos.xls');
    header('Pragma: no-cache');
	

?>
    <? echo $tabla;?>
</body>
</html>