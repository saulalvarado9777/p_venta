<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- select2" -->
<link rel="icon" href="../img/logo.jpeg" type="image/jpeg">
<link rel="stylesheet" href="../css/select2.css">
<link rel="stylesheet" href="../css/main.css">
<link rel="stylesheet" href="../css/nav.css">
<link rel="stylesheet" href="../css/catalogo.css">

<!-- css compra -->
<link rel="stylesheet" href="../css/compra.css">
<!-- sweetalert-->
  <link rel="stylesheet" href="../css/sweetalert2.css">
<!-- sweetalert-->
  <link rel="stylesheet" href="../css/datatables.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../css/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../../index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
      <li class="nav-item dropdown" id="carrito" style="display:none;"><!--aqui es el id para la clase de carrito-->
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-shopping-cart" aria-hidden="true">
            <span id="contador"></span>
          </i>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <table class="carro table table-hover text-nowrap p-0"><!--con esta clase hacemos el css elnombre del css es main-->
            <thead class="table-success">
              <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Eliminar</th>
              </tr>
            </thead>
            <tbody id="lista">
            </tbody>
          </table>
          <a href="#" id="procesar-pedido" class="btn btn-outline-success btn-block">Comprar</a>
          <a href="#" id="vaciar" class="btn btn-outline-danger btn-block">Eliminar</a>
        </div>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <a href="../controlador/logout.php">Cerrar sesion</a>
    </ul>
  </nav>
  <!-- /.navbar -->
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" id="nav">
    <!-- Brand Logo -->
    <a href="adm_catalogo.php" class="brand-link">
      <img src="../img/logo.jpeg"  
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: 1.0">
      <span class="brand-text font-weight-light animate__animated animate__bounce">Ventas</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../img/avatar5.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">
              <?php
                echo $_SESSION['nombre_us']; /* para mostrar el nombre del usuario que inicio sesión */
              ?>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li id="usuarios_h" class="nav-header">Usuarios</li>
          <li id="datos_personales" class="nav-item">
            <a href="editar_datos.php" class="nav-link">
              <i class="nav-icon fas fa-user-cog"></i>
              <p>
                Datos personales
              </p>
            </a>
          </li>
          <li id="usuario"  class="nav-item">
            <a href="adm_usuarios.php" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Usuarios
              </p>
            </a>
          </li>
          <li class="nav-header">Ventas</li>
          <li class="nav-item">
            <a href="adm_venta.php" class="nav-link">
              <i class="nav-icon fas fa-notes-medical"></i>
              <p>
                Lista de ventas
              </p>
            </a>
          </li>
        </ul>
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li id="almacen_h" class="nav-header">Almacen</li>
          <li id="prod" class="nav-item">
            <a href="adm_productos.php" class="nav-link">
              <i class="nav-icon fab fa-product-hunt"></i>
              <p>
                Productos
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a id="sto" href="adm_stock.php" class="nav-link">
              <i class="nav-icon fas fa-cubes"></i>
              <p>
                Stock
              </p>
            </a>
          </li>
          <li  class="nav-item">
            <a href="adm_categorias.php" class="nav-link">
              <i id="cat" class="nav-icon fas fa-folder-open"></i>
              <p>
                Categorias
              </p>
            </a>
          </li>
          <li id="compras_h" class="nav-header">Compras</li>
          <li id="prov" class="nav-item">
            <a href="adm_proveedor.php" class="nav-link">
              <i class="nav-icon fas fa-truck"></i>
              <p>
                Proveedores
              </p>
            </a>
          </li>
          <li id="clie" class="nav-item">
            <a href="adm_clientes.php" class="nav-link">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                Clientes
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>