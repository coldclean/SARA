<?php

error_reporting(E_ALL);
set_time_limit(0);

date_default_timezone_set('America/Bogota');
/** Include path **/
//echo '<br>', get_include_path();
set_include_path(get_include_path() . PATH_SEPARATOR . '../../../Classes/');

/** PHPExcel_IOFactory */
include 'PHPExcel/Classes/PHPExcel/IOFactory.php';
$arc_fac = $_POST['fac'];
$arc_act = $_POST['act'];
//$fact = './archivos/seriales/archivo1.xls';
//$acta = './archivos/seriales/archivo2.xlsx';
$fact = './archivos/seriales/'.$arc_fac;
$acta = './archivos/seriales/'.$arc_act;
//echo PATHINFO_BASENAME;

//echo 'Loading file ',pathinfo($fact,PATHINFO_BASENAME),' y ',pathinfo($acta, PATHINFO_BASENAME), ' using IOFactory to identify the format<br />';
$objFact = PHPExcel_IOFactory::load($fact);
$objActa = PHPExcel_IOFactory::load($acta); 

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
				//echo $val. ' ['. $j . ']' ;
				$k = $val;
				//echo 'fue diferente en la posición: ['.$i.']['.$j. ']';
				//$k++;
				$l=0;
			}			
			if ($val != ''){
				$depu[$k][$l] = $val;
				
				$l++;
				
			}
		}
	}
}

//print_r($depu);
					//$itemFact[$dat][3] = $temp2[0];				
			//	foreach ($temp as $l) {
				//	echo $temp[0].'<br>';
			//	}
				//echo $valor[$j].'<br>';
				//echo $hojaFact[$i+1][0];


				//$seriales[$dat][1] = $dat[$i][$j+3];
				
				//echo $valor[1] . ' ';

		// $cadena = (string)$dat;
		// $pos = strpos($cadena, "Serial-No./Batch No.：");
		// if ($pos === false){

		// }else{
		// 	echo "conseguida, en la posicion " . $pos;
		// 	$cadena = (string)str_replace("Serial-No./Batch No.：", "", $dat);
		// 	echo $cadena . '<br>';
		// 	array_push($seriales, $cadena);	
		// }
		# code...
	
	# code...




//$otra= ["que","ladilla","php"];


		//echo ' ['.$i.']['.$j.'] '.$val;


			//echo $j,' ',$k;
			//$depu[$k][$l] = $val;
			//echo $val;
			
			// if ($l > $lmax)
			// 	$lmax = $l;
		
			// if(($depu[$k][$l] != '') && ($j == 'A') && ($depu[$k][$l])) {	
			// 	$k++;
			// 	$l=0;
			// 	if ($k > $kmax)
			// 	$kmax = $k; 
			// }
			// 			$depu[$k][$l] = $val;
			// 			$l++;
echo '<h4 class="blanco"> Listado de Seriales conseguidos</h4><br> '; 
foreach ($depu as $x => $datos) {
	
	foreach ($datos as $y => $dato) {
		//echo '['.$x.']['.$y.']'.$dato.' ';
		//array_filter($dato);
		$dato = strtoupper($dato);
		$dato = str_replace("'", "-", $dato);
		$arreglo[$x][$y] = $dato;
		//echo $arreglo[$x][$y]. ' '; 
		foreach ($itemFact as $i => $valor) {	
			if (isset($itemFact[$i][7]))
				if (stripos($arreglo[$x][$y],$itemFact[$i][7]) === false){

				}else{
					$itemFact[$i][5] = $x;
					$itemFact[$i][3] = 1;
					$itemFact[$i][4] = 0;
					//echo $itemFact[$i][6].' encontro:  ' . $arreglo[$x][$y];
					$itemFact[$i][6] = $arreglo[$x][$y];
					//echo '<br>';
				}
			}
		}
	}

//foreach($itemFact as $i => $dim1){
	//	if ($itemFact[$i][3] == 0){
		//	if (isset($itemFact[$i][4]))
			//echo $itemFact[$i][4].'<br>';
	//}
		# code...
//}

echo '<table class="seriales">
				<tr>
					<td><strong>No.</strong></td>
					<td><strong>Serial</strong></td>
					<td><strong>Descripcion</strong></td>
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
						echo '<td>'.$itemFact[$i][1];
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
echo '<h4 class="blanco"> Listado de Otros Seriales conseguidos</h4><br>';

// foreach ($itemFact as $i => $value) {
// 	echo '<br>';
// 		if ($itemFact[$i][3] == 0 ){
// 			if(isset($itemFact[$i][7])){
// 				if (stripos($itemFact[$i][7],';') === false){

				
// 				}else{
// 					//echo $itemFact[$i][7];
// 					$otrSer= explode(";",$itemFact[$i][7]);
// 						foreach ($arreglo as $x => $arre) {
// 							echo '<br>';
// 							foreach ($arre as $y => $actar){
// 								echo $arre[$x][$y];

// 								echo $ser. '==' .$actar.' ';
// 								//echo $ser .' '.$actar.'\n';
// 								if(stripos($actar,$ser) === false){

// 								}else{

// 									echo $ser. '==' .$actar.'<br>';
// 								}
// 							# code...
// 						}

// 					}
// 				}
// 		}
// 	}
// }

?>