<?php
session_start();
// $title_page = "Nota de débito";
if (!isset($_SESSION['IdUsuario'])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
?>
    <!DOCTYPE html>
    <html lang="es">

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
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="background-color: #FFFFFF;">
                <!-- Main content -->
                <section class="content-header">
                    <h3 class="no-margin"> Nota de Débito <small> Lista </small> </h3>
                </section>

                <section class="content">

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <button type="button" class="btn btn-success" id="nuevaNotaDebito">
                                    <i class="fa fa-plus"></i>
                                    Nueva Nota de Débito
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label><img src="./images/sunat_logo.png" width="28" /> Estados SUNAT:</label>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label><img src="./images/accept.svg" width="28" /> Aceptado</label>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label><img src="./images/unable.svg" width="28" /> Rechazado</label>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label><img src="./images/reuse.svg" width="28" /> Pendiente de Envío</label>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label><img src="./images/error.svg" width="28" /> Comunicación de Baja (Anulado)</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <label>Fecha de inicio:</label>
                            <input type="date" class="form-control pull-right" id="fechaInicio">
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <label>Fecha de fin:</label>
                            <input type="date" class="form-control pull-right" id="fechaFinal">
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label>Opción</label>
                                <div class="input-group">
                                    <button class="btn btn-primary" id="btnEnvioMasivo"><i class="fa fa-gg-circle"></i> Envío masivo a sunat</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label>Generar excel</label>
                                <div class="input-group">
                                    <button class="btn btn-success" id="btnExcel"><i class="fa fa-file-excel-o"></i> Excel por fechas</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <label>Filtrar comprobantes por serie, numeración o cliente</label>
                            <input type="search" id="buscar" class="form-control" placeholder="Escribe para filtrar automaticamente" aria-describedby="search" value="">
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label>Opción</label>
                                <div class="input-group">
                                    <button type="submit" class="btn btn-link" id="btnRecargar"><i class="fa fa-refresh"></i> Actualizar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                                <table class="table table-striped" style="border-width: 1px;border-style: dashed;border-color: #E31E25;">
                                    <thead style="background-color: #FDB2B1;color: #B72928;">
                                        <th style="width:5%;">#</th>
                                        <th style="width:10%;">Correlativo</th>
                                        <th style="width:10%;">Fecha</th>
                                        <th style="width:10%;">Comprobante</th>
                                        <th style="width:15%;">Cliente</th>
                                        <th style="width:10%;">Estado</th>
                                        <th style="width:10%;">Total</th>
                                        <th style="width:10%;">Por Aplicar</th>
                                        <th style="width:20%;">Acciones</th>
                                    </thead>
                                    <tbody id="tbTable">

                                    </tbody>

                                </table>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
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
            </div>

            <?php include('./layout/footer.php') ?>

        </div>
        <script src="js/tools.js"></script>
        <script>
            let tools = new Tools();

            let state = false;
            let opcion = 0;
            let totalPaginacion = 0;
            let paginacion = 0;
            let filasPorPagina = 10;

            $(document).ready(function() {
                $("#fechaInicio").val(tools.getCurrentDate());

                $("#fechaFinal").val(tools.getCurrentDate());

                // $("#btnExcel").click(function() {
                //     if (tools.validateDate($("#fechaInicio").val()) && tools.validateDate($("#fechaFinal").val())) {
                //         if (!state) {
                //             openExcel($("#fechaInicio").val(), $("#fechaFinal").val());
                //         }
                //     }
                // });

                $("#contacto").append('<option> - seleccione un contacto -</option>')

                $("#nuevaNotaDebito").click(function() {
                    window.location.href = "nuevaNotaDebito.php";
                });
                $("#btnExcel").click(function() {
                    $("#mdAlert").modal("show")
                });
            });
        </script>
    </body>

    </html>
<?php }
