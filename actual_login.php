<?
    session_start();
    include "coneccion.php";
    $usuario = $_POST['usuario'];
    $pass = $_POST['password'];
    // entrar en la sesion
    $consulta  = "SELECT * from usuarios where email='$usuario' and password='$pass'";
	$resultado = mysql_query($consulta) or die("La consulta: $consulta" .mysql_error());//. mysql_error()
		
		if(@mysql_num_rows($resultado)>=1)
		{
			$res=mysql_fetch_row($resultado);
			$id=$res[0];
			$nombre=$res[1];
			$tipo=$res[4];

			$_SESSION['idU']=$id;
			$_SESSION['idA']=$tipo;
			$_SESSION['idNombre']=$nombre;
			$_SESSION['usuario']= $usuario;
            $_SESSION['pass']=	$pass;
            echo 1;
			//echo"<script>window.location=\"menu_admin.php\"</script>";
        }
        else
		{
            //echo"<script>alert(\"Usuario o password invalido\");</script>";
           
		}
?>