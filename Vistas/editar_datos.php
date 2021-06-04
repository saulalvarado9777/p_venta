<?php
    session_start();
    if($_SESSION['us_tipo']==1)
    {
      include_once 'layouts/header.php';
?>
  <title>Editar_Datos</title>
  <!-- Tell the browser to be responsive to screen width -->
  <?php
    include_once 'layouts/nav.php';
  ?>
<!-- Modal para cambiar contraseña -->
<div class="modal fade" id="cambiocontra" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header alert-success" style="background:#114358cc">
        <h5 class="modal-title" id="exampleModalLabel">Cambiar contraseña</h5>
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
          <div class="alert alert-success text-center m-1" id="update" style="display:none;">
            <span><i class="fas fa-check"> Se cambio la contraseña correctamente</i></span>
          </div>
          <div class="alert alert-danger text-center m-1" id="noupdate" style="display:none;">
            <span><i class="fas fa-times"> La contraseña no es correcta</i></span>
          </div>
          <form id="form-pass">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-unlock-alt"></i></span>
                </div>
                <input id="oldpass"  type="password" class="form-control" placeholder="Ingrese contraseña actual">
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-lock"></i></span>
                </div>
                <input id="newpass"  type="password" class="form-control" placeholder="Ingrese contraseña nueva">
              </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-outline-primary">Guardar cambios</button>
        </form>
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
            <h1>Datos personales</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adm_catalogo.php">Home</a></li><!--Se rediriga a la vista de catalogo-->
              <li class="breadcrumb-item active ">Datos personales</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section>
          <div class="content" style="margin-top:-2 0px">
            <div class="container-fluid">
                <div class="row">   
                    <div class="col-md-3">
                        <div class="card card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img src="../img/avatar5.png" class="profile-user-img img-fluid img-circle">
                                </div>
                                <input id="id_usuario" type="hidden" value="<?php echo $_SESSION['usuario']?>">
                                <h3 id="nombre" class="profile-username text-center" style="color:#114358cc">Nombre</h3>
                                <p id="apellido_pat" class="text-muted text-center" style="color:#114358cc">Apellido paterno</p>
                                <p id="apellido_mat" class="text-muted text-center" style="color:#114358cc">Apellido materno</p>
                                <ul class="list-group list-group-unbordered" >
                                    <li class="list-group-item">
                                        <b style="color:#114358cc">Nombre usuario</b><a id="nombre_usuario" class="float-right">12</a>  
                                    </li>
                                    <li class="list-group-item">
                                        <b style="color:#114358cc">Tipo usuario</b>  
                                        <span id="is_admin" class="float-right badge">Administrador</span>
                                    </li>
                                    <button type="button" class="btn btn-block btn-outline-primary btn-sm" data-toggle="modal" data-target="#cambiocontra" >Cambiar contraseña</button>
                                </ul>
                            </div>
                        </div>
                        <div class="card card-success">
                            <div class="card-header" style="background:#114358cc;">
                                <h3 class="card-title">Sobre mi</h3>
                            </div>
                            <div class="card-body">
                                <strong style="color:#114358cc;">
                                    <i class="fas fa-at mr-1"> Correo</i>
                                </strong>
                                <p id="email" class="text-muted">7222545861</p>
                                <button class="edit btn btn-block btn-outline-primary btn-sm" >Editar</button>
                            </div>
                            <div class="card-footer">
                                <p class="text-muted">Click en el boton si desea editar</p>
                            </div> 
                        </div>    
                    </div>
                    <div class="col-md-9">
                        <div class="card card-success">
                            <div class="card-header" style="background:#114358cc;">
                                <h3 class="card-title">Editar datos personales</h3>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-success text-center m-1" id="editado" style="display:none;">
                                <span><i class="fas fa-check"> Editado</i></span>
                                </div>
                                <div class="alert alert-danger text-center m-1" id="noeditado" style="display:none;">
                                <span><i class="fas fa-times"> Presione boton editar</i></span>
                                </div>
                                <form id='form-usuario' class="form-horizontal">
                                    <div class="form-group row">
                                        <label for="correo" class="col-sm-2 col-form-label">Correo</label>
                                        <div class="col-sm-10">
                                            <input type="text" id="correo" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10 float-right">
                                            <button class="btn btn-block btn-outline-primary">Guardar</button> 
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <p class="text-muted">Verificar datos antes de guardar</p>
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
<script src="../js/usuario.js"></script>