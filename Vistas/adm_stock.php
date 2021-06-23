<?php
    session_start();
    if($_SESSION['us_tipo']==1 ) //si el usario es  administrador entra a la pagina del administrador
    {
      include_once 'layouts/header.php';
?>
<!-- Modal editar lote-->
<div class="modal fade" id="editarstock" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="card card-success">
          <div class="card-header" style="background: #114358cc;">
              <h3 class="card-title">Editar stock</h3>
              <button data-dismiss="modal" aria-label="close" class="close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="card-body">
            <div class="alert alert-success text-center m-1" id="editar_stock" style="display:none;"><!--alerta para modificar-->
              <span><i class="fas fa-check m-1"> Se modifico correctamente</i></span>
            </div>
              <form id="form-editar-stock"> 
                <div class="form-group">
                    <label for="codigo-stock">Código stock:</label>
                    <label id="codigo-stock">Código stock</label>
                </div>
                <div class="form-group">
                    <label for="stock">Stock:</label>
                    <input id="stock" type="number" class="form-control" placeholder="Ingrese stock">
                </div>
                <input type="hidden" id="id_stock_producto">
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
  <title>Stock</title>
  <!-- Tell the browser to be responsive to screen width -->
  <?php
    include_once 'layouts/nav.php';
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Stock</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adm_catalogo.php">Home</a></li>
              <li class="breadcrumb-item active">Stock</li>
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
                                        <div class="card-title mt-2 mb-3">Buscar stock</div>
                                        <div class="input-group">
                                            <input id="buscar-stock" type="text" class="form-control float-left" placeholder="Ingrese nombre del producto">
                                            <div class="input-group-append">
                                                <button class="btn btn-default"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                      <div id="lotes" class="row d-flex align-items-stretch">
                                      </div>
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
<script src="../js/stock.js"></script>