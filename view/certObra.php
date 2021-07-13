<?php
session_start();

if (!isset($_SESSION['IdUsuario'])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
    if ($_SESSION["Permisos"][6]["ver"] == 1) {
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

                <!-- modal start certificado de residencia de obra -->
                <div class="row">
                    <div class="modal fade" id="mdCertResidenciaObra" data-backdrop="static">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" id="btnCloseCertResidenciaObra">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title" id="modal-title-residencia-obra">
                                        <i class="fa fa-plus">
                                        </i> Certificado de Habilidad para Firmar de Contrato de Obra Pública o Residencia
                                    </h4>
                                </div>
                                <div class="modal-body">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <label id="lblCertificadoResidenciaObraEstado"></label>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtIngenieroObra">Ingeniero(a)</label>
                                                <input type="text" class="form-control" id="txtIngenieroObra" placeholder="Datos completos del ingeniero" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label id="lblEspecialidadObra">Especialidad(es)</label>
                                                <select class="form-control" id="cbEspecialidadObra">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="txtFechaObra">Hábil Hasta</label>
                                                <input type="date" class="form-control" id="txtFechaObra" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="txtCertificadoNumeroObra">Certificado N°</label>
                                                <input type="text" class="form-control" id="txtCertificadoNumeroObra" placeholder="Número del Certificado" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtModalidadObra">Modalidad</label>
                                                <input type="text" class="form-control" id="txtModalidadObra" placeholder="Ingrese la Modalidad">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtProyectoObra">Proyecto</label>
                                                <input type="text" class="form-control" id="txtProyectoObra" placeholder="Ingrese el nombre del Proyecto">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtPropietarioObra">Propietario</label>
                                                <input type="text" class="form-control" id="txtPropietarioObra" placeholder="Ingrese la Propiedad">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Departamento/Provincia/Distrito</label>
                                                <select class="form-control select2" style="width: 100%;" id="cbDepartamentoObra">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" id="btnAceptarCertResidenciaObra">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" id="btnCloseCertRecidenciaObra">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal end certificado de residencia de obra-->
                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper" style="background-color: #FFFFFF;">
                    <!-- Main content -->
                    <section class="content-header">
                        <h3 class="no-margin"> Certificados de Residencia de Obra<small> Lista </small> </h3>
                    </section>

                    <section class="content">

                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Fecha de inicio:</label>
                                    <input type="date" class="form-control" id="fechaInicio">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <label>Fecha de fin:</label>
                                <div class="form-group">
                                    <input type="date" class="form-control" id="fechaFinal">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                <label>Filtrar por colegiado, N° de certificado.</label>
                                <div class="form-group">
                                    <input type="search" id="buscar" class="form-control" placeholder="Escribe para filtrar automaticamente" aria-describedby="search" value="">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6 col-sm-12 col-xs-12">
                                <label>Opción</label>
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
                                            <th style="width:4%;" class="text-center">#</th>
                                            <th style="width:4%;" class="text-center">P.D.F</th>
                                            <th style="width: 4%;" class="text-center">Editar</th>
                                            <th style="width:8%;">Usuario</th>
                                            <th style="width:10%;">Especialidad</th>
                                            <th style="width:5%;">N° Cert.</th>
                                            <th style="width:5%;">Estado</th>
                                            <th style="width:6%;">Modalidad</th>
                                            <th style="width:10%;">Propietario</th>
                                            <th style="width:10%;">Proyecto</th>
                                            <th style="width:6%;">Monto</th>
                                            <th style="width:15%;">Lugar</th>
                                            <th style="width:10%;">Fecha Pago</th>
                                            <th style="width:10%;">Fecha Venc.</th>
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
                let idCertObra = 0;

                let editView = "<?= $_SESSION["Permisos"][6]["actualizar"]; ?>";
                let deleteView = "<?= $_SESSION["Permisos"][6]["eliminar"]; ?>";

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

                    $("#fechaInicio").on("change", function() {
                        if (tools.validateDate($("#fechaInicio").val()) && tools.validateDate($("#fechaFinal").val())) {
                            if (!state) {
                                paginacion = 1;
                                loadTableIngresos(0, "", $("#fechaInicio").val(), $("#fechaFinal").val());
                                opcion = 0;
                            }
                        }
                    });

                    $("#buscar").keyup(function() {
                        if ($("#buscar").val().trim() != '') {
                            if (!state) {
                                paginacion = 1;
                                loadTableIngresos(1, $("#buscar").val().trim(), "", "");
                                opcion = 1;
                            }
                        }
                    });

                    loadInitIngresos();

                    $("#btnAceptarCertResidenciaObra").click(function() {
                        crudEditCertObra(idCertObra);
                    });

                    $("#btnAceptarCertResidenciaObra").keypress(function(event) {
                        if (event.keyCode === 13) {
                            crudEditCertObra(idCertObra);
                        }
                        event.preventDefault();
                    });

                    $("#btnCloseCertRecidenciaObra").click(function() {
                        $('#mdCertResidenciaObra').modal('hide');
                        cleanModalObra()
                    });

                    $("#btnCloseCertResidenciaObra").click(function() {
                        $('#mdCertResidenciaObra').modal('hide');
                        cleanModalObra()
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
                            "type": "allCertObra",
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
                                '<tr class="text-center"><td colspan="13"><img src="./images/spiner.gif"/><p>Cargando información.</p></td></tr>'
                            );
                            totalPaginacion = 0;
                            state = true;
                        },
                        success: function(result) {
                            if (result.estado == 1) {
                                if (result.data.length == 0) {
                                    tbTable.empty();
                                    tbTable.append(
                                        '<tr class="text-center"><td colspan="13"><p>No hay ingresos para mostrar.</p></td></tr>'
                                    );
                                    $("#lblPaginaActual").html(0);
                                    $("#lblPaginaSiguiente").html(0);
                                    state = false;
                                } else {
                                    tbTable.empty();
                                    for (let ingresos of result.data) {

                                        // let btnAnular = '<button class="btn btn-danger btn-xs" onclick="anularIngreso(\'' + ingresos.idIngreso + '\',\'' + ingresos.dni + '\')">' +
                                        //     '<i class="fa fa-ban"></i></br>Anular' +
                                        //     '</button>';
                                        let btnPdf = '<button class="btn btn-danger btn-xs" onclick="openPdf(\'' + ingresos.idIngreso + '\')">' +
                                            '<i class="fa fa-file-pdf-o" style="font-size:25px;"></i></br>' +
                                            '</button>';

                                        let btnEdit = editView == 0 ? '<i class="fa fa-minus" style="font-size:20px;"></i>' :
                                            '<button class="btn btn-warning btn-xs" onclick="editCertObra(\'' + ingresos.idIngreso + '\')">' +
                                            '<i class="fa fa-edit" style="font-size:25px;"></i>' +
                                            '</button>';

                                        tbTable.append('<tr>' +
                                            '<td class="text-center text-primary">' + ingresos.id + '</td>' +
                                            '<td class="text-center">' + btnPdf + '</td>' +
                                            '<td>' + btnEdit + '</td>' +
                                            '<td>' + ingresos.dni + '</br>' + ingresos.usuario + ' ' + ingresos.apellidos + '</td>' +
                                            '<td>' + ingresos.especialidad + '</td>' +
                                            '<td>' + ingresos.numCertificado + '</td>' +
                                            '<td>' + (ingresos.estado == "1" ? '<label class="text-danger">ANULADO</label>' : '<label class="text-success">ACTIVO</label>') + '</td>' +
                                            '<td>' + ingresos.modalidad + '</td>' +
                                            '<td>' + ingresos.propietario + '</td>' +
                                            '<td>' + ingresos.proyecto + '</td>' +
                                            '<td>' + tools.formatMoney(ingresos.monto) + '</td>' +
                                            '<td>' + ingresos.ubigeo + '</td>' +
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

                function editCertObra(idIngreso) {
                    $('#mdCertResidenciaObra').modal('show');

                    $.ajax({
                        url: "../app/controller/ConceptoController.php",
                        method: "GET",
                        dataType: "json",
                        data: {
                            "type": "certObra",
                            "idIngreso": idIngreso,
                        },
                        beforeSend: function() {

                            cleanModalObra();
                        },
                        success: function(result) {
                            $("#modal-title-residencia-obra").empty();
                            $("#modal-title-residencia-obra").append('<i class="fa fa-edit"> </i> Editar Certificado de Habilidad para Firmar de Contrato de Obra Pública o Residencia');

                            if (result.estado == 1) {

                                $("#cbEspecialidadObra").append('<option value="">- Seleccione -</option>');
                                for (let especialidades of result.especialidades) {
                                    $("#cbEspecialidadObra").append('<option value="' + especialidades.idEspecialidad + '">' + especialidades.Especialidad + '</option>');
                                }

                                $("#cbDepartamentoObra").append('<option value="">- Seleccione un Ubigeo -</option>');
                                for (let ubigeo of result.ubigeo) {
                                    $("#cbDepartamentoObra").append('<option value="' + ubigeo.IdUbicacion + '">' + ubigeo.Ubicacion + '</option>');
                                }
                                $('#cbDepartamentoObra').select2();

                                idCertObra = result.data.idResidencia;
                                $("#txtIngenieroObra").val(result.data.Apellidos + ', ' + result.data.Nombres);
                                $("#cbEspecialidadObra").val(result.data.idEspecialidad);
                                $("#txtFechaObra").val(result.data.HastaFecha);
                                $("#txtCertificadoNumeroObra").val(result.data.Numero);
                                $("#txtModalidadObra").val(result.data.Modalidad);
                                $("#txtProyectoObra").val(result.data.Proyecto);
                                $("#txtPropietarioObra").val(result.data.Propietario);
                                $('#cbDepartamentoObra').val(result.data.idUbigeo).trigger('change.select2');

                            } else {
                                $("#lblCertificadoResidenciaObraEstado").addClass("text-warning");
                                $("#lblCertificadoResidenciaObraEstado").append('<i class="fa fa-check"> </i> ' + result.message);
                                $("#cbEspecialidadObra").append('<option value="">- Seleccione -</option>');
                                $("#cbDepartamentoObra").append('<option value="">- Seleccione -</option>');
                            }
                        },
                        error: function(error) {
                            $("#modal-title-residencia-obra").empty();
                            $("#modal-title-residencia-obra").append('<i class="fa fa-edit"></i> Editar Certificado de Habilidad para Firmar de Contrato de Obra Pública o Residencia');
                            $("#cbEspecialidadObra").append('<option value="">- Seleccione -</option>');
                            $("#cbDepartamentoObra").append('<option value="">- Seleccione -</option>');
                            $("#lblCertificadoResidenciaObraEstado").addClass("text-danger");
                            $("#lblCertificadoResidenciaObraEstado").append('<i class="fa fa-check"> </i> ' + error.responseText);
                        }
                    });
                }

                function crudEditCertObra(idCertObra) {

                    if ($("#cbEspecialidadObra").val() == '') {
                        tools.AlertWarning("Certificado de Obra", "Seleccione una especialidad para continuar.");
                        $("#cbEspecialidadObra").focus();
                    } else if ($("#txtModalidadObra").val() == '') {
                        tools.AlertWarning("Certificado de Obra", "Ingrese una modalidad para continuar.");
                        $("#txtModalidadObra").focus();
                    } else if ($("#txtProyectoObra").val() == '') {
                        tools.AlertWarning("Certificado de Obra", "Ingrese un proyecto para continuar.");
                        $("#txtProyectoObra").focus();
                    } else if ($("#txtPropietarioObra").val() == '') {
                        tools.AlertWarning("Certificado de Obra", "Ingrese un Propietario para continuar.");
                        $("#txtPropietarioObra").focus();
                    } else if ($("#cbDepartamentoObra").val() == '') {
                        tools.AlertWarning("Certificado de Obra", "Ingrese un Departamento/Provincia/Distrito para continuar.");
                        $("#cbDepartamentoObra").focus();
                    } else {
                        $.ajax({
                            url: "../app/controller/ConceptoController.php",
                            method: "POST",
                            data: {
                                "type": "certObra",
                                "idCertificado": idCertObra,
                                "especialidad": $("#cbEspecialidadObra").val(),
                                "modalidad": $("#txtModalidadObra").val(),
                                "proyecto": $("#txtProyectoObra").val(),
                                "propietario": $("#txtPropietarioObra").val(),
                                "ubigeo": $("#cbDepartamentoObra").val()
                            },
                            beforeSend: function() {
                                tools.ModalAlertInfo("Certificado Obra", "Procesando petición..");
                            },
                            success: function(result) {
                                if (result.estado == 1) {
                                    tools.ModalAlertSuccess("Certificado Obra", result.message);
                                    loadInitIngresos();
                                } else {
                                    tools.ModalAlertWarning("Certificado Obra", result.message);
                                }
                                $('#mdCertResidenciaObra').modal('hide');
                                cleanModalObra();
                            },

                            error: function(error) {
                                tools.ModalAlertError("Certificado Obra", "Se produjo un error: " + error.responseText);
                            }
                        });
                    }
                }

                function cleanModalObra() {
                    $("#txtIngenieroObra").val('');
                    $("#cbEspecialidadObra").empty();
                    $("#txtFechaObra").val('');
                    $("#txtCertificadoNumeroObra").val('');
                    $("#txtModalidadObra").val('');
                    $("#txtProyectoObra").val('');
                    $("#txtPropietarioObra").val('');
                    $("#cbDepartamentoObra").empty();
                    idCertObra = 0;
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
                                    "type": "deleteCertObra",
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
            </script>
        </body>

        </html>

<?php
    } else {
        echo '<script>location.href = "./index.php";</script>';
    }
}
