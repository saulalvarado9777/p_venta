<?php
    session_start();
    if($_SESSION['us_tipo']==1 ) //si el usario es  administrador entra a la pagina del administrador
    {
      include_once 'layouts/header.php';
?>
  <title>Productos</title>
  <!-- Tell the browser to be responsive to screen width -->
  <?php
    include_once 'layouts/nav.php';
  ?>
<!-- modal crear reporte-->
<div class="modal fade" id="formatoreporte" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> <!--con el id del modal lo usamos el el boton para crear el producto-->
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="card card-success">
          <div class="card-header" style="background: #114358cc;">
              <h3 class="card-title">Elegir formato de reporte</h3>
              <button data-dismiss="modal" aria-label="close" class="close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="card-body">
                <div class="form-group text-center">
                    <button id="button-reporte" class="btn btn-outline-danger ml-2">Formato PDF <i class="far fa-file-pdf ml-2"></i> </button>
                    <button id="button-reporteExcel" class="btn btn-outline-success ml-2">Formato Excel <i class="far fa-file-excel ml-2"></i> </button>
                </div>
          </div>
      </div>
    </div>
  </div>
</div>
<!-- modal crear producto-->
<div class="modal fade" id="crearproducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> <!--con el id del modal lo usamos el el boton para crear el producto-->
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="card card-primary">
          <div class="card-header" style="background: #114358cc;">
              <h3 class="card-title">Crear producto</h3>
              <button data-dismiss="modal" aria-label="close" class="close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="card-body">
              <!--son los alert al momento de crear un nuevo producto-->
            <div class="alert alert-success text-center m-1" id="agregado" style="display:none;">
              <span><i class="fas fa-check m-1"> Se agrego correctamente</i></span>
            </div>
            <div class="alert alert-danger text-center m-1" id="noagregado" style="display:none;">
              <span><i class="fas fa-times m-1"> El producto ya existe</i></span>
             </div>
             <div class="alert alert-success text-center m-1" id="editado" style="display:none;">
              <span><i class="fas fa-check m-1"> El producto se edito correctamente</i></span>
             </div>
              <form id="form-crear-producto"><!-- id con el que identificamos el form para crear el producto--> 
                <div class="form-group">
                    <label for="codigo">Código</label>
                    <input id="codigo" type="text" class="form-control" placeholder="Ingresar nombre" required>
                </div>
                <div class="form-group">
                    <label for="nombre_producto">Nombre</label>
                    <input id="nombre_producto" type="text" class="form-control" placeholder="Ingresar nombre" required>
                </div>
                <div class="form-group">
                    <label for="inventario_min">Inventario mínimo</label>
                    <input id="inventario_min" type="number" class="form-control" placeholder="Ingresar inventario minímo">
                </div>
                <div class="form-group">
                    <label for="precio_in">Precio inicial</label>
                    <input id="precio_in" type="number" step="any" class="form-control" placeholder="Ingresar precio iniclal" required>
                </div>
                <div class="form-group">
                    <label for="precio_out">Precio venta</label>
                    <input id="precio_out" type="number" step="any" class="form-control" placeholder="Ingresar precio de venta" required>
                </div>
                <div class="form-group">
                    <label for="presentacion">Presentación</label>
                    <input id="presentacion" type="text"  class="form-control" placeholder="Ingresar presentación" required>
                </div>
                <div class="form-group">
                    <label for="unidad">Unidad</label>
                    <input id="unidad" type="text"  class="form-control" placeholder="Ingresar unidad" required>
                </div>
                <div class="form-group">
                    <label for="presentacion">Categoria</label>
                    <select name="categoria" id="categoria" class="form-control select2" style="width:100%"></select>
                </div>
                <input type="hidden" id="id_edit_producto">
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
            <h1>Productos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adm_catalogo.php">Home</a></li>
              <li class="breadcrumb-item active">Productos</li>
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
                  <button  type="button" id="button-crear" data-toggle="modal" data-target="#crearproducto" class="btn btn-outline-primary btn-sm m-1 mt-2 ml-3">Crear producto</button> 
                  <button  type="button" data-toggle="modal" data-target="#formatoreporte" class="btn btn-outline-secondary btn-sm m-1 mt-2">Reporte de productos</button> 
                  <input type="hidden" id="tipo_usuario" value="<?php echo $_SESSION['us_tipo'] ?>">
                </div>
                <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id='producto'>
                                <div class="card card-success">
                                    <div class="card-header" style="background: #114358cc;">
                                        <div class="card-title mt-2 mb-3">Buscar producto</div>
                                        <div class="input-group">
                                            <input id="buscar-producto" type="text" class="form-control float-left" placeholder="Ingrese nombre">
                                            <div class="input-group-append">
                                                <button class="btn btn-default"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                      <div id="productos" class="row d-flex align-items-stretch">
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
<script src="../js/productos.js"></script>