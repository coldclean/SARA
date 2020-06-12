<?php

$directorio = 'archivos/imagenes/7114199632';
$ficheros1  = scandir($directorio);
foreach ($ficheros1 as $fic) {

	$pos_pun = strpos($fic, '.');
	if ($pos_pun === false){		
		$ficheros_inv[]=$fic;
	}else{
		if ($pos_pun == 0){
			$ficheros_inv[]=$fic;
		}else{
			$extension = substr($fic, strlen($fic)-4);

			echo 'Extension: '.$extension.'<br>';
			if($extension == '.jpg')
				$ficheros_val[]=$directorio.'/'.$fic;
			else
				$ficheros_inv[]=$fic;
		}
	}
}

echo ' De los archivos mostrados solo los siguientes son validos: ';
foreach ($ficheros_val as $val) {
	echo '<br> '.$val.', ';
	# code...
}
echo '<br>';

echo 'Y los siguientes no son validos: ';
foreach ($ficheros_inv as $indice) {
	echo ' '. $indice.',';
 	# code...
 } 

?>
