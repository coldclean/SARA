<?php
ini_set('max_execution_time', 0); //300 seconds = 5 minutes
ini_set('memory_limit', '-1');
date_default_timezone_set('America/Bogota');
session_start();

//librerias para manipulacion excel
require_once 'php/conexion.php';
include 'php/PHPExcel/PHPExcel/IOFactory.php';
include 'php/PHPExcel/PHPExcel.php';
//librerias para manipulación OCR
# Imports the Google Cloud client library
//constantes
$max_tam =  2621440;
$fecha = getdate();
$fecha_ma = new DateTime($_POST['fecha_manifiesto']);
$fecha_manifiesto = $fecha_ma->format('d/m/Y');
$do = $_POST['do'];
$manifiesto = $_POST['manifiesto'];
$deposito = $_POST['deposito'];
$codigo = $_POST['codigo'];
$direccion = $_POST['direccion'];
$bultos = $_POST['bultos'];
$peso = $_POST['peso'];
$emp_trans = $_POST['emp_transportadora'];
$consignatario = $_POST['consignatario'];
$inicio = $_POST['inicio'];
$final = $_POST['final'];
$fecha_cadena = $fecha['mday']."/".$fecha['mon']."/".$fecha['year'];
$idusuario = $_SESSION['idusuario'];
$dotrans = $_POST['dotrans'];
$nombre = $_SESSION['nombre_usuario'];
$apellido = $_SESSION['apellido_usuario'];
$ape_nom = $nombre.' '.$apellido;

//include 'php/PHPExcel/PHPExcel.php';
# Includes the autoloader for libraries installed with composer
$exc = PHPExcel_IOFactory::createReader('Excel2007');
$exc = $exc->load('acta.xlsx');
$fecha_for = $fecha['mday'].$fecha['mon'].$fecha['hours'].$fecha['minutes'];
$nombre_archivo = 'acta_'.$do.'_'.$fecha_for.'.xlsx';
$exc->setActiveSheetIndex(0);

$exc->getActiveSheet()->setCellValue('C2',$do);
$exc->getActiveSheet()->setCellValue('I2',$fecha_cadena);
$exc->getActiveSheet()->setCellValue('A13',$dotrans);
$exc->getActiveSheet()->setCellValue('A8',$deposito);
$exc->getActiveSheet()->setCellValue('F8',$codigo);
$exc->getActiveSheet()->setCellValue('A11',$direccion);
$exc->getActiveSheet()->setCellValue('F13',$manifiesto);
$exc->getActiveSheet()->setCellValue('I13',$fecha_manifiesto);
$exc->getActiveSheet()->setCellValue('A15',$emp_trans);
$exc->getActiveSheet()->setCellValue('F15',$bultos);
$exc->getActiveSheet()->setCellValue('H15',$peso);
$exc->getActiveSheet()->setCellValue('A17',$consignatario);
$exc->getActiveSheet()->setCellValue('I16',$inicio);
$exc->getActiveSheet()->setCellValue('I17',$final);
$exc->getActiveSheet()->setCellValue('F64',strtoupper($ape_nom));



     $con = new Conector();
     $respuesta = $con->getDatos($do);
     //$respuesta = $con->getDatos($do);
     $arreglo_todo = array(1=>array(0=>""));
     $celda = null;
     //print_r($arreglo_todo);
     

     foreach ($respuesta as $filas) {
        $des = $filas['descripcion'];
        $ite = $filas['item'];
        settype($ite,"integer");
        if (array_key_exists($ite,$arreglo_todo)){
            $arreglo_todo[$ite][0] = $arreglo_todo[$ite][0].' '.strtoupper($des).";"; 
        }else{
            $arreglo_todo[$ite][0] = strtoupper($des).";";
        }

        
        $cantidad = $filas['cantidad'];
        $arreglo_todo[$ite][1] = $cantidad;
        $renglon = $ite+18;
         if ($renglon > 61 && $renglon < 130){
             $renglon = $renglon + 5;
         } 

         if ($renglon > 129 && $renglon < 197) {
            $renglon = $renglon + 10;
            //$renglon = (abs($renglon - 67)) + $renglon;
         }
         // if ($renglon > 129 && $renglon < 135){
         //    //$renglon = (abs($renglon - 135)) + $renglon;
         //    $renglon = $
         // }

    // $exc->getActiveSheet()->setCellValue('B'.$renglon,($exc->getActiveSheet()->getCell('B'.$renglon)->getValue()).' '.$des.";");
     
     
 }
 //print_r($arreglo_todo);
 //print_r($arreglo_todo);
 //arsort($arreglo_todo);
     //echo $exc->getActiveSheet()->getCell('B19')->getValue();
     $index_renglon = 19;
    foreach ($arreglo_todo as $it => $item) {
        $nletras = 0;
        $cadena_dividida = explode(" ", $item[0]);
        $exc->getActiveSheet()->setCellValue('A'.$index_renglon,$it);
        $exc->getActiveSheet()->setCellValue('I'.$index_renglon,$item[1]);

        for($i=0; $i<count($cadena_dividida); $i++){
            $celda = $celda.' '.$cadena_dividida[$i];
            if(strlen($celda)>60 || $i == (count($cadena_dividida)-1)){
                $exc->getActiveSheet()->setCellValue('B'.$index_renglon,$celda);
                $celda='';
                $index_renglon++;
                if ($index_renglon>61 && $index_renglon<67){
                    $index_renglon = 67;
                }
                if ($index_renglon>129 && $index_renglon<135){
                    $index_renglon = 135;
                }
            }
        }
    }

  $objescritura = PHPExcel_IOFactory::createWriter($exc,'Excel2007');
     $objescritura-> save($nombre_archivo);
     $con->registroDo($do,$dotrans,$idusuario,$manifiesto,$deposito,$consignatario,$nombre_archivo);
     //$horas=$con->obtener_hora($do);
       echo '<a href='.$nombre_archivo.' title="acta">acta_'.$do.'</a>';
     echo '<br>';


//print_r($mostrar);

?>