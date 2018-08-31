<?
    session_start();
    // entrar en la sesion
    $_SESSION['usuario']=$_POST['usuario'];
    $_SESSION['pass']=$_POST['password'];
    echo "echo";
?>