<?
    include "coneccion.php";
    include "funciones.php";
    //recibe fechas y valor.
    $desde = date("Y-m-d",strtotime($_GET["desde"]));
    $hasta = date("Y-m-d",strtotime($_GET["hasta"]));
    $valor = $_GET['val'];

    /*
    -valor=1 detalle_ingresos.php
    */

    //inicio switch
    switch ($valor)
    {

        //detalle ingresos
        case 1:
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
                $tr .="<tr>";
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
            echo $tabla;
            break;
        
        default:
            
            break;
    }
    //fin switch
?>