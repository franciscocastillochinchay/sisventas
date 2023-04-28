<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Pagos{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar registro
public function insertar($idventapago,$idusuario,$fechapago,$numeropago,$montopago,$descripcion){
	$sql="INSERT INTO pagos (idventa,idusuario,fecha_hora,numero,monto,estado,descripcion) VALUES ('$idventapago','$idusuario','$fechapago','$numeropago','$montopago','Aceptado','$descripcion')";
	
	//echo "<script>console.log('Debug Objects: " . $sql . "' );</script>";
	  ejecutarConsulta($sql);


	 $sql1="UPDATE venta v
	 set v.saldo= total_venta-(SELECT sum(p1.monto) 
														 FROM pagos p1
														 WHERE p1.estado<>'Anulado'
														 and p1.estado='Aceptado'
														 and p1.idventa='$idventapago')
	 where v.idventa='$idventapago'";
		//echo "<script>console.log('Debug Objects: " . $sql1 . "' );</script>";	 
	 return ejecutarConsulta($sql1);

}

public function anular($idventa){
	$sql="UPDATE venta SET estado='Anulado' WHERE idventa='$idventa'";
	return ejecutarConsulta($sql);
}

public function validarnegativo($idventapago,$idusuario,$fechapago,$numeropago,$montopago,$descripcion){
	
	

	$sql1="SELECT v.total_venta-(IFNULL(sum(p.monto),0)+$montopago) negativo
		FROM venta v 
		LEFT JOIN pagos p on v.idventa=p.idventa
		WHERE v.estado<>'Anulado'
		and p.estado='Aceptado'
		and p.idventa=$idventapago";

	
	//echo `<script>console.log('YYYYY: " . $sql1 . "' );</script>`;	 
	//echo "$sql1";

		return ejecutarConsultaSimpleFila($sql1);
}


//implementar un metodopara mostrar los datos de unregistro a modificar
public function mostrar($idventa){
	$sql="SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,u.idusuario,u.nombre as usuario, v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.saldo,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE idventa='$idventa'  and v.estado<>'Anulado'";
	return ejecutarConsultaSimpleFila($sql);
}

public function listarDetallePagos($idventa){
	$sql="SELECT v.idventa,p.numero,DATE(p.fecha_hora) fechapago,p.monto,p.estado,p.descripcion FROM venta v LEFT JOIN pagos p on v.idventa=p.idventa WHERE v.estado<>'Anulado' and p.idventa='$idventa'";
	return ejecutarConsulta($sql);
}

//listar registros
public function listar(){
	$sql="SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,u.idusuario,u.nombre as usuario, v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.saldo,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.estado<>'Anulado' ORDER BY v.idventa DESC";
	return ejecutarConsulta($sql);
}


public function ventacabecera($idventa){
	$sql= "SELECT v.idventa, v.idcliente, p.nombre AS cliente, p.direccion, p.tipo_documento, p.num_documento, p.email, p.telefono, v.idusuario, u.nombre AS usuario, v.tipo_comprobante, v.serie_comprobante, v.num_comprobante, DATE(v.fecha_hora) AS fecha, v.saldo, v.total_venta FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
	return ejecutarConsulta($sql);
}

public function ventadetalles($idventa){
	$sql="SELECT a.nombre AS articulo, a.codigo, d.cantidad, d.precio_venta, d.descuento, (d.cantidad*d.precio_venta-d.descuento) AS subtotal FROM detalle_venta d INNER JOIN articulo a ON d.idarticulo=a.idarticulo WHERE d.idventa='$idventa'";
         return ejecutarConsulta($sql);
}


}

 ?>
