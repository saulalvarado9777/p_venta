<?php
    session_start();
    if($_SESSION['us_tipo']==1 || $_SESSION['us_tipo']==2) //si el usario es  administrador entra a la pagina del administrador
    {//a esta vista tienen acceoso tanto loas administradores como los vendedores 
      include_once 'layouts/header.php';
?>
  <title>Ventas</title>
  <!-- Tell the browser to be responsive to screen width -->
  <?php
    include_once 'layouts/nav.php';

  ?>}

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h1 class="">Venta</h1>
                <button id="actualizar" class="btn btn-outline-success ml-2">Actualizar</button>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="adm_catalogo.php">Home</a></li>
                  <li class="breadcrumb-item active">Venta:</li><label id="id_venta">1</label>
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>
    <section><!--plantilla compra-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="background: #eeeeee;">
                    <header>
                        <div class="container mt-1 mb-1">
                                <div class="row aling-items-start">
                                    <div class="col">
                                        <p class="titulo_cp ">Vendedor: <?php echo $_SESSION["nombre_us"];?></p>
                                    </div>
                                    <span class="titulo_cp1">Cliente: </span>
                                    <div class="col">
                                        <select id="cliente_select" class="form-control select2" style="width:100%;"></select>
                                    </div>
                                </div>
                        </div>
                    </header>
                    <div class="card-body p-0">
                        <div id="cp"class="card-body p-0" style="background:#eeeeee">
                            <div class="card-header" >
                                <div class="card-title" style="margin-top:-25px;">Buscar producto</div>
                                    <div class="input-group m-0">
                                        <input id="buscar-producto" type="text" class="form-control float-left" placeholder="Ingrese nombre">
                                        <div class="input-group-append">
                                            <button class="btn btn-default"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                            </div>
                            <div class="card-body">
                                <div id="productos" class="row d-flex align-items-stretch"><!--Aqui se coloca el card de carrito buscar los productos-->
                                </div>
                            </div>
                            <table id="compras" class="compra table table-hover text-nowrap" style="margin-top:-25px;">
                                <thead class='table-success' >
                                    <tr>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Stock</th>
                                        <th scope="col">Precio</th>
                                        <th scope="col">Presentación</th>
                                        <th scope="col">Unidad</th>
                                        <th scope="col">Categoria</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col">Sub Total</th>
                                        <th scope="col">Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody id="lista-compra" class='table-active'><!--este tbody le pertenece a los registros que se van ir agrgando a la compra-->
                                    
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card card-default">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                            <i class="fas fa-dollar-sign"></i>
                                            Calculo 1
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="info-box mb-3 bg-gradient-info shadow-sm">
                                                <span class="info-box-icon"><i class="ion ion-ios-cart-outline"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-left ">SUBTOTAL</span>
                                                    <span class="info-box-number" id="subtotal">12</span>
                                                </div>
                                            </div>
                                            <div class="info-box mb-3 bg-gradient-info shadow-sm">
                                                <span class="info-box-icon"><i class="ion ion-ios-cart-outline"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-left ">IVA</span>
                                                    <span class="info-box-number" id="con_igv">12</span>
                                                </div>
                                            </div>
                                            <div class="info-box mb-3 bg-gradient-info shadow-sm">
                                                <span class="info-box-icon"><i class="ion ion-ios-cart-outline"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-left ">SIN DESCUENTO</span>
                                                    <span class="info-box-number" id="total_sin_descuento">12</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card card-default">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                            <i class="fas fa-bullhorn"></i>
                                            Calculo 2
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="info-box bg-gradient-danger"  style="margin-top: -20px;">
                                                <span class="info-box-icon"><i class="fas fa-comment-dollar"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-left mb-1">DESCUENTO</span>
                                                    <input id="descuento"type="number" min="1" placeholder="Ingrese descuento" class="form-control">
                                                </div>
                                            </div>
                                            <div class="info-box mb-3 bg-gradient-info shadow-sm">
                                                <span class="info-box-icon"><i class="ion ion-ios-cart-outline"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-left ">TOTAL</span>
                                                    <span class="info-box-number" id="total">12</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card card-default">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                            <i class="fas fa-cash-register"></i>
                                            Cambio
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                        <div class="info-box mb-3 bg-gradient-success shadow-sm">
                                            <span class="info-box-icon"><i class="fas fa-money-bill-alt"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text text-left mb-1 ">INGRESO</span>
                                                <input type="number" id="pago" min="1" placeholder="Ingresa Dinero" class="form-control">
                                            </div>
                                        </div>
                                        <div class="info-box mb-3 bg-gradient-info shadow-sm">
                                            <span class="info-box-icon"><i class="fas fa-money-bill-wave"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text text-left ">VUELTO</span>
                                                <span class="info-box-number" id="cambio">3</span>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-md-4 mb-2">
                                <button id="imp" class="btn btn-outline-secondary"><i class="fas fa-print"></i></button>
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <a  id="procesar-compra" href="#"  class="btn btn-outline-success btn-block">Realizar compra</a>
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
<?php
include_once 'layouts/footer.php';
    }
    else
    {
        header('Location: ../index.php');
    }
?>
<script src="../js/carrito.js"></script>
<script src="../js/catalogo.js"></script>

