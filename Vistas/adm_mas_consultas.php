<?php
    session_start();
    if($_SESSION['us_tipo']==1) //si el usario es  administrador entra a la pagina del administrador
    {
      include_once 'layouts/header.php';
?>
  <title>Ventas</title>
  <!-- Tell the browser to be responsive to screen width -->
  <?php
    include_once 'layouts/nav.php';
  ?>
  <!-- modal registro de ventas-->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Consultas</h1>
            <!--<input type="hidden" id="tipo_usuario" value="<?php echo $_SESSION['us_tipo'] ?>">-->
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adm_catalogo.php">Home</a></li>
              <li class="breadcrumb-item active">Consultas</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
  <section>
    <div class="card-body">
      <div class="tab-content">
        <div class="tab-pane active" id="producto">
            <div class="card card-success">
                    <div class="card-header" style="background: #114358cc;">
                        <h3 class="card-title">Consultas generales</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12"><!--ocupa toda la pantalla de ancho-->
                                <h2>Ventas por mes del año actual</h2>
                                <div class="chart-responsive">
                                    <canvas id="grafico1" style="min-height:250px; height:250px; max-height:250px; max-width:100%"></canvas>
                                </div>
                            </div>
                            <div class="col-md-12"><!--ocupa toda la pantalla de ancho-->
                                <h2>Mejores vendedores</h2>
                                <div class="chart-responsive">
                                    <canvas id="grafico2" style="min-height:250px; height:250px; max-height:250px; max-width:100%"></canvas>
                                </div>
                            </div>
                            <div class="col-md-12"><!--ocupa toda la pantalla de ancho-->
                                <h2>Productos más vendidos en el mes</h2>
                                <div class="chart-responsive">
                                    <canvas id="grafico4" style="min-height:250px; height:250px; max-height:250px; max-width:100%"></canvas>
                                </div>
                            </div>
                            <div class="col-md-12"><!--ocupa toda la pantalla de ancho-->
                                <h2>Mejores clientes</h2>
                                <div class="chart-responsive">
                                    <canvas id="grafico5" style="min-height:250px; height:250px; max-height:250px; max-width:100%"></canvas>
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
<script src="../js/chart.min.js"></script>
<script src="../js/mas_consultas.js"></script>