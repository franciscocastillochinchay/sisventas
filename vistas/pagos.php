<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{


require 'header.php';

if ($_SESSION['ventas']==1) {

 ?>
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h1 class="box-title">Pagos 
              </h1>
                <div class="box-tools pull-right">
                </div>
            </div>
              <!--box-header-->
              <!--centro-->
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th>Opciones</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Usuario</th>
                    <th>Documento</th>
                    <th>Número</th>
                    <th>Total Venta</th>
                    <th>Saldo</th>
                    <th>Estado</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Opciones</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Usuario</th>
                    <th>Documento</th>
                    <th>Número</th>
                    <th>Total Venta</th>
                    <th>Saldo</th>
                    <th>Estado</th>
                  </tfoot>   
                </table>
              </div>

<!-- AGREGAR NUEVA VENTA -->
<div class="panel-body" style="height: 400px;" id="formularioregistros">

    <form action="" name="formulario" id="formulario" method="POST">
      <div class="form-group col-lg-8 col-md-8 col-xs-12">
        <label for="">Cliente Pago(*):</label>
        <input class="form-control" type="hidden" name="idventa" id="idventa">
        <select name="idcliente" id="idcliente" class="form-control selectpicker" data-live-search="true" required>
          
        </select>
      </div>

      <div class="form-group col-lg-4 col-md-4 col-xs-12">
        <label for="">Fecha(*): </label>
        <input class="form-control" type="datetime-local" name="fecha_hora" id="fecha_hora" >
      </div>

      <div class="form-group col-lg-6 col-md-6 col-xs-12">
        <label for="">Tipo Comprobante(*): </label>
        <select name="tipo_comprobante" id="tipo_comprobante" class="form-control selectpicker" >
          <option value="Boleta">Boleta</option>
          <!-- <option value="Factura">Factura</option>
          <option value="Ticket">Ticket</option> -->
        </select>
      </div>
      
      <div class="form-group col-lg-2 col-md-2 col-xs-6">
        <label for="">Serie: </label>
        <input class="form-control" type="text" name="serie_comprobante" id="serie_comprobante" maxlength="7" placeholder="Seriee" disabled>
      </div>
      
      <div class="form-group col-lg-2 col-md-2 col-xs-6">
        <label for="">Número: </label>
        <input class="form-control" type="text" name="num_comprobante" id="num_comprobante" maxlength="10" placeholder="Número" disabled>
      </div>
      
      <div class="form-group col-lg-2 col-md-2 col-xs-6">
        <label for="">Saldo: </label>
        <input class="form-control" type="text" name="saldo" id="saldo" value="0" disabled>
      </div>

      <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>  Guardar</button>
          <button class="btn btn-danger" onclick="cancelarform()" type="button" id="btnCancelar"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
      </div>

    </form>
    
    <form action="" name="formulariodetallespagos" id="formulariodetallespagos" method="POST">
      <input class="form-control" type="hidden" name="idventapago" id="idventapago">
      <div class="form-group col-lg-2 col-md-2 col-xs-6">
         <label for="">Numero: </label>
         <input class="form-control" type="text" name="numeropago" id="numeropago" value="0" >
      </div>

      <div class="form-group col-lg-2 col-md-2 col-xs-6">
         <label for="">Monto: </label>
         <input class="form-control" type="text" name="montopago" id="montopago" value="0" >
      </div>

      <div class="form-group col-lg-4 col-md-4 col-xs-12">
         <label for="">Fecha de pago (*): </label>
         <input class="form-control" type="datetime-local" name="fechapago" id="fechapago" required>
      </div>

      <div class="form-group col-lg-2 col-md-2 col-xs-6">
         <label for="">Descripcion: </label>
         <input class="form-control" type="text" name="descripcion" id="descripcion" value="0" >
      </div>

      <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <button class="btn btn-primary" type="submit" id="btnGuardarPagos"><i class="fa fa-save"></i>Guardar Pagos</button>
          
      </div>

      <div class="form-group col-lg-12 col-md-12 col-xs-12">
        <table id="tbldetallespagos" class="table table-striped table-bordered table-condensed table-hover">
          <thead style="background-color:#A9D0F5">
            <th>Opciones</th>
            <th>Numero</th>
            <th>Fecha pago	</th>
            <th>Monto</th>
            <th>Estado</th>
            <th>Descripcion</th>
            
          </thead>
          
          <tbody>
            
          </tbody>
        </table>
      </div>
      
      
    </form>

</div>



<!--fin centro-->
      </div>
      </div>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>



  
<?php 
}else{
 require 'noacceso.php'; 
}

require 'footer.php';
 ?>
 <script src="scripts/pagos.js"></script>
 <?php 
}

ob_end_flush();
  ?>

