<?php
session_start();
// $title_page = "Nota de débito";
if (!isset($_SESSION['IdUsuario'])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
    if ($_SESSION["Permisos"][20]["ver"] == 1) {
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
                <!-- modal detalle del ingreso -->
                <div class="row">
                    <div class="modal fade" id="mostrarDetalleNotaCredito" data-backdrop="static">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-group">
                                        </i> Detalle de la Nota de Crédito
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">#</th>
                                                            <th width="30%">Concepto</th>
                                                            <th width="15%">Precio</th>
                                                            <th width="15%">Cantidad</th>
                                                            <th width="15%">Afectación</th>
                                                            <th width="15%">Importe</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbDetalleNotaCredito">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                <label>Fecha de inicio.</label>
                                <div class="form-group">
                                    <input type="date" class="form-control" id="fechaInicio">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12">
                                <label>Fecha de fin.</label>
                                <div class="form-group">
                                    <input type="date" class="form-control" id="fechaFinal">
                                </div>
                            </div>
                            <?php
                            if ($_SESSION["Permisos"][20]["crear"] == 1) {
                                echo '<div class="col-md-3 col-sm-12 col-xs-12">
                                <label>Envío masivo.</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <button class="btn btn-danger" id="btnEnvioMasivo"><i class="fa fa-gg-circle"></i> Envío masivo a sunat</button>
                                    </div>
                                </div>
                            </div>';
                            }
                            ?>

                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <label>Filtrar por serie, numeración o colegiado(Presione Enter).</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="search" id="txtBuscar" class="form-control" placeholder="Escribe para filtrar automaticamente" aria-describedby="search" value="">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-primary" id="btnBuscar">Buscar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <label>Opción.</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <button type="submit" class="btn btn-default" id="btnRecargar"><i class="fa fa-refresh"></i> Actualizar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="table-responsive">
                                    <table class="table table-striped" style="border-width: 1px;border-style: dashed;border-color: #E31E25;">
                                        <thead style="background-color: #FDB2B1;color: #B72928;">
                                            <th style="width:5%;" class="text-center">#</th>
                                            <th style="width:5%;">Anular</th>
                                            <th style="width:5%;">P.D.F</th>
                                            <th style="width:5%;">Detalle</th>
                                            <th style="width:10%;">Fecha</th>
                                            <th style="width:10%;">Comprobante</th>
                                            <th style="width:15%;">Colegiado</th>
                                            <th style="width:10%;">Modificado</th>
                                            <th style="width:10%;">Estado</th>
                                            <th style="width:5%;">Total</th>
                                            <th style="width:10%;" class="text-center">Estado Sunat</th>
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

                let addView = "<?= $_SESSION["Permisos"][20]["crear"]; ?>";
                let editView = "<?= $_SESSION["Permisos"][20]["actualizar"]; ?>";
                let deleteView = "<?= $_SESSION["Permisos"][20]["eliminar"]; ?>";

                $(document).ready(function() {


                    $("#fechaInicio").val(tools.getCurrentDate());

                    $("#fechaFinal").val(tools.getCurrentDate());

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
                                loadTableNotasCredito(1, "", $("#fechaInicio").val(), $("#fechaFinal").val());
                                opcion = 1;
                            }
                        }
                    });

                    $("#fechaFinal").on("change", function() {
                        if (tools.validateDate($("#fechaInicio").val()) && tools.validateDate($("#fechaFinal").val())) {
                            if (!state) {
                                paginacion = 1;
                                loadTableNotasCredito(1, "", $("#fechaInicio").val(), $("#fechaFinal").val());
                                opcion = 1;
                            }
                        }
                    });

                    $("#txtBuscar").keyup(function() {
                        if (event.keyCode == 13) {
                            if ($("#txtBuscar").val().trim() != '') {
                                if (!state) {
                                    paginacion = 1;
                                    loadTableNotasCredito(2, $("#txtBuscar").val().trim(), "", "");
                                    opcion = 2;
                                }
                            }
                        }
                    });

                    $("#btnBuscar").click(function(event) {
                        if ($("#txtBuscar").val().trim() != '') {
                            if (!state) {
                                paginacion = 1;
                                loadTableNotasCredito(2, $("#txtBuscar").val().trim(), "", "");
                                opcion = 2;
                            }
                        }
                    });

                    $("#btnBuscar").keypress(function(event) {
                        if (event.keyCode == 13) {
                            if ($("#txtBuscar").val().trim() != '') {
                                if (!state) {
                                    paginacion = 1;
                                    loadTableNotasCredito(2, $("#txtBuscar").val().trim(), "", "");
                                    opcion = 2;
                                }
                            }
                        }
                        event.preventDefault();
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

                    $("#nuevaNotaCredito").click(function() {
                        window.location.href = "nuevaNotaCredito.php"
                    });
                    $("#btnExcel").click(function() {
                        $("#mdAlert").modal("show")
                    });

                    $("#btnEnvioMasivo").click(function() {
                        envioMasivo();
                    });

                    $("#btnEnvioMasivo").keypress(function(event) {
                        if (event.getCode() == 13) {
                            envioMasivo();
                        }
                        event.preventDefault();
                    });

                    listarNotasCredito();
                });

                function onEventPaginacion() {
                    switch (opcion) {
                        case 0:
                            loadTableNotasCredito(0, "", "", "");
                            break;
                        case 1:
                            loadTableNotasCredito(1, "", $("#fechaInicio").val(), $("#fechaFinal").val());
                            break;
                        case 2:
                            loadTableNotasCredito(2, $("#txtBuscar").val().trim(), "", "");
                            break;
                    }
                }

                function listarNotasCredito() {
                    if (!state) {
                        paginacion = 1;
                        loadTableNotasCredito(0, "", "", "");
                        opcion = 0;
                    }
                }

                function loadTableNotasCredito(opcion, buscar, fechaInicio, fechaFinal) {
                    $.ajax({
                        url: "../app/controller/NotaCreditoController.php",
                        method: "GET",
                        data: {
                            "type": "all",
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
                                '<tr class="text-center"><td colspan="12"><img src="./images/spiner.gif"/><p>Cargando información.</p></td></tr>'
                            );
                            totalPaginacion = 0;
                            arrayIngresos = [];
                            state = true;
                        },
                        success: function(result) {
                            if (result.estado == 1) {
                                arrayIngresos = result.data;
                                if (arrayIngresos.length == 0) {
                                    tbTable.empty();
                                    tbTable.append(
                                        '<tr class="text-center"><td colspan="12"><p>No hay comprobantes para mostrar.</p></td></tr>'
                                    );
                                    $("#lblPaginaActual").html(0);
                                    $("#lblPaginaSiguiente").html(0);
                                    state = false;
                                } else {
                                    tbTable.empty();
                                    for (let notacredito of arrayIngresos) {
                                        let resumen = '<button class="btn btn-default btn-xs" onclick="resumenDiarioXml(\'' + notacredito.idNotaCredito + '\',\'' + notacredito.Serie + "-" + notacredito.NumRecibo + '\',\'' + tools.getDateYYMMDD(notacredito.FechadeRegistro) + '\')"><img src="./images/documentoanular.svg" width="26" /></button>';

                                        let btnPdf = '<button class="btn btn-danger btn-xs" onclick="openPdf(\'' + notacredito.idNotaCredito + '\')">' +
                                            '<i class="fa fa-file-pdf-o" style="font-size:25px;"></i></br>' +
                                            '</button>';
                                        let btnDetalle = '<button class="btn btn-warning btn-xs" onclick="openDetalle(\'' + notacredito.idNotaCredito + '\')">' +
                                            '<i class="fa fa-eye" style="font-size:25px;"></i></br>' +
                                            '</button>';

                                        let estadosunat = addView == 0 ? '<i class="fa fa-minus" style="font-size:20px;"></i>' :
                                            notacredito.Estado === "A" ?
                                            '<button class="btn btn-default btn-xs" onclick="facturarXml(\'' + notacredito.idNotaCredito + '\')"><img src="./images/error.svg" width="26" /></button>' :
                                            (notacredito.Xmlsunat === "" ?
                                                '<button class="btn btn-default btn-xs" onclick="facturarXml(\'' + notacredito.idNotaCredito + '\')"><img src="./images/reuse.svg" width="26" /></button>' :
                                                notacredito.Xmlsunat === "0" ?
                                                '<button class="btn btn-default btn-xs"><img src="./images/accept.svg" width="26"/></button>' :
                                                '<button class="btn btn-default btn-xs" onclick="facturarXml(\'' + notacredito.idNotaCredito + '\')"><img src="./images/unable.svg" width="26"/></button>');


                                        let observacionsunat =
                                            (notacredito.Xmldescripcion === "" ? "Por Generar Xml y Enviar" : limitar_cadena(notacredito.Xmldescripcion, 90, "..."));


                                        tbTable.append('<tr>' +
                                            '<td class="text-center text-primary">' + notacredito.id + '</td>' +
                                            '<td>' + resumen + '</td>' +
                                            '<td>' + btnPdf + '</td>' +
                                            '<td>' + btnDetalle + '</td>' +
                                            '<td>' + notacredito.FechadeRegistro + '</td>' +
                                            '<td>' + notacredito.Serie + '-' + notacredito.NumRecibo + '</td>' +
                                            '<td>' + notacredito.NumeroDocumento + '<br>' + notacredito.Persona + '</td>' +
                                            '<td>' + notacredito.SerieModificado + '-' + notacredito.NumeracionModificado + '</td>' +
                                            '<td>' + (notacredito.Estado == "C" ? '<span class="text-green">Cobrado</span>' : '<span class="text-red">Anulado</span>') + '</td>' +
                                            '<td>' + tools.formatMoney(notacredito.Total) + '</td>' +
                                            '<td class="text-center">' + estadosunat + '</td>' +
                                            '<td>' + observacionsunat + '</td>' +
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
                                    '<tr class="text-center"><td colspan="12"><p>' + result.message + '</p></td></tr>'
                                );
                                $("#lblPaginaActual").html(0);
                                $("#lblPaginaSiguiente").html(0);
                                state = false;
                            }
                        },

                        error: function(error) {
                            tbTable.empty();
                            tbTable.append(
                                '<tr class="text-center"><td colspan="12"><p>' + error.responseText + '</p></td></tr>'
                            );
                            $("#lblPaginaActual").html(0);
                            $("#lblPaginaSiguiente").html(0);
                            state = false;
                        }
                    });
                }

                function limitar_cadena(cadena, limite, sufijo) {
                    if (cadena.length > limite) {
                        return cadena.substr(0, limite) + sufijo;
                    }
                    return cadena;
                }

                function facturarXml(idNotaCredito) {
                    tools.ModalDialog("Nota de Crédito", "¿Está seguro de continuar con el envío?", function(value) {
                        if (value == true) {
                            $.ajax({
                                url: "../app/examples/notacredito.php",
                                method: "GET",
                                data: {
                                    "idNotaCredito": idNotaCredito
                                },
                                beforeSend: function() {
                                    tools.ModalAlertInfo("Nota de Crédito", "Firmando xml y enviando a la sunat.");
                                },
                                success: function(result) {
                                    let object = result;
                                    if (object.state === true) {
                                        if (object.accept === true) {
                                            tools.ModalAlertSuccess("Nota de Crédito", "Código " + object.code + " " + object.description);
                                            onEventPaginacion();
                                        } else {
                                            tools.ModalAlertWarning("Nota de Crédito", "Código " + object.code + " " + object.description);
                                        }
                                    } else {
                                        tools.ModalAlertWarning("Nota de Crédito", "Código " + object.code + " " + object.description);
                                    }
                                },
                                error: function(error) {
                                    tools.ModalAlertError("Nota de Crédito", error.responseText == "" || error.responseText == null ? "Se produjo un error interno, intente nuevamente." : error.responseText);
                                }
                            });
                        }
                    });
                }

                function resumenDiarioXml(idNotaCredito, comprobante, resumen) {
                    tools.ModalDialog("Emitir resumen díario", "¿Se anulará el documento: " + comprobante + ", y se creará el siguiente resumen individual: RC-" + resumen + "-1, estás seguro de anular el documento? los cambios no se podrán revertir!", function(value) {
                        if (value == true) {
                            $.ajax({
                                url: "../app/examples/resumennotacredito.php",
                                method: "GET",
                                data: {
                                    "idNotaCredito": idNotaCredito
                                },
                                beforeSend: function() {
                                    tools.ModalAlertInfo("Emitir resumen díario", "Firmando xml y enviando a la sunat.");
                                },
                                success: function(result) {
                                    let object = result;
                                    if (object.state === true) {
                                        if (object.accept === true) {
                                            tools.ModalAlertSuccess("Emitir resumen díario", "Código " + object.code + " " + object.description);
                                            onEventPaginacion();
                                        } else {
                                            tools.ModalAlertWarning("Emitir resumen díario", "Código " + object.code + " " + object.description);
                                        }
                                    } else {
                                        tools.ModalAlertWarning("Emitir resumen díario", "Código " + object.code + " " + object.description);
                                    }
                                },
                                error: function(error) {
                                    tools.ModalAlertError("Nota de Crédito", error.responseText == "" || error.responseText == null ? "Se produjo un error interno, intente nuevamente." : error.responseText);
                                }
                            });
                        }
                    });
                }

                function envioMasivo() {
                    tools.ModalDialog("Nota de Crédito", "Está seguro de continuar con el envío?", function(value) {
                        if (value == true) {
                            for (let ingresos of arrayIngresos) {
                                if (ingresos.Xmlsunat !== "0") {
                                    firmaMasivaXml(ingresos.idNotaCredito);
                                }
                            }
                        }
                    });
                }

                function firmaMasivaXml(idNotaCredito) {
                    if (value == true) {
                        $.ajax({
                            url: "../app/examples/notacredito.php",
                            method: "GET",
                            data: {
                                "idNotaCredito": idNotaCredito
                            },
                            beforeSend: function() {
                                tools.ModalAlertInfo("Nota de Crédito", "Firmando xml y enviando a la sunat.");
                            },
                            success: function(result) {
                                let object = result;
                                if (object.state === true) {
                                    if (object.accept === true) {
                                        tools.ModalAlertSuccess("Nota de Crédito", "Resultado: Código " + object.code + " " + object.description);
                                    } else {
                                        tools.ModalAlertWarning("Nota de Crédito", "Resultado: Código " + object.code + " " + object.description);
                                    }
                                } else {
                                    tools.ModalAlertWarning("Nota de Crédito", "Resultado: Código " + object.code + " " + object.description);
                                }
                            },
                            error: function(error) {
                                tools.ModalAlertError("Nota de Crédito", "Error en el momento de firmar el xml: " + error.responseText);
                            }
                        });
                    }
                }

                function openPdf(idNotaCredito) {
                    window.open("../app/sunat/pdfnotacredito.php?idNotaCredito=" + idNotaCredito, "_blank");
                }

                function openDetalle(idNotaCredito) {
                    $("#mostrarDetalleNotaCredito").modal("show");
                    $.ajax({
                        url: "../app/controller/NotaCreditoController.php",
                        method: "GET",
                        data: {
                            "type": "detalleNotaCreedito",
                            "idNotaCredito": idNotaCredito,
                        },
                        beforeSend: function() {
                            $("#tbDetalleNotaCredito").empty();
                            $("#tbDetalleNotaCredito").append('<tr class="text-center"><td colspan="6"><img src="./images/spiner.gif"/><p>Cargando información.</p></td></tr>');

                        },
                        success: function(result) {
                            if (result.estado == 1) {
                                $("#tbDetalleNotaCredito").empty();
                                if (result.detalles.length == 0) {
                                    $("#tbDetalleNotaCredito").append('<tr class="text-center"><td colspan="6"><p>No hay datos para Mostrar</p></td></tr>');
                                } else {
                                    for (let detalle of result.detalles) {
                                        $("#tbDetalleNotaCredito").append('<tr>' +
                                            '<td>' + detalle.Id + '</td>' +
                                            '<td>' + detalle.Concepto + '</td>' +
                                            '<td>' + tools.formatMoney(detalle.Precio) + '</td>' +
                                            '<td>' + tools.formatMoney(detalle.Cantidad) + '</td>' +
                                            '<td>' + detalle.Nombre + '</td>' +
                                            '<td>' + tools.formatMoney(detalle.Total) + '</td>' +
                                            '</tr>');
                                    }
                                }
                            } else {
                                $("#tbDetalleNotaCredito").append('<tr class="text-center"><td colspan="6"><p>' + result.message + '</p></td></tr>');
                            }
                        },
                        error: function(error) {
                            $("#tbDetalleNotaCredito").append('<tr class="text-center"><td colspan="6"><p>' + error.responseText + '</p></td></tr>');
                        }
                    });
                }
            </script>
        </body>

        </html>
<?php
    } else {
        echo '<script>location.href = "./index.php";</script>';
    }
}
