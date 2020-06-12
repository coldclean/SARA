<?php
//error_reporting(E_ALL);
session_start();
date_default_timezone_set('America/Bogota');
?>

<html>
<?php 
if ($_SESSION['nivel'] == "ADMINISTRADOR"){
  echo "<div name='menu' id='menu'><a href='gestionusuarios.php'>Gestion Usuarios</a></div>"; 
}
echo "<div name='sesion' id='sesion'>[".strtoupper($_SESSION['nombre_usuario'])." ".strtoupper($_SESSION['apellido_usuario'])."] <a href='cerrar.php'>cerrar sesion</a></div>"; ?>
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
        <h2 align="center" class="blanco">Sistema Automatizado de Reconocimiento Aduanero</h2>

        <script type="text/javascript">

          $(document).ready(function(){
            $("#fotos").hide();
            $("#respuesta_foto").hide();
            $("#respuesta_acta").hide();
            $("#padre").hide();
            $("#reiniciar").hide();
            $("#generar").hide();
            //$("#procesar").hide();
            $("#reiniciar").click(function(){
              window.location='datos_acta.php';
            });
             $("#imagen").change(function(){
              $("#respuesta_foto").hide();
            });

            $("#procesar").click(function(){
              $("#do_oculto").val($("#do").val());
              $("#form_foto input").each(function(){
                if($(this).val() == ""){
                  alert("todos los campos deben ser llenados");
                  $(this).focus();
                  alert($(this).attr("id"));
                  exit;
                }
              });

              var formData = new FormData($(".form_foto")[0]);
              $.ajax({
                url: "analizar_foto.php",
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                  alert("La foto fue analizada")
                  $("#respuesta_foto").html("<p>" + data + "</p>");
                  $("#respuesta_foto").show("fast");
                  $("#padre").show("slow");
                  //$("generar").show("slow");

            },
            
        });
    });
    $("#crear_do").click(function(){
      $("#form_do input").each(function(){
        if($(this).val() == ""){
          alert("Todos los campos deben ser llenados");
          $(this).focus();
          exit;
        }
      });
        $("#datos_acta").hide();
        $("#fotos").show();
    });

  $("#registro input").each(function(){
              if($(this).val() == ""){
                alert("todos los campos deben ser llenados");
                $(this).focus();
                exit;
              }
            });

    $("#generar").click(function(){
      $('#codigo').prop('disabled',false);
      $('#direccion').prop('disabled', false);

        var formu2 = new FormData($(".form_do")[0]);
        $.ajax({
            url: "generar_acta.php",
            type: "POST",
            data: formu2,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data){
                $("#fotos").hide();
                $("#respuesta_acta").show();
                $("#respuesta_acta").html("<p>" + data +"</p>");
                $("#guardar_foto").hide();
                $("#reiniciar").show();
                $('#generar').hide();
            },
        });

    });
    $("#guardar_foto").click(function(){
      $("#descripcion_corregida").val($("#descri").val());
      $("#do_oculto").val($("#do").val());
              var formData = new FormData($(".form_foto")[0]);
              $.ajax({
                url: "guardar_foto.php",
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                  alert("La foto para el DO: " + $("#do_oculto").val() + " fue guardada");
                  $("#respuesta_foto").html("<p>" + data + "</p>");
                  $("#respuesta_foto").show("fast");
                  $("#generar").show("slow");
                  $("#padre").hide("slow");
                  $("#reiniciar").show();
            },
        });

      //$("#descri").val($("#respuesta_foto").text());
    });
    $("#marca_bool").change(function(){
      if($("#marca_bool").is(':checked')){
        $("#marca_texto").val("Sin Marca");
        $("#marca_texto").attr("disabled","disabled");
      }else{
        $("#marca_texto").val("");
        $("#marca_texto").removeAttr("disabled");
      }

    });
   $('#deposito').on("focusout", function(e){
    var self = $(this);
    if($(this).val() == ""){
      //alert("Debe indicar el deposito");
    }else{
      var depo = $('#deposito').val();
      $.ajax({
                url: "depositos.php",
                type: 'POST',
                data: {"deposito" : depo},
                dataType: 'json',
                cache: false,
                success: function (data) {
                  if(!data){
                    self.val("");
                    setTimeout(function() {self.focus();},50);
                    alert("El deposito ingresado no existe, intente de nuevo");
                  }else{
                  
                   $('#direccion').val(data['direccion']);
                    $('#codigo').val(data['codigo']);
                }

                 
            },
        });
    }
     

});


    
});

</script>
</head>

<body>
    
    <div id="datos_acta" name="datos_acta" class="formulario">
    <div class="cabecera">Datos generales del acta: </div>
      <form id="form_do" name="form_do" class="form_do" method="post" enctype="multipart/form-data" >
        <p>
          <div>
          <label for="dotrans">Documento de Transporte:</label>
          <input type="text" name="dotrans" id="dotrans" value="" size="8" />
          </div>
          <div>
          <label for="do">D.O:</label>
          <input type="text" name="do" id="do" value="" size="8" />
          </div>
          <div>
          <label for="manifiesto">Manifiesto:</label>
          <input type="text" name="manifiesto" id="manifiesto" value="" size="13"/>
          </div>
          <div>
          <label for="fecha_manifiesto">Fecha Manifiesto:</label>
          <input type="date" name="fecha_manifiesto" id="fecha_manifiesto" value="" size="13"/>
          </div>
          <div>
          <label for="deposito">Deposito:</label>
          <input type="text" list=depolist name="deposito" id="deposito" size="15" />
<datalist id=depolist>
  <option value="AINTERCARGA">
  <option value="CONSIMEX">
  <option value="DAPSA">
  <option value="DHL GLOBAL">
  <option value="ROLDAN">
  <option value="REPREMUNDO">
  <option value="REPREMUNDO 1">
  <option value="SNIDER">
  <option value="TRANSAEREO">
  <option value="ZONA FRANCA">
</datalist>
          </div>
          <div>
          <label for="codigo">Codígo</label>
          <input type="text" name="codigo" id="codigo" value="" size="5" disabled />
          </div>
          <div>
          <label for="direccion">Dirección Deposito</label>
          <input type="text" name="direccion" id="direccion" value="" size="20" disabled />
          </div>
          <div>
          <label for="bultos">No. Bultos</label>
          <input type="text" name="bultos" id="bultos" size="3" />
          </div>
          <div>
          <label for="peso">Peso</label>
          <input type="text" name="peso" id="peso" value="" size="3"/>
          </div>
          <div>
          <lbabel for="emp_transportadora"> Empresa Transportadora</lbabel>
          <input type="text" name="emp_transportadora" id="emp_transportadora" / >
          </div>

          <div>
          <label for="consignatario">Consignatario</label>
          <input type="text" name="consignatario" id="consignatario" value="" size="10" />
          </div>
          <div>
          <div>Hora: <label for="inicio">Inicio:</label><input type="time" name="inicio" id="inicio" value="" size="1" /> <label for="final">Final:</label><input type="time" name="final" id="final" value="" size="1"/></div>
          </div>
          <input type="button" name="crear_do" id="crear_do" value="Iniciar" /> 
        </p>
      </form>
 </div>

<div name="fotos" id="fotos" class="formulario">
<div class="cabecera">Datos foto:</div>
<form id="form_foto" name="form_foto" class="form_foto" method="post" enctype="multipart/form-data" >
<p>
  
    <input type="text" name="do_oculto" id="do_oculto" value="algo" hidden />

    <input type="text" name="descripcion_corregida" id="descripcion_corregida" value="algo" hidden />
    <label for="item_num">Item No.</label>
    <input type="text" name="item_num" id="item_num" value="" size="1"/>
    <label for="imagen">Seleccione la imagen</label>
    <input type="file" name="archivo" id="imagen" accept=".jpg, .jpeg, .png" />
    <label for="cant_ite">Cantidad</label>
    <input type="text" name="cant_ite" value="" size="1"/>
    <label for="marca_bool">Marca:</label>
    <input type="checkbox" name="marca_bool" id="marca_bool"/><input type="text" name="marca_texto" id="marca_texto" />
    <input type="button" name="procesar" id="procesar" value="Procesar" /> 
<!--     <button>Enviar</button>
 -->
 </p>
</div>
 <hr>

<div id="padre" name="padre" class="padre" > 
<input type="button" name="guardar_foto" id="guardar_foto" value="Guardar Foto" />
</div>


<div id="respuesta_foto" name="respuesta_foto" style="color : black">
    <br>
    <br>
    <hr>
</div> 

<div id="respuesta_acta" name="respuesta_acta" style="color : black">

<hr>
    
</div> 
<div>
   <input type="button" name="generar" id="generar" value="Generar Acta" />
   <input type="button" name="reiniciar" id="reiniciar" value="Nuevo DO" />
   </form>
   </div>
</body>
</html>