<?php
    // recibe las fechas
    $desde = $_POST['desde'];
    $hasta = $_POST['hasta'];

    //Consulta a las tablas cobros, proyectos, clilentes.
    $consulta  = "SELECT date_format(c.fecha,'%Y/%m/%d') as fecha,";
    $consulta .= "c.id as idcobro,";
    $consulta .= "p.id as idp,";
    $consulta .= "p.nombre as proyecto,";
    $consulta .= "cl.id as idcl,";
    $consulta .= "cl.nombre as cliente,";
    $consulta .= "c.concepto,";
    $consulta .= "c.monto,";
    $consulta .= "cl.rfc,";
    $consulta .= "c.seguro";
    $consulta .= " FROM cobros c";
    $consulta .= " JOIN proyectos p ON c.id_proyecto=p.id"; 
    $consulta .= " JOIN clientes cl ON p.id_cliente=cl.id";
    $consulta .= " where c.id_estatus_cobro=1";
    $consulta .= " AND c.fecha>='$desde 00:00:00'";
    $consulta .= " AND c.fecha<='$hasta 00:00:00'";
    
    $resultado = mysql_query($consulta) or die("La consulta: $consulta" . mysql_error());
?>