<?php
ini_set('max_execution_time', 0); //300 seconds = 5 minutes
ini_set('memory_limit', '-1');
date_default_timezone_set('America/Bogota');
//librerias para manipulacion excel
require_once 'php/conexion.php';
//librerias para manipulación OCR
require __DIR__ . '/vendor/autoload.php';
# Imports the Google Cloud client library
use Google\Cloud\Vision\VisionClient;
//constantes
$max_tam =  2621440;
$fecha = getdate();

//include 'php/PHPExcel/PHPExcel.php';
# Includes the autoloader for libraries installed with composer

$item = $_POST['item_num'];
$cant = $_POST['cant_ite'];
$do = $_POST['do_oculto'];
$marca =" ";

if (array_key_exists('marca_texto', $_POST)){
    $marca= $_POST['marca_texto'];
    $descripcion = "Marca: ".$marca." ".$_POST['descripcion_corregida'];
    
}else{
   $descripcion = $_POST['descripcion_corregida'];
}


# Your Google Cloud Platform project ID


$directorio = 'archivos/imagenes/temp/';

//$ficheros1  = scandir($directorio);
//$ficheros = $_FILES['archivo']['name'];
//print_r($_FILES);
//echo count($ficheros_val);
//echo ($_FILES['archivo']['tmp_name']);
$imagen = $_FILES['archivo']['tmp_name'];
$exif = exif_read_data($imagen, 'IFD0');
$hora_fecha_foto = $exif['DateTimeOriginal'];
$imagen_tam = filesize($imagen);
list($ancho,$alto) = getimagesize($imagen);

if($imagen_tam >= $max_tam){
    $max_ancho = $ancho*0.5;
    $max_alto = $alto*0.5;
}else{
    $max_ancho = $ancho;
    $max_alto = $alto;
}

$nueva_imagen= imagecreatefromjpeg($imagen);
 
//aspecto 
// $x_aspecto = $ancho_max / $ancho;
// $y_aspecto = $alto_max / $alto;

// if (($ancho <= $ancho_max) && ($alto <= $alto_max)){
//     $ancho_final = $ancho;
//     $alto_final = $alto;
// }
// else if (($x_aspecto * $alto) < $alto_max){
//     $alto_final = ceil($x_aspecto * $alto);
//     $ancho_final = $ancho_max;
// }
// else{
//     $ancho_final = ceil($y_aspecto * $ancho);
//     $alto_final = $alto_max;
// }
    //$lienzo = imagecreatetruecolor($max_ancho, $max_alto);
    //imagecopyresampled($lienzo, $nueva_imagen, 0, 0, 0, 0, $max_ancho, $max_alto, $ancho, $alto);
    //imagedestroy($nueva_imagen);
//move_uploaded_file($imagen,$directorio.$_FILES['archivo']['name']);
    //imagejpeg($lienzo,$directorio.$_FILES['archivo']['name'],95);
$imagen = $directorio."".$_FILES['archivo']['name'];

# The name of the image file to annotate

//$fileName = __DIR__ . '/archivos/imagenes/IMG_4487.JPG';

# Prepare the image to be annotated
//$image = $vision->image(fopen($fileName, 'r'),
  //  ['faces']
//);
// foreach ($ficheros_val as $i => $imag) {
//   try{  
//     unset($image);
//     unset($annotation);
//     unset($tes);
 
//   }
//   catch (Exception $e){
//     $excepcion = $e->getMessage();//con esta funcion se evita el mensaje de la API de google de recurso agotado por solicitudes 
//     while ($excepcion != null){
//         if ($m <= 4)
//           $m=pow(2,$intento);
//         $n = rand(1000000,9000000);
//         time_nanosleep($m,$n);
//         try{
//             unset($image);
//             unset($annotation);
//             unset($tes);
//             $image = $vision->image(file_get_contents($imag), ['TEXT_DETECTION']);
//             $annotation = $vision->annotate($image);
//             $tes = $annotation->text();
//             $excepcion = null;
//             $intento = 0;
//         }
//         catch (Exception $e){
//             $excepcion = $e->getMessage();

//         }

//         $intento++;
//     }
//   }
//print_r($tes->info());
     $con = new conector();
     $con->grabar_foto($item,$descripcion,$cant,$imagen,$hora_fecha_foto,$do);
     //echo json_encode($datos);
?>