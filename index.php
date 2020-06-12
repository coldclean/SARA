<?php

header("Content-Type: text/html;charset=UTF-8");    
session_start();
date_default_timezone_set('America/Bogota');

require_once("php/conexion.php");

if(isset($_SESSION["session_username"]) && $_SESSION["session_username"]!= ""){

 //echo "Session is set"; // for testing purposes
    header("Location: datos_acta.php");
}
if(isset($_POST['ingresar'])){
    if(!empty($_POST['usuario']) && !empty($_POST['pass'])) {
        $username=$_POST['usuario'];
        $clave=$_POST['pass'];
        $co = new conector();
        $co->b_usuario($username,$clave);

//$numrows=mysql_num_rows($query);
$numrows = $co->numreg(); 
if($numrows!=0){
 
        $_SESSION['session_username']= $username;
        $_SESSION['nombre_usuario'] = $co->getDatosUsuarios()['nombre'];
        $_SESSION['apellido_usuario'] = $co->getDatosUsuarios()['apellido'];
        $_SESSION['idusuario'] = $co->getDatosUsuarios()['idusuario'];
        $_SESSION['nivel'] = $co->getDatosUsuarios()['nivel'];
 
/* Redirect browser */
        header('Location: datos_acta.php');
 } else {
 
$message = 'Nombre de usuario ó contraseña invalida!';
 }
 
} else {
 $message = 'Todos los campos son requeridos!';
}
}
?>
<html>
    <head>
    		<link href="css/estilo_form.css" rel=stylesheet>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script src="https://code.jquery.com/jquery-2.0.2.js" integrity="sha256-0u0HIBCKddsNUySLqONjMmWAZMQYlxTRbA8RfvtCAW0=" crossorigin="anonymous"> </script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <title>Registro de usuarios</title>
        <script type="text/javascript">
        $(document).ready(function() {
        	

        });
        </script>
    </head>
    <body>
        <h2 align="center" class="blanco">Inicio de Sesion</h2>
        <?php if (!empty($message)) { echo "<p align=\"center\" class=\"error\">" . "Error: ". $message . "</p>";} ?>
        <form action="" id="inicio" name="inicio" class="registro" method="post" enctype="multipart/form-data" >
        <div class="tabla">
        	<div class="cuerpo_tabla">
        	 <div class="fila_tabla">
        			<div class="celda_tabla"><label for="usuario">Usuario: </label></div>
        			<div class="celda_tabla"><input type="text" name="usuario" id="usuario" value="" size="15" /></div>
        		</div>
        		 <div class="fila_tabla">
        			<div class="celda_tabla"><label for="pass">Contraseña:</label></div>
        			<div class="celda_tabla"><input type="password" name="pass" id="pass" value="" size=15 /></div>
        		</div>
        	</div>
        			<div class="div_pie">
                    <div>
        		 	<input type="submit" name="ingresar" id="ingresar" value="Ingresar"/> 
        		 	<input type="reset" name="borrar" value="Borrar" />
        			</div>
                    </div>
                 <a href="registrar.php">Registrar Usuarios</a>
        	</div>
        	
        </form>
    </body>

