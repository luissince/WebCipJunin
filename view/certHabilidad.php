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

            <!-- modal start certificado -->
            <div class="row">
                <div class="modal fade" id="mdCertHabilidad" data-backdrop="static">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" id="btnCloseCertificado">
                                    <i class="fa fa-close"></i>
                                </button>
                                <h4 class="modal-title" id="modal-title-certificado-habilidad">
                                    <i class="fa fa-plus">
                                    </i> Certificado de Habilidad
                                </h4>
                            </div>
                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-md-12">
                                        <label id="lblCertificadoHabilidadEstado"></label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtIngenieroCertificado">Ingeniero(a)</label>
                                            <input type="text" class="form-control" id="txtIngenieroCertificado" placeholder="Datos completos del ingeniero" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label id="lblEspecialidadCertificado">Especialidad(es)</label>
                                            <select class="form-control" id="cbEspecialidadCertificado">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txtFechaCertificado">Fecha</label>
                                            <input type="date" class="form-control" id="txtFechaCertificado" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txtCorrelativoCertificado">Certificado N°</label>
                                            <input type="text" class="form-control" id="txtCorrelativoCertificado" placeholder="0" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txtAsuntoCertificado">Asunto</label>
                                            <input type="text" class="form-control" id="txtAsuntoCertificado" value="EJERCICIO DE LA PROFESIÓN" placeholder="Ingrese el asunto">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txtEntidadCertificado">Entidad o Propietario</label>
                                            <input type="text" class="form-control" id="txtEntidadCertificado" value="VARIOS" placeholder="Ingrese la entidad o el propietario">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtLugarCertificado">Lugar</label>
                                            <input type="text" class="form-control" id="txtLugarCertificado" value="A NIVEL NACIONAL" placeholder="Ingrese el lugar">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" id="btnAceptarCertificado">
                                    <i class="fa fa-check"></i> Aceptar</button>
                                <button type="button" class="btn btn-primary" id="btnCancelarCertificado">
                                    <i class="fa fa-remove"></i> Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modal end certificado -->

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="background-color: #FFFFFF;">
                <!-- Main content -->
                <section class="content-header">
                    <h3 class="no-margin"> Certificados de Habilidad<small> Lista </small> </h3>
                </section>

                <section class="content">

                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                            <label>Fecha de inicio.</label>
                            <div class="form-group">
                                <input type="date" class="form-control" id="fechaInicio">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                            <label>Fecha de fin.</label>
                            <div class="form-group">
                                <input type="date" class="form-control" id="fechaFinal">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                            <label>Filtrar por colegiado, N° certificado.</label>
                            <div class="form-group">
                                <input type="search" id="buscar" class="form-control" placeholder="Escribe para filtrar automaticamente" aria-describedby="search" value="">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12 col-xs-12">
                            <label>Opción.</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <button type="submit" class="btn btn-default" id="btnRecargar"><i class="fa fa-refresh"></i> Recargar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                                <table class="table table-striped" style="border-width: 1px;border-style: dashed;border-color: #E31E25;">
                                    <thead style="background-color: #FDB2B1;color: #B72928;">
                                        <th width="4%;" class="text-center">#</th>
                                        <th width="4%;" class="text-center">P.D.F</th>
                                        <th width="4%;" class="text-center">Editar</th>
                                        <th width="8%;">N° CIP</th>
                                        <th width="10%;">Colegiado</th>
                                        <th width="10%;">Especialidad</th>
                                        <th width="9%;">N° Certificado</th>
                                        <th width="5%;">Estado</th>
                                        <th width="10%;">Asunto</th>
                                        <th width="10%;">Entidad</th>
                                        <th width="10%;">Lugar</th>
                                        <th width="8%;">Fecha Pago</th>
                                        <th width="8%;">Fecha Venci.</th>
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

                $("#btnRecargar").click(function() {
                    loadInitIngresos();
                });

                $("#btnRecargar").keypress(function(event) {
                    if (event.keyCode === 13) {
                        loadInitIngresos();
                    }
                    event.preventDefault();
                });

                $("#fechaInicio").on("change", function() {
                    if (tools.validateDate($("#fechaInicio").val()) && tools.validateDate($("#fechaFinal").val())) {
                        if (!state) {
                            paginacion = 1;
                            loadTableIngresos(0, "", $("#fechaInicio").val(), $("#fechaFinal").val());
                            opcion = 0;
                        }
                    }
                });

                $("#fechaFinal").on("change", function() {
                    if (tools.validateDate($("#fechaInicio").val()) && tools.validateDate($("#fechaFinal").val())) {
                        if (!state) {
                            paginacion = 1;
                            loadTableIngresos(0, "", $("#fechaInicio").val(), $("#fechaFinal").val());
                            opcion = 0;
                        }
                    }
                });

                $("#buscar").keyup(function(event) {
                    if (event.keyCode === 13) {
                        if ($("#buscar").val().trim() != '') {
                            if (!state) {
                                paginacion = 1;
                                loadTableIngresos(1, $("#buscar").val().trim(), "", "");
                                opcion = 1;
                            }
                        }
                    }
                });

                loadInitIngresos();

                $("#btnCancelarCertificado").click(function() {
                    $('#mdCertHabilidad').modal('hide');
                    cleanModalHabilidad()
                });

                $("#btnCloseCertificado").click(function() {
                    $('#mdCertHabilidad').modal('hide');
                    cleanModalHabilidad()
                });

            });

            function onEventPaginacion() {
                switch (opcion) {
                    case 0:
                        loadTableIngresos(0, "", $("#fechaInicio").val(), $("#fechaFinal").val());
                        break;
                    case 1:
                        loadTableIngresos(1, $("#buscar").val().trim(), "", "");
                        break;
                }
            }

            function loadInitIngresos() {
                if (tools.validateDate($("#fechaInicio").val()) && tools.validateDate($("#fechaFinal").val())) {
                    if (!state) {
                        paginacion = 1;
                        loadTableIngresos(0, "", $("#fechaInicio").val(), $("#fechaFinal").val());
                        opcion = 0;
                    }
                }
            }

            function loadTableIngresos(opcion, buscar, fechaInicio, fechaFinal) {
                $.ajax({
                    url: "../app/controller/IngresoController.php",
                    method: "GET",
                    data: {
                        "type": "allCertHabilidad",
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
                            '<tr class="text-center"><td colspan="11"><img src="./images/spiner.gif"/><p>Cargando información.</p></td></tr>'
                        );
                        state = true;
                        totalPaginacion = 0;
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            tbTable.empty();
                            if (result.data.length == 0) {
                                tbTable.append(
                                    '<tr class="text-center"><td colspan="11"><p>No hay ingresos para mostrar.</p></td></tr>'
                                );
                                $("#lblPaginaActual").html(0);
                                $("#lblPaginaSiguiente").html(0);
                                state = false;
                            } else {
                                for (let ingresos of result.data) {

                                    // let btnAnular = '<button class="btn btn-danger btn-xs" onclick="anularIngreso(\'' + ingresos.idIngreso + '\',\'' + ingresos.dni + '\')">' +
                                    //     '<i class="fa fa-ban"></i></br>Anular' +
                                    //     '</button>';
                                    let btnPdf = '<button class="btn btn-danger btn-xs" onclick="openPdf(\'' + ingresos.idIngreso + '\')">' +
                                        '<i class="fa fa-file-pdf-o" style="font-size:25px;"></i></br>' +
                                        '</button>';
                                    let btnEdit =
                                        '<button class="btn btn-warning btn-xs" onclick="editCertHabilidad(\'' + ingresos.idIngreso + '\')">' +
                                        '<i class="fa fa-edit" style="font-size:25px;"></i>' +
                                        '</button>';

                                    tbTable.append('<tr>' +
                                        '<td class="text-center text-primary">' + ingresos.id + '</td>' +
                                        '<td>' + btnPdf + '</td>' +
                                        '<td>' + btnEdit + '</td>' +
                                        '<td>' + ingresos.numeroCip + '</td>' +
                                        '<td>' + ingresos.dni + '</br>' + ingresos.usuario + ' ' + ingresos.apellidos + '</td>' +
                                        '<td>' + ingresos.especialidad + '</td>' +
                                        '<td>' + ingresos.numCertificado + '</td>' +
                                        '<td>' + (ingresos.estado == 0 ? '<label class="text-danger">ANULADO</label>' : '<label class="text-success">ACTIVO</label>') + '</td>' +
                                        '<td>' + ingresos.asunto + '</td>' +
                                        '<td>' + ingresos.entidad + '</td>' +
                                        '<td>' + ingresos.lugar + '</td>' +
                                        '<td>' + ingresos.fechaPago + '</td>' +
                                        '<td>' + ingresos.fechaVencimiento + '</td>' +
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

            function openPdf(idIngreso) {
                window.open("../app/sunat/pdfCertHabilidad.php?idIngreso=" + idIngreso, "_blank");
            }

            function editCertHabilidad(idCertificado) {
                $('#mdCertHabilidad').modal('show');

                $.ajax({
                    url: "../app/controller/ConceptoController.php",
                    method: "GET",
                    dataType: "json",
                    data: {
                        "type": "certHabilidad",
                        "idCertificado": idCertificado,
                    },
                    beforeSend: function() {

                        cleanModalHabilidad();
                    },
                    success: function(result) {
                        console.log(result)
                        $("#modal-title-certificado-habilidad").empty();
                        $("#modal-title-certificado-habilidad").append('<i class="fa fa fa-edit"> </i> Editar Certificado de Habilidad');
                        if (result.estado == 1) {

                            $("#txtIngenieroCertificado").val(result.data.Apellidos + ', ' + result.data.Nombres);
                            $("#cbEspecialidadCertificado").empty();
                            $("#txtFechaCertificado").val(result.data.Fecha);
                            $("#txtCorrelativoCertificado").val(result.data.Numero);
                            $("#txtAsuntoCertificado").val(result.data.Asunto);
                            $("#txtEntidadCertificado").val(result.data.Entidad);
                            $("#txtLugarCertificado").val(result.data.Lugar);

                            $("#cbEspecialidadCertificado").append('<option value="">- Seleccione -</option>');
                            for (let especialidades of result.especialidades) {
                                $("#cbEspecialidadCertificado").append('<option value="' + especialidades.idEspecialidad + '">' + especialidades.Especialidad + '</option>');
                            }
                        } else {
                                $("#lblCertificadoHabilidadEstado").addClass("text-warning");
                                $("#lblCertificadoHabilidadEstado").append('<i class="fa fa-check"> </i> ' + result.message);
                                $("#cbEspecialidadCertificado").append('<option value="">- Seleccione -</option>');
                        }
                    },
                    error: function(error) {
                        $("#modal-title-certificado-habilidad").empty();
                        $("#modal-title-certificado-habilidad").append('<i class="fa fa-plus"></i> Certificado de Habilidad');
                        $("#cbEspecialidadCertificado").append('<option value="">- Seleccione -</option>');
                        $("#lblCertificadoHabilidadEstado").addClass("text-danger");
                        $("#lblCertificadoHabilidadEstado").append('<i class="fa fa-check"> </i> ' + error.responseText);
                    }
                });
            }

            function anularIngreso(idIngreso, dni) {
                tools.ModalDialogInputText("Ingreso", "¿Está seguro de anular el comprobante?", function(value) {
                    if (value.dismiss == "cancel") {} else if (value.value.length == 0) {
                        tools.ModalAlertWarning("Ingreso", "No ingreso ningún motivo :(");
                    } else {
                        $.ajax({
                            url: "../app/controller/IngresoController.php",
                            method: 'POST',
                            data: {
                                "type": "deleteCertHabilidad",
                                "idIngreso": idIngreso,
                                "idUsuario": dni,
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

            function cleanModalHabilidad() {
                $("#txtIngenieroCertificado").val('');
                $("#cbEspecialidadCertificado").empty();
                $("#txtFechaCertificado").val('');
                $("#txtCorrelativoCertificado").val('');
                $("#txtAsuntoCertificado").val('');
                $("#txtEntidadCertificado").val('');
                $("#txtLugarCertificado").val('');
            }
        </script>
    </body>

    </html>

<?php }
