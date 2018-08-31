<?
include "coneccion.php";

function EncontrarMes($month){
  $meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
  $namemonth = $meses[$month];
  return $namemonth;
}

function EncontrarArea($idarea){
  $queryarea = "SELECT id,nombre FROM areas WHERE id=$idarea";
  $resultadoarea = mysql_query($queryarea) or die("Error en consulta area: $queryarea " . mysql_error());
  $resarea = mysql_fetch_assoc($resultadoarea);
  $namearea = $resarea['nombre'];
  $tab1 = "<td>$namearea</td>";
  return $tab1;
}

function EncontrarArea2($idarea){
  $queryarea = "SELECT id,nombre FROM areas WHERE id=$idarea";
  $resultadoarea = mysql_query($queryarea) or die("Error en consulta area: $queryarea " . mysql_error());
  $resarea = mysql_fetch_assoc($resultadoarea);
  $namearea = $resarea['nombre'];
  return $namearea;
}
/*
Calcula el ingreso
estatus_pago 2 = pagado.
*/
function CalculaIngresosMes($year,$month,$idarea){
    $totalmesarea =0;
    $queryfacturas = "SELECT f.id_area,a.nombre,f.monto AS total,YEAR(fecha_pago) AS anio,MONTH(fecha_pago) AS mes FROM facturacion f LEFT JOIN areas a ON f.id_area=a.id WHERE f.estatus_pago=2 AND YEAR(fecha_pago)=$year AND MONTH(fecha_pago)=$month AND f.id_area=$idarea";
    $resultadofacturas = mysql_query($queryfacturas) or die("Error en consulta horario: $queryfacturas " . mysql_error());
    while ($resfac = mysql_fetch_assoc($resultadofacturas)) {
      $totalmesarea = $totalmesarea + $resfac['total'];
      
    }
     
    $totalmes = "<td>".money_format('$%n',$totalmesarea)."</td>";
    
  return $totalmes;
}

function TotalGeneralarea($year,$month,$idarea){

  $queryfacturas = "SELECT f.id_area,a.nombre,f.monto AS total,YEAR(fecha_pago) AS anio,MONTH(fecha_pago) AS mes FROM facturacion f LEFT JOIN areas a ON f.id_area=a.id WHERE f.estatus_pago=2 AND YEAR(fecha_pago)=$year AND MONTH(fecha_pago)=$month AND f.id_area=$idarea";
    $resultadofacturas = mysql_query($queryfacturas) or die("Error en consulta horario: $queryfacturas " . mysql_error());
    while ($resfac = mysql_fetch_assoc($resultadofacturas)) {
      $totalmesarea = $totalmesarea + $resfac['total'];
      
    }
    
  return $totalmesarea;
}

function CalcularTotalIngresos($year,$month){
  $totalareas=0;
  $queryfacturas = "SELECT f.id_area,a.nombre,f.monto AS total,YEAR(fecha_pago) AS anio,MONTH(fecha_pago) AS mes FROM facturacion f LEFT JOIN areas a ON f.id_area=a.id WHERE f.estatus_pago=2 AND YEAR(fecha_pago)=$year AND MONTH(fecha_pago)=$month AND f.id_area>=1 AND f.id_area<=7";
    $resultadofacturas = mysql_query($queryfacturas) or die("Error en consulta totalareas: $queryfacturas " . mysql_error());
    while ($resfac = mysql_fetch_assoc($resultadofacturas)) {
      $totalareas = $totalareas + $resfac['total']; 
    }
    
  return $totalareas;
}


/*
Calcula el ingreso del mes para detalle de ingresos.
estatus_pago 2 = pagado.
*/
function CalculaIngresosDetalleMes($year,$month,$idarea){
  $totalmes = "";
  $queryfacturas = "SELECT a.nombre AS area,DATE_FORMAT(f.fecha_emision,'%Y-%m-%d') AS emision,f.no_factura AS factura,c.nombre AS cliente,f.concepto,f.monto, DATE_FORMAT(f.fecha_pago,'%Y-%m-%d') AS pago,ep.nombre AS estatus,f.tipo FROM facturacion f LEFT JOIN areas a ON f.id_area=a.id JOIN clientes c ON f.id_cliente=c.id JOIN estatus_pago ep ON f.estatus_pago=ep.id WHERE f.estatus_pago=2 AND YEAR(fecha_pago)=$year AND MONTH(fecha_pago)=$month AND f.id_area=$idarea";
  $resultadofacturas = mysql_query($queryfacturas) or die("Error en consulta horario: $queryfacturas " . mysql_error());
  while ($resfac = mysql_fetch_assoc($resultadofacturas)) {
    $tipo = $resfac['tipo'];
    $area = $resfac['area'];
    $emision = $resfac['emision'];
    $factura = $resfac['factura'];
    $cliente = $resfac['cliente'];
    $concepto = $resfac['concepto'];
    $total = $resfac['monto'];
    $pago = $resfac['pago'];
    $estatus = $resfac['estatus'];
    switch ($tipo) {
      case 1:
          $t = "Viáticos";
          break;
      case 2:
          $t = "Favores";
          break;
      case 3:
          $t = "Normal";
          break;
      default:
          $t = "Sin tipo";
          break;
    }
    $totalmes .= "<tr><td>".$area."</td><td>".$emision."</td><td>".$factura."</td><td>".$cliente."</td><td>".$concepto."</td><td>".$total."</td><td>".$pago."</td><td>".$estatus."</td><td>".$t."</td></tr>";
    
  }
   
  
  return $totalmes;
}


function CalculartotalDetalleMes($year,$month,$idarea){
  $total = 0;
  $queryfacturas = "SELECT a.nombre AS area,DATE_FORMAT(f.fecha_emision,'%Y-%m-%d') AS emision,f.no_factura AS factura,c.nombre AS cliente,f.concepto,f.monto, DATE_FORMAT(f.fecha_pago,'%Y-%m-%d') AS pago,ep.nombre AS estatus,f.tipo FROM facturacion f LEFT JOIN areas a ON f.id_area=a.id JOIN clientes c ON f.id_cliente=c.id JOIN estatus_pago ep ON f.estatus_pago=ep.id WHERE f.estatus_pago=2 AND YEAR(fecha_pago)=$year AND MONTH(fecha_pago)=$month AND f.id_area=$idarea";
  $resultadofacturas = mysql_query($queryfacturas) or die("Error en consulta horario: $queryfacturas " . mysql_error());
  while ($resfac = mysql_fetch_assoc($resultadofacturas)) {
    $total = $total + $resfac['monto'];
    
  }
   
  
  return $total;
}


/*funciones para  reportes egresos */

function CalculaIngresosMesGasto($year,$month,$idarea){
  $totalmesarea =0;
  $queryfacturas = "SELECT g.id_area,g.subtotal, DATE_FORMAT(g.fecha,'%Y-%m-%d') AS fecha FROM gastos g WHERE MONTH(g.fecha)=$month AND YEAR(g.fecha)=$year AND g.id_area=$idarea";
  $resultadofacturas = mysql_query($queryfacturas) or die("Error en consulta horario: $queryfacturas " . mysql_error());
  while ($resfac = mysql_fetch_assoc($resultadofacturas)) {
    $totalmesarea = $totalmesarea + $resfac['subtotal'];
    
  }
   
  $totalmes = "<td>".money_format('$%n',$totalmesarea)."</td>";
  
return $totalmes;
}
//exportar
function CalculaIngresosMesGasto2($year,$month,$idarea){
  $totalmesarea =0;
  $queryfacturas = "SELECT g.id_area,g.subtotal, DATE_FORMAT(g.fecha,'%Y-%m-%d') AS fecha FROM gastos g WHERE MONTH(g.fecha)=$month AND YEAR(g.fecha)=$year AND g.id_area=$idarea";
  $resultadofacturas = mysql_query($queryfacturas) or die("Error en consulta horario: $queryfacturas " . mysql_error());
  while ($resfac = mysql_fetch_assoc($resultadofacturas)) {
    $totalmesarea = $totalmesarea + $resfac['subtotal'];
    
  }
   
  $totalmes2 = $totalmesarea;
  
return $totalmes2;
}

function TotalGeneralareaGasto($year,$month,$idarea){

  $queryfacturas = "SELECT g.id_area,g.subtotal, DATE_FORMAT(g.fecha,'%Y-%m-%d') AS fecha FROM gastos g WHERE MONTH(g.fecha)=$month AND YEAR(g.fecha)=$year AND g.id_area=$idarea";
    $resultadofacturas = mysql_query($queryfacturas) or die("Error en consulta horario: $queryfacturas " . mysql_error());
    while ($resfac = mysql_fetch_assoc($resultadofacturas)) {
      $totalmesarea = $totalmesarea + $resfac['subtotal'];
      
    }
    
  return $totalmesarea;
}

function CalcularTotalIngresosGasto($year,$month){
  $totalareas=0;
  $queryfacturas = "SELECT g.id_area,g.subtotal, DATE_FORMAT(g.fecha,'%Y-%m-%d') AS fecha FROM gastos g WHERE MONTH(g.fecha)=$month AND YEAR(g.fecha)=$year AND g.id_area>=1 AND g.id_area<=7";
    $resultadofacturas = mysql_query($queryfacturas) or die("Error en consulta totalareas: $queryfacturasgastos " . mysql_error());
    while ($resfac = mysql_fetch_assoc($resultadofacturas)) {
      $totalareas = $totalareas + $resfac['subtotal']; 
    }
    
  return $totalareas;
}
/*fin funciones reportes egresos */
?>
