<?php
    session_start();
    if($_SESSION['us_tipo']==1 ) //si el usario es  administrador entra a la pagina del administrador
    {
      include_once 'layouts/header.php';
?>
  <title>Editar</title>
  <!-- Tell the browser to be responsive to screen width -->
  <?php
    include_once 'layouts/nav.php';
  ?>
<!-- modal crear cliente-->
<div class="modal fade" id="crearcliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="card card-primary">
          <div class="card-header" style="background: #114358cc;">
              <h3 class="card-title">Crear cliente</h3>
              <button data-dismiss="modal" aria-label="close" class="close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="card-body"> <!--alert que se agrego correctamente el registro-->
            <div class="alert alert-success text-center m-1" id="agregado" style="display:none;">
              <span><i class="fas fa-check m-1"> Se agrego correctamente</i></span>
            </div>
            <div class="alert alert-danger text-center m-1" id="noagregado" style="display:none;"><!--alert que 
            no agrego correctamente el registro-->
              <span><i class="fas fa-times m-1"> El cliente ya existe</i></span>
             </div>
              <form id="form-crear"> 
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input id="nombre" type="text" class="form-control" placeholder="Ingresar nombre" required>
                </div>
                <div class="form-group">
                    <label for="correo">Correo</label>
                    <input id="correo" type="text" class="form-control" placeholder="Ingresar correo">
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input id="telefono" type="number" class="form-control" placeholder="Ingresar teléfono" required>
                </div>
                <input type="hidden" id="id_edit_cli">
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
<!-- modal editar cliente-->
<div class="modal fade" id="editarcliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="card card-primary">
          <div class="card-header" style="background: #114358cc;">
              <h3 class="card-title">Editar cliente</h3>
              <button data-dismiss="modal" aria-label="close" class="close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="card-body"> <!--alert que se agrego correctamente el registro-->
            <div class="alert alert-success text-center m-1" id="editado" style="display:none;">
              <span><i class="fas fa-check m-1"> Se edito correctamente</i></span>
            </div>
            <div class="alert alert-danger text-center m-1" id="noeditado" style="display:none;"><!--alert que 
            no agrego correctamente el registro-->
              <span><i class="fas fa-times m-1">No se pudo editar</i></span>
             </div>
              <form id="form-editar"> 
                <div class="form-group">
                    <label for="correo_edit">Correo</label>
                    <input id="correo_edit" type="text" class="form-control" placeholder="Ingresar correo">
                </div>
                <div class="form-group">
                    <label for="telefono_edit">Teléfono</label>
                    <input id="telefono_edit" type="number" class="form-control" placeholder="Ingresar teléfono" required>
                </div>
                <input type="hidden" id="id_cliente">
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
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Proveedores</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adm_catalogo.php">Home</a></li>
              <li class="breadcrumb-item active">Clientes</li>
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
                    <button  type="button" id="button-crear" data-toggle="modal" data-target="#crearcliente" class="btn btn-outline-primary btn-sm m-1 mt-2">Crear cliente</button> 
                    <input type="hidden" id="tipo_usuario" value="<?php echo $_SESSION['us_tipo'] ?>">
                  </div>
                  <div class="card-body">
                          <div class="tab-content">
                              <div class="tab-pane active" id='cliente'>
                                  <div class="card card-success">
                                      <div class="card-header" style="background: #114358cc;">
                                          <div class="card-title mt-2 mb-3">Buscar cliente</div>
                                          <div class="input-group">
                                              <input id="buscar_cliente" type="text" class="form-control float-left" placeholder="Ingrese nombre de cliente">
                                              <div class="input-group-append">
                                                  <button class="btn btn-default"><i class="fas fa-search"></i></button>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="card-bod">
                                        <div id="clientes" class="row d-flex align-items-stretch">

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
<script src="../js/cliente.js"></script>