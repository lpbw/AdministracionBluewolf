<?php
  include "coneccion.php";

  $pro=$_POST['pro'];//Arreglo con id de proyectos.
  $dest=$_POST['dest'];
  $inicio=$_POST['inicio'];
  $fin=$_POST['fin'];
  $nper=$_POST['nper'];
  $personas=mb_strtoupper($_POST['descrip'],'utf-8');
  $motivo=mb_strtoupper($_POST['motivo'],'utf-8');
  $montos=$_POST['montos'];
  $idviaticos=$_POST['idviaticos'];
  $c=0;
  $idU = $_POST['idu'];

  $queryd="select id from destino where nombre='$dest'";
  $resq=mysql_query($queryd) or die("La consulta: $queryd" . mysql_error());
  $res=mysql_fetch_assoc($resq);
  $iddes=$res['id'];//id del destino


  if($iddes=="")//cuando es nuevo el destino
  {
    $insertdestino="INSERT INTO destino (nombre) value('$dest')";
    $resgasto = mysql_query($insertdestino) or die("Error: insertdestino, file:viaje.php: $insertdestino" . mysql_error());
    $iddes=mysql_insert_id();
  }

  $query="insert into viajes (id_proyecto,fecha_inicio,fecha_fin,id_destino,no_personas,viajeros,anticipo,anticipo_total,fecha_anti,gasto_total,estatus,fecha_peticion,id_usuario,motivo)values(0,'$inicio','$fin','$iddes','$nper','$personas','1','','','','1',now(),'$idU','$motivo')";
  $resquery=mysql_query($query) or die("La consulta: $query" . mysql_error());
  $idviaje=mysql_insert_id();

  foreach($montos as $m)
  {
    $query="insert into anticipos (id_viaje,monto,id_viatico)values('$idviaje','$m','$idviaticos[$c]')";
    $resquery=mysql_query($query) or die("La consulta: $query" . mysql_error());
    $c++;
  }
  // recorre el arreglo con los id de los proyectos luego los guarda en la tabla.
  if($pro!=0)
  {
    foreach($pro as $p)
    {
      $query3="insert into proyectos_viajes (id_viaje,id_proyecto,monto)values('$idviaje','$p',0)";
      $resquery3=mysql_query($query3) or die("La consulta: $query3" . mysql_error());
    }
  }
  else
  {
      $query3="insert into proyectos_viajes (id_viaje,id_proyecto,monto)values('$idviaje','$pro',0)";
      $resquery3=mysql_query($query3) or die("La consulta: $query3" . mysql_error());
  }

  $pro_nombre="";

  if($pro!=0)
  {
    $queryp="SELECT p.nombre FROM proyectos_viajes pv join proyectos p on pv.id_proyecto=p.id WHERE id_viaje=$idviaje";
    $resp=mysql_query($queryp) or die("La consulta: $queryp" . mysql_error());
    while($res=mysql_fetch_assoc($resp))
    {
    $pro_nombre=$pro_nombre." ".$res['nombre'];
    }
  }

$queryu="SELECT * FROM usuarios WHERE id=$idU";
$resuu=mysql_query($queryu) or die("La consulta: $queryu" . mysql_error());
$resu=mysql_fetch_assoc($resuu);
$usuario=$resu['nombre'];

$body="<label>LA SIGUIENTE PERSONA SOLICITO VIATICOS: ".$usuario."</label><br><label>PROYECTO: ".$pro_nombre."</label><br><label>FECHA INICIO: ".$inicio."</label><br><label>FECHA FIN: ".$fin."</label><br><label>DESTINO: ".$dest."</label><br><label>CANTIDAD DE PERSONAS: ".$nper."</label><br><label>VIAJANTES: ".$personas."</label><br><label>MOTIVO: ".$motivo."</label><br>";

$body=$body."<table border=\"1\"><thead><tr><td>MONTO</td><td>CONCEPTO</td></tr></thead><tbody>";
$queryanticipos="SELECT a.monto,v.concepto FROM anticipos a JOIN viaticos v ON a.id_viatico=v.id WHERE id_viaje='$idviaje'";
$resanti=mysql_query($queryanticipos) or die("La consulta: $queryanticipos" . mysql_error());
while($res=mysql_fetch_assoc($resanti))
{
$body=$body."<tr><td>".$res['monto']."</td><td>".$res['concepto']."</td></tr>";
}
$body=$body."</table></tbody>";

  mail("administracion@bluewolf.com.mx", "VIATICOS", $body, "From:<info@bluewolf.com.mx>\nContent-type: text/html; charset=utf-8\n");
  echo "Su viaje se a guardado exitosamente!!!";
?>
