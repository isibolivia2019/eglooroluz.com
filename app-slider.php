<?php ini_set('display_errors', '1');?>
<aside id="left-sidebar-nav">
    <ul id="slide-out" class="side-nav fixed leftside-navigation">
        <li class="user-details cyan darken-2">
            <div class="row">
                <div class="col col s4 m4 l4">
                    <img src="public/images/avatar.jpg" alt="" class="circle responsive-img valign profile-image">
                </div>
                <div class="col col s8 m8 l8">
                    <ul id="profile-dropdown" class="dropdown-content">
                        <li><a href="#"><i class="mdi-action-face-unlock"></i> Perfil</a></li>
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="mdi-hardware-keyboard-tab"></i> Cerrar</a></li>
                    </ul>
                    <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown"><?php echo $_SESSION['personal'];?><i class="mdi-navigation-arrow-drop-down right"></i></a>
                    <p class="user-roal"><?php echo $_SESSION['cargo'];?></p>
                </div>
            </div>
        </li>
        <li class="no-padding">
            <ul class="collapsible collapsible-accordion">
                <li class="bold"><a href="inicio.php" class="waves-effect waves-cyan"><i class="mdi-action-home"></i>Inicio</a></li>
                <?php if($_SESSION['Permiso_Usuario'] == 1){?>
                    <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-editor-border-all"></i>Usuarios</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="usuario.php">Lista Habilitados</a></li>
                                <li><a href="usuario-deshabilitado.php">Lista Deshabilitados</a></li>
                                <li><a href="usuario-agregar.php">Agregar Nuevo Usuario</a></li>
                            </ul>
                        </div>
                    </li>
                <?php }?>
                <?php if($_SESSION['Permiso_Cargo'] == 1){?>
                    <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-editor-border-all"></i>Cargos</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="cargo.php">Lista de Cargos</a></li>
                                <li><a href="cargo-agregar.php">Agregar Nuevo Cargo</a></li>
                                <li><a href="cargo-asignar.php">Asignar Cargos</a></li>
                            </ul>
                        </div>
                    </li>
                <?php }?>
                <?php if($_SESSION['Permiso_Horario'] == 1){?>
                    <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-editor-border-all"></i>Horarios</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="horario.php">Lista de Horarios</a></li>
                                <li><a href="horario-agregar.php">Agregar Nuevo Horario</a></li>
                                <li><a href="horario-asignar.php">Asignar Horarios</a></li>
                                <li><a href="horario-registro.php">Registro de Horarios</a></li>
                            </ul>
                        </div>
                    </li>
                <?php }?>
                <?php if($_SESSION['Permiso_Sueldo'] == 1){?>
                    <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-editor-border-all"></i>Sueldos</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="sueldo.php">Lista de Sueldos</a></li>
                                <li><a href="sueldo-agregar.php">Agregar Nuevo Sueldo</a></li>
                                <li><a href="sueldo-asignar.php">Asignar Sueldos</a></li>
                            </ul>
                        </div>
                    </li>
                <?php }?>
                <?php if($_SESSION['Permiso_Sucursal'] == 1){?>
                    <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-editor-border-all"></i>Sucursales</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="sucursal.php">Lista de Sucursales</a></li>
                                <li><a href="sucursal-agregar.php">Agregar Nueva Sucursal</a></li>
                            </ul>
                        </div>
                    </li>
                <?php }?>
                <?php if($_SESSION['Permiso_Almacen'] == 1){?>
                    <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-editor-border-all"></i>Almacenes</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="almacen.php">Lista de Almacenes</a></li>
                                <li><a href="almacen-agregar.php">Agregar Almacen</a></li>
                            </ul>
                        </div>
                    </li>
                <?php }?>
                <?php if($_SESSION['Permiso_Producto'] == 1){?>
                    <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-editor-border-all"></i>Productos</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="producto.php">Lista de Productos</a></li>
                                <li><a href="producto-agregar.php">Agregar Producto</a></li>
                                <li><a href="producto-compra-registro.php">Productos Comprados</a></li>
                            </ul>
                        </div>
                    </li>
                <?php }?>
                <?php if($_SESSION['Permiso_Categoria'] == 1){?>
                    <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-editor-border-all"></i>Categorias</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="categoria.php">Lista de Categorias</a></li>
                                <li><a href="categoria-agregar.php">Agregar Nueva Categoria</a></li>
                                <li><a href="categoria-asignar.php">Asignar Categorias</a></li>
                            </ul>
                        </div>
                    </li>
                <?php }?>
                <?php if($_SESSION['Permiso_Descuento'] == 1){?>
                    <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-editor-border-all"></i>Descuentos</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="table-basic.html">Actuales Descuentos</a></li>
                                <li><a href="table-data.html">Lista Total Descuentos</a></li>
                                <li><a href="descuentos-agregar.html">Agregar Descuentos</a></li>
                                <li><a href="table-data.html">Agregar Varios </a></li>
                            </ul>
                        </div>
                    </li>
                <?php }?>
                <?php if($_SESSION['Permiso_Trasnferencia'] == 1){?>
                    <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-editor-border-all"></i>Transferencias</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="table-basic.html">Actuales Descuentos</a></li>
                            </ul>
                        </div>
                    </li>
                <?php }?>
                <?php if($_SESSION['Permiso_ProductoPerdido'] == 1){?>
                    <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-editor-border-all"></i>Productos Perdidos</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="table-basic.html">Inventario</a></li>
                                <li><a href="table-basic.html">Agregar</a></li>
                                <li><a href="table-basic.html">Registros</a></li>
                            </ul>
                        </div>
                    </li>
                <?php }?>
                <?php if($_SESSION['Permiso_Venta'] == 1){?>
                    <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-editor-border-all"></i>Ventas</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="table-basic.html">Listas</a></li>
                                <li><a href="table-basic.html">Ventas</a></li>
                            </ul>
                        </div>
                    </li>
                <?php }?>
                <?php if($_SESSION['Permiso_Venta'] == 1){?>
                    <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-editor-border-all"></i>Cotizaciones</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="table-basic.html">Cotizar Venta</a></li>
                            </ul>
                        </div>
                    </li>
                <?php }?>
                <?php if($_SESSION['Permiso_Reporte'] == 1){?>
                    <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-editor-border-all"></i>Reportes</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="table-basic.html">Compras</a></li>
                                <li><a href="table-basic.html">Ventas</a></li>
                                <li><a href="table-basic.html">Traspasos</a></li>
                                <li><a href="table-basic.html">Descuentos</a></li>
                                <li><a href="table-basic.html">Invenntario</a></li>
                                <li><a href="table-basic.html">Caja Chica</a></li>
                            </ul>
                        </div>
                    </li>
                <?php }?>
                <?php if($_SESSION['Permiso_Acceso'] == 1){?>
                    <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-editor-border-all"></i>Accesos</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="table-basic.html">Del Personal</a></li>
                                <li><a href="table-basic.html">Sucursal / Almacen</a></li>
                                <li><a href="table-basic.html">Listas</a></li>
                            </ul>
                        </div>
                    </li>
                <?php }?>
                <?php if($_SESSION['Permiso_CajaChica'] == 1){?>
                    <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-editor-border-all"></i>Caja Chica</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="table-basic.html">Lista de gastos</a></li>
                                <li><a href="table-basic.html">Agregar gastos</a></li>
                            </ul>
                        </div>
                    </li>
                <?php }?>
                <?php if($_SESSION['Permiso_Cliente'] == 1){?>
                    <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-editor-border-all"></i>Clientes</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="table-basic.html">Lista de Clientes</a></li>
                                <li><a href="table-basic.html">Agregar Cliente</a></li>
                            </ul>
                        </div>
                    </li>
                <?php }?>
                <?php if($_SESSION['Permiso_Configuracion'] == 1){?>
                    <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-editor-border-all"></i>Configuraciones</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="table-basic.html">Tipo de Cambio</a></li>
                                <li><a href="table-basic.html">Datos Empresa</a></li>
                                <li><a href="table-basic.html">Datos Facturacion</a></li>
                                <li><a href="table-basic.html">Prueba Certificacion</a></li>
                                <li><a href="table-basic.html">Eliminar Compra</a></li>
                                <li><a href="table-basic.html">Actualizar Cant Inven</a></li>
                                <li><a href="table-basic.html">Editar precios</a></li>
                            </ul>
                        </div>
                    </li>
                <?php }?>
                <li class="bold"><a href="logout.php" class="waves-effect waves-cyan"><i class="mdi-action-home"></i>Cerrar Sesion</a></li>
            </ul>
        </li>
        <li class="li-hover"><div class="divider"></div></li>
        <li class="li-hover"><p class="ultra-small margin more-text">Daily Sales</p></li>
        <li class="li-hover">
            <div class="row">
                <div class="col s12 m12 l12">
                    <div class="sample-chart-wrapper">                            
                        <div class="ct-chart ct-golden-section" id="ct2-chart"></div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
    <a href="" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only darken-2"><i class="mdi-navigation-menu" ></i></a>
</aside>
