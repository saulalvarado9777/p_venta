<?php
    session_start();
    if($_SESSION['us_tipo']==1 ) //si el usario es  administrador entra a la pagina del administrador
    {
      include_once 'layouts/header.php';
?>
  <title>Compras</title>
  <!-- Tell the browser to be responsive to screen width -->
  <?php
    include_once 'layouts/nav.php';
  ?>
<!-- Modal crear categoria-->
<div class="modal fade" id="cambiar_estado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="card card-success">
          <div class="card-header" style="background: #114358cc;">
              <h3 class="card-title">Cambiar estado</h3>
              <button data-dismiss="modal" aria-label="close" class="close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="card-body">
            <div class="alert alert-danger text-center m-1" id="noedit" style="display:none;"><!--alerta de que no se agrego-->
              <span><i class="fas fa-times m-1"></i>No se pudo editar</span>
            </div>
            <div class="alert alert-success text-center m-1" id="edit" style="display:none;"><!--alerta para modificar-->
              <span><i class="fas fa-check m-1"></i>Se cambio el estado</span>
            </div>
              <form id="form-editar"> 
                <div class="form-group">
                    <label for="estado_compra">Estado</label>
                    <select  id="estado_compra" class="form-control select2" style="width:100%"></select>
                    <input type="hidden" id="id_compra">
                </div>
          </div>
          <div class="card-footer">
                <button type="submit" class="btn btn-outline-primary float-right m-1">Guardar</button>
                <button type="button" data-dismiss="modal" class="btn btn-outline-secondary float-right m-1">Cerrar</button> 
              </form>
          </div>
      </div>
    </div>
  </div>
</div>
  <!-- modal vista compras-->
  <div class="modal fade" id="vista_compra" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> <!--con el id del modal lo usamos el el boton para crear el producto-->
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="card card-primary">
          <div class="card-header" style="background: #114358cc;">
              <h3 class="card-title">Registro de compras</h3>
              <button data-dismiss="modal" aria-label="close" class="close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label for="codigo_compra">Código compra: </label>
              <span id="codigo_compra"></span>
            </div>
            <div class="form-group">
              <label for="fecha_compra">Fecha de compra: </label>
              <span id="fecha_compra"></span>
            </div>
            <div class="form-group">
              <label for="fecha_entrega">Fecha de entrega: </label>
              <span id="fecha_entrega"></span>
            </div>
            <div class="form-group">
              <label for="estado">Estado: </label>
              <span id="estado"></span>
            </div>
            <div class="form-group">
              <label for="proveedor">Proveedor: </label>
              <span id="proveedor"></span>
            </div>
            <table class="table table-hover text-nowrap table-responsive">
              <thead class="table-success">
                <tr>
                  <th>#</th>
                  <th>Código</th>
                  <th>Cantida</th>
                  <th>Precio compra</th>
                  <th>Producto</th>
                  <th>Categoria</th>
                </tr>
              </thead>
              <tbody id="detalles" class="table-warning">
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
          <div class="col-sm-6">
            <h1>Compras <a class="btn btn-outline-primary ml-2" href="adm_ingresar_compras.php">Crear compra</a> </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adm_catalogo.php">Home</a></li>
              <li class="breadcrumb-item active">Compras</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
  <section>
  <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="col-sm-6">
                  <input type="hidden" id="tipo_usuario" value="<?php echo $_SESSION['us_tipo'] ?>">
                </div>
                <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id='producto'>
                                <div class="card card-success">
                                    <div class="card-header" style="background: #114358cc;">
                                        <div class="card-title mt-2 mb-3">Buscar compras</div>
                                        <div class="input-group">
                                            <input id="buscar-stock" type="text" class="form-control float-left" placeholder="Ingrese nombre del producto">
                                            <div class="input-group-append">
                                                <button class="btn btn-default"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                      <table id="compras" class="display table table-hover text-nowrap" style="width:100%">
                                        <thead>
                                          <tr>
                                            <th>#</th>
                                            <th>Id | código</th>
                                            <th>Fecha de compra</th>
                                            <th>Fecha de entrega</th>
                                            <th>Total</th>
                                            <th>Estado</th>
                                            <th>Proveedor</th>
                                            <th>Operación</th>

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
<script src="../js/compras.js"></script>