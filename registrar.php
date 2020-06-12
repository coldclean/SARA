<?php
error_reporting(E_ALL);
set_time_limit(0);
date_default_timezone_set('America/Bogota');

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
        	$("#registro").submit(function(e){
        		e.preventDefault();
        	});
        	$("#guardar").click(function(e){
        		$("#registro input").each(function(){
        			if($(this).val() == ""){
        				alert("todos los campos deben ser llenados");
        				$(this).focus();
        				exit;
        			}
        		});
        var formu = new FormData($(".registro")[0]);
        $.ajax({
            url: "registrar_usuario.php",
            type: "POST",
            data: formu,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data){
                alert(data);
                if (data == "1"){
            	alert("el Usuario: " + $("#usuario").val() + " fue registrado será redireccionado" );
            	location.href ="index.php";
            }else{
                alert("El usuario ya existe");
            }
            },
        });

    });
        	

        });
        </script>
    </head>
    <body>
        <h2 align="center" class="blanco">Registro de Usuario</h2>
        <form id="registro" name="registro" class="registro" method="post" enctype="multipart/form-data" >
        <div class="tabla">
        	<div class="cuerpo_tabla">
        	 <div class="fila_tabla">
        			<div class="celda_tabla celda_superior"><label for="usuario">Usuario: </label></div>
        			<div class="celda_tabla celda_superior"><input type="text" name="usuario" id="usuario" value="" size="15" /></div>
        		</div>
        		 <div class="fila_tabla">
        			<div class="celda_tabla"><label for="pass">Contraseña:</label></div>
        			<div class="celda_tabla"><input type="password" name="pass" id="pass" value="" size=15 /></div>
        		</div>
        		 <div class="fila_tabla">
        			<div class="celda_tabla"><label for="confirmar">Confirmar:</label></div>
        			<div class="celda_tabla"><input type="password" name="pass_confir" id="pass_confir" value="" size="15" /></div>
        		</div>
        		<div class="fila_tabla">
        			<div class="celda_tabla"><label for="nommbre">Nombre: </label> </div>
        			<div class="celda_tabla"><input type="text" name="nombre" id="nombre" value="" size=15 pattern="[a-zA-Z]" /></div>
        		</div>
        		<div class="fila_tabla"> 
        			<div class="celda_tabla"><label for="apellido">Apellido: </label></div>
        			<div class="celda_tabla"><input type="text" name="apellido" id="apellido" value="" size=15 /></div>
        		</div>
        		<div class="fila_tabla">
        			<div class="celda_tabla"><label for="cedula">Cédula: </label></div>
        			<div class="celda_tabla"><input type="text" name="cedula" id="cedula" value="" size=15 /></div>
        		</div>
        		 <div class="fila_tabla">
        			<div class="celda_tabla celda_inferior"><label for="cargo">Cargo: </label></div>
        			<div class="celda_tabla celda_inferior"><input type="text" name="cargo" id="cargo" value="" size=15 /></div>
        		</div>
        			</div>
        			<div class="div_pie">
        		 	<input type="submit" name="guardar" id="guardar" value="Guardar"/> 
        		 	<input type="reset" name="borrar" value="Borrar" />
        			</div>
                    <div>
                    <a href="index.php">Regresar</a>
                    </div>
        	</div>

        	
        </form>

    </body>

