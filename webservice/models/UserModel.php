<?php

/**
 * UserModel short summary.
 *
 * UserModel description.
 *
 * @version 1.0
 * @author isaac.ojeda
 */
class UserModel
{
   	    public $id_usuarios;
        public $id_sucursal;
        public $id_tipo_usuario;
        public $correo;
        public $password;
        public $nombre;
        public $direccion;
        public $telefono;
        public $id_alta_usuarios;
        public $fecha;
    //public $email;

    function __construct(){
        $this->id_usuarios = -1;
    }
}

?>
