<?php

//include "checar_sesion_admin.php";
include "coneccion.php";




    $query = "DELETE FROM documentos WHERE id = {$_POST['iddoc']}";
    $result = mysql_query($query) or print("<script>alert('Error al eliminar');</script>");
	
	if($_POST['archivo']!=""){
	$archivo="docs/{$_POST['archivo']}";
	unlink($archivo); 
	}
?>
<script>
    window.location = '<? echo $_SERVER['HTTP_REFERER'];?>';
</script>
