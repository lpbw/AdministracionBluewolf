<?php
session_start();
include "coneccion.php";
include "checar_sesion.php";
include "checar_sesion_admin.php";
$idU=$_SESSION['idU'];
$nombreU=$_SESSION['nombreU'];
$tipoU=$_SESSION['tipoU'];

setlocale(LC_TIME, 'spanish');  
$fecha=mb_convert_encoding (strftime("%A %d de %B del %Y"), 'utf-8');

$hora=date("h:i A");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bombardier Mantenimiento</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #D7D7DF;
}
-->
</style>
<link href="images/textos.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
<link rel="stylesheet" href="colorbox.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="colorbox/jquery.colorbox-min.js"></script>
<script type="text/javascript">

	$(document).ready(function(){

		$(".iframe").colorbox({iframe:true,width:"550", height:"550",transition:"fade", scrolling:true, opacity:0.7});

		$(".iframe2").colorbox({iframe:true,width:"1200", height:"650",transition:"fade", scrolling:true, opacity:0.7});

		$("#click").click(function(){ 

			$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");



			return false;

		});

	});

<!--

function cerrarV(){

		$.fn.colorbox.close();

	}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function borrar(id){
        if(confirm('Desea eliminar esta Maquina?')){
            var elem = document.createElement('input');
            elem.name='id';
            elem.value = id;
            elem.type = 'hidden';
            $("#form1").append(elem);

            $("#form1").attr('action','elimina_maquina.php');
            $("#form1").submit();
        }
    }
//-->
</script>
</head>

<body onload="MM_preloadImages('images/b_cancelar_r.png','images/b_surtir_r.png')">
<form id="form1" name="form1" method="post" action="">
<table width="1024" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td background="images/fondo.jpg"><table width="1024" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="3"><img src="images/spacer.gif" width="10" height="20" /></td>
            </tr>
          <tr>
            <td width="235"><img src="images/logotipo.png" width="235" height="50" /></td>
            <td width="511">&nbsp;</td>
            <td width="234" valign="top"><div align="right" class="texto_reloj"><span class="texto_fecha"><?php echo $fecha?></span><br /><?php echo $hora?></div></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><img src="images/spacer.gif" width="10" height="40" /></td>
      </tr>
      <tr>
        <td><table width="396" height="36" align="left" background="images/tit_general.jpg">
  <tr>
    <td class="texto_reportes_tit">&ensp;&ensp;Maquinas</td>
  </tr>
</table>
<table width="100" align="right" height="36">
  <tr>
  	<!--<td class="texto_reportes_tit2" align="center"><a href="horno.php"><img src="images/refresh.png" width="30" border="0"></a></td>-->
    <td class="texto_reportes_grande" align="center"><div align="right"><a href="menu_maquinas.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image41','','images/b_home_r.png',1)"><img src="images/b_home.png" name="Image41" width="37" height="33" border="0" id="Image41" /></a></div></td>
  </tr>
</table>
</td>
      </tr>
      <tr>
        <td><table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td><img src="images/spacer.gif" width="10" height="70" /></td>
          </tr>
          <tr>
            <td bgcolor="#e5e6e9"><table width="100%" border="0" cellspacing="0" cellpadding="3">
              <tr>
                <td colspan="3"  class="texto_reportes_tit" align="center">&nbsp;</td>
              </tr>
              <tr>
               <td bgcolor="#CCCCCC"class="texto_reportes_tit">&nbsp;</td>
                <td bgcolor="#CCCCCC" align="center" class="texto_reportes_tit"><a href="update_maquina.php" class="texto_reportes_tit iframe">Nuevo (+)</a></td>
              </tr>
			  <tr>
                <td colspan="7"><div align="center"><img src="images/b_linea.jpg" width="962" height="1" /></div></td>
                </tr>
              <tr>
                <td width="50%" bgcolor="#CCCCCC" class="texto_reportes_tit"><div align="center">Nombre</div></td>
                <td width="50%" bgcolor="#CCCCCC" class="texto_reportes_tit"><div align="center">&nbsp;</div></td>
              </tr>
              <tr>
                <td colspan="7"><div align="center"><img src="images/b_linea.jpg" width="962" height="1" /></div></td>
                </tr>
				<?php
				$query = "SELECT * FROM mante_maquinas order by nombre";
				$result = mysql_query($query) or print(mysql_error());
				while($res = mysql_fetch_assoc($result)){
				?>
              <tr>
                <td class="texto_reportes_info"><div align="center"><a href="update_maquina.php?id=<?php echo $res['id']?>" class="texto_reportes_info iframe"><?php echo $res['nombre']?></a></div></td>
				
                <td><div align="center" class="texto_reportes_info"><a href="javascript:borrar(<? echo $res['id']; ?>);" ><img src="images/b_borrar.png" border="0" title="Eliminar" /></a></div></td>
                
              
             <?php }?>
            </table></td>
          </tr>
          <tr>
            <td><img src="images/spacer.gif" width="10" height="30" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><img src="images/spacer.gif" width="10" height="70" /></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="241" align="center">&nbsp;</td>
            
            </tr>
        </table></td>
      </tr>
      <tr>
        <td><img src="images/spacer.gif" width="10" height="20" /></td>
      </tr>
      <tr>
        <td><div align="center"><img src="images/b_linea.jpg" width="980" height="1" /></div></td>
      </tr>
      <tr>
        <td><table width="356" border="0" align="center" cellpadding="0" cellspacing="5">
          <tr>
            <td width="346" height="24"><div align="center" class="texto_sistema">Mantenimiento 1.0</div></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
