<?php
session_start();

if (!isset($_SESSION['IdUsuario'])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
    if ($_SESSION["Permisos"][7]["ver"] == 1) {
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

                <!-- modal start certificado de proyecto -->
                <div class="row">
                    <div class="modal fade" id="mdCertProyecto" data-backdrop="static">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" id="btnCloseCertProyecto">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title" id="modal-title-certificado-proyecto">
                                        <i class="fa fa-plus">
                                        </i> Certificado de Proyecto
                                    </h4>
                                </div>
                                <div class="modal-body">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <label id="lblCertificadoProyectoEstado"></label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtIngenieroProyecto">Ingeniero(a)</label>
                                                <input type="text" class="form-control" id="txtIngenieroProyecto" placeholder="Datos completos del ingeniero" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label id="lblEspecialidadProyecto">Especialidad(es)</label>
                                                <select class="form-control" id="cbEspecialidadProyecto">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="txtFechaProyecto">Hábil Hasta</label>
                                                <input type="date" class="form-control" id="txtFechaProyecto" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="txtNumeroCertificadoProyecto">Certificado N°</label>
                                                <input type="text" class="form-control" id="txtNumeroCertificadoProyecto" placeholder="Número del certificado" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="txtModalidadProyecto">Modalidad</label>
                                                <input type="text" class="form-control" id="txtModalidadProyecto" placeholder="Ingrese la modalidad">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="txtPropietarioProyecto">Propietario</label>
                                                <input type="text" class="form-control" id="txtPropietarioProyecto" placeholder="Ingrese el propietario">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtProyectoProyecto">Proyecto</label>
                                                <input type="text" class="form-control" id="txtProyectoProyecto" placeholder="Ingrese el nombre del proyecto">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Departamento/Provincia/Distrito</label>
                                                <select class="form-control select2" style="width: 100%;" id="cbDepartamentoProyecto">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtUrbProyecto">Urb./A.A.H.H./PP.JJ/Asoc</label>
                                                <input type="text" class="form-control" id="txtUrbProyecto" placeholder="Urb./A.A.H.H./PP.JJ/Asoc">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtCalleProyecto">Jr./Av./Calle/Pasaje</label>
                                                <input type="text" class="form-control" id="txtCalleProyecto" placeholder="Jr./Av./Calle/Pasaje">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" id="btnAceptarCertProyecto">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" id="btnCancelCertProyecto">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal end certificado de proyecto -->

                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper" style="background-color: #FFFFFF;">
                    <!-- Main content -->
                    <section class="content-header">
                        <h3 class="no-margin"> Certificados de Proyecto<small> Lista </small> </h3>
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
                                            <th style="width:4%;">#</th>
                                            <th style="width:4%;">P.D.F</th>
                                            <th style="width:4%;">Editar</th>
                                            <th style="width:8%;">Colegiado</th>
                                            <th style="width:12%;">Especialidad</th>
                                            <th style="width:5%;">N° Cert.</th>
                                            <th style="width:5%;">Estado</th>
                                            <th style="width:5%;">Modalidad</th>
                                            <th style="width:10%;">Propietario</th>
                                            <th style="width:12%;">Proyecto</th>
                                            <th style="width:4%;">Monto</th>
                                            <th style="width:13%;">Lugar</th>
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
                let filasPorPagina = 2;
                let tbTable = $("#tbTable");
                let idCertProyecto = 0;

                let editView = "<?= $_SESSION["Permisos"][7]["actualizar"]; ?>";
                let deleteView = "<?= $_SESSION["Permisos"][7]["eliminar"]; ?>";

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

                    $("#btnRecargar").click(function() {
                        loadInitIngresos();
                    });

                    $("#btnRecargar").keypress(function(event) {
                        if (event.keyCode === 13) {
                            loadInitIngresos();
                        }
                        event.preventDefault();
                    });

                    loadInitIngresos();

                    $("#btnAceptarCertProyecto").click(function() {
                        crudEditCertProyecto(idCertProyecto);
                    });

                    $("#btnAceptarCertProyecto").keypress(function(event) {
                        if (event.keyCode === 13) {
                            crudEditCertProyecto(idCertProyecto);
                        }
                        event.preventDefault();
                    });

                    $("#btnCloseCertProyecto").click(function() {
                        $('#mdCertProyecto').modal('hide');
                        cleanModalProyecto()
                    });

                    $("#btnCancelCertProyecto").click(function() {
                        $('#mdCertProyecto').modal('hide');
                        cleanModalProyecto()
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
                            "type": "allCertProyecto",
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
                                            '<i class="fa fa-file-pdf-o" style="font-size:25px;"></i>' +
                                            '</button>';

                                        let btnEdit = editView == 0 ? '<i class="fa fa-minus" style="font-size:20px;"></i>' :
                                            '<button class="btn btn-warning btn-xs" onclick="editCertProyecto(\'' + ingresos.idIngreso + '\')">' +
                                            '<i class="fa fa-edit" style="font-size:25px;"></i>' +
                                            '</button>';

                                        tbTable.append('<tr>' +
                                            '<td class="text-center text-primary">' + ingresos.id + '</td>' +
                                            '<td>' + btnPdf + '</td>' +
                                            '<td>' + btnEdit + '</td>' +
                                            '<td>' + ingresos.dni + '</br>' + ingresos.usuario + ' ' + ingresos.apellidos + '</td>' +
                                            '<td>' + ingresos.especialidad + '</td>' +
                                            '<td>' + ingresos.numCertificado + '</td>' +
                                            '<td>' + (ingresos.estado == "0" ? '<label class="text-success">ACTIVO</label>' : '<label class="text-danger">ANULADO</label>') + '</td>' +
                                            '<td>' + ingresos.modalidad + '</td>' +
                                            '<td>' + ingresos.propietario + '</td>' +
                                            '<td>' + ingresos.proyecto + '</td>' +
                                            '<td>' + tools.formatMoney(ingresos.monto) + '</td>' +
                                            '<td>' + ingresos.ubigeo + '</br>' + ingresos.adicional1 + '</br>' + ingresos.adicional2 + '</td>' +
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
                    window.open("../app/sunat/pdfCertProyecto.php?idIngreso=" + idIngreso, "_blank");
                }

                function editCertProyecto(idIngreso) {
                    $('#mdCertProyecto').modal('show');

                    $.ajax({
                        url: "../app/controller/ConceptoController.php",
                        method: "GET",
                        dataType: "json",
                        data: {
                            "type": "certProyecto",
                            "idIngreso": idIngreso,
                        },
                        beforeSend: function() {

                            cleanModalProyecto();
                        },
                        success: function(result) {
                            $("#modal-title-certificado-proyecto").empty();
                            $("#modal-title-certificado-proyecto").append('<i class="fa fa-edit"> </i> Editar Certificado de Proyecto');

                            if (result.estado == 1) {
                                $("#cbEspecialidadProyecto").append('<option value="">- Seleccione -</option>');
                                for (let especialidades of result.especialidades) {
                                    $("#cbEspecialidadProyecto").append('<option value="' + especialidades.idEspecialidad + '">' + especialidades.Especialidad + '</option>');
                                }

                                $("#cbDepartamentoProyecto").append('<option value="">- Seleccione un Ubigeo -</option>');
                                for (let ubigeo of result.ubigeo) {
                                    $("#cbDepartamentoProyecto").append('<option value="' + ubigeo.IdUbicacion + '">' + ubigeo.Ubicacion + '</option>');
                                }
                                $('#cbDepartamentoProyecto').select2();

                                idCertProyecto = result.data.idProyecto;
                                $("#txtIngenieroProyecto").val(result.data.Apellidos + ', ' + result.data.Nombres);
                                $("#cbEspecialidadProyecto").val(result.data.idEspecialidad);
                                $("#txtFechaProyecto").val(result.data.HastaFecha);
                                $("#txtNumeroCertificadoProyecto").val(result.data.Numero);
                                $("#txtModalidadProyecto").val(result.data.Modalidad);
                                $("#txtPropietarioProyecto").val(result.data.Propietario);
                                $("#txtProyectoProyecto").val(result.data.Proyecto);
                                $('#cbDepartamentoProyecto').val(result.data.idUbigeo).trigger('change.select2');
                                $("#txtUrbProyecto").val(result.data.Adicional1);
                                $("#txtCalleProyecto").val(result.data.Adicional2);

                            } else {
                                $("#lblCertificadoProyectoEstado").addClass("text-warning");
                                $("#lblCertificadoProyectoEstado").append('<i class="fa fa-check"> </i> ' + result.message);
                                $("#cbEspecialidadProyecto").append('<option value="">- Seleccione -</option>');
                                $("#cbDepartamentoProyecto").append('<option value="">- Seleccione -</option>');
                            }
                        },
                        error: function(error) {
                            $("#modal-title-certificado-proyecto").empty();
                            $("#modal-title-certificado-proyecto").append('<i class="fa fa-edit"></i> Editar Certificado de Habilidad para Firmar de Contrato de Obra Pública o Residencia');
                            $("#cbEspecialidadProyecto").append('<option value="">- Seleccione -</option>');
                            $("#cbDepartamentoProyecto").append('<option value="">- Seleccione -</option>');
                            $("#lblCertificadoProyectoEstado").addClass("text-danger");
                            $("#lblCertificadoProyectoEstado").append('<i class="fa fa-check"> </i> ' + error.responseText);
                        }
                    });
                }

                function crudEditCertProyecto(idCertProyecto) {

                    if ($("#cbEspecialidadProyecto").val() == '') {
                        tools.AlertWarning("Certificado de Proyecto", "Seleccione una especialidad para continuar.");
                        $("#cbEspecialidadProyecto").focus();
                    } else if ($("#txtModalidadProyecto").val() == '') {
                        tools.AlertWarning("Certificado de Proyecto", "Ingrese una modalidad para continuar.");
                        $("#txtModalidadProyecto").focus();
                    } else if ($("#txtPropietarioProyecto").val() == '') {
                        tools.AlertWarning("Certificado de Proyecto", "Ingrese un Propietario para continuar.");
                        $("#txtPropietarioProyecto").focus();
                    } else if ($("#txtProyectoProyecto").val() == '') {
                        tools.AlertWarning("Certificado de Proyecto", "Ingrese un Proyecto para continuar.");
                        $("#txtProyectoProyecto").focus();
                    } else if ($("#cbDepartamentoProyecto").val() == '') {
                        tools.AlertWarning("Certificado de Proyecto", "Ingrese un Departamento/Provincia/Distrito para continuar.");
                        $("#cbDepartamentoProyecto").focus();
                    } else if ($("#txtUrbProyecto").val() == '') {
                        tools.AlertWarning("Certificado de Proyecto", "Ingrese una Urb./A.A.H.H./PP.JJ/Asoc para continuar.");
                        $("#txtUrbProyecto").focus();
                    } else if ($("#txtCalleProyecto").val() == '') {
                        tools.AlertWarning("Certificado de Proyecto", "Ingrese una Jr./Av./Calle/Pasaje para continuar.");
                        $("#txtCalleProyecto").focus();
                    } else {
                        $.ajax({
                            url: "../app/controller/ConceptoController.php",
                            method: "POST",
                            data: {
                                "type": "certProyecto",
                                "idCertificado": idCertProyecto,
                                "especialidad": $("#cbEspecialidadProyecto").val(),
                                "modalidad": $("#txtModalidadProyecto").val(),
                                "proyecto": $("#txtProyectoProyecto").val(),
                                "propietario": $("#txtPropietarioProyecto").val(),
                                "ubigeo": $("#cbDepartamentoProyecto").val(),
                                "adicional1": $("#txtUrbProyecto").val(),
                                "adicional2": $("#txtCalleProyecto").val()

                            },
                            beforeSend: function() {
                                tools.ModalAlertInfo("Certificado Proyecto", "Procesando petición..");
                            },
                            success: function(result) {
                                if (result.estado == 1) {
                                    tools.ModalAlertSuccess("Certificado Proyecto", result.message);
                                    loadInitIngresos();
                                } else {
                                    tools.ModalAlertWarning("Certificado Proyecto", result.message);
                                }
                                $('#mdCertProyecto').modal('hide');
                                cleanModalProyecto();
                            },

                            error: function(error) {
                                tools.ModalAlertError("Certificado Proyecto", "Se produjo un error: " + error.responseText);
                            }
                        });
                    }
                }

                function cleanModalProyecto() {
                    $("#txtIngenieroProyecto").val('');
                    $("#cbEspecialidadProyecto").empty();
                    $("#txtFechaProyecto").val('');
                    $("#txtNumeroCertificadoProyecto").val('');
                    $("#txtModalidadProyecto").val('');
                    $("#txtPropietarioProyecto").val('');
                    $("#txtProyectoProyecto").val('');
                    $("#cbDepartamentoProyecto").empty();
                    $("#txtUrbProyecto").val('');
                    $("#txtCalleProyecto").val('');
                    idCertProyecto = 0;
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
                                    "type": "deleteCertProyecto",
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
