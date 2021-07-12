<?php
session_start();

if (!isset($_SESSION['IdUsuario'])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
    if ($_SESSION["Permisos"][3]["ver"] == 1) {
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
                    <div class="modal fade" id="mostrarDetalleIngreso" data-backdrop="static">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-group">
                                        </i> Detalle del Ingreso
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
                                                            <th width="50%">Concepto</th>
                                                            <th width="15%">Precio</th>
                                                            <th width="15%">Cantidad</th>
                                                            <th width="15%">Importe</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbDetalleIngreso">

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
                <!--end modal history enginner  -->

                <!-- modal detalle del ingreso -->
                <div class="row">
                    <div class="modal fade" id="eviarDocumentoalCorreo" data-backdrop="static">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-envelope">
                                        </i> Enviar Documento por Correo
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Universidad" class="col-sm-4 control-label">Correo del Colegiado</label>
                                                <div class="col-sm-8">
                                                    <input id="txtCorreo" type="text" class="form-control" placeholder="Ingrese un correo válido" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" id="btnAceptarEnvio">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="btnCancelEnvio">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- </div> -->
                <!--end modal history enginner  -->

                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper" style="background-color: #FFFFFF;">
                    <!-- Main content -->
                    <section class="content-header">
                        <h3 class="no-margin"> Ingresos <small> Lista </small> </h3>
                    </section>

                    <section class="content">

                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <label>Fecha de inicio(Entre Fechas).</label>
                                <div class="form-group">
                                    <input type="date" class="form-control" id="fechaInicio">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <label>Fecha de fin(Entre Fechas).</label>
                                <div class="form-group">
                                    <input type="date" class="form-control" id="fechaFinal">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <label>Comprobantes(Con Fechas).</label>
                                <div class="form-group">
                                    <select class="form-control" id="cbComprobantes">
                                        <option value="">- Seleccione -</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <label>Estado(Con Fechas).</label>
                                <div class="form-group">
                                    <select class="form-control" id="cbEstado">
                                        <option value="">- Seleccione -</option>
                                        <option value="C">Cobrado</option>
                                        <option value="A">Anulado</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <label>Filtrar por serie, numeración o colegiado(Presione Enter).</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="search" id="txtBuscar" class="form-control" placeholder="Escribe para filtrar automaticamente" aria-describedby="search" value="">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-primary" id="btnBuscar"> Buscar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-12 col-xs-12">
                                <label>Opción.</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <button type="button" class="btn btn-default" id="btnRecargar"><i class="fa fa-refresh"></i> Recargar</button>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label>Generar excel</label>
                                <div class="input-group">
                                    <button class="btn btn-success" id="btnExcel"><i class="fa fa-file-excel-o"></i> Excel por fechas</button>
                                </div>
                            </div>
                        </div> -->
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="table-responsive">
                                    <table class="table table-striped" style="border-width: 1px;border-style: dashed;border-color: #E31E25;">
                                        <thead style="background-color: #FDB2B1;color: #B72928;">
                                            <th style="width:5%;" class="text-center">#</th>
                                            <th style="width:4%;">Anular</th>
                                            <th style="width:4%;">P.D.F</th>
                                            <th style="width:4%;">Detalle</th>
                                            <th style="width:10%;">Fecha</th>
                                            <th style="width:12%;">Comprobante</th>
                                            <th style="width:24%;">Colegiado</th>
                                            <th style="width:9%;">Estado</th>
                                            <th style="width:9%;">Total</th>
                                            <th style="width:15%;">Usuario</th>
                                            <th style="width:4%;">enviar</th>
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

                let arrayIngresos = [];

                let idIngreso = '';

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


                    $("#btnExcel").click(function() {
                        if (tools.validateDate($("#fechaInicio").val()) && tools.validateDate($("#fechaFinal").val())) {
                            if (!state) {
                                openExcel($("#fechaInicio").val(), $("#fechaFinal").val());
                            }
                        }
                    });

                    $("#fechaInicio").on("change", function() {
                        if (tools.validateDate($("#fechaInicio").val()) && tools.validateDate($("#fechaFinal").val())) {
                            if (!state) {
                                paginacion = 1;
                                loadTableIngresos(0, "", $("#fechaInicio").val(), $("#fechaFinal").val(), 0, "");
                                opcion = 0;
                            }
                        }
                    });

                    $("#fechaFinal").on("change", function() {
                        if (tools.validateDate($("#fechaInicio").val()) && tools.validateDate($("#fechaFinal").val())) {
                            if (!state) {
                                paginacion = 1;
                                loadTableIngresos(0, "", $("#fechaInicio").val(), $("#fechaFinal").val(), 0, "");
                                opcion = 0;
                            }
                        }
                    });

                    $("#txtBuscar").keyup(function(event) {
                        if (event.keyCode == 13) {
                            if ($("#txtBuscar").val().trim() != '') {
                                if (!state) {
                                    paginacion = 1;
                                    loadTableIngresos(1, $("#txtBuscar").val().trim(), "", "", 0, "");
                                    opcion = 1;
                                }
                            }
                        }
                    });

                    $("#btnBuscar").click(function() {
                        if ($("#txtBuscar").val().trim() != '') {
                            if (!state) {
                                paginacion = 1;
                                loadTableIngresos(1, $("#txtBuscar").val().trim(), "", "", 0, "");
                                opcion = 1;
                            }
                        }
                    });

                    $("#btnBuscar").keyup(function(event) {
                        if (event.keyCode == 13) {
                            if ($("#txtBuscar").val().trim() != '') {
                                if (!state) {
                                    paginacion = 1;
                                    loadTableIngresos(1, $("#txtBuscar").val().trim(), "", "", 0, "");
                                    opcion = 1;
                                }
                            }
                        }
                    });

                    $("#btnRecargar").click(function() {
                        loadInitIngresos();
                    });

                    $("#btnRecargar").keypress(function(event) {
                        if (event.keyCode === 13) {
                            loadInitIngresos();
                        }
                        event.preventDefault();
                    });

                    $("#cbComprobantes").change(function() {
                        if ($("#cbComprobantes").val() != '') {
                            if (!state) {
                                paginacion = 1;
                                loadTableIngresos(2, "", $("#fechaInicio").val(), $("#fechaFinal").val(), $("#cbComprobantes").val(), "");
                                opcion = 2;
                            }
                        }
                    });

                    $("#cbEstado").change(function() {
                        if (tools.validateDate($("#fechaInicio").val()) && tools.validateDate($("#fechaFinal").val()) && $("#cbEstado").val() != '') {
                            if (!state) {
                                paginacion = 1;
                                loadTableIngresos(3, "", $("#fechaInicio").val(), $("#fechaFinal").val(), 0, $("#cbEstado").val());
                                opcion = 3;
                            }
                        }
                    });

                    loadComprobantes();
                    loadInitIngresos();

                    $("#btnCancelEnvio").click(function() {
                        $("#eviarDocumentoalCorreo").modal("hide");
                        $("#txtCorreo").val('');
                    });

                    $("#btnAceptarEnvio").click(function() {
                        // $("#eviarDocumentoalCorreo").modal("hide");
                        // $("#txtCorreo").val('');
                        enviarDocumentoCorreo($("#txtCorreo").val(), idIngreso);
                    });
                });

                function onEventPaginacion() {
                    switch (opcion) {
                        case 0:
                            loadTableIngresos(0, "", $("#fechaInicio").val(), $("#fechaFinal").val(), 0, "");
                            break;
                        case 1:
                            loadTableIngresos(1, $("#txtBuscar").val().trim(), "", "", 0, "");
                            break;
                        case 2:
                            loadTableIngresos(2, "", $("#fechaInicio").val(), $("#fechaFinal").val(), $("#cbComprobantes").val(), "");
                            break;
                        case 3:
                            loadTableIngresos(3, "", $("#fechaInicio").val(), $("#fechaFinal").val(), 0, $("#cbEstado").val());
                            break;
                    }
                }

                function loadInitIngresos() {
                    if (tools.validateDate($("#fechaInicio").val()) && tools.validateDate($("#fechaFinal").val())) {
                        if (!state) {
                            paginacion = 1;
                            loadTableIngresos(0, "", $("#fechaInicio").val(), $("#fechaFinal").val(), 0, "");
                            opcion = 0;
                        }
                    }
                }

                function loadTableIngresos(opcion, buscar, fechaInicio, fechaFinal, comprobante, estado) {
                    $.ajax({
                        url: "../app/controller/IngresoController.php",
                        method: "GET",
                        data: {
                            "type": "allIngresos",
                            "opcion": opcion,
                            "buscar": buscar,
                            "fechaInicio": fechaInicio,
                            "fechaFinal": fechaFinal,
                            "comprobante": comprobante,
                            "estado": estado,
                            "posicionPagina": ((paginacion - 1) * filasPorPagina),
                            "filasPorPagina": filasPorPagina
                        },
                        beforeSend: function() {
                            tbTable.empty();
                            tbTable.append(
                                '<tr class="text-center"><td colspan="11"><img src="./images/spiner.gif"/><p>Cargando información.</p></td></tr>'
                            );
                            arrayIngresos = [];
                            state = true;
                        },
                        success: function(result) {

                            if (result.estado == 1) {
                                arrayIngresos = result.data;
                                if (arrayIngresos.length == 0) {
                                    tbTable.empty();
                                    tbTable.append(
                                        '<tr class="text-center"><td colspan="11"><p>No hay ingresos para mostrar.</p></td></tr>'
                                    );
                                    totalPaginacion = parseInt(Math.ceil((parseFloat(result.total) / parseInt(
                                        filasPorPagina))));
                                    $("#lblPaginaActual").html("0");
                                    $("#lblPaginaSiguiente").html(totalPaginacion);
                                    state = false;
                                } else {
                                    tbTable.empty();
                                    for (let ingresos of arrayIngresos) {

                                        let btnAnular = '<button class="btn btn-default btn-xs" onclick="anularIngreso(\'' + ingresos.idIngreso + '\')">' +
                                            '<i class="fa fa-ban" style="font-size:25px;"></i></br>' +
                                            '</button>';
                                        let btnPdf = '<button class="btn btn-danger btn-xs" onclick="openPdf(\'' + ingresos.idIngreso + '\')">' +
                                            '<i class="fa fa-file-pdf-o" style="font-size:25px;"></i></br>' +
                                            '</button>';
                                        let btnDetalle = '<button class="btn btn-warning btn-xs" onclick="openDetalle(\'' + ingresos.idIngreso + '\')">' +
                                            '<i class="fa fa-eye" style="font-size:25px;"></i></br>' +
                                            '</button>';
                                        let btnEnviar = '<button class="btn btn-info btn-xs" onclick="getCorreo(\'' + ingresos.numeroDocumento + '\', \'' + ingresos.idIngreso + '\', \'' + '\')">' +
                                            '<i class="fa fa-envelope" style="font-size:25px;"></i></br>' +
                                            '</button>';

                                        let observacionsunat =
                                            (ingresos.xmldescripcion === "" ? "Por Generar Xml y Enviar" : ingresos.xmldescripcion);

                                        tbTable.append('<tr>' +
                                            '<td class="text-center text-primary">' + ingresos.id + '</td>' +
                                            '<td>' + btnAnular + '</td>' +
                                            '<td>' + btnPdf + '</td>' +
                                            '<td>' + btnDetalle + '</td>' +
                                            '<td>' + ingresos.fecha + '<br>' + tools.getTimeForma(ingresos.hora, true) + '</td>' +
                                            '<td>' + ingresos.comprobante + '<br>' + ingresos.serie + '-' + ingresos.numRecibo + '</td>' +
                                            '<td>' + ingresos.nombreDocumento + ' - ' + ingresos.numeroDocumento + '</br>' + ingresos.persona + '</td>' +
                                            '<td>' + (ingresos.estado == "C" ? '<span class="text-green">Pagado</span>' : '<span class="text-red">Anulado</span>') + '</td>' +
                                            '<td>' + tools.formatMoney(ingresos.total) + '</td>' +
                                            '<td>' + ingresos.usuario + '<br>' + ingresos.rol + '</td>' +
                                            '<td>' + btnEnviar + '</td>' +
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
                                    '<tr class="text-center"><td colspan="11"><p>' + result.mensaje + '</p></td></tr>'
                                );
                                $("#lblPaginaActual").html(0);
                                $("#lblPaginaSiguiente").html(0);
                                state = false;
                            }
                        },

                        error: function(error) {
                            tbTable.empty();
                            tbTable.append(
                                '<tr class="text-center"><td colspan="11"><p>' + error.responseText + '</p></td></tr>'
                            );
                            $("#lblPaginaActual").html(0);
                            $("#lblPaginaSiguiente").html(0);
                            state = false;
                        }
                    });
                }

                function getCorreo(dniColegiado, idIngres) {

                    idIngreso = idIngres;

                    $("#eviarDocumentoalCorreo").modal("show");

                    $.ajax({
                        url: "../app/controller/ComprobanteController.php",
                        method: "GET",
                        data: {
                            "type": "correo",
                            "colegiado": dniColegiado
                        },
                        beforeSend: function() {
                            $("#txtCorreo").val('');
                        },
                        success: function(result) {
                            if (result.estado == 1) {
                                if (result.data.length != 0) {
                                    $("#txtCorreo").val(result.data[0].email);
                                }
                            }
                        },
                        error: function(error) {
                            $("#txtCorreo").val('');
                        }
                    })
                }

                function loadComprobantes() {
                    $.ajax({
                        url: "../app/controller/ComprobanteController.php",
                        method: "GET",
                        data: {
                            "type": "comprobante"
                        },
                        beforeSend: function() {
                            $("#cbComprobantes").empty();
                            $("#cbComprobantes").append('<option value="">- Seleccione -</option>');
                        },
                        success: function(result) {
                            if (result.estado == 1) {
                                for (let value of result.data) {
                                    $("#cbComprobantes").append('<option value="' + value.IdTipoComprobante + '">' + value.Nombre + '</option>');
                                }
                            }
                        },
                        error: function(error) {

                        }
                    });
                }

                function openExcel(fechaInicio, fechaFinal) {
                    window.open("../app/sunat/excelventa.php?cbTipoDocumento=null&txtFechaInicial=" + fechaInicio + "&txtFechaFinal=" + fechaFinal + "&comprobante=0", "_blank");
                }

                function openPdf(idIngreso) {
                    window.open("../app/sunat/pdfingresos.php?idIngreso=" + idIngreso, "_blank");
                }

                function openDetalle(idIngreso) {
                    $("#mostrarDetalleIngreso").modal("show");
                    $.ajax({
                        url: "../app/controller/IngresoController.php",
                        method: "GET",
                        data: {
                            "type": "detalleingreso",
                            "idIngreso": idIngreso,
                        },
                        beforeSend: function() {
                            $("#tbDetalleIngreso").empty();
                            $("#tbDetalleIngreso").append('<tr class="text-center"><td colspan="5"><img src="./images/spiner.gif"/><p>Cargando información.</p></td></tr>');

                        },
                        success: function(result) {
                            if (result.estado == 1) {
                                $("#tbDetalleIngreso").empty();
                                if (result.detalles.length == 0) {
                                    $("#tbDetalleIngreso").append('<tr class="text-center"><td colspan="5"><p>No hay datos para Mostrar</p></td></tr>');
                                } else {
                                    for (let detalle of result.detalles) {
                                        $("#tbDetalleIngreso").append('<tr>' +
                                            '<td>' + detalle.Id + '</td>' +
                                            '<td>' + detalle.Concepto + '</td>' +
                                            '<td>' + tools.formatMoney(detalle.Precio) + '</td>' +
                                            '<td>' + tools.formatMoney(detalle.Cantidad) + '</td>' +
                                            '<td>' + tools.formatMoney(detalle.Total) + '</td>' +
                                            '</tr>');
                                    }
                                }
                            } else {
                                $("#tbDetalleIngreso").append('<tr class="text-center"><td colspan="5"><p>' + result.message + '</p></td></tr>');
                            }
                        },
                        error: function(error) {
                            $("#tbDetalleIngreso").append('<tr class="text-center"><td colspan="5"><p>' + error.responseText + '</p></td></tr>');

                        }
                    });
                }

                function anularIngreso(idIngreso) {
                    tools.ModalDialogInputText("Ingreso", "¿Está seguro de anular el comprobante?", function(value) {
                        if (value.dismiss == "cancel") {} else if (value.value.length == 0) {
                            tools.ModalAlertWarning("Ingreso", "No ingreso ningún motivo :(");
                        } else {
                            $.ajax({
                                url: "../app/controller/IngresoController.php",
                                method: 'POST',
                                data: {
                                    "type": "deleteIngreso",
                                    "idIngreso": idIngreso,
                                    "idUsuario": 1,
                                    "motivo": value.value.toUpperCase(),
                                    "fecha": tools.getCurrentDate(),
                                    "hora": tools.getCurrentTime()
                                },
                                beforeSend: function() {
                                    tools.ModalAlertInfo("Ingreso", "Procesando petición..");
                                },
                                success: function(result) {
                                    if (result.estado == 1) {
                                        tools.ModalAlertSuccess("Ingreso", result.message);
                                        loadInitIngresos();
                                    } else {
                                        tools.ModalAlertWarning("Ingreso", result.message);
                                    }
                                },
                                error: function(error) {
                                    tools.ModalAlertError("Ingreso", "Se produjo un error: " + error.responseText);
                                }
                            });
                        }
                    });
                }

                function enviarDocumentoCorreo(correo, idIngreso) {
                    $.ajax({
                        url: "../app/sunat/mail.php",
                        method: 'POST',

                        data: {
                            "correodestino": correo,
                            "idIngreso": idIngreso
                        },
                        beforeSend: function() {
                            $("#eviarDocumentoalCorreo").modal("hide");
                            $("#txtCorreo").val('');
                            tools.ModalAlertInfo("Envio Correo", "Procesando petición..");
                        },
                        success: function(result) {
                            console.log(result);
                            if (result.estado == 1) {
                                tools.ModalAlertSuccess("Envio Correo", result.message);

                            } else {
                                tools.ModalAlertWarning("Envio Correo", result.message);
                            }
                        },
                        error: function(error) {
                            console.log(error);
                            tools.ModalAlertError("Envio Correo", "Se produjo un error: " + error.responseText);
                        }
                    })
                }
            </script>
        </body>

        </html>

<?php
    } else {
        echo '<script>location.href = "./index.php";</script>';
    }
}
