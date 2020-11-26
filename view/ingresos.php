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
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="background-color: #FFFFFF;">
            <!-- Main content -->
            <section class="content-header">
                <h3 class="no-margin"> Ingresos <small> Lista </small> </h3>
            </section>

            <!-- Modal alert-->
            <div class="modal fade" id="modalAlert" data-backdrop="static" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="static">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" id="btnIconCloseModal">
                                <i class="fa fa-close"></i>
                            </button>
                            <h5 class="modal-title">
                                Envío del comprobante
                            </h5>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-1" id="alertIcon">
                                    <i class="fa fa-commenting-o fa-3x text-info"></i>
                                </div>
                                <div class="col-md-11">
                                    <h5 id="alertText"></h5>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!-- <button type="button" class="btn btn-secondary" id="btnButtonCloseModal">Close</button> -->
                            <button type="button" class="btn btn-primary" id="btnButtonAcceptModal">Aceptar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal alert-->
            <section class="content">

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
                        <!-- <div class="form-group"> -->
                        <label>Fecha de inicio:</label>
                        <!-- <div class="input-group date"> -->
                        <!-- <div class="input-group-addon"> -->
                        <!-- <i class="fa fa-calendar"></i> -->
                        <!-- </div> -->
                        <input type="date" class="form-control pull-right" id="datepicker">
                        <!-- </div> -->
                        <!-- </div> -->
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <!-- <div class="form-group"> -->
                        <label>Fecha de fin:</label>
                        <!-- <div class="input-group date"> -->
                        <!-- <div class="input-group-addon"> -->
                        <!-- <i class="fa fa-calendar"></i> -->
                        <!-- </div> -->
                        <input type="date" class="form-control pull-right" id="datepicker">
                        <!-- </div> -->
                        <!-- </div> -->
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
                                <button class="btn btn-success" id="btnEnvioMasivo"><i class="fa fa-file-excel-o"></i> Excel por fechas</button>
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
                                    <th style="width:10%;">Opciones</th>
                                    <th style="width:10%;">Fecha</th>
                                    <th style="width:10%;">Comprobante</th>
                                    <th style="width:15%;">Cliente</th>
                                    <th style="width:10%;">Estado</th>
                                    <th style="width:10%;">Total</th>
                                    <th style="width:10%;">Estado Sunat</th>
                                    <th style="width:20%;">Observaciones Sunat</th>
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
        let totalPaginacion = 0;
        let paginacion = 0;
        let filasPorPagina = 10;
        let tbTable = $("#tbTable");

        let arrayIngresos = [];

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

            $("#btnIconCloseModal").on("click", function(e) {
                $("#modalAlert").modal('hide');
            });

            $("#btnButtonAcceptModal").on("click", function(e) {
                $("#modalAlert").modal('hide');
            });

            $("#btnEnvioMasivo").click(function() {
                alertify.confirm('Ingreso', "¿Está seguro de continuar con el envío?", function() {
                    for (let ingresos of arrayIngresos) {
                        if (ingresos.estado == "C") {
                            if (ingresos.xmlsunat !== "0") {
                                firmaMasivaXml(ingresos.idIngreso);
                            }
                        }
                    }
                }, function() {

                });
            });

            $("#btnEnvioMasivo").keypress(function(event) {
                if (event.keyCode === 13) {
                    alertify.confirm('Ingreso', "¿Está seguro de continuar con el envío?", function() {
                        for (let ingresos of arrayIngresos) {
                            if (ingresos.estado == "C") {
                                if (ingresos.xmlsunat !== "0") {
                                    firmaMasivaXml(ingresos.idIngreso);
                                }
                            }
                        }
                    }, function() {

                    });
                }
                event.preventDefault();
            });

            $("#btnRecargar").click(function() {
                loadInitIngresos();
            });

            $("#btnRecargar").keypress(function(event) {
                if(event.keyCode === 13){
                    loadInitIngresos();
                }
                event.preventDefault();
            });

        });

        function loadInitIngresos() {
            if (!state) {
                paginacion = 1;
                loadTableIngresos();
            }
        }

        function loadTableIngresos() {
            $.ajax({
                url: "../app/controller/ListarIngresos.php",
                method: "GET",
                data: {
                    "posicionPagina": ((paginacion - 1) * filasPorPagina),
                    "filasPorPagina": filasPorPagina
                },
                beforeSend: function() {
                    tbTable.empty();
                    tbTable.append(
                        '<tr class="text-center"><td colspan="9"><img src="./images/spiner.gif"/><p>Cargando información.</p></td></tr>'
                    );
                    arrayIngresos.splice(0, arrayIngresos.length);
                    state = true;
                },
                success: function(result) {
                    if (result.estado == 1) {
                        arrayIngresos = result.data;
                        if (arrayIngresos.length == 0) {
                            tbTable.empty();
                            tbTable.append(
                                '<tr class="text-center"><td colspan="9"><p>No hay ingresos para mostrar.</p></td></tr>'
                            );
                            totalPaginacion = parseInt(Math.ceil((parseFloat(result.total) / parseInt(
                                filasPorPagina))));
                            $("#lblPaginaActual").html("0");
                            $("#lblPaginaSiguiente").html(totalPaginacion);
                            state = false;
                        } else {
                            tbTable.empty();
                            for (let ingresos of arrayIngresos) {
                                let btnAnular = '<button class="btn btn-danger btn-xs" onclick="">' +
                                    '<i class="fa fa-ban"></i></br>Anular' +
                                    '</button>';
                                let btnPdf = '<button class="btn btn-default btn-xs" onclick="openPdf(\'' + ingresos.idIngreso + '\')">' +
                                    '<i class="fa fa-file-pdf-o"></i></br>P.D.F' +
                                    '</button>';

                                let estadosunat = ingresos.estado === "C" ?
                                    (ingresos.xmlsunat === "" ?
                                        '<button class="btn btn-default btn-xs" onclick="facturarXml(\'' + ingresos.idIngreso + '\',\'' + ingresos.estado + '\')"><img src="./images/reuse.svg" width="30" /></button>' :
                                        ingresos.xmlsunat === "0" ?
                                        '<button class="btn btn-default btn-xs"><img src="./images/accept.svg" width="30"/></button>' :
                                        '<button class="btn btn-default btn-xs" onclick="facturarXml(\'' + ingresos.idIngreso + '\',\'' + ingresos.estado + '\')"><img src="./images/unable.svg" width="30"/></button>') :
                                    (ingresos.xmlsunat === "" ?
                                        '<button class="btn btn-default btn-xs" onclick="resumenDiarioXml(\'' + ingresos.idIngreso + '\',\'' + ingresos.serie + "-" + ingresos.numRecibo + '\',\'' + tools.getDateYYMMDD(ingresos.fecha) + '\')"><img src="./images/reuse.svg" width="30" /></button>' :
                                        '<button class="btn btn-default btn-xs"><img src="./images/error.svg" width="30"/></button>');

                                let observacionsunat =
                                    (ingresos.xmldescripcion === "" ? "Por Generar Xml y Enviar" : ingresos.xmldescripcion);

                                tbTable.append('<tr>' +
                                    '<td style="text-align: center;color: #2270D1;">' +
                                    '' + ingresos.id + '' +
                                    '</td>' +
                                    '<td>' + btnAnular + ' ' + btnPdf + '</td>' +
                                    '<td>' + ingresos.fecha + '</td>' +
                                    '<td>' + ingresos.serie + '-' + ingresos.numRecibo + '</td>' +
                                    '<td>' + ingresos.idDNI + '</br>' + ingresos.nombres + ' ' + ingresos.apellidos + '</td>' +
                                    '<td>' + (ingresos.estado == "C" ? '<span class="text-green">Pagado</span>' : '<span class="text-red">Anulado</span>') + '</td>' +
                                    '<td>' + tools.formatMoney(ingresos.total) + '</td>' +
                                    '<td style="text-align: center;">' + estadosunat + '</td>' +
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
                            '<tr class="text-center"><td colspan="9"><p>No se pudo cargar la información.</p></td></tr>'
                        );
                        $("#lblPaginaActual").html(0);
                        $("#lblPaginaSiguiente").html(0);
                        state = false;
                    }
                },

                error: function(error) {
                    console.log(error)
                    tbTable.empty();
                    tbTable.append(
                        '<tr class="text-center"><td colspan="9"><p>Se produjo un error, intente nuevamente.</p></td></tr>'
                    );
                    $("#lblPaginaActual").html(0);
                    $("#lblPaginaSiguiente").html(0);
                    state = false;
                }
            });
        }

        function facturarXml(idIngreso, estado) {
            alertify.confirm('Ingreso', "¿Está seguro de continuar con el envío?", function() {
                if (estado === "C") {
                    $.ajax({
                        url: "../app/examples/boleta.php",
                        method: "GET",
                        data: {
                            "idIngreso": idIngreso
                        },
                        beforeSend: function() {
                            $("#alertIcon").empty();
                            $("#alertIcon").append('<i class="fa fa-refresh fa-3x text-primary"></i>');
                            $("#alertText").html("Firmando xml y enviando a la sunat.");
                            $("#btnIconCloseModal").addClass('disabled pointer-events');
                            $("#btnButtonAcceptModal").addClass('disabled pointer-events');
                            $("#modalAlert").modal('show');
                        },
                        success: function(result) {
                            let object = result;
                            if (object.state === true) {
                                if (object.accept === true) {
                                    $("#alertIcon").empty();
                                    $("#alertIcon").append('<i class="fa fa-exclamation-circle fa-3x text-success"></i>');
                                    $("#alertText").html("Resultado: Código " + object.code + " " + object.description);
                                    $("#btnIconCloseModal").removeClass('disabled pointer-events');
                                    $("#btnButtonAcceptModal").removeClass('disabled pointer-events');
                                    //loadInitIngresos();
                                } else {
                                    $("#alertIcon").empty();
                                    $("#alertIcon").append('<i class="fa fa-warning fa-3x text-warning"></i>');
                                    $("#alertText").html("Resultado: Código " + object.code + " " + object.description);
                                    $("#btnIconCloseModal").removeClass('disabled pointer-events');
                                    $("#btnButtonAcceptModal").removeClass('disabled pointer-events');
                                }
                            } else {
                                $("#alertIcon").empty();
                                $("#alertIcon").append('<i class="fa fa-warning fa-3x text-warning"></i>');
                                $("#alertText").html("Resultado: Código " + object.code + " " + object.description);
                                $("#btnIconCloseModal").removeClass('disabled pointer-events');
                                $("#btnButtonAcceptModal").removeClass('disabled pointer-events');
                            }
                        },
                        error: function(error) {
                            console.log(error.responseText)
                            $("#alertIcon").empty();
                            $("#alertIcon").append('<i class="fa fa-times-circle fa-3x text-danger "></i>');
                            $("#alertText").html("Error en el momento de firmar el xml, intente nuevamente o comuníquese con su proveedor del sistema.");
                            $("#btnIconCloseModal").removeClass('disabled pointer-events');
                            $("#btnButtonAcceptModal").removeClass('disabled pointer-events');
                        }
                    });
                }
            }, function() {
                //console.log("hjhj");
            });

        }

        function resumenDiarioXml(idIngreso, comprobante, resumen) {
            alertify.confirm('Ingreso', "¿Realmente Deseas Anular el Documento?", "Se anulará el documento: " + comprobante + ", y se creará el siguiente resumen individual: RC-" + resumen + "-1, estás seguro de anular el documento? los cambios no se podrán revertir!", function() {
                $.ajax({
                    url: "./examples/resumen.php",
                    method: "GET",
                    data: {
                        "idIngreso": idIngreso
                    },
                    beforeSend: function() {
                        $("#alertIcon").empty();
                        $("#alertIcon").append('<i class="fa fa-refresh fa-3x text-primary"></i>');
                        $("#alertText").html("Firmando xml y enviando a la sunat.");
                        $("#btnIconCloseModal").addClass('disabled pointer-events');
                        $("#btnButtonAcceptModal").addClass('disabled pointer-events');
                        $("#modalAlert").modal('show');
                    },
                    success: function(result) {
                        let object = result;
                        if (object.state === true) {
                            if (object.accept === true) {
                                $("#alertIcon").empty();
                                $("#alertIcon").append('<i class="fa fa-exclamation-circle fa-3x text-success"></i>');
                                $("#alertText").html("Resultado: Código " + object.code + " " + object.description);
                                $("#btnIconCloseModal").removeClass('disabled pointer-events');
                                $("#btnButtonAcceptModal").removeClass('disabled pointer-events');
                            } else {
                                $("#alertIcon").empty();
                                $("#alertIcon").append('<i class="fa fa-warning fa-3x text-warning"></i>');
                                $("#alertText").html("Resultado: Código " + object.code + " " + object.description);
                                $("#btnIconCloseModal").removeClass('disabled pointer-events');
                                $("#btnButtonAcceptModal").removeClass('disabled pointer-events');
                            }
                        } else {
                            $("#alertIcon").empty();
                            $("#alertIcon").append('<i class="fa fa-warning fa-3x text-warning"></i>');
                            $("#alertText").html("Resultado: Código " + object.code + " " + object.description);
                            $("#btnIconCloseModal").removeClass('disabled pointer-events');
                            $("#btnButtonAcceptModal").removeClass('disabled pointer-events');
                        }
                    },
                    error: function(error) {
                        $("#alertIcon").empty();
                        $("#alertIcon").append('<i class="fa fa-times-circle fa-3x text-danger "></i>');
                        $("#alertText").html("Error en el momento de firmar el xml, intente nuevamente o comuníquese con su proveedor del sistema.");
                        $("#btnIconCloseModal").removeClass('disabled pointer-events');
                        $("#btnButtonAcceptModal").removeClass('disabled pointer-events');
                    }
                });

            }, function() {

            });
            //alert.alertConfirmation("Ventas", "¿Realmente Deseas Anular el Documento?", "Se anulará el documento: " + comprobante + ", y se creará el siguiente resumen individual: RC-" + resumen + "-1, estás seguro de anular el documento? los cambios no se podrán revertir!", function(result) {
        }

        function firmaMasivaXml(idIngreso) {
            $.ajax({
                url: "../app/examples/boleta.php",
                method: "GET",
                data: {
                    "idIngreso": idIngreso
                },
                beforeSend: function() {
                    $("#alertIcon").empty();
                    $("#alertIcon").append('<i class="fa fa-refresh fa-3x text-primary"></i>');
                    $("#alertText").html("Firmando xml y enviando a la sunat.");
                    $("#btnIconCloseModal").addClass('disabled pointer-events');
                    $("#btnButtonAcceptModal").addClass('disabled pointer-events');
                    $("#modalAlert").modal('show');
                },
                success: function(result) {
                    let object = result;
                    if (object.state === true) {
                        if (object.accept === true) {
                            $("#alertIcon").empty();
                            $("#alertIcon").append('<i class="fa fa-exclamation-circle fa-3x text-success"></i>');
                            $("#alertText").html("Resultado: Código " + object.code + " " + object.description);
                            $("#btnIconCloseModal").removeClass('disabled pointer-events');
                            $("#btnButtonAcceptModal").removeClass('disabled pointer-events');
                        } else {
                            $("#alertIcon").empty();
                            $("#alertIcon").append('<i class="fa fa-warning fa-3x text-warning"></i>');
                            $("#alertText").html("Resultado: Código " + object.code + " " + object.description);
                            $("#btnIconCloseModal").removeClass('disabled pointer-events');
                            $("#btnButtonAcceptModal").removeClass('disabled pointer-events');
                        }
                    } else {
                        $("#alertIcon").empty();
                        $("#alertIcon").append('<i class="fa fa-warning fa-3x text-warning"></i>');
                        $("#alertText").html("Resultado: Código " + object.code + " " + object.description);
                        $("#btnIconCloseModal").removeClass('disabled pointer-events');
                        $("#btnButtonAcceptModal").removeClass('disabled pointer-events');
                    }
                },
                error: function(error) {
                    $("#alertIcon").empty();
                    $("#alertIcon").append('<i class="fa fa-times-circle fa-3x text-danger "></i>');
                    $("#alertText").html("Error en el momento de firmar el xml, intente nuevamente o comuníquese con su proveedor del sistema.");
                    $("#btnIconCloseModal").removeClass('disabled pointer-events');
                    $("#btnButtonAcceptModal").removeClass('disabled pointer-events');
                }
            });
        }

        function openPdf(idIngreso) {
            window.open("../app/sunat/pdfingresos.php?idIngreso=" + idIngreso, "_blank");
        }
    </script>
</body>

</html>