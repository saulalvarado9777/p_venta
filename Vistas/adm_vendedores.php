<?php
  include_once 'layouts/header.php';/*falta condiconal para la sesión */
?>
<title>Administrador</title>
<?php
  include_once 'layouts/nav.php';
  session_start();
  if($_SESSION['us_tipo']==2)
  {
?>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Catalogo</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Catalogo</li>
            </ol>
          </div>
        </div>
    </div><!-- /.container-fluid -->
  </section>
  <section>
    <div class="card-body">
      <div class="tab-content">
        <div class="tab-pane active" id="producto">
          <div class="card" id="buscar">
                <div class="card-header">
                  <h3 class="card-title">Buscar producto</h3>
                  <div class="input-group">
                    <input type="text" placeholder="Ingresa nombre del producto" class="form-control float-left">
                    <div class="input-group-apped">
                      <button class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div>
          </div>
          <div class="card-body p-0 table-responsive">
            <table class="table table-over text-nowrap">
              <thead class="table" id="tabla_buscar">
                <tr>
                  <th>Código</th>
                  <th>Producto</th>
                  <th>Stock</th>
                  <th>Precio</th>
                  <th>Acción</th>
                </tr>
              </thead>
              <tbody class="table active" id="productos"></tbody>
            </table>
          </div>
          <div class="card-footer">
          <!--Aqui va el footer-->
          </div>
        </div>  
      </div>
    </div>
  </section>
</div>
<?php
include_once 'layouts/footer.php';
  }
    else
    {
        header('Location: ../index.php');
    }
?>