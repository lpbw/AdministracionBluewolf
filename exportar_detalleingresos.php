<?
    session_start();
	include "coneccion.php";
	include "checar_sesion.php";
    include "checar_sesion_admin.php";
	include "funciones.php";
    $desde = date("Y-m-d",strtotime($_GET["f1"]));
    $hasta = date("Y-m-d",strtotime($_GET["f2"]));
    $datedesde = explode("-",$desde);
            $yeardesde = (int)$datedesde[0];//Yeardesde
            $monthdesde = (int)$datedesde[1];//monthdesde
            $daydesde = (int)$datedesde[2];//daydesde
            // separar fecha hasta en anio, mes, dia
            $datehasta = explode("-",$hasta);
            $yearhasta = (int)$datehasta[0];//Yearhasta
            $monthasta = (int)$datehasta[1];//monthhasta
            $dayhasta = (int)$datehasta[2];//dayhasta
            $tabla = "<table class=\"t\" id=\"mitabla\"><thead><th>área</th><th>fecha emision</th><th>no.factura</th><th>cliente</th><th>concepto</th><th>total</th><th>fecha pago</th><th>estatus</th><th>tipo</th></thead>";
            $tabla .= "<tbody>";
            $totalgeneral = 0;
            $val1 = $monthdesde;
		    $val2 = $monthasta;
            //area
            for ($w=1; $w <=7 ; $w++)
            {
                $count=0;
                $totalgeneralmes=0;
                //$tr .="<tr>";
                for ($x=$yeardesde; $x <= $yearhasta ; $x++)
                {
                    if ($x < $yearhasta)
                    {
                        if ($count == 1)
                        {
                            $val1 = 1;
                            $val2 = 12;
                        }
                        else
                        {
                            $val2 = 12;
                            $val1 = $monthdesde;
                        }
                        
                    }
                    elseif($x == $yearhasta)
                    {
                        //si ya entro una vez en el for de year
                        if ($count == 1)
                        {
                            $val1 = 1;
                            $val2 = $monthasta;
                        }
                        else
                        {
                            $val1 = $monthdesde;
                            $val2 = $monthasta;
                        }
                        
                    }
                    //recorre los meses.
                    for ($i=$val1; $i <=$val2  ; $i++)
                    { 
                        $tr .= CalculaIngresosDetalleMes($x,$i,$w);//year,month,area
                        $totalgeneral = $totalgeneral + CalculartotalDetalleMes($x,$i,$w);
                    }
                    $count=1;
                }
                //$tr .="</tr>";
            }
            $tabla .= $tr."<tr><td colspan=\"4\"></td><td>TOTAL GENERAL</td><td>$totalgeneral</td><td colspan=\"3\"></td></tr></tbody></table>";
            //echo $tabla;
	header('Content-type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename=Detalle Ingresos.xls');
	header('Pragma: no-cache');
	header('Expires: 0');
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
    <? echo $tabla;?>
</body>
</html>