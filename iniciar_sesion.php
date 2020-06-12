<?php
header("Content-Type: text/html;charset=ISO 8859-1");    
session_start();
?>
 
<?php require_once("php/conexion.php"); ?>
<?php // include("includes/consulta.php"); ?>
 
<?php
 //print_r($filas);
if(isset($_SESSION["session_username"]) && $_SESSION["session_username"]!= ""){
 //echo "Session is set"; // for testing purposes
	header("Location: datos_acta.php");
}
 
if(!empty($_POST['usuario']) && !empty($_POST['pass'])) {
 $username=$_POST['usuario'];
 $clave=$_POST['pass'];
 $co = new conector();

//$numrows=mysql_num_rows($query);
$numrows = $co->numreg($username, $clave); 
 if($numrows!=0)
{
// while($row=mysql_fetch_assoc($query))
 //{
 //$dbclave=$co->getClave();
 //}
 

if($co->acceso())
{
 
 $_SESSION['session_username']= $username;
 $_SESSION['nombre_usuario'] = $co->getDatos()['nombre'];
 $_SESSION['apellido_usuario'] = $co->getDatos()['apellido'];
 
/* Redirect browser */
 header('Location: crear_do.php');
 }
 } else {
 
$message = 'Nombre de usuario ó contraseña invalida!';
 }
 
} else {
 $message = 'Todos los campos son requeridos!';
}

?>