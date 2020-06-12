<?php
date_default_timezone_set('America/Bogota');
//librerias para manipulacion excel
require_once 'php/conexion.php';
$con = new conector();
$usuario = strtoupper($_POST['usuario']);
$pass = $_POST['pass'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$cedula = $_POST['cedula'];
$cargo = $_POST['cargo'];
//if($con->usuarioexiste($usuario)){
if ($con->usuarioexiste($usuario)==0){
	$respuesta=$con->grabar_usuario($usuario,$cedula,$nombre,$apellido,$cargo,$pass);	
}else{
	$respuesta = "existe";
}
	//}
//$respuesta=$con->grabar_usuario($usuario,$cedula,$nombre,$apellido,$cargo,$pass);
echo $respuesta;
?>