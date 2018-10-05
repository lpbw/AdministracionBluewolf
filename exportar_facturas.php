<?
    require_once 'PHPExcel/Classes/PHPExcel.php';
    include "coneccion.php";

    $desde=date("Y-m-d",strtotime($_GET['f1']));//fecha desde.
    $hasta=date("Y-m-d",strtotime($_GET['f2']));//fecha hasta.
    
    /*--Totales Generales-*/
    $TotalGeneral=0;
    $SaldoAnteriorGeneral=0;
    $IvaGeneral=0;
    $SubTotalGeneral=0;
    $SaldoTotalGeneral=0;
    // Create new PHPExcel object
    $Excel = new PHPExcel();

    // Set document properties
    $Excel->getProperties()->setCreator("Luis Perez")
    ->setLastModifiedBy("Luis Perez")
    ->setTitle("Reporte Intereses Misíon")
    ->setSubject("reporte Intereses")
    ->setDescription("Reporte de Intereses Misíon.")
    ->setKeywords("office 2007 openxml php")
    ->setCategory("Reporte Intereses");

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
            'color' => array('rgb' => 'C5C5C5')
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

    //creamos nuestro array con los estilos para body
    $titulos = array(
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

    $Excel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($h1);
    $Excel->getActiveSheet()->mergeCells('A1:L1');
    $Excel->getActiveSheet()->setCellValue('A1',"Fecha Reporte de Facturas BW del $desde al $hasta");

    //-----------------Titulos de la tabla--------------------------------//
    $Excel->getActiveSheet()->setCellValue('A2',"Fecha")->getStyle('A2')->applyFromArray($h1);//0
    $Excel->getActiveSheet()->setCellValue('B2',"No.Factura")->getStyle('B2')->applyFromArray($h1);//1
    $Excel->getActiveSheet()->setCellValue('C2',"Cliente")->getStyle('C2')->applyFromArray($h1);//2
    $Excel->getActiveSheet()->setCellValue('D2',"Concepto")->getStyle('D2')->applyFromArray($h1);//3
    $Excel->getActiveSheet()->setCellValue('E2',"Área de Venta")->getStyle('E2')->applyFromArray($h1);//4
    $Excel->getActiveSheet()->setCellValue('F2',"Saldo Anterior")->getStyle('F2')->applyFromArray($h1);//5
    $Excel->getActiveSheet()->setCellValue('G2',"Subtotal")->getStyle('G2')->applyFromArray($h1);//6
    $Excel->getActiveSheet()->setCellValue('H2',"Iva")->getStyle('H2')->applyFromArray($h1);//7
    $Excel->getActiveSheet()->setCellValue('I2',"Total")->getStyle('I2')->applyFromArray($h1);//8
    $Excel->getActiveSheet()->setCellValue('J2',"Saldo")->getStyle('J2')->applyFromArray($h1);//9
    $Excel->getActiveSheet()->setCellValue('K2',"Estatus")->getStyle('K2')->applyFromArray($h1);//10
    $Excel->getActiveSheet()->setCellValue('L2',"Fecha de Pago")->getStyle('L2')->applyFromArray($h1);//11
    /*-------------------------------------------------------------------*/

            /**------------------Query para encontrar Proyectos de las facturas pagos pendientes anteriores -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
        $QueryProyectoAtras="SELECT id,id_proyecto,no_factura,estatus_pago FROM facturacion WHERE fecha_emision<'$desde 00:00:00' AND estatus_pago=1 ORDER BY no_factura";
        $ResultadoProyectoAtras = mysql_query($QueryProyectoAtras) or die("Error en consulta proyecto atras: $QueryProyectoAtras " . mysql_error());
        $Columna=0;
        $Fila=3;
		while($ResProyectoAtras=mysql_fetch_assoc($ResultadoProyectoAtras))
		{
            $IdFacturaAtras = $ResProyectoAtras['id'];
            if ($ResProyectoAtras['id_proyecto']==0)//factura no tiene proyecto
            {
                $QueryFacturasAtras = "SELECT ep.nombre AS estatus,date_format(f.fecha_emision,'%Y-%m-%d') as emision,f.no_factura,c.nombre as cliente,f.concepto,a.nombre as area,f.monto,f.iva,f.total,ep.nombre as estatus,date_format(f.fecha_pago,'%Y-%m-%d') AS pago from facturacion f join clientes c on f.id_cliente=c.id join areas a on f.id_area=a.id join estatus_pago ep on f.estatus_pago=ep.id where f.id='$IdFacturaAtras' order by f.no_factura";
            }
            else//Factura con proyecto
            {
                $QueryFacturasAtras = "SELECT ep.nombre AS estatus,date_format(f.fecha_emision,'%Y-%m-%d') as emision,f.no_factura,c.nombre as cliente,f.concepto,a.nombre as area,f.monto,f.iva,f.total,ep.nombre as estatus,date_format(f.fecha_pago,'%Y-%m-%d') AS pago from facturacion f join clientes c on f.id_cliente=c.id join proyectos p on f.id_proyecto=p.id join areas a on p.id_area=a.id join estatus_pago ep on f.estatus_pago=ep.id where f.id='$IdFacturaAtras' order by f.no_factura";
            }

            $ResultadoFacturasAtras = mysql_query($QueryFacturasAtras) or die("Error en query facturas pendientes atras $QueryFacturasAtras".mysql_error());
            $ResFacAtras = mysql_fetch_assoc($ResultadoFacturasAtras);

            //fecha
            $Columna=0; //A
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacAtras['emision']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            //no factura
            $Columna++; //B
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacAtras['no_factura']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            //cliente
            $Columna++; //C
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacAtras['cliente']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);
            
            //concepto
            $Columna++; //D
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacAtras['concepto']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            //area
            $Columna++; //E
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacAtras['area']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            //saldo anterior
            $Columna++; //F
            $SaldoAnteriorGeneral=$SaldoAnteriorGeneral+$ResFacAtras['total'];
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacAtras['total']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");

            //subtotal
            $Columna++; //G
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, 0);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");

            //iva
            $Columna++; //H
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, 0);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");

            //total
            $Columna++; //I
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, 0);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");

            //saldo
            $Columna++; //J
            $SaldoTotalGeneral=$SaldoTotalGeneral+$ResFacAtras['total'];
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacAtras['total']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");

            //estatus
            $Columna++; //K
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacAtras['estatus']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            //fecha pago
            $Columna++; //L
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacAtras['pago']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            $Fila++;
        }
    /**--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */


    /**------------------Query para encontrar Proyectos de las facturas con pago pendiente -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
        $QueryProyecto="SELECT id,id_proyecto,no_factura,estatus_pago FROM facturacion WHERE fecha_emision>='$desde 00:00:00' AND estatus_pago=1 ORDER BY no_factura";
        $ResultadoProyecto = mysql_query($QueryProyecto) or die("Error en consulta proyecto: $QueryProyecto " . mysql_error());
        $Columna=0;
        //$Fila=3;
		while($ResProyecto=mysql_fetch_assoc($ResultadoProyecto))
		{
            $IdFactura = $ResProyecto['id'];
            if ($ResProyecto['id_proyecto']==0)//factura no tiene proyecto
            {
                $QueryFacturasPendientes = "SELECT ep.nombre AS estatus,date_format(f.fecha_emision,'%Y-%m-%d') as emision,f.no_factura,c.nombre as cliente,f.concepto,a.nombre as area,f.monto,f.iva,f.total,ep.nombre as estatus,date_format(f.fecha_pago,'%Y-%m-%d') AS pago from facturacion f join clientes c on f.id_cliente=c.id join areas a on f.id_area=a.id join estatus_pago ep on f.estatus_pago=ep.id where f.id='$IdFactura' order by f.no_factura";
            }
            else//Factura con proyecto
            {
                $QueryFacturasPendientes = "SELECT ep.nombre AS estatus,date_format(f.fecha_emision,'%Y-%m-%d') as emision,f.no_factura,c.nombre as cliente,f.concepto,a.nombre as area,f.monto,f.iva,f.total,ep.nombre as estatus,date_format(f.fecha_pago,'%Y-%m-%d') AS pago from facturacion f join clientes c on f.id_cliente=c.id join proyectos p on f.id_proyecto=p.id join areas a on p.id_area=a.id join estatus_pago ep on f.estatus_pago=ep.id where f.id='$IdFactura' order by f.no_factura";
            }

            $ResultadoFacturasPendientes = mysql_query($QueryFacturasPendientes) or die("Error en query facturas pendioentes $QueryFacturasPendientes".mysql_error());
            $ResFacPendientes = mysql_fetch_assoc($ResultadoFacturasPendientes);

            //fecha
            $Columna=0; //A
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacPendientes['emision']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            //no factura
            $Columna++; //B
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacPendientes['no_factura']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            //cliente
            $Columna++; //C
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacPendientes['cliente']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);
            
            //concepto
            $Columna++; //D
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacPendientes['concepto']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            //area
            $Columna++; //E
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacPendientes['area']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            //saldo anterior
            $Columna++; //F
            $SaldoAnteriorGeneral=$SaldoAnteriorGeneral+$ResFacPendientes['total'];
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacPendientes['total']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");

            //subtotal
            $Columna++; //G
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, 0);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");

            //iva
            $Columna++; //H
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, 0);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");

            //total
            $Columna++; //I
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, 0);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");

            //saldo
            $Columna++; //J
            $SaldoTotalGeneral=$SaldoTotalGeneral+$ResFacPendientes['total'];
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacPendientes['total']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");

            //estatus
            $Columna++; //K
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacPendientes['estatus']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            //fecha pago
            $Columna++; //L
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacPendientes['pago']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            $Fila++;
        }
    /**--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */

    /**------------------Query para encontrar Proyectos de las facturas ppagadas -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
        $QueryProyectoPagadas="SELECT id,id_proyecto,no_factura,estatus_pago FROM facturacion WHERE fecha_emision>='$desde 00:00:00' AND fecha_emision<='$hasta 00:00:00' AND estatus_pago=2 ORDER BY no_factura";
        $ResultadoProyectoPagadas = mysql_query($QueryProyectoPagadas) or die("Error en consulta proyecto pagadas: $QueryProyectoPagadas " . mysql_error());
        $Count=0;
        //$Fila=3;
		while($ResProyectoPagadas=mysql_fetch_assoc($ResultadoProyectoPagadas))
		{
            $IdFacturaPagadas = $ResProyectoPagadas['id'];
            $ArrayIdFacturasPagadas[$count] = $IdFacturaPagadas;
            $count++;
            if ($ResProyectoPagadas['id_proyecto']==0)//factura no tiene proyecto
            {
                $QueryFacturasPagadas = "SELECT ep.nombre AS estatus,date_format(f.fecha_emision,'%Y-%m-%d') as emision,f.no_factura,c.nombre as cliente,f.concepto,a.nombre as area,f.monto,f.iva,f.total,ep.nombre as estatus,date_format(f.fecha_pago,'%Y-%m-%d') AS pago from facturacion f join clientes c on f.id_cliente=c.id join areas a on f.id_area=a.id join estatus_pago ep on f.estatus_pago=ep.id where f.id='$IdFacturaPagadas' order by f.no_factura";
            }
            else//Factura con proyecto
            {
                $QueryFacturasPagadas = "SELECT ep.nombre AS estatus,date_format(f.fecha_emision,'%Y-%m-%d') as emision,f.no_factura,c.nombre as cliente,f.concepto,a.nombre as area,f.monto,f.iva,f.total,ep.nombre as estatus,date_format(f.fecha_pago,'%Y-%m-%d') AS pago from facturacion f join clientes c on f.id_cliente=c.id join proyectos p on f.id_proyecto=p.id join areas a on p.id_area=a.id join estatus_pago ep on f.estatus_pago=ep.id where f.id='$IdFacturaPagadas' order by f.no_factura";
            }

            $ResultadoFacturasPagadas = mysql_query($QueryFacturasPagadas) or die("Error en query facturas pagadas $QueryFacturasPagadas".mysql_error());
            $ResFacPagadas = mysql_fetch_assoc($ResultadoFacturasPagadas);

            //fecha
            $Columna=0; //A
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacPagadas['emision']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            //no factura
            $Columna++; //B
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacPagadas['no_factura']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            //cliente
            $Columna++; //C
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacPagadas['cliente']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);
            
            //concepto
            $Columna++; //D
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacPagadas['concepto']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            //area
            $Columna++; //E
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacPagadas['area']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            //saldo anterior
            $Columna++; //F
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, 0);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");

            //subtotal
            $Columna++; //G
            $SubTotalGeneral=$SubTotalGeneral+$ResFacPagadas['monto'];
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacPagadas['monto']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");

            //iva
            $Columna++; //H
            $IvaGeneral=$IvaGeneral+$ResFacPagadas['iva'];
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacPagadas['iva']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");

            //total
            $Columna++; //I
            $TotalGeneral=$TotalGeneral+$ResFacPagadas['total'];
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacPagadas['total']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");

            //saldo
            $Columna++; //J
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, 0);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");

            //estatus
            $Columna++; //K
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacPagadas['estatus']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            //fecha pago
            $Columna++; //L
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacPagadas['pago']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            $Fila++;
        }
    /**--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
    
    /**------------------Query para encontrar Proyectos de las facturas canceladas -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
        $QueryProyectoCanceladas="SELECT id,id_proyecto,no_factura,estatus_pago FROM facturacion WHERE fecha_emision>='$desde 00:00:00' AND fecha_emision<='$hasta 00:00:00' AND estatus_pago=3 ORDER BY no_factura";
        $ResultadoProyectoCanceladas = mysql_query($QueryProyectoCanceladas) or die("Error en consulta proyecto canceladas: $QueryProyectoCanceladas " . mysql_error());
        //$Columna=0;
        //$Fila=3;
		while($ResProyectoCanceladas=mysql_fetch_assoc($ResultadoProyectoCanceladas))
		{
            $IdFacturaPagadas = $ResProyectoCanceladas['id'];
            if ($ResProyectoCanceladas['id_proyecto']==0)//factura no tiene proyecto
            {
                $QueryFacturasCanceladas = "SELECT ep.nombre AS estatus,date_format(f.fecha_emision,'%Y-%m-%d') as emision,f.no_factura,c.nombre as cliente,f.concepto,a.nombre as area,f.monto,f.iva,f.total,ep.nombre as estatus,date_format(f.fecha_pago,'%Y-%m-%d') AS pago from facturacion f join clientes c on f.id_cliente=c.id join areas a on f.id_area=a.id join estatus_pago ep on f.estatus_pago=ep.id where f.id='$IdFacturaPagadas' order by f.no_factura";
            }
            else//Factura con proyecto
            {
                $QueryFacturasCanceladas = "SELECT ep.nombre AS estatus,date_format(f.fecha_emision,'%Y-%m-%d') as emision,f.no_factura,c.nombre as cliente,f.concepto,a.nombre as area,f.monto,f.iva,f.total,ep.nombre as estatus,date_format(f.fecha_pago,'%Y-%m-%d') AS pago from facturacion f join clientes c on f.id_cliente=c.id join proyectos p on f.id_proyecto=p.id join areas a on p.id_area=a.id join estatus_pago ep on f.estatus_pago=ep.id where f.id='$IdFacturaPagadas' order by f.no_factura";
            }

            $ResultadoFacturasCanceladas = mysql_query($QueryFacturasCanceladas) or die("Error en query facturas canceladas $QueryFacturasCanceladas".mysql_error());
            $ResFacCanceladas = mysql_fetch_assoc($ResultadoFacturasCanceladas);

            //fecha
            $Columna=0; //A
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacCanceladas['emision']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            //no factura
            $Columna++; //B
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacCanceladas['no_factura']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            //cliente
            $Columna++; //C
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacCanceladas['cliente']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);
            
            //concepto
            $Columna++; //D
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacCanceladas['concepto']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            //area
            $Columna++; //E
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacCanceladas['area']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            //saldo anterior
            $Columna++; //F
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, 0);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");

            //subtotal
            $Columna++; //G
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, 0);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");

            //iva
            $Columna++; //H
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, 0);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");

            //total
            $Columna++; //I
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, 0);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");

            //saldo
            $Columna++; //J
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, 0);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");

            //estatus
            $Columna++; //K
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacCanceladas['estatus']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            //fecha pago
            $Columna++; //L
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacCanceladas['pago']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            $Fila++;
        }
    /**--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
    
        /**------------------Query para encontrar Proyectos de las facturas sustituidas -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
        $QueryProyectoSustituidas="SELECT id,id_proyecto,no_factura,estatus_pago FROM facturacion WHERE fecha_emision>='$desde 00:00:00' AND fecha_emision<='$hasta 00:00:00' AND estatus_pago=4 ORDER BY no_factura";
        $ResultadoProyectoSustituido = mysql_query($QueryProyectoSustituidas) or die("Error en consulta proyecto sustituidos: $QueryProyectoSustituidas " . mysql_error());
        //$Columna=0;
        //$Fila=3;
		while($ResProyectoSustituido = mysql_fetch_assoc($ResultadoProyectoSustituido))
		{
            $IdFacturaPagadas = $ResProyectoSustituido['id'];
            if ($ResProyectoSustituido['id_proyecto']==0)//factura no tiene proyecto
            {
                $QueryProyectoSustituido = "SELECT ep.nombre AS estatus,date_format(f.fecha_emision,'%Y-%m-%d') as emision,f.no_factura,c.nombre as cliente,f.concepto,a.nombre as area,f.monto,f.iva,f.total,ep.nombre as estatus,date_format(f.fecha_pago,'%Y-%m-%d') AS pago from facturacion f join clientes c on f.id_cliente=c.id join areas a on f.id_area=a.id join estatus_pago ep on f.estatus_pago=ep.id where f.id='$IdFacturaPagadas' order by f.no_factura";
            }
            else//Factura con proyecto
            {
                $QueryProyectoSustituido = "SELECT ep.nombre AS estatus,date_format(f.fecha_emision,'%Y-%m-%d') as emision,f.no_factura,c.nombre as cliente,f.concepto,a.nombre as area,f.monto,f.iva,f.total,ep.nombre as estatus,date_format(f.fecha_pago,'%Y-%m-%d') AS pago from facturacion f join clientes c on f.id_cliente=c.id join proyectos p on f.id_proyecto=p.id join areas a on p.id_area=a.id join estatus_pago ep on f.estatus_pago=ep.id where f.id='$IdFacturaPagadas' order by f.no_factura";
            }

            $ResultadoFacturasSustituidas = mysql_query($QueryProyectoSustituido) or die("Error en query facturas sustituidas $QueryProyectoSustituido".mysql_error());
            $ResFacSustituidas = mysql_fetch_assoc($ResultadoFacturasSustituidas);

            //fecha
            $Columna=0; //A
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacSustituidas['emision']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            //no factura
            $Columna++; //B
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacSustituidas['no_factura']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            //cliente
            $Columna++; //C
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacSustituidas['cliente']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);
            
            //concepto
            $Columna++; //D
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacSustituidas['concepto']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            //area
            $Columna++; //E
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacSustituidas['area']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            //saldo anterior
            $Columna++; //F
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, 0);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");

            //subtotal
            $Columna++; //G
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, 0);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");

            //iva
            $Columna++; //H
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, 0);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");

            //total
            $Columna++; //I
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, 0);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");

            //saldo
            $Columna++; //J
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, 0);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");

            //estatus
            $Columna++; //K
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacSustituidas['estatus']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            //fecha pago
            $Columna++; //L
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResFacSustituidas['pago']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            $Fila++;
        }
    /**--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
        
    /*------------------------------- Complementos ----------------------------------------------------------------------*/
       
        foreach ($ArrayIdFacturasPagadas as $Id) 
        {   
            $QueryProyectoComplemento="SELECT f.id_proyecto,f.no_factura,f.estatus_pago,c.id_complemento,c.no_complemento,c.concepto,c.monto FROM facturacion f JOIN complemento c ON f.id=c.id_factura WHERE id=$Id";
            $ResultadoProyectoComplemento = mysql_query($QueryProyectoComplemento) or die("Error Query complemento $QueryProyectoComplemento".mysql_error());
            $ResProyectoComplemento = mysql_fetch_assoc($ResultadoProyectoComplemento);
            
            if ($ResProyectoComplemento['id_proyecto']==0)//factura no tiene proyecto
            {
                $QueryProyectoCom = "SELECT ep.nombre AS estatus,date_format(f.fecha_emision,'%Y-%m-%d') as emision,f.no_factura,c.nombre as cliente,f.concepto,a.nombre as area,f.monto,f.iva,f.total,ep.nombre as estatus,date_format(f.fecha_pago,'%Y-%m-%d') AS pago from facturacion f join clientes c on f.id_cliente=c.id join areas a on f.id_area=a.id join estatus_pago ep on f.estatus_pago=ep.id where f.id='$Id' order by f.no_factura";
            }
            else//Factura con proyecto
            {
                $QueryProyectoCom = "SELECT ep.nombre AS estatus,date_format(f.fecha_emision,'%Y-%m-%d') as emision,f.no_factura,c.nombre as cliente,f.concepto,a.nombre as area,f.monto,f.iva,f.total,ep.nombre as estatus,date_format(f.fecha_pago,'%Y-%m-%d') AS pago from facturacion f join clientes c on f.id_cliente=c.id join proyectos p on f.id_proyecto=p.id join areas a on p.id_area=a.id join estatus_pago ep on f.estatus_pago=ep.id where f.id='$Id' order by f.no_factura";
            }

            
            $ResultadoComplemento = mysql_query($QueryProyectoCom) or die("Error Query complemento $QueryProyectoCom".mysql_error());
            $ResComplemento = mysql_fetch_assoc($ResultadoComplemento);
            
            //fecha
            $Columna=0; //A
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResComplemento['pago']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            //no factura
            $Columna++; //B
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResComplemento['no_factura']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            //cliente
            $Columna++; //C
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResComplemento['cliente']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);
            
            //concepto
            $Columna++; //D
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResProyectoComplemento['concepto']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            //area
            $Columna++; //E
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResComplemento['area']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            //saldo anterior
            $Columna++; //F
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, 0);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");

            //subtotal
            $Columna++; //G
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, 0);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");

            //iva
            $Columna++; //H
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, 0);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");

            //total
            $Columna++; //I
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, 0);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");

            //saldo
            $Columna++; //J
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, 0);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");

            //estatus
            $Columna++; //K
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResComplemento['estatus']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            //fecha pago
            $Columna++; //L
            $Excel->getActiveSheet()->setCellValueByColumnAndRow($Columna, $Fila, $ResComplemento['pago']);
            $Excel->getActiveSheet()->getStyleByColumnAndRow($Columna,$Fila)->applyFromArray($body);

            $Fila++;
        }
    /**----------------------------------------------------------------------------------------------------------------- */

    /**-------------------------------------totales ---------------------------------------- */
        $Excel->getActiveSheet()->setCellValueByColumnAndRow(5, $Fila, $SaldoAnteriorGeneral);
        $Excel->getActiveSheet()->getStyleByColumnAndRow(5,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");
        $Excel->getActiveSheet()->setCellValueByColumnAndRow(6, $Fila, $SubTotalGeneral);
        $Excel->getActiveSheet()->getStyleByColumnAndRow(6,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");
        $Excel->getActiveSheet()->setCellValueByColumnAndRow(7, $Fila, $IvaGeneral);
        $Excel->getActiveSheet()->getStyleByColumnAndRow(7,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");
        $Excel->getActiveSheet()->setCellValueByColumnAndRow(8, $Fila, $TotalGeneral);
        $Excel->getActiveSheet()->getStyleByColumnAndRow(8,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");
        $Excel->getActiveSheet()->setCellValueByColumnAndRow(8, $Fila, $SaldoTotalGeneral);
        $Excel->getActiveSheet()->getStyleByColumnAndRow(8,$Fila)->applyFromArray($body)->getNumberFormat()->setFormatCode("$#.##0,00");
    /**------------------------------------------------------------------------------------- */

    // Redirect output to a client’s web browser (Excel2007)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Reporte Facturas.xlsx"');
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