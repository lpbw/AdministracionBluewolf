<?php

//include "checar_sesion_admin.php";
include "coneccion.php";
$id=$_POST['idc'];
echo "<script>alert('id'+$id)</script>";


    $query = "DELETE FROM participante_proyectos WHERE id = $id";
    $result = mysql_query($query) or print("<script>alert('Error al eliminar');</script>");
	
	

?>
<script>
    window.location = '<? echo $_SERVER['HTTP_REFERER'];?>';
</script>
