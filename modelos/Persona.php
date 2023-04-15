<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Persona{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar regiustro
public function insertar($tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$zona,$iddepartamento){
	$sql="INSERT INTO persona (tipo_persona,nombre,tipo_documento,num_documento,direccion,telefono,email,zona,iddepartamento) VALUES ('$tipo_persona','$nombre','$tipo_documento','$num_documento','$direccion','$telefono','$email','$zona','$iddepartamento')";
	return ejecutarConsulta($sql);
}



public function editar($idpersona,$tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$zona,$iddepartamento){
	$sql="UPDATE persona SET tipo_persona='$tipo_persona', nombre='$nombre',tipo_documento='$tipo_documento',num_documento='$num_documento',direccion='$direccion',telefono='$telefono',email='$email',zona='$zona' ,iddepartamento='$iddepartamento'
	WHERE idpersona='$idpersona'";
	echo "<script>console.log('Debug Objects: " . $sql . "' );</script>";
	return ejecutarConsulta($sql);
}
//funcion para eliminar datos
public function eliminar($idpersona){
	$sql="DELETE FROM persona WHERE idpersona='$idpersona'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($idpersona){
	$sql="SELECT * FROM persona WHERE idpersona='$idpersona'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros
public function listarp(){
	$sql="SELECT * FROM persona WHERE tipo_persona='Proveedor'";
	return ejecutarConsulta($sql);
}

public function listarc(){
	$sql="SELECT persona.* ,departamento.nombre nombredepartamento
			FROM persona 
			left JOIN departamento on persona.iddepartamento=departamento.iddepartamento
			WHERE tipo_persona='Cliente' ";
	return ejecutarConsulta($sql);
}

#yyyy
public function selectDepartamento(){
	$sql="SELECT * FROM departamento";
	return ejecutarConsulta($sql);
}

}

 ?>
