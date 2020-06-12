<?php

error_reporting(E_ALL);
set_time_limit(0);

date_default_timezone_set('America/Bogota');

?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/Mint-1.4.3/build/css-mint.css">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 		<script
  src="https://code.jquery.com/jquery-2.0.2.js"
  integrity="sha256-0u0HIBCKddsNUySLqONjMmWAZMQYlxTRbA8RfvtCAW0="
  crossorigin="anonymous"></script>

  <link href="css/uploadfile.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="js/jquery.uploadfile.min.js"></script>


  <link href="css/uploadfile.css" rel="stylesheet">
<script type="text/javascript">

$(document).ready(function() {
	$("#subida_acta").uploadFile({
        url:"prueba.php",
        allowDuplicates: false,
        fileName:"myfile",
        //allowedTypes: "txt",
        multiple:false,
        //acceptFiles:"text/plain", 
        dragDropStr:"<span><b>Arrastre y Suelte Aquí El Acta</b></span>",
        uploadStr:"Cargar",
        duplicateErrorStr: "El reporte ya existe",
        abortStr: "Abortar",
        onSuccess: function(files, response, xhr, pd){ 
            alert("El acta: " + files + " fue cargada "  );
            ("#do_at").trigger("click");
        }
    });




	$('.para_ampliar').each(function() {
		$(this).click(function(e){
			$(this).addClass("activo").parent().siblings("tr").find("td").removeClass("activo");
			
			$(this).next().addClass("activo");

			//$(this).parent().find("td"); 
			//$(this).siblings("td").eq(0).addClass("activo");
		});
		$(this).dblclick(function(e){
			//alert("hola");
			e.preventDefault();
			$(this).removeClass("activo");
			$(this).next().removeClass("activo");
		});
	});
});
</script>



<title>Auditoria de Seriales e Items</title>
<br><br>
<h4 align="center" class="blanco"> Módulo de Auditoría Seriales e Items </h4>
</head>

<body>

<?php

/** Include path **/
set_include_path(get_include_path() . PATH_SEPARATOR . '../../../Classes/');
/** PHPExcel_IOFactory */
include 'PHPExcel/Classes/PHPExcel/IOFactory.php';
           
$fact = './archivos/seriales/archivo1.xls';
$acta = './archivos/seriales/archivo2.xlsx';

$objFact = PHPExcel_IOFactory::load($fact);
$objActa = PHPExcel_IOFactory::load($acta); 

echo '<hr />';

$hojaFact = $objFact->getActiveSheet()->toArray(null,true,true,false);
$hojaActa = $objActa->getActiveSheet()->toArray(null,true,true,false);
$seriales = array();
foreach ($hojaFact as $i => $valor) {	//con este ciclo se extrae y organiza la información de la factura, asociando datos con item
	foreach ($valor as $j => $dat) {
		if ($dat != '' && $j == 0) {
			if (is_numeric($dat)){
				$seriales[$dat][0] = $dat;
				$temp = explode("\n",$valor[$j+1]);
				$itemFact[$dat][0] = $temp[0];
				$itemFact[$dat][1] = $temp[1];
				$itemFact[$dat][2] = $valor[$j][1];
				$itemFact[$dat][3] = 0;
				$str = (string)$hojaFact[$i+1][1];
				if (!isset($hojaFact[$i+1][0])){
					if (strpos($str,'Serial') === false){
					}else{
						$temp2 = explode("Serial-No./Batch No.：", $hojaFact[$i+1][1]);
						$itemFact[$dat][7] = $temp2[1];
					}
				}
			}
		}
	}
}	
$i=0;
$j=0;
$k=-1;
$l=0;
$kmax=0;
$lmax=0;
foreach ($hojaActa as $i=>$valor){
	foreach ($valor as $j=>$val){
	 
		if ($i >=18){

			if($j == 0 && $val != '' && is_numeric($val)){
				$k = $val;
				$l=0;
			}			
			if ($val != ''){
				$depu[$k][$l] = $val;
				$l++;
			}
		}
	}
}	

?>
	
<div name="uploader_izq" class="uploaderizq">
	<div style="color:#FFF;font-size: 1.3em">Subir Acta</div> 
	<div id="subida_acta">Cargar Acta</div>
</div>

<div name="uploader_der" class="uploaderder">
	<div style="color:#FFF;font-size: 1.3em">Subir Factura</div>		
	<div id="subida_fact">Cargar Factura</div>
</div>

<div style="position: absolute;display: inline-block; top:220px">
<input type="button" name="Procesar" value="Procesar" />
</div>
 <h4 class="blanco"><br><br>Listado de Seriales conseguidos</h4><br>; 


<?php


foreach ($depu as $x => $datos) {
	
	foreach ($datos as $y => $dato) {
		$dato = strtoupper($dato);
		$dato = str_replace("'", "-", $dato);
		$arreglo[$x][$y] = $dato;
		foreach ($itemFact as $i => $valor) {	
			if (isset($itemFact[$i][7]))
				if (stripos($arreglo[$x][$y],$itemFact[$i][7]) === false){

				}else{
					$itemFact[$i][5] = $x;
					$itemFact[$i][3] = 1;
					$itemFact[$i][4] = 0;
					$itemFact[$i][6] = $arreglo[$x][$y];
				}
			}
		}
	}

foreach($itemFact as $i => $dim1){
		if ($itemFact[$i][3] == 0){
			if (isset($itemFact[$i][4]))
			echo $itemFact[$i][4].'<br>';
	}
}

echo '<table class="seriales">
				<tr>
					<td><strong>No.</strong></td>
					<td><strong>Serial</strong></td>
					<td><strong>Contexto</strong></td>
					<td><strong>Item Factura</strong></td>
					<td><strong>Item Acta</strong></td>
				</tr>';
				$cont = 0;
				foreach ($itemFact as $i => $valor) {
					if (isset($itemFact[$i][5])){
					//if (isset($itemFact[$i][7])){
						$cont++;
							if($i == $itemFact[$i][5]){
								echo '<tr class="encontrado">';
							}else{
								echo '<tr class="no_encontrado">';
							}
						echo '<td> '.$cont.' </td>';
						echo '<td class= "para_ampliar" id="zoom1" name="zoom1"><div >'.$itemFact[$i][7].' </div></td>';
						echo '<td id="zoom1" name="zoom1" ><div >'.$itemFact[$i][6].' </div></td>';
						echo '<td> '.$i.' </td>';
						echo '<td> '.$itemFact[$i][5].' </td>';
						echo '</tr>';
					}
				}
					foreach ($itemFact as $i => $valor) {
						if (isset($itemFact[$i][7]) && !isset($itemFact[$i][5])){
						$cont++;
						echo '<tr>';
						echo '<td>'.$cont.'</td>';
						echo '<td>'.$itemFact[$i][7].'</td>';
						echo '<td> </td>';
						echo '<td>'. $i .' </td>';
						echo '<td> </td>';
					}
					}
			echo '</table>';
$pos = 0;

// foreach ($arreglo as $i => $serial) {
// 	foreach ($serial as $j => $busq) {
// 		$cadena = (string)$busq;
// 			foreach ($seriñales as $k => $ser) {
// 				$pos = strpos($cadena, $ser); # Con esta función se realiza la comparación con las dos cadenas de seriales. 
// 				if ($pos === false){

// 				}else{
// 					echo $ser.'<br>';
// 					break; #se rompe el ciclo al conseguir el serial
// 				}
// 			}
// 		}
// 	}


//for ($i=0;$i<$kmax;$i++) {
	//echo '<br>';
	//for ($j=0;$j<$lmax;$j++) {
		
	//	echo ' [' . $i . '] '.'['.$j.'] '.$depu[$i][$j]. '<br>';
	

//var_dump($sheetData);
//print_r($depu);

?>
<body>
</html>