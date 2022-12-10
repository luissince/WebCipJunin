<?php
session_start();

if (!isset($_SESSION['IdUsuario'])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
    if ($_SESSION["Permisos"][9]["ver"] == 1) {
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
                <!-- modal añadir universidad  -->
                <div class="row">
                    <div class="modal fade" id="mdAddUniversidad">
                        <div class="modal-dialog modal-xs" style="width: 500px;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" id="btnCloseAddUniversidad">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-university">
                                        </i> Registrar Universidad
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Universidad" class="col-sm-4 control-label">Universidad</label>
                                                <div class="col-sm-8">
                                                    <input id="txtUniversidad" type="text" class="form-control" placeholder="Nombre Universidad" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-top: 0.5em;">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Universidad" class="col-sm-4 control-label">Siglas</label>
                                                <div class="col-sm-8">
                                                    <input id="txtSiglas" type="text" class="form-control" placeholder="Escriba las siglas" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" id="btnAceptarUniversidad">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="cancel-nuevo">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end modal añadir universidad -->

                <!-- modal editar Universidad  -->
                <div class="row">
                    <div class="modal fade" id="editAddUniversidad">
                        <div class="modal-dialog modal-xs" style="width: 500px;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" id="btnCLoseEditUniversidad">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-university">
                                        </i> Editar Universidad
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Universidad" class="col-sm-3 control-label">Universidad</label>
                                                <div class="col-sm-9">
                                                    <input id="txtUniversidad1" type="text" class="form-control" placeholder="Nombre Universidad" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-top: 0.5em;">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Universidad" class="col-sm-3 control-label">Siglas</label>
                                                <div class="col-sm-9">
                                                    <input id="txtSiglas1" type="text" class="form-control" placeholder="Escriba las siglas" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" id="btnAceptarUpdateUniversidad">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="cancel-nuevo">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end modal editar universidad -->

                <!-- modal eliminar Universidad  -->
                <div class="row">
                    <div class="modal fade" id="deleteUniversidad">
                        <div class="modal-dialog modal-xs" style="width: 500px;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-university">
                                        </i> Eliminar Universidad
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Universidad" class="col-sm-12 control-label">¿Estas seguro que deseas elimininar esta universidad?</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-warning" id="btnDeleteUniversidad">
                                            <i class="fa fa-check"></i> Aceptar</button>
                                        <button type="button" class="btn btn-primary" data-dismiss="modal" id="cancel-nuevo">
                                            <i class="fa fa-remove"></i> Cancelar</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end modal eliminar universidad -->
                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper" style="background-color: #FFFFFF;">
                    <!-- Main content -->
                    <section class="content-header">
                        <h3 class="no-margin"> Universidades <small> Lista </small> </h3>
                    </section>

                    <section class="content">

                        <div class="row">
                            <?php
                            if ($_SESSION["Permisos"][9]["crear"] == 1) {
                                echo '<div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <label>Nueva universidad.</label>
                                <div class="form-group">
                                    <button type="button" class="btn btn-success" id="btnNuevo">
                                        <i class="fa fa-plus"></i> Agregar universidad
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
                                <label>Filtrar por nombre o siglas.</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="search" id="buscar" class="form-control" placeholder="Buscar por Universidad o sigla" aria-describedby="search" value="">
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
                                            <th width="30%">Universidad</th>
                                            <th width="15%">Sigla</th>
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

                let editView = "<?= $_SESSION["Permisos"][9]["actualizar"]; ?>";
                let deleteView = "<?= $_SESSION["Permisos"][9]["eliminar"]; ?>";

                $(document).ready(function() {

                    loadInitUniversidades();

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
                        loadInitUniversidades()
                    });

                    $("#buscar").on("keyup", function(event) {
                        if (event.keyCode === 13) {
                            paginacion = 1;
                            loadTableUniversidades($("#buscar").val());
                            opcion = 1;
                        }
                    });

                    $("#btnNuevo").click(function() {
                        $("#mdAddUniversidad").modal("show");
                    })

                    $("#btnAceptarUniversidad").click(function() {
                        crudUniversidad($("#txtUniversidad").val(), $("#txtSiglas").val());
                    });

                    $("#cancel-nuevo").click(function() {
                        $("#confirmar").modal("hide");
                        $("#txtUniversidad").val('');
                        $("#txtSiglas").val('');
                    });

                    $("#btnCloseAddUniversidad").click(function() {
                        $("#mdAddUniversidad").modal("hide");
                        $("#txtUniversidad").val('');
                        $("#txtSiglas").val('');
                    });

                    $("#btnCLoseEditUniversidad").click(function() {
                        $("#editAddUniversidad").modal("hide");
                        $("#txtUniversidad1").val('');
                        $("#txtSiglas1").val('');
                    });
                });

                function onEventPaginacion() {
                    switch (opcion) {
                        case 0:
                            loadTableUniversidades("");
                            break;
                        case 1:
                            loadTableUniversidades($("#buscar").val());
                            break;
                    }
                }

                function loadInitUniversidades() {
                    if (!state) {
                        paginacion = 1;
                        loadTableUniversidades("");
                        opcion = 0;
                    }
                }

                function loadTableUniversidades(nombres) {
                    $.ajax({
                        url: "../app/controller/UniversidadController.php",
                        method: "GET",
                        data: {
                            "type": "alldata",
                            "nombres": nombres,
                            "posicionPagina": ((paginacion - 1) * filasPorPagina),
                            "filasPorPagina": filasPorPagina
                        },
                        beforeSend: function() {
                            tbTable.empty();
                            tbTable.append(
                                '<tr class="text-center"><td colspan="5"><img src="./images/spiner.gif"/><p>Cargando información.</p></td></tr>'
                            );
                            state = true;
                            totalPaginacion = 0;
                        },
                        success: function(result) {
                            if (result.estado === 1) {
                                tbTable.empty();
                                if (result.universidades.length == 0) {
                                    tbTable.append(
                                        '<tr class="text-center"><td colspan="5"><p>No hay datos para mostrar</p></td></tr>'
                                    );
                                    $("#lblPaginaActual").html(paginacion);
                                    $("#lblPaginaSiguiente").html(totalPaginacion);
                                    state = false;
                                }
                                for (let universidad of result.universidades) {

                                    let btnUpdate = editView == 0 ? '<i class="fa fa-minus" style="font-size:20px;"></i>' :
                                        '<button class="btn btn-warning btn-xs" onclick="updateUniversidad(\'' + universidad.idUniversidad + '\',\'' +
                                        universidad.universidad + '\',\'' + universidad.siglas + '\')">' +
                                        '<i class="fa fa-edit" style="font-size:25px;"></i>' +
                                        '</button>';
                                    let btnDelete = deleteView == 0 ? '<i class="fa fa-minus" style="font-size:20px;"></i>' :
                                        '<button class="btn btn-danger btn-xs" onclick="deleteUniversidad(\'' + universidad.idUniversidad + '\')">' +
                                        '<i class="fa fa-trash" style="font-size:25px;"></i>' +
                                        '</button>';

                                    tbTable.append('<tr>' +
                                        '<td class="text-center text-primary">' + universidad.Id + '</td>' +
                                        '<td>' + universidad.universidad + '</td>' +
                                        '<td>' + universidad.siglas + '</td>' +
                                        '<td class="text-center">' + btnUpdate + '' + '</td>' +
                                        '<td class="text-center">' + btnDelete + '</td>' +
                                        '</tr>');
                                }
                                totalPaginacion = parseInt(Math.ceil((parseFloat(result.total) / parseInt(
                                    filasPorPagina))));
                                $("#lblPaginaActual").html(paginacion);
                                $("#lblPaginaSiguiente").html(totalPaginacion);
                                state = false;
                            } else {
                                tbTable.empty();
                                tbTable.append(
                                    '<tr class="text-center"><td colspan="5"><p>No se pudo cargar la información.</p></td></tr>'
                                );
                                $("#lblPaginaActual").html(0);
                                $("#lblPaginaSiguiente").html(0);
                                state = false;
                            }
                        },
                        error: function(error) {
                            tbTable.empty();
                            tbTable.append(
                                '<tr class="text-center"><td colspan="5"><p>Se produjo un error, intente nuevamente.</p></td></tr>'
                            );
                            $("#lblPaginaActual").html(0);
                            $("#lblPaginaSiguiente").html(0);
                            state = false;
                        }
                    });
                }

                function crudUniversidad(universidad, siglas) {
                    if ($("#txtUniversidad").val() == '') {
                        tools.AlertWarning('Universidad', "Ingrese una universidad");
                        $("#txtUniversidad").focus();
                    } else if ($("#txtSiglas").val() == '') {
                        tools.AlertWarning('Universidad', "Ingrese las siglas");
                        $("#txtSiglas").focus();
                    } else {
                        $.ajax({
                            url: "../app/controller/UniversidadController.php",
                            method: "POST",
                            data: {
                                "type": "insertUniversidad",
                                "universidad": universidad,
                                "siglas": siglas,
                            },
                            beforeSend: function() {
                                tools.AlertInfo("Universidad", "Procesando información.");
                            },
                            success: function(result) {
                                if (result.estado == 1) {
                                    tools.AlertSuccess("Universidad", "Se registro correctamente.");
                                    $("#mdAddUniversidad").modal("hide");
                                    clearModal();
                                } else if (result.estado == 3) {
                                    tools.AlertWarning("Universidad", result.message);
                                } else {
                                    tools.AlertWarning("Universidad", result.message);
                                }
                            },
                            error: function(error) {
                                tools.AlertError("Universidad", "Error fatal: Comuniquese con el administrador del sistema");
                            }
                        });
                    }
                }

                function updateUniversidad(idU, nombre, abreviatura) {
                    let idUniversidad = idU;
                    let universidad = nombre;
                    let siglas = abreviatura;
                    $("#editAddUniversidad").modal("show");
                    $("#txtUniversidad1").val(universidad);
                    $("#txtSiglas1").val(siglas);

                    $("#btnAceptarUpdateUniversidad").unbind();

                    $("#btnAceptarUpdateUniversidad").bind("click", function() {
                        if ($("#txtUniversidad1").val() == '') {
                            tools.AlertWarning('Universidad', "Ingrese una universidad");
                            $("#txtUniversidad1").focus();
                        } else if ($("#txtSiglas1").val() == '') {
                            tools.AlertWarning('Universidad', "Ingrese las siglas");
                            $("#txtSiglas1").focus();
                        } else {
                            $.ajax({
                                url: "../app/controller/UniversidadController.php",
                                method: "POST",
                                data: {
                                    "type": "updateUniversidad",
                                    "iduniversidad": idUniversidad,
                                    "universidad": $("#txtUniversidad1").val(),
                                    "siglas": $("#txtSiglas1").val(),
                                },
                                beforeSend: function() {
                                    tools.AlertInfo("Universidad", "Procesando información.");
                                },
                                success: function(result) {
                                    if (result.estado == 1) {
                                        tools.AlertSuccess("Universidad", "Se actualizo correctamente.");
                                        $("#editAddUniversidad").modal("hide");
                                    } else if (result.estado == 3) {
                                        tools.AlertWarning("Universidad", result.message);
                                        // } else if (result.estado == 4) {
                                        //     tools.AlertWarning("Universidad", result.message);
                                    } else {
                                        tools.AlertWarning("Universidad", result.message);
                                    }
                                },
                                error: function(error) {
                                    console.log(error);
                                    tools.AlertError("Universidad", "Error fatal: Comuniquese con el administrador del sistema");
                                }
                            });
                        }
                    })
                }

                function deleteUniversidad(idU) {
                    $("#deleteUniversidad").modal("show");

                    let idUniversidad = idU;

                    $("#btnDeleteUniversidad").unbind();

                    $("#btnDeleteUniversidad").bind("click", function() {
                        $.ajax({
                            url: "../app/controller/UniversidadController.php",
                            method: "POST",
                            data: {
                                "type": "deleteUniversidad",
                                "iduniversidad": idUniversidad,
                            },
                            beforeSend: function() {
                                $("#deleteUniversidad").modal("hide");
                                tools.ModalAlertInfo("Universidad", "Procesando petición..");
                            },
                            success: function(result) {
                                if (result.estado == 1) {
                                    tools.ModalAlertSuccess("Universidad", result.message);
                                    loadInitUniversidades()
                                } else if (result.estado == 2) {
                                    tools.ModalAlertWarning("Universidad", result.message);
                                } else if (result.estado == 3) {
                                    tools.ModalAlertWarning("Universidad", result.message);
                                } else {
                                    tools.ModalAlertWarning("Universidad", result.message);
                                }
                            },
                            error: function(error) {
                                tools.ModalAlertError("Universidad", error.responseText);
                            }
                        });
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
