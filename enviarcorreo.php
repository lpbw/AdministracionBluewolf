<?php
$flag=0;
$Body=$_POST['correo'];//recibe el cuerpo del correo
$f1=$_POST['f1'];//recibe las fechas de la busqueda en scrap
$f2=$_POST['f2'];//recibe las fechas de la busqueda en scrap
$subject=$_POST['subject'];//recibe el motivo
$par=$_POST['para'];//recibe los correos
$pa=explode(",",$par);//separa los correos
foreach($pa as $p){//recorre todos los correos
$EmailFrom = "info@bluewolf.com.mx";
$para="perezluis197@gmail.com";//aqui va $p para enviar a cada correo
mail("$para", "$subject", $Body, "From: Bombardier <$EmailFrom>\nContent-type: text/html; charset=utf-8\n");
$flag=1;
}

//if($flag==1){
?>
<!--
<form name="en" id="en" action="http://bw-06/qa/reporte_scrap.php" method="post">
<input name="f1" id="f1"  value="<? echo $f1;?>"/>
<input name="f2" id="f2"  value="<? echo $f2;?>"/>
</form>
<script>document.en.submit();</script>-->

