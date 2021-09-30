<?php
session_start();

if (!isset($_SESSION['IdUsuario'])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
    if ($_SESSION["Permisos"][17]["ver"] == 1) {
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
                <!-- Content Wrapper. Contains page content -->
                <!-- modal nuevo Comprobante  -->
                <div class="row">
                    <div class="modal fade" id="NuevoComprobante">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" id="btnCloseComprobante">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title" id="modal-comprobante-title">
                                        <i class="fa fa-file-text-o"></i> Registrar comprobante
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtNombre">Nombre: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="txtNombre" type="text" class="form-control" placeholder="Ingrese Nombre" required="" minlength="11">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="txtSerie">Serie: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="txtSerie" type="text" class="form-control" placeholder="Serie ejemp (B001/F001)" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="txtNumeracion">Numeracion: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="txtNumeracion" type="number" class="form-control" placeholder="Ingrese numeracion" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="txtAlterno">Codigo Alterno: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="txtAlterno" type="number" class="form-control" placeholder="Codigo alterno" required="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="cbPredeterminado">Predeterminado:</label>
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" id="cbPredeterminado">
                                                        Si
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="cbEstado">Estado:</label>
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" id="cbEstado">
                                                        Activo
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="cbUsaRuc">Usa RUC:</label>
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" id="cbUsaRuc">
                                                        Si
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12" style="border-top: 1px solid #cacacb; margin: 5px 0 15px 0;">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="rbGuiaRemision">Comprobante para Guía de Remisión:</label>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" id="rbGuiaRemision" name="optionRadio">
                                                        Si
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="rbFacturado">Comprobante Facturado:</label>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" id="rbFacturado" name="optionRadio" checked>
                                                        Si
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="rbNotaCredito">Comprobante para Nota de crédito:</label>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" id="rbNotaCredito" name="optionRadio">
                                                        Si
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="cbDestino">Destino: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <select id="cbDestino" class="form-control">
                                                    <option value="1">MIXTO</option>
                                                    <option value="2">INTRANET</option>
                                                    <option value="3">CIP VIRTUAL</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <p class="text-left text-danger">Todos los campos marcados con <i class="fa fa-fw fa-asterisk text-danger"></i> son obligatorios</p>
                                    <button type="submit" class="btn btn-danger" id="btnAceptarAddComprobante">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" id="btnCancelarAddComprobante">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- final modal nuevo comprobante -->
                <div class="content-wrapper" style="background-color: #FFFFFF;">
                    <!-- Main content -->
                    <section class="content-header">
                        <h3 class="no-margin"> Comprobantes <small> Lista </small> </h3>
                    </section>

                    <section class="content">

                        <div class="row">
                            <?php

                            if ($_SESSION["Permisos"][17]["crear"] == 1) {
                                echo '
                                <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                    <label>Nuevo Comprobante.</label>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-success" id="btnNuevoComprobante">
                                            <i class="fa fa-plus"></i> Agregar
                                        </button>
                                    </div>
                                </div>';
                            } ?>

                            <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <label>Opción.</label>
                                <div class="form-group">
                                    <button class="btn btn-default" id="btnactualizar">
                                        <i class="fa fa-refresh"></i> Recargar
                                    </button>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label>Filtrar por nombre, serie y numeración.</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="search" id="txtBuscar" class="form-control" placeholder="Buscar por Nombre o tipo de comprobante" aria-describedby="search" value="">
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
                                            <th width="20%">Nombre</th>
                                            <th width="10%">Serie</th>
                                            <th width="10%">Numeración</th>
                                            <th width="10%">Código Alterno</th>
                                            <th width="10%">Predeterminado</th>
                                            <th width="10%">Estado</th>
                                            <th width="10%">Usa Ruc</th>
                                            <th width="10%">Destino</th>
                                            <th width="5%" class="text-center">Editar</th>
                                            <th width="5%" class="text-center">Eliminar</th>
                                        </thead>
                                        <tbody id="tbTable">

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

                let editView = "<?= $_SESSION["Permisos"][17]["actualizar"]; ?>";
                let deleteView = "<?= $_SESSION["Permisos"][17]["eliminar"]; ?>";

                let idComprobante = 0;

                $(document).ready(function() {

                    loadInitComprobantes();

                    $("#btnNuevoComprobante").click(function() {
                        idComprobante = 0;
                        $("#NuevoComprobante").modal("show");
                        $("#modal-comprobante-title").empty()
                        $("#modal-comprobante-title").append('<i class="fa fa-file-text-o"></i> Registrar comprobante')
                    });

                    $("#btnNuevoComprobante").keypress(function(event) {
                        if (event.keyCode == 13) {
                            idComprobante = 0;
                            $("#NuevoComprobante").modal("show");
                            $("#modal-comprobante-title").empty()
                            $("#modal-comprobante-title").append('<i class="fa fa-file-text-o"></i> Registrar comprobante')
                        }
                        event.preventDefault();
                    });

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

                    $("#btnactualizar").click(function() {
                        loadInitComprobantes();
                    });

                    $("#txtBuscar").on("keyup", function(event) {
                        if (event.keyCode === 13) {
                            paginacion = 1;
                            loadTableComprobante($("#txtBuscar").val());
                            opcion = 1;
                        }
                    });

                    $("#btnSearch").click(function() {
                        paginacion = 1;
                        loadTableComprobante($("#txtBuscar").val());
                        opcion = 1;
                    });

                    //---------------------------------------------------------------------------
                    // $("#btnNuevo").click(function() {
                    //     clearModalAddEmpresa();
                    //     $("#NuevaEmpresaPersona").modal("show")
                    //     $("#modal-empresa-title").empty()
                    //     $("#modal-empresa-title").append('<i class="fa fa-building-o"></i> Registrar Empresa')
                    // })

                    $("#btnAceptarAddComprobante").click(function() {
                        crudComprobante();
                    });

                    $("#btnCancelarAddComprobante").click(function() {
                        clearModalAddComprobante()
                    });

                    $("#btnCloseComprobante").click(function() {
                        clearModalAddComprobante()
                    });

                });

                function onEventPaginacion() {
                    switch (opcion) {
                        case 0:
                            loadTableComprobante("");
                            break;
                        case 1:
                            loadTableComprobante($("#txtBuscar").val());
                            break;
                    }
                }

                function loadInitComprobantes() {
                    if (!state) {
                        paginacion = 1;
                        loadTableComprobante("");
                        opcion = 0;
                    }
                }

                function loadTableComprobante(nombres) {
                    $.ajax({
                        url: "../app/controller/ComprobanteController.php",
                        method: "GET",
                        data: {
                            "type": "listaComprobantes",
                            "nombres": nombres,
                            "posicionPagina": ((paginacion - 1) * filasPorPagina),
                            "filasPorPagina": filasPorPagina
                        },
                        beforeSend: function() {
                            tbTable.empty();
                            tbTable.append(
                                '<tr class="text-center"><td colspan="9"><img src="./images/spiner.gif"/><p>Cargando información.</p></td></tr>'
                            );
                            state = true;
                            totalPaginacion = 0;
                        },
                        success: function(result) {
                            if (result.estado === 1) {
                                tbTable.empty();
                                if (result.data.length == 0) {
                                    tbTable.append(
                                        '<tr class="text-center"><td colspan="9"><p>No hay datos para mostrar.</p></td></tr>'
                                    );

                                    $("#lblPaginaActual").html(paginacion);
                                    $("#lblPaginaSiguiente").html(totalPaginacion);
                                    state = false;
                                } else {
                                    for (let comprobante of result.data) {

                                        let btnUpdate = editView == 0 ? '<i class="fa fa-minus" style="font-size:20px;"></i>' :
                                            '<button class="btn btn-warning btn-xs" onclick="updateComprobante(\'' + comprobante.IdTipoComprobante + '\')">' +
                                            '<i class="fa fa-edit" style="font-size:25px;"></i>' +
                                            '</button>';

                                        let btnDelete = deleteView == 0 ? '<i class="fa fa-minus" style="font-size:20px;"></i>' :
                                            '<button class="btn btn-danger btn-xs" onClick="deleteComprobante(\'' + comprobante.IdTipoComprobante + '\')">' +
                                            '<i class="fa fa-trash" style="font-size:25px;"></i> ' +
                                            '</button>';

                                        let predeterminado = comprobante.Predeterminado == "SI" ? '<span class="text-success">' + comprobante.Predeterminado + '</span>' : '<span class="text-danger">' + comprobante.Predeterminado + '</span>';

                                        let estado = comprobante.Estado == "ACTIVO" ? '<span class="text-primary">' + comprobante.Estado + '</span>' : '<span class="text-danger">' + comprobante.Estado + '</span>';

                                        let destino = comprobante.Destino == 1 ? "MIXTO" : comprobante.Destino == 2 ? "INTRANET" : "CIP VIRTUAL";

                                        tbTable.append('<tr>' +
                                            '<td class="text-center text-primary">' + comprobante.Id + '</td>' +
                                            '<td>' + comprobante.Nombre + '</td>' +
                                            '<td>' + comprobante.Serie + '</td>' +
                                            '<td>' + comprobante.Numeracion + '</td>' +
                                            '<td>' + comprobante.CodigoAlterno + '</td>' +
                                            '<td>' + predeterminado + '</td>' +
                                            '<td>' + estado + '</td>' +
                                            '<td>' + comprobante.Usa_ruc + '</td>' +
                                            '<td>' + destino + '</td>' +
                                            '<td class="text-center">' + btnUpdate + '</td>' +
                                            '<td class="text-center">' + btnDelete + '</td>' +
                                            '</tr>');
                                    }
                                    totalPaginacion = parseInt(Math.ceil((parseFloat(result.total) / parseInt(
                                        filasPorPagina))));
                                    $("#lblPaginaActual").html(paginacion);
                                    $("#lblPaginaSiguiente").html(totalPaginacion);
                                    state = false;
                                }
                            } else {
                                console.log(result);
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
                            tbTable.empty();
                            console.log(error);
                            tbTable.append(
                                '<tr class="text-center"><td colspan="9"><p>Se produjo un error, intente nuevamente.</p></td></tr>'
                            );
                            $("#lblPaginaActual").html(0);
                            $("#lblPaginaSiguiente").html(0);
                            state = false;
                        }
                    });
                }

                function crudComprobante() {
                    if ($("#txtNombre").val() == '') {
                        $("#txtNombre").focus();
                        tools.AlertWarning("Comprobante", "Ingrese un Nombre")
                    } else if ($("#txtSerie").val() == "") {
                        $("#txtSerie").focus();
                        tools.AlertWarning("Comprobante", "Ingrese Serie")
                    } else if ($("#txtNumeracion").val() == "") {
                        $("#txtNumeracion").focus();
                        tools.AlertWarning("Comprobante", "Ingrese Numeracion")
                    } else if ($("#txtAlterno").val() == "") {
                        $("#txtAlterno").focus();
                        tools.AlertWarning("Comprobante", "Ingrese Código Alterno")
                    } else {
                        tools.ModalDialog("Comprobante", "¿Está seguro de continuar?", function(value) {
                            if (value == true) {
                                $.ajax({
                                    url: "../app/controller/ComprobanteController.php",
                                    method: "POST",
                                    data: {
                                        "type": "addComprobante",
                                        "idComprobante": idComprobante,
                                        "nombre": $("#txtNombre").val(),
                                        "serie": $("#txtSerie").val(),
                                        "numeracion": $("#txtNumeracion").val(),
                                        "codigoAlterno": $("#txtAlterno").val(),
                                        "predeterminado": $("#cbPredeterminado").is(":checked"),
                                        "estado": $("#cbEstado").is(":checked"),
                                        "usaRuc": $("#cbUsaRuc").is(":checked"),
                                        "comprobanteAfiliado": $("#rbGuiaRemision").is(":checked") ? 1 : $("#rbFacturado").is(":checked") ? 2 : $("#rbNotaCredito").is(":checked") ? 3 : 0,
                                        "destino": $("#cbDestino").val()
                                    },
                                    beforeSend: function() {
                                        clearModalAddComprobante();
                                        tools.ModalAlertInfo("Comprobante", "Procesando petición..");
                                    },
                                    success: function(result) {
                                        if (result.estado === 1) {
                                            loadInitComprobantes();
                                            tools.ModalAlertSuccess("Comprobante", result.mensaje);
                                        } else if (result.estado === 2) {
                                            loadInitComprobantes();
                                            tools.ModalAlertSuccess("Comprobante", result.mensaje);
                                        } else {
                                            tools.ModalAlertWarning("Comprobante", result.mensaje);
                                        }
                                    },
                                    error: function(error) {
                                        tools.ModalAlertError("Empresa", "Se produjo un error: " + error.responseText);
                                    }
                                });
                            }
                        });
                    }
                }

                function clearModalAddComprobante() {
                    $("#modal-comprobante-title").empty()
                    $("#NuevoComprobante").modal("hide");
                    $("#txtNombre").val("");
                    $("#txtSerie").val("");
                    $("#txtNumeracion").val("");
                    $("#txtAlterno").val("");
                    $("#cbPredeterminado").prop("checked", false);
                    $("#cbEstado").prop("checked", false);
                    $("#cbUsaRuc").prop("checked", false);
                    $("#rbGuiaRemision").prop("checked", false);
                    $("#rbFacturado").prop("checked", false);
                    $("#rbNotaCredito").prop("checked", false);
                    $("#cbDestino").val("1");
                    idComprobante = 0;
                }

                function updateComprobante(id) {
                    $("#NuevoComprobante").modal("show");
                    $("#modal-comprobante-title").empty()
                    $("#modal-comprobante-title").append('<i class="fa fa-file-text-o"></i> Editar comprobante')
                    $.ajax({
                        url: "../app/controller/ComprobanteController.php",
                        method: "GET",
                        data: {
                            "type": "updateComprobante",
                            "idComprobante": id
                        },
                        beforeSend: function() {

                        },
                        success: function(result) {
                            $("#modal-comprobante-title").empty();
                            $("#modal-comprobante-title").append('<i class="fa fa-file-text-o"> </i> Editar comprobante');
                            if (result.estado == 1) {
                                let comprobante = result.Comprobante;
                                idComprobante = id;

                                $("#txtNombre").val(comprobante.Nombre);
                                $("#txtSerie").val(comprobante.Serie);
                                $("#txtNumeracion").val(comprobante.Numeracion);
                                $("#txtAlterno").val(comprobante.CodigoAlterno);
                                $("#cbPredeterminado").prop("checked", comprobante.Predeterminado == 1 ? true : false);
                                $("#cbEstado").prop("checked", comprobante.Estado == 1 ? true : false);
                                $("#cbUsaRuc").prop("checked", comprobante.UsarRuc == 1 ? true : false);
                                // $("#rbGuiaRemision").prop("checked", comprobante.ComprobanteAfiliado == 1 ? true : false);
                                // $("#rbFacturado").prop("checked", comprobante.ComprobanteAfiliado == 2 ? true : false);
                                // $("#rbNotaCredito").prop("checked", comprobante.ComprobanteAfiliado == 3 ? true : false);

                                if (comprobante.ComprobanteAfiliado == "1") {
                                    $("#rbGuiaRemision").prop("checked", true);
                                } else if (comprobante.ComprobanteAfiliado == "2") {
                                    $("#rbFacturado").prop("checked", true);
                                } else if (comprobante.ComprobanteAfiliado == "3") {
                                    $("#rbNotaCredito").prop("checked", true);
                                }

                                $("#cbDestino").val(comprobante.Destino);

                                tools.AlertInfo("Información", "Se cargo correctamente los datos.");
                            } else {
                                tools.AlertWarning("Advertencia", result.message);
                            }
                        },
                        error: function(error) {
                            $("#modal-user-title").empty();
                            $("#modal-user-title").append('<i class="fa fa-file-text-o"> </i> Editar comprobante');
                            tools.AlertError("Error", error.responseText);
                        }
                    });
                }

                function deleteComprobante(id) {
                    tools.ModalDialog("Comprobante", "¿Está seguro de eliminar el comprobante?", function(value) {
                        if (value == true) {
                            $.ajax({
                                url: "../app/controller/ComprobanteController.php",
                                method: "POST",
                                data: {
                                    "type": "deleteComprobante",
                                    "idComprobante": id,
                                },
                                beforeSend: function() {
                                    tools.ModalAlertInfo("Comprobante", "Procesando petición..");
                                    idUsuario = 0;
                                },
                                success: function(result) {
                                    if (result.estado == 1) {
                                        tools.ModalAlertSuccess("Comprobante", result.message);
                                        loadInitComprobantes();
                                    } else {
                                        tools.ModalAlertWarning("Comprobante", result.message);
                                    }
                                },
                                error: function(error) {
                                    tools.ModalAlertError("Comprobante", error.responseText);
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
