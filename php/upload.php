<?php
header("Content-Type: text/html;charset=ISO 8859-1");

$output_dir = "../reportes/";
if(isset($_FILES["myfile"]))
{
	$ret = array();
	
//	This is for custom errors;	
/*	$custom_error= array();
	$custom_error['jquery-upload-file-error']="File already exists";
	echo json_encode($custom_error);
	die();
*/
	$error =$_FILES["myfile"]["error"];
	//You need to handle  both cases
	//If Any browser does not support serializing of multiple files using FormData() 
	if(!is_array($_FILES["myfile"]["name"])) //single file
	{
 	 	$fileName = $_FILES["myfile"]["name"];
 		move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName);
    	$ret[]= $fileName;
	}
	else  //Multiple files, file[]
	{
	  $fileCount = count($_FILES["myfile"]["name"]);
	  for($i=0; $i < $fileCount; $i++)
	  {
	  	$fileName = $_FILES["myfile"]["name"][$i];
		move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName);
	  	$ret[]= $fileName;
	  }
	
	}

class grabado_datos{
	var $sBD ='localhost';
	var $nBD = 'datos_ge';
	var $uBD = 'root';
	var $cBD = '';
	var $conexion;
	var $paquete;
	
	function __construct(){

		
	}
}
$obj = new grabado_datos();
if($obj->conexion = mysqli_connect($obj->sBD,$obj->uBD,$obj->cBD,$obj->nBD)){
	$f = fopen($output_dir.$fileName, "r");
	$cont = 0;
	while(!feof($f)){ 
  $data = explode("\t", fgets($f));


			$GUIA = $data[0];
			

			$FECHA_GUIA =  ($data[1] != " ") ? date("Y-m-d",strtotime($data[1])) : $data[1];
			$PEDIDO = $data[2];
			$DO_IMP = $data[3];
			$DO_SUF = $data[4];
			$AUXILIAR_TRAMITADOR = $data[5];
			$TIPO_TRAMITE = $data[6];
			$MANIFIESTO_FMM = $data[7];
			$FECHA_MANIFIESTO_FMM = ($data[8] != " ") ? date("Y-m-d", strtotime( $data[8])) : $data[8];
			$HORA_MANIFIESTO_FMM = date("H:i:s",strtotime($data[9]));
			//echo "<br> Hora: ". $HORA_MANIFIESTO_FMM ."<br>";
			$LIBERACION = ($data[10] != " ") ? date("Y-m-d", strtotime($data[10])) : $data[10];
			$LEVANTE =  ($data[11] != " ") ? date("Y-m-d", strtotime($data[11])) : $data[11];
			$HORA_LEVANTE = date("H:i:s",strtotime($data[12]));
			$OBSERVACIONES = $data[13];
			$FECHA_SOLICITUD_CLASIFICACION = ($data[14] != " ") ? date("Y-m-d", strtotime($data[14])) : $data[14];
			$HORA_SOLICITUD_CLASIFICACION = date("H:i:s", strtotime($data[15]));
			$FECHA_RESPUESTA_CLASIFICACION = ($data[16] != " ") ? date("Y-m-d", strtotime($data[16])) : $data[16];
			$HORA_RESPUESTA_CLASIFICACION = date("H:i:s", strtotime($data[17]));
			$FECHA_ASIGNACION_A_DIGITACION = ($data[18] != " ") ? date("Y-m-d", strtotime($data[18])) : $data[18];
			$HORA_ASIGNACION_A_DIGITACION = date("H:i:s", strtotime($data[19]));
			$ENTRE_RYA = ($data[20] != " ") ? date("Y-m-d", strtotime($data[20])) : $data[20];
			$HORA_ENTRE_RYA = date("H:i:s",strtotime($data[21]));
			$REVISION = ($data[22] != " ") ? date("Y-m-d", strtotime($data[22])) : $data[22];
			$HORA_REVISION = date("H:i:s", strtotime($data[23]));
			$ACEPTADO = ($data[24] != " ") ? date("Y-m-d", strtotime($data[24])) : $data[24];
			$HORA_ACEPTADO = date("H:i:s", strtotime($data[25])); 

//"INSERT INTO $tabla_db1 (nombre,email,fecha) VALUES ('$nombre','$email','$fecha')";   
//mysql_query($_GRABAR_SQL);  
if($cont > 0){
	echo "<br> Contador: " . $cont . "Guia: ". $GUIA . "<br> ";
			$sql="SELECT guia_ID, DO_IMP FROM guia WHERE DO_IMP = '$DO_IMP' AND DO_SUF = '$DO_SUF'";
			$resultado = mysqli_query($obj->conexion,$sql);
	
			if(mysqli_num_rows($resultado)>0){
				$fila = mysqli_fetch_array($resultado);
				$guia_id = $fila['guia_ID'];

				$sql="UPDATE `guia` SET `GUIA` = '$GUIA', `FECHA_GUIA` = '$FECHA_GUIA', `PEDIDO` = '$PEDIDO', `DO_IMP` = '$DO_IMP', `DO_SUF` = '$DO_SUF', `AUXILIAR_TRAMITADOR` = '$AUXILIAR_TRAMITADOR' , `TIPO_TRAMITE` = '$TIPO_TRAMITE', `MANIFIESTO_FMM` = '$MANIFIESTO_FMM' , `FECHA_MANIFIESTO_FMM` = '$FECHA_MANIFIESTO_FMM', `HORA_MANIFIESTO_FMM` = '$HORA_MANIFIESTO_FMM', `LIBERACION` = '$LIBERACION' , `LEVANTE` = '$LEVANTE' , `HORA_LEVANTE` = '$HORA_LEVANTE', `OBSERVACIONES` = '$OBSERVACIONES' , `FECHA_SOLICITUD_CLASIFICACION` = '$FECHA_SOLICITUD_CLASIFICACION', `HORA_SOLICITUD_CLASIFICACION` = '$HORA_SOLICITUD_CLASIFICACION', `FECHA_RESPUESTA_CLASIFICACION` = '$FECHA_RESPUESTA_CLASIFICACION', `HORA_RESPUESTA_CLASIFICACION` = '$HORA_RESPUESTA_CLASIFICACION' , `FECHA_ASIGNACION_A_DIGITACION` = '$FECHA_ASIGNACION_A_DIGITACION', `HORA_ASIGNACION_A_DIGITACION` = '$HORA_ASIGNACION_A_DIGITACION', `ENTRE_RYA` = '$ENTRE_RYA' , `HORA_ENTRE_RYA` = '$HORA_ENTRE_RYA' , `REVISION` = '$REVISION', `HORA_REVISION` = '$HORA_REVISION', `ACEPTADO` = '$ACEPTADO', `HORA_ACEPTADO` = '$HORA_ACEPTADO' WHERE guia_id = $guia_id";
				}else{

					$sql="INSERT INTO `guia` (`guia_ID`, `GUIA`, `FECHA_GUIA`, `PEDIDO`, `DO_IMP`, `DO_SUF`, `AUXILIAR_TRAMITADOR`, `TIPO_TRAMITE`, `MANIFIESTO_FMM`, `FECHA_MANIFIESTO_FMM`, `HORA_MANIFIESTO_FMM`, `LIBERACION`, `LEVANTE`, `HORA_LEVANTE`, `OBSERVACIONES`, `FECHA_SOLICITUD_CLASIFICACION`, `HORA_SOLICITUD_CLASIFICACION`, `FECHA_RESPUESTA_CLASIFICACION`, `HORA_RESPUESTA_CLASIFICACION`, `FECHA_ASIGNACION_A_DIGITACION`, `HORA_ASIGNACION_A_DIGITACION`, `ENTRE_RYA`, `HORA_ENTRE_RYA`, `REVISION`, `HORA_REVISION`, `ACEPTADO`, `HORA_ACEPTADO`) VALUES (null,'$GUIA','$FECHA_GUIA','$PEDIDO','$DO_IMP','$DO_SUF','$AUXILIAR_TRAMITADOR','$TIPO_TRAMITE','$MANIFIESTO_FMM','$FECHA_MANIFIESTO_FMM','$HORA_MANIFIESTO_FMM','$LIBERACION','$LEVANTE','$HORA_LEVANTE','$OBSERVACIONES','$FECHA_SOLICITUD_CLASIFICACION','$HORA_SOLICITUD_CLASIFICACION','$FECHA_RESPUESTA_CLASIFICACION','$HORA_RESPUESTA_CLASIFICACION','$FECHA_ASIGNACION_A_DIGITACION','$HORA_ASIGNACION_A_DIGITACION','$ENTRE_RYA','$HORA_ENTRE_RYA','$REVISION','$HORA_REVISION','$ACEPTADO','$HORA_ACEPTADO')";
				}


	
	//echo $sql."<br>";

//echo "<br>".$GUIA."<br>".$FECHA_GUIA."<br>".$PEDIDO."<br>".$DO_IMP."<br>".$DO_SUF."<br>".$AUXILIAR_TRAMITADOR."<br>".$TIPO_TRAMITE."<br>".$MANIFIESTO_FMM."<br>".$FECHA_MANIFIESTO_FMM."<br>".$HORA_MANIFIESTO_FMM."<br>".$LIBERACION."<br>".$LEVANTE."<br>".$HORA_LEVANTE."<br>".$OBSERVACIONES."<br>".$FECHA_SOLICITUD_CLASIFICACION."<br>".$HORA_SOLICITUD_CLASIFICACION."<br>".$FECHA_RESPUESTA_CLASIFICACION."<br>".$HORA_RESPUESTA_CLASIFICACION."<br>".$FECHA_ASIGNACION_A_DIGITACION."<br>".$HORA_ASIGNACION_A_DIGITACION."<br>".$ENTRE_RYA."<br>".$HORA_ENTRE_RYA."<br>".$REVISION."<br>".$HORA_REVISION."<br>".$ACEPTADO."<br>".$HORA_ACEPTADO."<br>";


	$resultado = mysqli_query($obj->conexion,$sql) or die(mysqli_error($obj->conexion));
			if($resultado){
				echo "consulta ejecutada";
			}else{
				echo "no se pudo ejecutar la consulta";
			}
		}
		$cont++;
	}
    fclose($f);

}else{
	echo "No se pudo Error".mysql_error();
}







    echo json_encode($ret);
 }
 ?>