<?php
    session_start();
    if($_SESSION['us_tipo']==1 || $_SESSION['us_tipo']==2) //si el usario es  administrador entra a la pagina del administrador
    {
      include_once 'layouts/header.php';
?>
  <title>Ventas</title>
  <!-- Tell the browser to be responsive to screen width -->
  <?php
    include_once 'layouts/nav.php';
  ?>
  <!-- modal registro de ventas-->
  <div class="modal fade" id="vista_venta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> <!--con el id del modal lo usamos el el boton para crear el producto-->
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="card card-primary">
          <div class="card-header" style="background: #114358cc;">
              <h3 class="card-title">Registro de ventas</h3>
              <button data-dismiss="modal" aria-label="close" class="close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label for="codigo_venta">Código venta: </label>
              <span id="codigo_venta"></span>
            </div>
            <div class="form-group">
              <label for="cliente">Cliente: </label>
              <span id="cliente"></span>
            </div>
            <div class="form-group">
              <label for="fecha">Fecha: </label>
              <span id="fecha"></span>
            </div>
            <div class="form-group">
              <label for="vendedor">Vendedor: </label>
              <span id="vendedor"></span>
            </div>
            <table class="table table-hover text-nowrap">
              <thead class="table-success">
                <tr>
                  <th>Cantidad</th>
                  <th>Precio</th>
                  <th>Producto</th>
                  <th>Unidad</th>
                  <th>Presentación</th>
                  <th>Categoria</th>
                  <th>Subtotal</th>
                </tr>
              </thead>
              <tbody id="registros" class="table-warning">
              </tbody>
            </table>
            <div class="float-right input-group-append">
              <h3 class="m-1">Total:$</h3>
              <h3 class="m-1" id="total"></h3>
            </div>
          </div>
          <div class="card-footer">
            <button type="button" data-dismiss="modal" class="btn btn-outline-secondary float-right m-1">Cerrar</button> 
          </div>
      </div>
    </div>
  </div>
</div>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 ml-1">
            <h1>Ventas</h1>
            <!--<input type="hidden" id="tipo_usuario" value="<?php echo $_SESSION['us_tipo'] ?>">-->
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adm_catalogo.php">Home</a></li>
              <li class="breadcrumb-item active">Ventas</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section>
    <div class="card-body" style="margin-top:-70px;">
      <div class="tab-content">
        <div class="tab-pane active" id="producto">
            <div class="card card-success">
                    <div class="card-header" style="background: #114358cc;">
                    <h3 class="card-title">Consultas</h3>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-lg-3 col-6">
                          <!-- small box -->
                          <div class="small-box bg-info">
                            <div class="inner">
                              <h3 id="venta_dia_vendedor">0</h3>
                              <p>Venta del día por vendedor</p>
                            </div>
                            <div class="icon">
                              <i class="fas fa-user"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                          </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                          <!-- small box -->
                          <div class="small-box bg-success">
                            <div class="inner">
                              <h3 id="venta_diaria">0</h3>
                              <p>Venta diaria</p><!--Es la suma de la venta diaria de cada uno de los vendedores-->
                            </div>
                            <div class="icon">
                              <i class="fas fa-shopping-bag"></i>
                            </div>
                            <a href="adm_mas_consultas.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                          </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                          <!-- small box -->
                          <div class="small-box bg-warning">
                            <div class="inner">
                              <h3 id="venta_mensual">0</h3>
                              <p>Venta mensual</p>
                            </div>
                            <div class="icon">
                              <i class="fas fa-calendar-alt"></i>
                            </div>
                            <a href="adm_mas_consultas.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                          </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                          <!-- small box -->
                          <div class="small-box bg-danger">
                            <div class="inner">
                              <h3 id="venta_anual">0</h3>
                              <p>Venta anual</p>
                            </div>
                            <div class="icon">
                              <i class="fas fa-signal"></i>
                            </div>
                            <a href="adm_mas_consultas.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                          </div>
                        </div>
                        <!-- ./col -->
                      </div>
                    </div>
                    <div class="card-footer">    
                    </div>
             </div>
        </div>
      </div>
    </div>
  </section>
  <section>
    <div class="card-body" style="margin-top: -45px;">
      <div class="tab-content">
        <div class="tab-pane active" id="producto">
            <div class="card card-success">
                    <div class="card-header" style="background: #114358cc;">
                    <h3 class="card-title">Buscar ventas</h3>
                    </div>
                    <div class="card-body">
                        <table id="tabla_ventas" class="display table table-hover text-nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Cliente</th>
                                        <th>Total</th>
                                        <th>Vendedor</th>
                                        <th>Fecha</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                        </table>     
                    </div>
                    <div class="card-footer">    
                    </div>
             </div>
        </div>
      </div>
    </div>
  </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
include_once 'layouts/footer.php';
    }
    else
    {
        header('Location: ../index.php');
    }
?>
<script src="../js/datatables.js"></script>
<script src="../js/venta.js"></script>