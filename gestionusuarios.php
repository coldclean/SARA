<?php
//error_reporting(E_ALL);
session_start();
date_default_timezone_set('America/Bogota');
require_once("php/conexion.php");
?>
<html>
<head>
        <!-- <link rel="stylesheet" type="text/css" href="css/Mint-1.4.3/build/css-mint.css"> -->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script src="https://code.jquery.com/jquery-2.0.2.js" integrity="sha256-0u0HIBCKddsNUySLqONjMmWAZMQYlxTRbA8RfvtCAW0=" crossorigin="anonymous"></script>
        <link href="css/estilo_basico.css" rel="stylesheet">
        <link href="css/uploadfile.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="js/jquery.uploadfile.min.js"></script>
        <title>SARA</title>
        <br><br>
        <h2 align="center" class="blanco">Gestion de Usuarios</h2>
        <script type="text/javascript">
        $(document).ready(function(){
                $("#crear").hide();
                $("#borrar").hide();
                $("#crear_admin").click(function(){
                  $("#crear").show();

                });
                $("#guardar").click(function(){
                  var formData = new FormData($(".datos_admin")[0]);
                  $.ajax({
                    url: "administrador.php",
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        alert(data);
                        alert("El usuario es ahora administrador");
                        $("#crear").hide();
                    },
            
                });
        });
        });
        </script>

</head>
<body>
<div>
<input type="button" name="crear_admin" id="crear_admin" value="Crear Administrador" />
<input type="button" name="borrar_usuario" id="borrar_usuario" value="Borrar Usuario" />
</div>
<div id="crear">
<form id="datos_admin" name="datos_admin" method="post" enctype="multipart/form-data">
        Indique el Usuario que desea establecer como administrador<br /> 
   <select name="administrador" id="administrador"> 
      
     <?php
          //creacion datalist por base de datis
          $co = new conector();
          $us = $co->getUsuarios();
          foreach ($us as $usuario) {
                echo $usuario['usuario'];
                unset($usu);
                $usu= $usuario['usuario'];
                //echo '<option value=""></option>';
                echo '<option value="'.$usu.'">'.$usu.'</option>';
          }  
          ?>
  </select>
 <input type="button" name="guardar" id="guardar" value="Guardar" />


</form>

</body>
</html>