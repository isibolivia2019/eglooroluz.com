<?php ini_set('display_errors', '1');?>
<aside id="left-sidebar-nav">
    <ul id="slide-out" class="side-nav fixed leftside-navigation">
        <li class="user-details cyan darken-2">
            <div class="row">
                <div class="col col s4 m4 l4">
                    <img src="public/imagenes/usuarios/sin_imagen_usuario.jpg" alt="" class="circle responsive-img valign profile-image">
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
                <?php /*if($_SESSION['Permiso_Usuario'] == 1){?>
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
                                <li><a href="registro-horario.php">Registro de Horarios</a></li>
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
                                <li><a href="sueldo-planilla.php">Planilla de Sueldos</a></li>
                            </ul>
                        </div>
                    </li>
                <?php }*/?>
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
                                <li><a href="producto-compra-registro.php">Registro de Compras</a></li>
                            </ul>
                        </div>
                    </li>
                <?php }?>
                <?php if($_SESSION['Permiso_Categoria'] == 1){?>
                    <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-editor-border-all"></i>Categorias</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="categoria.php">Lista de Categorias</a></li>
                                <li><a href="categoria-agregar.php">Agregar Categoria</a></li>
                                <li><a href="categoria-asignar.php">Asignar Categorias</a></li>
                            </ul>
                        </div>
                    </li>
                <?php }?>
                <?php if($_SESSION['Permiso_Descuento'] == 1){?>
                    <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-editor-border-all"></i>Descuentos</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="descuento.php">Actuales Descuentos</a></li>
                                <li><a href="descuento-total.php">Lista Total Descuentos</a></li>
                                <li><a href="descuento-agregar.php">Agregar Descuentos</a></li>
                            </ul>
                        </div>
                    </li>
                <?php }?>
                <?php if($_SESSION['Permiso_Trasnferencia'] == 1){?>
                    <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-editor-border-all"></i>Transferencias</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="transferencia.php">Transferir Producto</a></li>
                                <li><a href="transferencia-lista.php">Lista de Transferencias</a></li>
                            </ul>
                        </div>
                    </li>
                <?php }?>
                <?php if($_SESSION['Permiso_ProductoPerdido'] == 1){?>
                    <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-editor-border-all"></i>Productos Perdidos</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="producto-perdido.php">Inventario</a></li>
                                <li><a href="producto-perdido-agregar.php">Agregar</a></li>
                                <li><a href="producto-perdido-registro.php">Registros</a></li>
                            </ul>
                        </div>
                    </li>
                <?php }?>
                <?php if($_SESSION['Permiso_Venta'] == 1){?>
                    <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-editor-border-all"></i>Ventas</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="venta-lista.php">Listas</a></li>
                                <li><a href="venta.php">Ventas</a></li>
                            </ul>
                        </div>
                    </li>
                <?php }?>
                <?php if($_SESSION['Permiso_Venta'] == 1){?>
                    <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-editor-border-all"></i>Cotizaciones</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="cotizacion.php">Cotizar Venta</a></li>
                            </ul>
                        </div>
                    </li>
                <?php }?>
                <?php if($_SESSION['Permiso_Reporte'] == 1){?>
                    <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-editor-border-all"></i>Reportes</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="reporte-caja-chica.php">Caja Chica</a></li>
                                <li><a href="reporte-compra.php">Compras</a></li>
                                <li><a href="reporte-venta.php">Ventas</a></li>
                                <li><a href="reporte-traspaso.php">Traspasos</a></li>
                                <li><a href="reporte-descuento">Descuentos</a></li>
                                <li><a href="reporte-inventario.php">Inventario</a></li>
                                <li><a href="reporte-perdido.php">Productos Perdidos</a></li>
                                <li><a href="reporte-horario.php">Horarios</a></li>
                            </ul>
                        </div>
                    </li>
                <?php }?>
                <?php if($_SESSION['Permiso_CajaChica'] == 1){?>
                    <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-editor-border-all"></i>Caja Chica</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="caja-chica.php">Lista de gastos</a></li>
                                <li><a href="caja-chica-agregar.php">Agregar gastos</a></li>
                            </ul>
                        </div>
                    </li>
                <?php }?>
                <?php if($_SESSION['Permiso_Acceso'] == 1){?>
                    <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-editor-border-all"></i>Accesos</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="verificacion-1.php">Del Personal</a></li>
                                <li><a href="acceso-sucursal.php">a Sucursal</a></li>
                                <li><a href="acceso-almacen.php">a Almacen</a></li>
                                <li><a href="verificacion-1.php">Listas</a></li>
                            </ul>
                        </div>
                    </li>
                <?php }?>
                <?php if($_SESSION['Permiso_Cliente'] == 1){?>
                    <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-editor-border-all"></i>Clientes</a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="cliente-email.php">Correos Electronicos</a></li>
                                <?php //<li><a href="verificacion-1.php">Agregar Cliente</a></li>?>
                            </ul>
                        </div>
                    </li>
                <?php }?>
                <?php if($_SESSION['Permiso_Configuracion'] == 1){?>
                    <li class="bold"><a class="collapsible-header  waves-effect waves-cyan"><i class="mdi-editor-border-all"></i>Configuraciones</a>
                        <div class="collapsible-body">
                            <ul>
                                <?php //<li><a href="verificacion-1.php">Tipo de Cambio</a></li>?>
                                <?php //<li><a href="verificacion-1.php">Datos Empresa</a></li>?>
                                <?php //<li><a href="verificacion-1.php">Datos Facturacion</a></li>?>
                                <?php //<li><a href="verificacion-1.php">Prueba Certificacion</a></li>?>
                                <?php //<li><a href="verificacion-1.php">Eliminar Compra</a></li>?>
                                <li><a href="editar-cantidad.php">Cantidad Inventario</a></li>
                                <li><a href="editar-precio.php">Editar precios</a></li>
                            </ul>
                        </div>
                    </li>
                <?php }?>
                <li class="bold"><a href="mis-horarios.php" class="waves-effect waves-cyan"><i class="mdi-editor-border-all"></i>Mis Horarios</a></li>
                <li class="bold"><a href="logout.php" class="waves-effect waves-cyan"><i class="mdi-action-home"></i>Cerrar Sesion</a></li>
            </ul>
        </li>
        <li class="li-hover"><div class="divider"></div></li>
    </ul>
    <a href="" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only darken-2"><i class="mdi-navigation-menu" ></i></a>
</aside>
