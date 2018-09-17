<?php
    include "coneccion.php";
    $Idproveedor=$_GET['idp'];
    $query = "DELETE FROM listaproveedores WHERE id_lista = $Idproveedor";
    $result = mysql_query($query) or print("<script>alert('Error al eliminar');</script>");
	
	

?>
<script>
    window.location = '<? echo $_SERVER['HTTP_REFERER'];?>';
</script>