<?
include "coneccion.php";
$querygasto="SELECT concepto,subtotal FROM gastos";
$resgasto = mysql_query($querygasto) or die("Error: querygasto, file:gastos.php: $querygasto" . mysql_error());
while($res = mysql_fetch_assoc($resgasto)){
$dato.="{
            name: '{$res['concepto']}',
            y: {$res['subtotal']}
        },";
}
$dato=trim($dato,',');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>grafica</title>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script>
// Build the chart
$(function () { 
Highcharts.chart('container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Browser market shares January, 2015 to May, 2015'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [<? echo $dato;?>]
    }]
});
});
</script>
</head>

<body>

<div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto;">
</div>

</body>
</html>
