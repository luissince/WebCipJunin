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
                    <h3 class="no-margin"> Nota de Crédito <small> Lista </small> </h3>
                </section>

                <section class="content">

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <button type="button" class="btn btn-success" id="nuevaNotaCredito">
                                    <i class="fa fa-plus"></i>
                                    Nueva Nota de crédito
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
                                        <th style="width:2%;">#</th>
                                        <th style="width:7%;">Opciones</th>
                                        <th style="width:10%;">Tipo de Nota Credito</th>
                                        <th style="width:7%;">Fecha Registro</th>
                                        <th style="width:10%;">Comprobante</th>
                                        <th style="width:25%;">Cliente</th>
                                        <th style="width:13%;">Motivo</th>
                                        <th style="width:5%;">Total</th>
                                        <th style="width:5%;">Estado Sunat</th>
                                        <th style="width:15%;">Observaciones Sunat</th>
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
            let tbTable = $("#tbTable");

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

                $("#btnIzquierda").click(function() {
                    if (!state) {
                        if (paginacion > 1) {
                            paginacion--;
                            onEventPaginacion();
                        }
                    }
                });

                $("#btnDerecha").click(function() {
                    if (!state) {
                        if (paginacion < totalPaginacion) {
                            paginacion++;
                            onEventPaginacion();
                        }
                    }
                });

                $("#fechaInicio").on("change", function() {
                    if (tools.validateDate($("#fechaInicio").val()) && tools.validateDate($("#fechaFinal").val())) {
                        if (!state) {
                            paginacion = 1;
                            loadTableNotasCredito(0, "", $("#fechaInicio").val(), $("#fechaFinal").val());
                            opcion = 0;
                        }
                    }
                });

                $("#fechaFinal").on("change", function() {
                    if (tools.validateDate($("#fechaInicio").val()) && tools.validateDate($("#fechaFinal").val())) {
                        if (!state) {
                            paginacion = 1;
                            loadTableNotasCredito(0, "", $("#fechaInicio").val(), $("#fechaFinal").val());
                            opcion = 0;
                        }
                    }
                });

                $("#buscar").keyup(function() {
                    if ($("#buscar").val().trim() != '') {
                        if (!state) {
                            paginacion = 1;
                            loadTableNotasCredito(1, $("#buscar").val().trim(), "", "");
                            opcion = 1;
                        }
                    }
                });

                $("#btnRecargar").click(function() {
                    listarNotasCredito();
                });

                $("#btnRecargar").keypress(function(event) {
                    if (event.keyCode === 13) {
                        listarNotasCredito();
                    }
                    event.preventDefault();
                });

                $("#contacto").append('<option> - seleccione un contacto -</option>')

                $("#nuevaNotaCredito").click(function() {
                    window.location.href = "nuevaNotaCredito.php"
                });
                $("#btnExcel").click(function() {
                    $("#mdAlert").modal("show")
                });

                listarNotasCredito();
            });

            function listarNotasCredito() {
                if (tools.validateDate($("#fechaInicio").val()) && tools.validateDate($("#fechaFinal").val())) {
                    if (!state) {
                        paginacion = 1;
                        loadTableNotasCredito(0, "", $("#fechaInicio").val(), $("#fechaFinal").val());
                        opcion = 0;
                    }
                }
            }

            function onEventPaginacion() {
                switch (opcion) {
                    case 0:
                        loadTableNotasCredito(0, "", $("#fechaInicio").val(), $("#fechaFinal").val());
                        break;
                    case 1:
                        loadTableNotasCredito(1, $("#buscar").val().trim(), "", "");
                        break;
                }
            }

            function loadTableNotasCredito(opcion, buscar, fechaInicio, fechaFinal) {
                $.ajax({
                    url: "../app/controller/ListarIngresos.php",
                    method: "GET",
                    data: {
                        "type": "allNotasCredito",
                        "opcion": opcion,
                        "buscar": buscar,
                        "fechaInicio": fechaInicio,
                        "fechaFinal": fechaFinal,
                        "posicionPagina": ((paginacion - 1) * filasPorPagina),
                        "filasPorPagina": filasPorPagina
                    },
                    beforeSend: function() {
                        tbTable.empty();
                        tbTable.append(
                            '<tr class="text-center"><td colspan="10"><img src="./images/spiner.gif"/><p>Cargando información.</p></td></tr>'
                        );
                        arrayIngresos = [];
                        state = true;
                    },
                    success: function(result) {

                        if (result.estado == 1) {

                            console.log(result.data);
                            arrayIngresos = result.data;
                            if (arrayIngresos.length == 0) {
                                tbTable.empty();
                                tbTable.append(
                                    '<tr class="text-center"><td colspan="10"><p>No hay ingresos para mostrar.</p></td></tr>'
                                );
                                totalPaginacion = parseInt(Math.ceil((parseFloat(result.total) / parseInt(
                                    filasPorPagina))));
                                $("#lblPaginaActual").html("0");
                                $("#lblPaginaSiguiente").html(totalPaginacion);
                                state = false;
                            } else {
                                tbTable.empty();
                                for (let ingresos of arrayIngresos) {

                                    let btnPdf = '<button class="btn btn-default btn-xs" onclick="openPdf(\'' + ingresos.idNotaCredito + '\')">' +
                                        '<i class="fa fa-file-pdf-o"></i></br>P.D.F' +
                                        '</button>';
                                    let btnDetalle = '<button class="btn btn-warning btn-xs" onclick="openDetalle(\'' + ingresos.idNotaCredito + '\')">' +
                                        '<i class="fa fa-eye"></i></br>Detalle' +
                                        '</button>';

                                    let motivo = ingresos.motivoNotaCredito == 1 ? 'Anulación de la operación' :
                                        ingresos.motivoNotaCredito == 1 ? 'Anulación de la operación' :
                                        ingresos.motivoNotaCredito == 2 ? 'Anulación por error en el ruc' :
                                        ingresos.motivoNotaCredito == 3 ? 'Corrección por error en la descripción' :
                                        ingresos.motivoNotaCredito == 4 ? 'Descuento global' :
                                        ingresos.motivoNotaCredito == 5 ? 'Descuento por ítem' :
                                        ingresos.motivoNotaCredito == 6 ? 'Devolución total' :
                                        ingresos.motivoNotaCredito == 7 ? 'Devolución por ítem' :
                                        ingresos.motivoNotaCredito == 8 ? 'Bonificación' :
                                        ingresos.motivoNotaCredito == 9 ? 'Disminución en el valor' :
                                        ingresos.motivoNotaCredito == 10 ? 'Otros Conceptos' : 'Ajustes de operaciones de exportación'

                                    tbTable.append('<tr>' +
                                        '<td style="text-align: center;color: #2270D1;">' +
                                        '' + ingresos.id + '' +
                                        '</td>' +
                                        '<td>' + btnDetalle + '</td>' +
                                        '<td>' + ingresos.tipoNotaCredito + '</td>' +
                                        '<td>' + ingresos.fechadeRegistro + '<br>' + tools.getTimeForma(ingresos.hora, true) + '</td>' +
                                        '<td>' + ingresos.serie + '-' + ingresos.correlativo + '</td>' +
                                        '<td>' + ingresos.numeroDocIdent + '</br>' + ingresos.nombres + '</td>' +
                                        '<td>' + motivo +
                                        '<td>' + tools.formatMoney(ingresos.total) + '</td>' +
                                        '<td style="text-align: center;">' + 'estadosunat' + '</td>' +
                                        '<td>' + 'observacionsunat' + '</td>' +
                                        '</tr>'
                                    );
                                }
                                totalPaginacion = parseInt(Math.ceil((parseFloat(result.total) / parseInt(
                                    filasPorPagina))));
                                $("#lblPaginaActual").html(paginacion);
                                $("#lblPaginaSiguiente").html(totalPaginacion);
                                state = false;
                            }
                        } else {
                            tbTable.empty();
                            tbTable.append(
                                '<tr class="text-center"><td colspan="10"><p>' + result.mensaje + '</p></td></tr>'
                            );
                            $("#lblPaginaActual").html(0);
                            $("#lblPaginaSiguiente").html(0);
                            state = false;
                        }
                    },

                    error: function(error) {
                        tbTable.empty();
                        tbTable.append(
                            '<tr class="text-center"><td colspan="10"><p>' + error.responseText + '</p></td></tr>'
                        );
                        $("#lblPaginaActual").html(0);
                        $("#lblPaginaSiguiente").html(0);
                        state = false;
                    }
                });
            }
        </script>
    </body>

    </html>
<?php }
