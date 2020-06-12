<?php
class conector{
	private $sBD ='localhost';
	private $nBD = 'vision';
	private $uBD = 'root';
	private $cBD = '';
	private $usuario;
	private $pass;
	private $filas;
	private $item; 
	private $texto;
	private $foto;
	private $ruta;
	private $con;

	public function __construct(){
				$this->con = new PDO('mysql:host='.$this->sBD.';dbname='.$this->nBD,$this->uBD,$this->cBD);
				$this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
	}

	public function b_usuario($usuario, $pass){
		$this->usuario = $usuario; 
		$this->pass = $pass;

		try{
			$consul = $this->con->prepare("SELECT idusuario, nombre, apellido, usuario, pass, nivel FROM usuarios WHERE usuario='".$usuario."' AND pass='".md5($pass)."' AND activo= 1");
			$consul->execute();
			$this->filas= $consul->fetchAll(PDO::FETCH_ASSOC);

		} catch (PDOException $ex) {
			echo $ex->getMessage();
			echo "no se realizo";
			exit;
		}
	}
	public function grabar_foto($item,$texto, $cant,$ruta, $hora_fecha_foto, $do){
		$this->item = $item; 
		$this->cant = $cant;
		$this->texto = $texto;
		$this->ruta = $ruta;
		$this->do = $do;

		//$con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		try{
			$consul = $this->con->prepare("INSERT INTO foto (item, descripcion, cantidad, ruta, fecha_hora, do) VALUES (?,?,?,?,?,?)");
			//$consul->bindParam($this->item,$this->texto,$this->cant,$this->ruta,$this->do);
			$consul->bindParam(1,$this->item, PDO::PARAM_INT);
			$consul->bindParam(2,$this->texto,PDO::PARAM_STR);
			$consul->bindParam(3,$this->cant,PDO::PARAM_STR);
			$consul->bindParam(4,$this->ruta,PDO::PARAM_STR);
			$consul->bindParam(5,$hora_fecha_foto,PDO::PARAM_STR);
			$consul->bindParam(6,$this->do,PDO::PARAM_INT);
			$consul->execute();
		} catch (PDOException $ex) {
			echo $ex->getMessage();
			echo "no se realizo";
			exit;
		}

		// try{
		// 	$consul = $this->con->prepare("INSERT INTO foto (item, descripcion, cantidad, ruta, do) VALUES (".$this->item.",".$this->texto.",".$this->cant.",".$this->ruta.",".$this->do.")");
		// 	$consul->execute();

		// } catch (PDOException $ex) {
		// 	echo $ex->getMessage();
		// 	echo "no se realizo";
		// 	exit;
		// }

	}
		public function grabar_usuario($usuario,$cedula, $nombre,$apellido,$cargo,$pass){
		//$con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		try{
			$consul = $this->con->prepare("INSERT INTO usuarios (usuario, cedula, nombre, apellido, cargo, pass) VALUES ('".$usuario."','".$cedula."','".$nombre."','".$apellido."','".$cargo."','".md5($pass)."')");
			$consul->execute();
			return true;

		} catch (PDOException $ex) {
			echo $ex->getMessage();
			echo "no se realizo";
			return false;
			exit;
		}

	}
	
	public function numReg(){
		//print_r($this->filas);
		return count($this->filas);
	}
	public function acceso(){

		if($this->usuario == $this->filas[0]['usuario'] && $this->clave == $this->filas[0]['clave']){
			return true;
		}else{
			return false;
		}
	}
	public function getDatos($do){
		$sql = "SELECT item, descripcion, cantidad FROM foto where do = '".$do."' ORDER BY item";
		$resultado = $this->con->query($sql);
		return $resultado;
	}
		public function getDatosUsuarios(){
		$datos['nombre'] = $this->filas[0]['nombre'];
		$datos['apellido'] = $this->filas[0]['apellido'];
		$datos['usuario'] = $this->filas[0]['usuario'];
		$datos['idusuario'] = $this->filas[0]['idusuario'];
		$datos['nivel'] = $this->filas[0]['nivel'];
		return $datos;
	}
	public function registroDo($do,$dotrans,$idusuario,$manifiesto,$deposito,$consignatario,$nombre_archivo){
		try{
			$consul = $this->con->prepare("INSERT INTO actas (do, do_transporte, manifiesto, deposito, consignatario, acta, idusuario) VALUES ('".$do."','".$dotrans."','".$manifiesto."','".$deposito."','".$consignatario."','".$nombre_archivo."','".$idusuario."')");
			$consul->execute();
			return true;

		} catch (PDOException $ex) {
			echo $ex->getMessage();
			echo "no se realizo";
			return false;
			exit;
		}

	}
	public function obtener_hora($do){
		//$sql = "SELECT * FROM vision.foto where do=".$do." ORDER BY fecha_hora DESC LIMIT 1;"
		$sql = "(SELECT DATE_FORMAT(fecha_hora,'%H:%I') Hora FROM vision.foto where do = '$do' ORDER BY idfoto DESC LIMIT 1) UNION ALL (SELECT DATE_FORMAT(fecha_hora, '%H:%I') Hora FROM vision.foto where do = '$do' ORDER BY idfoto ASC LIMIT 1)";
		$resultado = $this->con->prepare($sql);
		$resultado->execute();
		$res = $resultado->fetchAll(PDO::FETCH_ASSOC);
		return $res; //arreglar horas que muestra una sola OJO
	}
	public function datos_deposito($deposito){
		try{
			$consul = $this->con->prepare("SELECT codigo, direccion FROM depositos where nombre='$deposito'");
			$consul->execute();
			$filas= $consul->fetchAll(PDO::FETCH_ASSOC);
			if (count($filas) == 1){
				$datos_deposito['codigo'] = $filas[0]['codigo'];
				$datos_deposito['direccion'] = $filas[0]['direccion'];
				return $datos_deposito; 
			}else{
				return false;
			} 
			
			//return $datos_deposito;

		} catch (PDOException $ex) {
			return false;
		}
				//return (array("codigo"=>$fila['codigo'], "direccion"=>$fila['direccion']));
				# code...
			}
		
	public function getDatos_modificado($do,$item){
		$sql = "SELECT descripcion, cantidad FROM foto where do = '".$do."'  AND item = '".$item."'";
		$resultado = $this->con->prepare($sql);
		$resultado->execute();
		$filas = $resultado->fetchAll(PDO::FETCH_ASSOC);
		return count($filas);//terminar
	}
	public function getConsigantarios(){
		$sql = "SELECT nombre FROM consignatario ORDER BY nombre ASC";
		$resultado = $this->con->prepare($sql);
		$resultado->execute();
		$filas = $resultado->fetchAll(PDO::FETCH_ASSOC);
		return $filas;
	}
	public function getTransportador(){
		$sql = "SELECT nombre FROM transportador ORDER BY nombre ASC";
		$resultado = $this->con->prepare($sql);
		$resultado->execute();
		$filas = $resultado->fetchAll(PDO::FETCH_ASSOC);
		return $filas;
	}
	public function usuarioexiste($usuario){
		$sql = "SELECT * FROM usuarios WHERE usuario='$usuario'";
		$resultado = $this->con->prepare($sql);
		$resultado->execute();
		$num_fil = $resultado->fetchColumn();
		return $num_fil;
	}
	public function getUsuarios(){
		$sql = "SELECT usuario FROM usuarios where nivel='ASISTENTE'";
		$resultado = $this->con->prepare($sql);
		$resultado->execute();
		$filas = $resultado->fetchAll(PDO::FETCH_ASSOC);
		return $filas;
	}
	public function crearAdmin($usuario){
		$sql="UPDATE usuarios SET nivel = 'ADMINISTRADOR' where usuario='$usuario'";
		$resultado = $this->con->prepare($sql);
		$resultado->execute();
	}
}
?>