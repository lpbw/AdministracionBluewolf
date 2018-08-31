<?
    session_start();
	include "coneccion.php";
	include "checar_sesion.php";
    include "checar_sesion_admin.php";
    include "funciones.php";
    require_once 'PHPExcel/Classes/PHPExcel.php';
    $desde=date("Y-m-d",strtotime($_GET["f1"]));
    $hasta=date("Y-m-d",strtotime($_GET["f2"]));
    
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
   // Create new PHPExcel object
    $Excel = new PHPExcel();
    // Set document properties
    $Excel->getProperties()->setCreator("Luis Perez")
    ->setLastModifiedBy("Luis Perez")
    ->setTitle("Reporte Egresos bw")
    ->setSubject("reporte egresos")
    ->setDescription("Reporte de egresos bw.")
    ->setKeywords("office 2007 openxml php")
    ->setCategory("Reporte Egresos");
    //creamos nuestro array con los estilos para titulos 
    $h1 = array(
        'font' => array(
        'bold' => true, 
        'size' => 8, 
        'name' => 'Tahoma'
        ), 
        'borders' => array(
        'outline' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '000000')
        )
        ), 
        'alignment' => array(
        'vertical' => 'center', 
        'horizontal' => 'center'
        ),
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '666666')
        )
    ); 
    
    //creamos nuestro array con los estilos para body
    $body = array(
        'font' => array(
        'bold' => false, 
        'size' => 8, 
        'name' => 'Tahoma'
        ), 
        'borders' => array(
        'outline' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '000000')
        )
        ), 
        'alignment' => array(
        'vertical' => 'center', 
        'horizontal' => 'center'
        )
    ); 
    

    //Damos formato o estilo a nuestras celdas 
    $Excel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($h1); 
    // titulo
    $des = EncontrarMes($monthdesde);
    $has = EncontrarMes($monthasta);
    $Excel->getActiveSheet()->mergeCells('A1:L1');
    $Excel->getActiveSheet()->setCellValue('A1',"REPORTE DE EGRESOS BW DEL ".$des."/".$yeardesde." AL ".$has."/".$yearhasta);

    //encabezado
    $count=0;
    $c=1;
	$val1 = $monthdesde;
	$val2 = $monthasta;
    $Excel->getActiveSheet()->setCellValue('A2',"AREÁ");
    $Excel->getActiveSheet()->getStyle('A2')->applyFromArray($h1);
    for ($x=$yeardesde; $x <= $yearhasta ; $x++) {
		if ($x == $yearhasta) {
            $val2=$monthasta;
            $columna=1;
            $fila=2;
			if ($count > 0 ) {
                $val1=1;
                $columna=$c;
                $fila=2;
			}
		}else {
            $val2=12;
            $columna=1;
            $fila=2;
			if ($count > 0 ) {
                $val1=1;
                $columna=$c;
                $fila=2;
			}
		}
        //recorre los meses.
        
		for ($i=$val1; $i <=$val2  ; $i++) { 
            $month = EncontrarMes($i);//nombre del mes.

            //Poner valor por columna y fila
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($columna, $fila, $month."/".$x);

            //poner estilo por columna y fila
            $Excel->getActiveSheet()->getStyleByColumnAndRow($columna,$fila)->applyFromArray($h1);
            $totalareas = CalcularTotalIngresosGasto($x,$i);
             //Poner valor por columna y fila
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($columna, 10,$totalareas);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($columna,10)->getNumberFormat()->setFormatCode('$#,##0.00');
            $Excel->getActiveSheet()->getStyleByColumnAndRow($columna,10)->applyFromArray($body);
            $total1=$total1+$totalareas;
            $columna++;
            $c++;
		}
		
		$count++;
    } 
    //Poner valor por columna y fila
    $Excel->getActiveSheet()->setCellValueByColumnAndRow($columna, $fila, "TOTAL GENERAL");
    //poner estilo por columna y fila
    $Excel->getActiveSheet()->getStyleByColumnAndRow($columna,$fila)->applyFromArray($h1);
    //body
	$val1 = $monthdesde;
	$val2 = $monthasta;
    $totalgeneral = 0;
    
    $fila=3;
	//area
	for ($w=1; $w <=7 ; $w++) {
        $columna=1;
		$count=0;
		$totalgeneralmes=0;
		$total2 = 0;
		$tab1 .="<tr>";
        $area = EncontrarArea2($w);//nombre area
        //Poner valor por columna y fila
        $Excel->getActiveSheet()->setCellValueByColumnAndRow(0, $fila, $area);
        $Excel->getActiveSheet()->getStyleByColumnAndRow(0,$fila)->applyFromArray($body);
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
                
                $totalmesgasto2 = CalculaIngresosMesGasto2($x,$i,$w);//year,month,area
                 //Poner valor por columna y fila
                $Excel->getActiveSheet()->setCellValueByColumnAndRow($columna, $fila, $totalmesgasto2);
                $Excel->getActiveSheet()->getStyleByColumnAndRow($columna,$fila)->getNumberFormat()->setFormatCode('$#,##0.00');
                $Excel->getActiveSheet()->getStyleByColumnAndRow($columna,$fila)->applyFromArray($body);
                $columna++;
				$totalgeneralmes = $totalgeneralmes + TotalGeneralareaGasto($x,$i,$w);//year,month,area
				
			}
			$totalgeneral = $totalgeneral + $totalgeneralmes;
			$total2 = $total2 + $totalgeneral;
			$count=1;
		}
		  //Poner valor por columna y fila
          $Excel->getActiveSheet()->setCellValueByColumnAndRow($columna, $fila, $totalgeneralmes);
          $Excel->getActiveSheet()->getStyleByColumnAndRow($columna,$fila)->getNumberFormat()->setFormatCode('$#,##0.00');
          $Excel->getActiveSheet()->getStyleByColumnAndRow($columna,$fila)->applyFromArray($body);
		if ($w == 7) {
			
			if ((int)$total1 == (int)$total2) {
                $tab2 = "<tr><td>TOTAL GENERAL</td>".$td."<td>".money_format('$%n',$total1)."</td></tr>";
                 //Poner valor por columna y fila
                $Excel->getActiveSheet()->setCellValueByColumnAndRow(0, 10, "TOTAL GENERAL");
                $Excel->getActiveSheet()->getStyleByColumnAndRow(0,10)->applyFromArray($body);
                $Excel->getActiveSheet()->setCellValueByColumnAndRow($columna, $fila+1, $total1);
                $Excel->getActiveSheet()->getStyleByColumnAndRow($columna,$fila+1)->getNumberFormat()->setFormatCode('$#,##0.00');
                $Excel->getActiveSheet()->getStyleByColumnAndRow($columna,$fila+1)->applyFromArray($body);
			}elseif((int)$total1 != (int)$total2) {
				
				$tab2 = "<tr><td>TOTAL GENERAL</td>".$td."<td>Las cantidades no coinciden</td></tr>";
			}	
        }
        $fila++;
       
	}
    //fin body

    // Rename worksheet
    $Excel->getActiveSheet()->setTitle('Egresos');
    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $Excel->setActiveSheetIndex(0);

    // Redirect output to a client’s web browser (Excel2007)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Reporte Egresos '.$des.'/'.$yeardesde.'-'.$has.'/'.$yearhasta.'.xlsx"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');
    // If you're serving to IE over SSL, then the following may be needed
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0
    $objWriter = PHPExcel_IOFactory::createWriter($Excel, 'Excel2007');
    $objWriter->save('php://output');
    exit; 
?>