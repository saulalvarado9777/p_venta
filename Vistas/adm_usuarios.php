<?php
    session_start();
    if($_SESSION['us_tipo']==1) //si el usario es  administrador entra a la pagina del administrador
    {
      include_once 'layouts/header.php';
?>
  <title>Editar</title>
  <!-- Tell the browser to be responsive to screen width -->
  <?php
    include_once 'layouts/nav.php';
  ?>
<!-- Modal para confirmar acción de eliminar  -->
<div class="modal fade" id="confirmar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header alert-success" style="background:#114358cc">
        <h5 class="modal-title" id="exampleModalLabel">Confirmar acción</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="text-center">
              <img src="../img/avatar5.png" class="profile-user-img img-fluid img-circle">
          </div>
          <div class="text-center">
              <b>
                  <?php
                    echo $_SESSION['nombre_us'];
                  ?>
              </b>
          </div>
          <span> Ingresar contraseña para confirmar </span>
          <div class="alert alert-success text-center m-1" id="confirmado" style="display:none;">
            <span><i class="fas fa-check"> Se elimino el usuario correctamente</i></span>
          </div>
          <div class="alert alert-danger text-center m-1" id="rechazado" style="display:none;">
            <span><i class="fas fa-times"> La contraseña no es correcta</i></span>
          </div>
          <form id="form-confirmar">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-unlock-alt"></i></span>
              </div>
               <input id="oldpass"  type="password" class="form-control" placeholder="Ingrese contraseña actual">
               <input type="hidden" id="id_user">
               <input type="hidden" id="funcion">
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-outline-danger">Eliminar</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- modal crear usuario-->
<div class="modal fade" id="crearusuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="card card-success">
          <div class="card-header" style="background: #114358cc;">
              <h3 class="card-title">Crear usuario</h3>
              <button data-dismiss="modal" aria-label="close" class="close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="card-body">
            <div class="alert alert-success text-center m-1" id="agregado" style="display:none;">
              <span><i class="fas fa-check m-1"> Se agrego correctamente</i></span>
            </div>
            <div class="alert alert-danger text-center m-1" id="noagregado" style="display:none;">
              <span><i class="fas fa-times m-1"> El usuario ya existe</i></span>
            </div>
              <form id="form-crear"> 
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input id="nombre" type="text" class="form-control" placeholder="Ingresar nombre" required>
                </div>
                <div class="form-group">
                    <label for="apellido_pat">Apellido Paterno</label>
                    <input id="apellido_pat" type="text" class="form-control" placeholder="Ingresar apellido paterno" required>
                </div>
                <div class="form-group">
                    <label for="apellido_mat">Apellido Materno</label>
                    <input id="apellido_mat" type="text" class="form-control" placeholder="Ingresar apellido materno" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="text" class="form-control" placeholder="Ingresar email" required>
                </div>
                <div class="form-group">
                    <label for="nombre_usuario">Nombre usuario</label>
                    <input id="nombre_usuario" type="text" class="form-control" placeholder="Ingresar nombre de usuario" required>
                </div>
                <div class="form-group">
                    <label for="contrasena">Contraseña</label>
                    <input id="contrasena" type="password" class="form-control" placeholder="Ingresar contraseña" required>
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
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Usuarios</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adm_catalogo.php">Home</a></li>
              <li class="breadcrumb-item active">Usuarios</li>
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
                  <button  type="button" id="button-crear" data-toggle="modal" data-target="#crearusuario" class="btn btn-outline-primary btn-sm m-1 mt-2" > Crear usuario</button> 
                  <input type="hidden" id="tipo_usuario" value="<?php echo $_SESSION['us_tipo'] ?>">
                </div>
                <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id='usuario'>
                                <div class="card card-success">
                                    <div class="card-header" style="background: #114358cc;">
                                        <div class="card-title mt-2 mb-3">Buscar usuarios</div>
                                        <div class="input-group">
                                            <input id="buscar" type="text" class="form-control float-left" placeholder="Ingrese nombre">
                                            <div class="input-group-append">
                                                <button class="btn btn-default"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                      <div id="usuarios" class="row d-flex align-items-stretch">
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
<script src="../js/gestion_usuario.js"></script>