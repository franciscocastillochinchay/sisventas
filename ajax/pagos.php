<?php 
require_once "../modelos/Pagos.php";
if (strlen(session_id())<1) 
	session_start();

$venta = new Pagos();

$idventa=isset($_POST["idventa"])? limpiarCadena($_POST["idventa"]):"";

$idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
$idusuario=$_SESSION["idusuario"];
$tipo_comprobante=isset($_POST["tipo_comprobante"])? limpiarCadena($_POST["tipo_comprobante"]):"";
$serie_comprobante=isset($_POST["serie_comprobante"])? limpiarCadena($_POST["serie_comprobante"]):"";
$num_comprobante=isset($_POST["num_comprobante"])? limpiarCadena($_POST["num_comprobante"]):"";
$fecha_hora=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
$saldo=isset($_POST["saldo"])? limpiarCadena($_POST["saldo"]):"";
$total_venta=isset($_POST["total_venta"])? limpiarCadena($_POST["total_venta"]):"";


$numeropago=isset($_POST["numeropago"])? limpiarCadena($_POST["numeropago"]):"";
$montopago=isset($_POST["montopago"])? limpiarCadena($_POST["montopago"]):"";
$fechapago=isset($_POST["fechapago"])? limpiarCadena($_POST["fechapago"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$idventapago=isset($_POST["idventapago"])? limpiarCadena($_POST["idventapago"]):"";


switch ($_GET["op"]) {
	case 'guardaryeditarpagos':
	if (empty($idventa)) {
		$rspta=$venta->insertar($idventapago,$idusuario,$fechapago,$numeropago,$montopago,$descripcion); 
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
	}else{
        
	}
		break;
	

	case 'anular':
		$rspta=$venta->anular($idventa);
		echo $rspta ? "Ingreso anulado correctamente" : "No se pudo anular el ingreso";
		break;
	
	case 'mostrar':
		$rspta=$venta->mostrar($idventa);
		echo json_encode($rspta);
		break;

	case 'listarDetallePagos':
		//recibimos el idventa
		$id=$_GET['id'];

		$rspta=$venta->listarDetallePagos($id);
		$total=0;
		echo ' <thead style="background-color:#A9D0F5">
        <th>Opciones</th>
        <th>Numero</th>
        <th>Fecha pago</th>
        <th>Monto</th>
        <th>Estado</th>
        <th>Descripcion</th>
       </thead>';
		while ($reg=$rspta->fetch_object()) {
			echo '<tr class="filas">
			<td></td>
			<td>'.$reg->numero.'</td>
			<td>'.$reg->fechapago.'</td>
			<td>'.$reg->monto.'</td>
			<td>'.$reg->estado.'</td>
			<td>'.$reg->descripcion.'</td></tr>';
			
		}
		echo '<tfoot>
         <th></th>
         <th></th>
         <th></th>
         <th></th>
         <th></th>
         
       </tfoot>';
		break;

    case 'listar':
		$rspta=$venta->listar();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
                 if ($reg->tipo_comprobante=='Ticket') {
                 	$url='../reportes/exTicket.php?id=';
                 }else{
                    $url='../reportes/exFactura.php?id=';
                 }

			$data[]=array(
            "0"=>
			'<button class="btn btn-success btn-xs" onclick="listardocumentos('.$reg->idventa.')"><i class="fa fa-credit-card"></i></button>',
            "1"=>$reg->fecha,
            "2"=>$reg->cliente,
            "3"=>$reg->usuario,
            "4"=>$reg->tipo_comprobante,
            "5"=>$reg->serie_comprobante. '-' .$reg->num_comprobante,
            "6"=>$reg->total_venta,
            "7"=>($reg->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':'<span class="label bg-red">Anulado</span>'
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		break;

		case 'selectCliente':
			require_once "../modelos/Persona.php";
			$persona = new Persona();

			$rspta = $persona->listarc();

			while ($reg = $rspta->fetch_object()) {
				echo '<option value='.$reg->idpersona.'>'.$reg->nombre.'</option>';
			}
			break;

			case 'listarArticulos':
			require_once "../modelos/Articulo.php";
			$articulo=new Articulo();

				$rspta=$articulo->listarActivosVenta();
				$data=Array();

				while ($reg=$rspta->fetch_object()) {
					$data[]=array(
					"0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idarticulo.',\''.$reg->nombre.'\','.$reg->precio_venta.','.$reg->stock.')"><span class="fa fa-plus"></span></button>',
					"1"=>$reg->nombre,
					"2"=>$reg->categoria,
					"3"=>$reg->codigo,
					"4"=>$reg->stock,
					"5"=>$reg->precio_venta,
					"6"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px'>"
				
					);
				}
				$results=array(
					"sEcho"=>1,//info para datatables
					"iTotalRecords"=>count($data),//enviamos el total de registros al datatable
					"iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
					"aaData"=>$data); 
				echo json_encode($results);

				break;
}
 ?>