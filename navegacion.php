    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="btn btn-primary btn-sm ml-4" href="salir.php">Cerrar sesión</a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="admin.php" class="brand-link">
            <img src="dist/img/logo.jpeg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light"><b>Pop'n Joy v 0.1</b></span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            
            <!-- Sidebar Menu -->
            <nav class="mt-2">

                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                    <!-- SUCURSALES -->
                    <li class="nav-item">
                        <a href="sucursal.php" class="nav-link">
                            <i class="nav-icon fas fa-hotel"></i>
                            <p>
                                EMPRESA
                            </p>
                        </a>
                    </li>

                    <!-- CLIENTES -->
                    <li class="nav-item">
                        <a href="clientes.php" class="nav-link">
                            <i class="nav-icon fas fa-id-badge"></i>
                            <p>
                                CLIENTES
                            </p>
                        </a>
                    </li>

                    <!-- CATEGORIAS -->
                    <li class="nav-item">
                        <a href="categorias.php" class="nav-link">
                            <i class="nav-icon fab fa-cuttlefish"></i>
                            <p>
                                CATEGORIAS
                            </p>
                        </a>
                    </li>

                    <!-- PRODUCTOS -->
                    <li class="nav-item">
                        <a href="productos.php" class="nav-link">
                            <i class="nav-icon fab fa-product-hunt"></i>
                            <p>
                                PRODUCTOS
                            </p>
                        </a>
                    </li>

                     <!-- VENTAS -->
                    <li class="nav-item has-treeview menu-close">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-money-check-alt"></i>
                            <p>
                                VENTAS
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="ventas.php" class="nav-link">
                                <i class="fas fa-minus-3x nav-icon"></i>
                                <p>Vender Productos</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="historial_ventas.php" class="nav-link">
                                <i class="fas fa-minus-3x nav-icon"></i>
                                <p>Historial de ventas</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="historial_cierres.php" class="nav-link">
                                <i class="fas fa-minus-3x nav-icon"></i>
                                <p>Historial de cierres</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- CIERRE DE DIA -->
                    <li class="nav-item">
                        <a href="cierre_dia.php" class="nav-link">
                            <i class="nav-icon fas fa-hand-holding-usd"></i>
                            <p>
                                CIERRE DE DIA
                            </p>
                        </a>
                    </li>

                </ul>

            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>