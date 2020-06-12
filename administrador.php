<?php
date_default_timezone_set('America/Bogota');
//librerias para manipulacion excel
require_once 'php/conexion.php';
$con = new conector();
$usuario = strtoupper($_POST['administrador']);
echo $usuario;
//$con->crearAdmin($usuario);

?>