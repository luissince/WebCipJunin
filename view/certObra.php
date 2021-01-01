<?php
session_start();

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
                    <h3 class="no-margin"> Certificados de Residencia de Obra<small> Lista </small> </h3>
                </section>

                <section class="content">

                    <div class="row">
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <label>Fecha de inicio:</label>
                            <input type="date" class="form-control pull-right" id="datepicker">
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <label>Fecha de fin:</label>
                            <input type="date" class="form-control pull-right" id="datepicker">
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <label>Filtrar certificado, numeración o cliente</label>
                            <input type="search" id="buscar" class="form-control" placeholder="Escribe para filtrar automaticamente" aria-describedby="search" value="">
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12">
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
                                        <th style="width:3%;">#</th>
                                        <th style="width:6%;">Opciones</th>
                                        <th style="width:10%;">Usuario</th>
                                        <th style="width:10%;">Especialidad</th>
                                        <th style="width:6%;">N° Cert.</th>
                                        <th style="width:6%;">Modalidad</th>
                                        <th style="width:10%;">Propietario</th>
                                        <th style="width:10%;">Proyecto</th>
                                        <th style="width:6%;">Monto</th>
                                        <th style="width:15%;">Lugar</th>
                                        <th style="width:7%;">Fecha Pago</th>
                                        <th style="width:7%;">Fecha Venc.</th>
                                        <th style="width:5%;">Estado</th>
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

            let arrayCertObra = [];

            $(document).ready(function() {
                loadInitIngresos();

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

                $("#btnRecargar").click(function() {
                    loadInitIngresos();
                });

                $("#btnRecargar").keypress(function(event) {
                    if (event.keyCode === 13) {
                        loadInitIngresos();
                    }
                    event.preventDefault();
                });
            });

            function onEventPaginacion() {
                switch (opcion) {
                    case 0:
                        loadTableIngresos();
                        break;
                    case 1:
                        loadTableIngresos();
                        break;
                }
            }

            function loadInitIngresos() {
                if (!state) {
                    paginacion = 1;
                    loadTableIngresos();
                    opcion = 0;
                }
            }

            function loadTableIngresos() {
                $.ajax({
                    url: "../app/controller/ListarIngresos.php",
                    method: "GET",
                    data: {
                        "type": "allCertObra",
                        "posicionPagina": ((paginacion - 1) * filasPorPagina),
                        "filasPorPagina": filasPorPagina
                    },
                    beforeSend: function() {
                        tbTable.empty();
                        tbTable.append(
                            '<tr class="text-center"><td colspan="13"><img src="./images/spiner.gif"/><p>Cargando información.</p></td></tr>'
                        );
                        arrayCertObra.splice(0, arrayCertObra.length);
                        state = true;
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            arrayCertObra = result.data;
                            if (arrayCertObra.length == 0) {
                                tbTable.empty();
                                tbTable.append(
                                    '<tr class="text-center"><td colspan="13"><p>No hay ingresos para mostrar.</p></td></tr>'
                                );
                                totalPaginacion = parseInt(Math.ceil((parseFloat(result.total) / parseInt(
                                    filasPorPagina))));
                                $("#lblPaginaActual").html("0");
                                $("#lblPaginaSiguiente").html(totalPaginacion);
                                state = false;
                            } else {
                                tbTable.empty();
                                for (let ingresos of arrayCertObra) {
                                    
                                    let btnAnular = '<button class="btn btn-danger btn-xs" onclick="anularIngreso(\'' + ingresos.idIngreso + '\',\'' + ingresos.dni + '\')">' +
                                        '<i class="fa fa-ban"></i></br>Anular' +
                                        '</button>';
                                    let btnPdf = '<button class="btn btn-default btn-xs" onclick="openPdf(\'' + ingresos.idIngreso + '\')">' +
                                        '<i class="fa fa-file-pdf-o"></i></br>P.D.F' +
                                        '</button>';

                                    tbTable.append('<tr>' +
                                        '<td style="text-align: center;color: #2270D1;">' +
                                        '' + ingresos.id + '' +
                                        '</td>' +
                                        '<td>' + btnAnular + ' ' + btnPdf + '</td>' +
                                        '<td>' +  ingresos.dni + '</br>' + ingresos.usuario + ' ' + ingresos.apellidos + '</td>' +
                                        '<td>' + ingresos.especialidad + '</td>' +
                                        '<td>' + ingresos.numCertificado + '</td>' +
                                        '<td>' + ingresos.modalidad + '</td>' +
                                        '<td>' + ingresos.propietario + '</td>' +
                                        '<td>' + ingresos.proyecto + '</td>' +
                                        '<td>' + tools.formatMoney(ingresos.monto) + '</td>' +
                                        '<td>' + ingresos.ubigeo + '</td>' +
                                        '<td>' + ingresos.fechaPago + '</td>' +
                                        '<td>' + ingresos.fechaVencimiento + '</td>' +
                                        '<td>' + ingresos.estado + '</td>' +
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
                                '<tr class="text-center"><td colspan="13"><p>' + result.mensaje + '</p></td></tr>'
                            );
                            $("#lblPaginaActual").html(0);
                            $("#lblPaginaSiguiente").html(0);
                            state = false;
                        }
                    },

                    error: function(error) {
                        tbTable.empty();
                        tbTable.append(
                            '<tr class="text-center"><td colspan="13"><p>' + error.responseText + '</p></td></tr>'
                        );
                        $("#lblPaginaActual").html(0);
                        $("#lblPaginaSiguiente").html(0);
                        state = false;
                    }
                });
            }

            function openPdf(idIngreso) {
                window.open("../app/sunat/pdfCertObra.php?idIngreso=" + idIngreso, "_blank");
            }

            function anularIngreso(idIngreso, dni) {
                tools.ModalDialogInputText("Ingreso", "¿Está seguro de anular el comprobante?", function(value) {
                    if (value.dismiss == "cancel") {                       
                    } else if (value.value.length == 0) {
                        tools.ModalAlertWarning("Ingreso", "No ingreso ningún motivo :(");
                    } else {
                        $.ajax({
                            url: "../app/controller/IngresoController.php",
                            method: 'POST',
                            data: {
                                "type": "deleteCertObra",
                                "idIngreso": idIngreso,
                                "idUsuario": dni,
                                "motivo":value.value.toUpperCase(),
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
                                } else if (result.estado == 2) {
                                    tools.ModalAlertWarning("Ingreso", result.message);
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
        </script>
    </body>

    </html>

<?php }