<?php  
require_once 'php/conexion.php';

$depo = $_POST["deposito"];
$con = new conector();
echo json_encode($con->datos_deposito($depo));

?>