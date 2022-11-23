<?php
session_start();

if (!isset($_SESSION['IdUsuario'])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
    if ($_SESSION["Permisos"][27]["ver"] == 1) {
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <?php include('./layout/head.php'); ?>

        </head>

        <body class="hold-transition skin-blue sidebar-mini">
            <div class="wrapper">

                <!-- start header -->
                <?php include('./layout/header.php') ?>
                <!-- end header -->
                <!-- start menu -->
                <?php include('./layout/menu.php') ?>
                <!-- end menu -->

                <!-- modal añadir  -->
                <div class="row">
                    <div class="modal fade" id="mdEmpleo" data-keyboard="false" data-backdrop="static">
                        <div class="modal-dialog modal-xs" style="width: 500px;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" id="btnCloseModal">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title" id="titleModal">
                                        <i class="fa fa-address-card">
                                        </i> Nueva Mensaje
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtTitulo" class="col-sm-4 control-label">Titulo <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <div class="col-sm-8">
                                                    <input id="txtTitulo" type="text" class="form-control" placeholder="Ingrese el titulo" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-top: 0.5em;">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtDescripcion" class="col-sm-4 control-label">Descripción <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <div class="col-sm-8">
                                                    <textarea id="txtDescripcion" type="text" class="form-control" placeholder="Ingrese la descripción" required=""></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-top: 0.5em;">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtEmpresa" class="col-sm-4 control-label">Empresa <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <div class="col-sm-8">
                                                    <input id="txtEmpresa" type="text" class="form-control" placeholder="Ingrese el nombre de la empresa" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-top: 0.5em;">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtCelular" class="col-sm-4 control-label">Celular <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <div class="col-sm-8">
                                                    <input id="txtCelular" type="number" class="form-control" placeholder="Ingrese el número de celular" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-top: 0.5em;">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtTelefono" class="col-sm-4 control-label">Telefono</label>
                                                <div class="col-sm-8">
                                                    <input id="txtTelefono" type="number" class="form-control" placeholder="Ingrese el número de telefono">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-top: 0.5em;">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtCorreo" class="col-sm-4 control-label">Correo</label>
                                                <div class="col-sm-8">
                                                    <input id="txtCorreo" type="email" class="form-control" placeholder="Ingrese el correo">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-top: 0.5em;">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtDireccion" class="col-sm-4 control-label">Dirección</label>
                                                <div class="col-sm-8">
                                                    <input id="txtDireccion" type="text" class="form-control" placeholder="Ingrese la dirección">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-top: 0.5em;">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtDireccion" class="col-sm-4 control-label">Estado</label>
                                                <div class="col-sm-8">
                                                    <div class="checkbox">
                                                        <label for="cbEstado">
                                                            <input type="checkbox" id="cbEstado" checked>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" id="btnAceptar">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" id="cancel-modal">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end modal añadir -->

                <!-- modal eliminar  -->
                <div class="row">
                    <div class="modal fade" id="mdDeleteEmpleo">
                        <div class="modal-dialog modal-xs" style="width: 500px;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" onclick="closeModalDelete()">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-address-card">
                                        </i> Eliminar Mensaje
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">¿Estas seguro que deseas elimininar esta oferta laboral?</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-warning" id="btnDeleteEmpleo">
                                            <i class="fa fa-check"></i> Aceptar</button>
                                        <button type="button" class="btn btn-primary" onclick="closeModalDelete()">
                                            <i class="fa fa-remove"></i> Cancelar</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end modal eliminar  -->
                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper" style="background-color: #FFFFFF;">
                    <!-- Main content -->
                    <section class="content-header">
                        <h3 class="no-margin"> Mensajes (App) <small> Lista </small> </h3>
                    </section>

                    <section class="content">

                        <div class="row">                
                            <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <label>Nueva oferta.</label>
                                <div class="form-group">
                                    <button type="button" class="btn btn-success" id="btnNuevo">
                                        <i class="fa fa-paper-plane"></i> Crear Mensaje
                                    </button>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <label>Opción.</label>
                                <div class="form-group">
                                    <button class="btn btn-default" id="btnactualizar">
                                        <i class="fa fa-refresh"></i> Recargar
                                    </button>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label>Filtrar por titulo o descripcíon.</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="search" id="buscar" class="form-control" placeholder="Buscar por titulo o descripcíon" aria-describedby="search" value="">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-primary" id="btnSearch">Buscar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="table-responsive">
                                    <table class="table table-striped" style="border-width: 1px;border-style: dashed;border-color: #E31E25;">
                                        <thead style="background-color: #FDB2B1;color: #B72928;">
                                            <th width="5%" class="text-center">#</th>
                                            <th width="30%">Titulo</th>
                                            <th width="15%">Fecha/Hora</th>
                                            <th width="10%">Celular</th>
                                            <th width="20%">Empresa</th>
                                            <th width="10%">Estado</th>
                                            <th width="5%" class="text-center">Editar</th>
                                            <th width="5%" class="text-center">Eliminar</th>
                                        </thead>
                                        <tbody id="tbTable">
                                            <tr>
                                                <td class="text-center" colspan="8">No hay datos.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12" style="text-align:center;">
                                    <ul class="pagination">
                                        <li>
                                            <button class="btn btn-primary" id="btnIzquierda">
                                                <i class="fa fa-toggle-left"></i>
                                            </button>
                                        </li>
                                        <li>
                                            <span id="lblPaginaActual" class="font-weight-bold">0</span>
                                        </li>
                                        <li><span>a</span></li>
                                        <li>
                                            <span id="lblPaginaSiguiente" class="font-weight-bold">0</span>
                                        </li>
                                        <li>
                                            <button class="btn btn-primary" id="btnDerecha">
                                                <i class="fa fa-toggle-right"></i>
                                            </button>
                                        </li>
                                    </ul>
                                </div>

                            </div>

                        </div>
                    </section>
                    <!-- /.content -->
                </div>
                <!-- /.content-wrapper -->
                <!-- start footer -->
                <?php include('./layout/footer.php') ?>
                <!-- end footer -->
            </div>
            <!-- ./wrapper -->
            <script src="js/tools.js"></script>
            <script>
                let tools = new Tools();
                let state = false;
                let opcion = 0;
                let totalPaginacion = 0;
                let paginacion = 0;
                let filasPorPagina = 10;
                let tbTable = $("#tbTable");

                let idUsuario = <?= $_SESSION['IdUsuario'] ?>;
            </script>
        </body>

        </html>
<?php
    } else {
        echo '<script>location.href = "./index.php";</script>';
    }
}
