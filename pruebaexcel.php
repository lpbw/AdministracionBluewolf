<?
session_start();
include_once('PHPExcel/Classes/PHPExcel/IOFactory.php');
include "coneccion.php";
include "checar_sesion.php";
include "checar_sesion_admin.php";
include "funciones.php";
$desde=date("Y-m-d",strtotime($_GET["f1"]));
$hasta=date("Y-m-d",strtotime($_GET["f2"]));

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
->setLastModifiedBy("Maarten Balliauw")
->setTitle("Office 2007 XLSX Test Document")
->setSubject("Office 2007 XLSX Test Document")
->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
->setKeywords("office 2007 openxml php")
->setCategory("Test result file");
//estilo
$estilo = array( 
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),
    'borders' => array(
      'outline' => array(
        'style' => PHPExcel_Style_Border::BORDER_THIN
      )
    )
  );
  $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($estilo);
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
$counthead=1;//excel
//head tabla
for ($x=$yeardesde; $x <= $yearhasta ; $x++)
{
    if ($x == $yearhasta)
    {
        $val2=$monthasta;
        if ($count > 0 )
        {
            $val1=1;
        }
    }
    else
    {
        $val2=12;
        if ($count > 0 )
        {
            $val1=1;
        }
    }
    //recorre los meses.
    
    for ($i=$val1; $i <=$val2  ; $i++)
    { 
        $month = EncontrarMes($i);//nombre del mes.
        $tab .= "<th>$month/$x</th>";
        $totalareas = CalcularTotalIngresos($x,$i);
        $td .= "<td>".money_format('$%n',$totalareas)."</td>";
        $total1=$total1+$totalareas;
        $counthead++;
    }
    
    $count++;
}
// Add some data
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:L'.$counthead);//combinar celdas.
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Reporte de Ingresos BW del '.$desde.' al '.$hasta);
$tab .= "<th>total general</th></tr></thead>";
//body tabla
$tab1 = "<tbody>";
$val1 = $monthdesde;
$val2 = $monthasta;
$totalgeneral = 0;
//area
for ($w=1; $w <=7 ; $w++)
{
    $count=0;
    $totalgeneralmes=0;
    $total2 = 0;
    $tab1 .="<tr border=\"1\">";
    $tab1 .= EncontrarArea($w);//nombre area
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
        }elseif ($x == $yearhasta) 
        {
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
        for ($i=$val1; $i <=$val2  ; $i++)
        { 
            $tab1 .= CalculaIngresosMes($x,$i,$w);//year,month,area
            $totalgeneralmes = $totalgeneralmes + TotalGeneralarea($x,$i,$w);//year,month,area
            
        }
        $totalgeneral = $totalgeneral + $totalgeneralmes;
        $total2 = $total2 + $totalgeneral;
        $count=1;
    }
    $tab1 .="<td>".money_format('$%n',$totalgeneralmes)."</td></tr>";
    if ($w == 7) 
    {
        if ((int)$total1 == (int)$total2) 
        {
            $tab2 = "<tr><td>TOTAL GENERAL</td>".$td."<td>".money_format('$%n',$total1)."</td></tr>";
        }
        elseif((int)$total1 != (int)$total2) 
        {    
            $tab2 = "<tr><td>TOTAL GENERAL</td>".$td."<td>Las cantidades no coinciden</td></tr>";
        }	
    }
}		
$tab1 .= $tab2;
$tab1 .= "</tbody></table>";
$tabla .= $tab.$tab1;
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="01simple.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>