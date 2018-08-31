<?php
$flag=0;
$Body=$_POST['correo'];//recibe el cuerpo del correo
$f1=$_POST['f1'];//recibe las fechas de la busqueda en scrap
$f2=$_POST['f2'];//recibe las fechas de la busqueda en scrap
$subject=$_POST['subject'];//recibe el motivo
$par=$_POST['para'];//recibe los correos
$url=$_POST['url'];//recibe url
$pa=explode(",",$par);//separa los correos
$ir=$_POST['ir'];
if($subject=="Nueva Captura-Metodos"){
$parent=1;
}
if($subject=="No Conformidad"){
$parent=1;
}


foreach($pa as $p){//recorre todos los correos
$EmailFrom = "Bombardier.Notificaciones@gmail.com";
$para="perezluis197@gmail.com";//aqui va $p para enviar a cada correo
mail("$p", "$subject", $Body, "From: Bombardier <$EmailFrom>\nContent-type: text/html; charset=utf-8\n");
$flag=1;
}

if($flag==1){
?>
<style>
body{
background-image:url(enviando.gif);
background-repeat:no-repeat;
background-attachment:fixed;
background-position:center;
background-color: #d7d7df;
}
</style>
<body>
<form name="en" id="en" action="<? echo $url;?>" method="post">
<input type="hidden" name="f1" id="f1"  value="<? echo $f1;?>"/>
<input type="hidden" name="f2" id="f2"  value="<? echo $f2;?>"/>
<input type="hidden" name="parent" id="parent"  value="<? echo $parent;?>"/>
<input type="hidden" name="ir" id="ir"  value="<? echo $ir;?>"/>
</form>
<script>document.en.submit();</script>
</body>

<?
}
?>
