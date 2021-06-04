<?php
    session_start();
    if($_SESSION['us_tipo']==1)
    {
      include_once 'layouts/header.php';
?>
<!-- Modal crear categoria-->
<div class="modal fade" id="crear-categoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="card card-success">
          <div class="card-header" style="background: #114358cc;">
              <h3 class="card-title">Crear categoria</h3>
              <button data-dismiss="modal" aria-label="close" class="close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="card-body">
            <div class="alert alert-success text-center m-1" id="agregado-categoria" style="display:none;"><!--alerta para agregar-->
              <span><i class="fas fa-check m-1"> Se agrego correctamente</i></span>
            </div>
            <div class="alert alert-danger text-center m-1" id="noagregado-categoria" style="display:none;"><!--alerta de que no se agrego-->
              <span><i class="fas fa-times m-1"> El nombre ya existe</i></span>
            </div>
            <div class="alert alert-success text-center m-1" id="edit-cat" style="display:none;"><!--alerta para modificar-->
              <span><i class="fas fa-check m-1"> Se modifico correctamente</i></span>
            </div>
              <form id="form-crear-categoria"> 
                <div class="form-group">
                    <label for="nombre-categoria">Nombre</label>
                    <input id="nombre-categoria" type="text" class="form-control" placeholder="Ingresar nombre" required>
                    <input type="hidden" id="id_editar_cat">
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
  <title>Categorias</title>
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
            <h1>Categorias</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adm_catalogo.php">Home</a></li>
              <li class="breadcrumb-item active">Categorias</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <div class="container-fuid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                  <div class="col-sm-6">
                    <button type="button" data-toggle="modal" data-target="#crear-categoria" class="btn btn-outline-primary btn-sm ml-3 m-1 mt-2">Crear categoria</button>
                  </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id='categoria'>
                                <div class="card card-success">
                                    <div class="card-header" style="background: #114358cc;">
                                        <div class="card-title mt-2 mb-3">Buscar categoria</div>
                                        <div class="input-group">
                                            <input id="buscar-categoria" type="text" class="form-control float-left" placeholder="Ingrese nombre">
                                            <div class="input-group-append">
                                                <button class="btn btn-default"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0 table-responsive">     
                                        <table class="table table-over text-nowrap mt-3">
                                          <thead class="table-primary ">
                                            <tr>
                                              <th>Id</th>
                                              <th>Categoria</th>
                                              <th>Acción</th>
                                            </tr>
                                          </thead>
                                          <tbody class="table-active" id="categorias">
                                          </tbody>
                                        </table>
                                    </div>
                                    <div class="card-footer">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main content -->
    <section class="content">
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
<script src="../js/categoria.js"></script>
