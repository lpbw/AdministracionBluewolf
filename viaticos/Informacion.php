<?php
    session_start();
	include "checar_sesion.php";
	include "checar_sesion_admin.php";
	include "coneccion.php";
	include "SimpleImage.php";
    $idv=$_GET["idv"];
    $valor=$_GET["val"];
    switch ($valor) {
        case 1:
            //Obtiene la informacion del viaje
            $queryviaje="SELECT date_format(v.fecha_inicio,'%Y-%m-%d') AS fecha_inicio,date_format(v.fecha_fin,'%Y-%m-%d') AS fecha_fin,d.nombre,v.no_personas,v.viajeros,v.motivo,date_format(v.fecha_peticion,'%Y-%m-%d') AS fecha_peticion,v.estatus,v.gasto_total,v.fecha_anti,v.anticipo_total, pv.id_proyecto FROM proyectos_viajes pv JOIN viajes v ON pv.id_viaje=v.id JOIN destino d ON v.id_destino=d.id WHERE id_viaje='$idv'";
	        $resvia=mysql_query($queryviaje) or die("La consulta: $queryviaje" . mysql_error());
            $resv=mysql_fetch_assoc($resvia);

            // Recorre los proyectos que tiene el viaje.
            while($respp=mysql_fetch_assoc($resv)){
                $idproyecto=$respp['id_proyecto'];
                $fecha_inicio=$respp['fecha_inicio'];
                $fecha_fin=$respp['fecha_fin'];
                $iddestino=$respp['id_destino'];
                $n_personas=$respp['no_personas'];
                $viajeros=$respp['viajeros'];
                $anticipo_total=$respp['anticipo_total'];
                $fecha_anticipo=$respp['fecha_anti'];
                $gasto_total=$respp['gasto_total'];
                $idestatus=$respp['estatus'];
                $fecha_peticion=$respp['fecha_peticion'];
                $motivo=$respp['motivo'];

                if($idproyecto!=0){
                    $queryproyecto="SELECT id,nombre FROM proyectos WHERE id='$idproyecto'";
                    $respro=mysql_query($queryproyecto) or die("La consulta: $queryproyecto" . mysql_error());
                    $resp=mysql_fetch_assoc($respro);
                    $proyecto=$proyecto.$resp['nombre'].".<br>";
                }
            }
            $Datos->fecha_inicio=$fecha_inicio;
            $Json = json_encode($Datos);
            
        break;
        
        default:
            # code...
        break;
    }
?>