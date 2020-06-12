<?php
//ini_set('display_errors', 'On');

require __DIR__."/PHPExcelReader/SpreadsheetReader.php"; //better use autoloading
use \PHPExcelReader\SpreadsheetReader as Reader;
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
echo "../".__DIR__."/DO_20170218092413.xls";
$dat = new Reader("../".__DIR__ ."/DO_20170218092413.xls");
//echo $dat->dump(true,true);
$obj = new grabado_datos();

if($obj->conexion = mysqli_connect($obj->sBD,$obj->uBD,$obj->cBD,$obj->nBD)){
	$paquete=$dat;
	echo "exito";
	echo "Numero de filas: ".$paquete->sheets[0]['numRows']."<br>";
	echo "Numero de Columnas: ".$paquete->paquete->sheets[0]['numCols']."<br>";

		for ($i = 2; $i <= $paquete->sheets[0]['numRows']; $i++) {
			$GUIA = $paquete->sheets[0]['cells'][$i][1];
			$FECHA_GUIA =  date("Y-m-d",strtotime($paquete->sheets[0]['cells'][$i][2]));
			$PEDIDO = $paquete->sheets[0]['cells'][$i][3];
			$DO_IMP = $paquete->sheets[0]['cells'][$i][4];
			$DO_SUF = $paquete->sheets[0]['cells'][$i][5];
			$AUXILIAR_TRAMITADOR = $paquete->sheets[0]['cells'][$i][6];
			$TIPO_TRAMITE = $paquete->sheets[0]['cells'][$i][7];
			$MANIFIESTO_FMM = $paquete->sheets[0]['cells'][$i][8];
			$FECHA_MANIFIESTO_FMM = date("Y-m-d", strtotime( $paquete->sheets[0]['cells'][$i][9]));
			$HORA_MANIFIESTO_FMM = $paquete->sheets[0]['cells'][$i][10];
			$LIBERACION = date("Y-m-d", strtotime($paquete->sheets[0]['cells'][$i][11]));
			$LEVANTE = date("Y-m-d", strtotime($paquete->sheets[0]['cells'][$i][12]));
			$HORA_LEVANTE = $paquete->sheets[0]['cells'][$i][13];
			$OBSERVACIONES = $paquete->sheets[0]['cells'][$i][14];
			$FECHA_SOLICITUD_CLASIFICACION = date("Y-m-d", strtotime($paquete->sheets[0]['cells'][$i][15]));
			$HORA_SOLICITUD_CLASIFICACION = $paquete->sheets[0]['cells'][$i][16];
			$FECHA_RESPUESTA_CLASIFICACION = date("Y-m-d", strtotime($paquete->sheets[0]['cells'][$i][17]));
			$HORA_RESPUESTA_CLASIFICACION = $paquete->sheets[0]['cells'][$i][18];
			$FECHA_ASIGNACION_A_DIGITACION = date("Y-m-d", strtotime($paquete->sheets[0]['cells'][$i][19]));
			$HORA_ASIGNACION_A_DIGITACION = $paquete->sheets[0]['cells'][$i][20];
			$ENTRE_RYA = date("Y-m-d", strtotime($paquete->sheets[0]['cells'][$i][21]));
			$HORA_ENTRE_RYA = $paquete->sheets[0]['cells'][$i][22];
			$REVISION = date("Y-m-d", strtotime($paquete->sheets[0]['cells'][$i][23]));
			$HORA_REVISION = $paquete->sheets[0]['cells'][$i][24];
			$ACEPTADO = date("Y-m-d", strtotime($paquete->sheets[0]['cells'][$i][25]));
			$HORA_ACEPTADO = $paquete->sheets[0]['cells'][$i][26]; 

//"INSERT INTO $tabla_db1 (nombre,email,fecha) VALUES ('$nombre','$email','$fecha')";   
//mysql_query($_GRABAR_SQL);  

			$sql="SELECT guia_ID, DO_IMP FROM guia WHERE DO_IMP = '$DO_IMP' AND DO_SUF = '$DO_SUF'";
			$resultado = mysqli_query($obj->conexion,$sql);
	
			if(mysqli_num_rows($resultado)>0){
				$fila = mysqli_fetch_array($resultado);
				$guia_id = $fila['guia_ID'];
				echo $guia_id."<br>";

				$sql="UPDATE `guia` SET `GUIA` = '$GUIA', `FECHA_GUIA` = '$FECHA_GUIA', `PEDIDO` = '$PEDIDO', `DO_IMP` = '$DO_IMP', `DO_SUF` = '$DO_SUF', `AUXILIAR_TRAMITADOR` = '$AUXILIAR_TRAMITADOR' , `TIPO_TRAMITE` = '$TIPO_TRAMITE', `MANIFIESTO_FMM` = '$MANIFIESTO_FMM' , `FECHA_MANIFIESTO_FMM` = '$FECHA_MANIFIESTO_FMM', `HORA_MANIFIESTO_FMM` = 'HORA_MANIFIESTO_FMM', `LIBERACION` = '$LIBERACION' , `LEVANTE` = '$LEVANTE' , `HORA_LEVANTE` = '$HORA_LEVANTE', `OBSERVACIONES` = '$OBSERVACIONES' , `FECHA_SOLICITUD_CLASIFICACION` = '$FECHA_SOLICITUD_CLASIFICACION', `HORA_SOLICITUD_CLASIFICACION` = '$HORA_SOLICITUD_CLASIFICACION', `FECHA_RESPUESTA_CLASIFICACION` = '$FECHA_RESPUESTA_CLASIFICACION', `HORA_RESPUESTA_CLASIFICACION` = '$HORA_RESPUESTA_CLASIFICACION' , `FECHA_ASIGNACION_A_DIGITACION` = '$FECHA_ASIGNACION_A_DIGITACION', `HORA_ASIGNACION_A_DIGITACION` = '$HORA_ASIGNACION_A_DIGITACION', `ENTRE_RYA` = '$ENTRE_RYA' , `HORA_ENTRE_RYA` = '$HORA_ENTRE_RYA' , `REVISION` = '$REVISION', `HORA_REVISION` = '$HORA_REVISION', `ACEPTADO` = '$ACEPTADO', `HORA_ACEPTADO` = '$HORA_ACEPTADO' WHERE guia_id = $guia_id";
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

}else{
	echo "Error".mysql_error();
}


			
?>