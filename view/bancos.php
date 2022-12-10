<?php
session_start();

if (!isset($_SESSION['IdUsuario'])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
    if ($_SESSION["Permisos"][24]["ver"] == 1) {
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
                <!-- modal nuevo Banco  -->
                <div class="row">
                    <div class="modal fade" id="NuevoBanco">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" id="btnCloseBanco">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title" id="modal-Banco-title">
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="modal-overlay d-none" id="divLoad">
                                        <div class="modal-overlay-content">
                                            <div>
                                                <i class="fa fa-refresh fa-spin"></i>
                                            </div>
                                            <div>
                                                <label id="lblOverlayModal">Cargando información...</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Nombre">Nombre de la Entidad Bancaria: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="Nombre" type="text" class="form-control" placeholder="Nombre del Banco" required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="NumeroCuenta">Numero de Cuenta: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="NumeroCuenta" type="text" class="form-control" placeholder="Numero de cuenta" required="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="NumeroCuentaInterbancaria">Numero de Cuenta Interbancaria: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="NumeroCuentaInterbancaria" type="text" class="form-control" placeholder="Numero de cuenta interbancaria" required="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="checkbox" id="estado" checked>
                                                <label for="estado" id="lblEstado"> Activo</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <p class="text-left text-danger">Todos los campos marcados con <i class="fa fa-fw fa-asterisk text-danger"></i> son obligatorios</p>
                                    <button type="submit" class="btn btn-danger" id="btnAceptarBanco">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" id="btnCancelarBanco">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end modal new Bussinees -->
                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper" style="background-color: #FFFFFF;">
                    <!-- Main content -->
                    <section class="content-header">
                        <h3 class="no-margin"> Bancos <small> Lista </small> </h3>
                    </section>

                    <section class="content">

                        <div class="row">

                            <?php
                            if ($_SESSION["Permisos"][24]["crear"]) {
                                echo '<div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <label>Nueva Entidad.</label>
                                <div class="form-group">
                                    <button type="button" class="btn btn-success" id="btnNuevo">
                                        <i class="fa fa-plus"></i> Agregar Entidad
                                    </button>
                                </div>
                            </div>';
                            }
                            ?>
                            <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <label>Opción.</label>
                                <div class="form-group">
                                    <button class="btn btn-default" id="btnactualizar">
                                        <i class="fa fa-refresh"></i> Recargar
                                    </button>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label>Filtrar por Nombre del Banco.</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="search" id="buscar" class="form-control" placeholder="Buscar..." aria-describedby="search" value="">
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
                                            <th width="20%">Numero de Cuenta</th>
                                            <th width="25%">Numero Cuenta Interbancaria</th>
                                            <th width="15%">Estado</th>
                                            <th width="15%" colspan="2">Opciones</th>
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

                let editView = "<?= $_SESSION["Permisos"][24]["actualizar"]; ?>";
                let deleteView = "<?= $_SESSION["Permisos"][24]["eliminar"]; ?>";

                let idBanco = 0;

                $(document).ready(function() {

                    loadInitBancos();

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
                        $("#buscar").val("");
                        loadInitBancos();
                    });

                    $("#buscar").on("keyup", function(event) {
                        if (event.keyCode === 13) {
                            if ($("#buscar").val() != '') {
                                if (!state) {
                                    paginacion = 1;
                                    loadTableBancos($("#buscar").val());
                                    opcion = 1;
                                }
                            }

                        }
                    });

                    $("#btnSearch").click(function() {
                        if ($("#buscar").val() != '') {
                            if (!state) {
                                paginacion = 1;
                                loadTableBancos($("#buscar").val());
                                opcion = 1;
                            }
                        }
                    });

                    $("#btnNuevo").click(function() {
                        clearModalBanco();
                        $("#NuevoBanco").modal("show")
                        $("#modal-Banco-title").empty()
                        $("#modal-Banco-title").append('<i class="fa fa-bank"></i> Registrar Entidad Bancaria')
                    })

                    $("#btnAceptarBanco").click(function() {
                        crudBanco();
                    });

                    $("#btnCancelarBanco").click(function() {
                        clearModalBanco()
                    });

                    $("#btnCloseBanco").click(function() {
                        clearModalBanco()
                    });

                    $("#estado").change(function() {
                        $("#lblEstado").html($("#estado").is(":checked") ? " Activo" : " Inactivo");
                    });

                });

                function onEventPaginacion() {
                    switch (opcion) {
                        case 0:
                            loadTableBancos("");
                            break;
                        case 1:
                            loadTableBancos($("#buscar").val());
                            break;
                    }
                }

                function loadInitBancos() {
                    if (!state) {
                        paginacion = 1;
                        loadTableBancos("");
                        opcion = 0;
                    }
                }

                function loadTableBancos(nombres) {
                    $.ajax({
                        url: "../app/controller/BancoController.php",
                        method: "GET",
                        data: {
                            "type": "allBancos",
                            "nombres": nombres,
                            "posicionPagina": ((paginacion - 1) * filasPorPagina),
                            "filasPorPagina": filasPorPagina
                        },
                        beforeSend: function() {
                            tbTable.empty();
                            tbTable.append(
                                '<tr class="text-center"><td colspan="6"><img src="./images/spiner.gif"/><p>Cargando información.</p></td></tr>'
                            );
                            state = true;
                            totalPaginacion = 0;
                        },
                        success: function(result) {
                            if (result.estado === 1) {
                                tbTable.empty();
                                if (result.bancos.length == 0) {
                                    tbTable.append(
                                        '<tr class="text-center"><td colspan="6"><p>No hay datos para mostrar.</p></td></tr>'
                                    );

                                    $("#lblPaginaActual").html(paginacion);
                                    $("#lblPaginaSiguiente").html(totalPaginacion);
                                    state = false;
                                } else {

                                    for (let banco of result.bancos) {

                                        let btnUpdate = editView == 0 ? '<i class="fa fa-minus" style="font-size:20px;"></i>' :
                                            '<button class="btn btn-warning btn-xs" onclick="updateBanco(\'' + banco.Idbanco + '\')">' +
                                            '<i class="fa fa-edit" style="font-size:25px;"></i>' +
                                            '</button>';
                                        let btnDelete = deleteView == 0 ? '<i class="fa fa-minus" style="font-size:20px;"></i>' :
                                            '<button class="btn btn-danger btn-xs" onclick="deleteBanco(\'' + banco.Idbanco + '\')">' +
                                            '<i class="fa fa-trash" style="font-size:25px;"></i>' +
                                            '</button>';

                                        tbTable.append('<tr>' +
                                            '<td class="text-center text-primary">' + banco.Id + '</td>' +
                                            '<td>' + banco.Nombre + '</td>' +
                                            '<td>' + banco.NmroCuenta + '</td>' +
                                            '<td>' + banco.NmroCuentaInterbancaria + '</td>' +
                                            '<td>' + (banco.EstadoBanco == "1" ? '<span class="text-green">activo</span>' : '<span class="text-red">inactivo</span>') + '</td>' +
                                            '<td>' + btnUpdate + '</td>' +
                                            '<td>' + btnDelete + '</td>' +
                                            '</tr>');
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
                                    '<tr class="text-center"><td colspan="6"><p>No se pudo cargar la información.</p></td></tr>'
                                );
                                $("#lblPaginaActual").html(0);
                                $("#lblPaginaSiguiente").html(0);
                                state = false;
                            }
                        },
                        error: function(error) {
                            tbTable.empty();
                            tbTable.append(
                                '<tr class="text-center"><td colspan="6"><p>Se produjo un error, intente nuevamente.</p></td></tr>'
                            );
                            $("#lblPaginaActual").html(0);
                            $("#lblPaginaSiguiente").html(0);
                            state = false;
                        }
                    });
                }

                function crudBanco() {
                    if ($("#Nombre").val() == '') {
                        $("#Nombre").focus();
                        tools.AlertWarning("Banco", "Ingrese un nombre válido")
                    } else if ($("#NumeroCuenta").val() == "") {
                        $("#NumeroCuenta").focus();
                        tools.AlertWarning("Banco", "Ingrese un úmero de cuenta para continuar")
                    } else if ($("#NumeroCuentaInterbancaria").val() == "") {
                        $("#NumeroCuentaInterbancaria").focus();
                        tools.AlertWarning("Banco", "Ingrese un úmero de cuenta interbancaria para continuar")
                    } else {
                        tools.ModalDialog("Banco", "¿Está seguro de continuar?", function(value) {
                            if (value == true) {
                                $.ajax({
                                    url: "../app/controller/BancoController.php",
                                    method: "POST",
                                    data: {
                                        "type": "addBanco",
                                        "idbanco": idBanco,
                                        "nombre": $("#Nombre").val(),
                                        "numeroCuenta": $("#NumeroCuenta").val(),
                                        "numeroCuentaInterbancaria": $("#NumeroCuentaInterbancaria").val(),
                                        "estado": $("#estado").is(":checked"),
                                    },
                                    beforeSend: function() {
                                        clearModalBanco();
                                        tools.ModalAlertInfo("Banco", "Procesando petición..");
                                    },
                                    success: function(result) {
                                        if (result.estado === 1) {
                                            loadInitBancos();
                                            tools.ModalAlertSuccess("Banco", result.mensaje);
                                        } else {
                                            tools.ModalAlertWarning("Banco", result.mensaje);
                                        }
                                    },
                                    error: function(error) {
                                        tools.ModalAlertError("Banco", "Se produjo un error: " + error.responseText);
                                    }
                                });
                            }
                        });
                    }
                }

                function updateBanco(id) {
                    $("#NuevoBanco").modal("show");
                    $("#modal-Banco-title").empty()
                    $("#modal-Banco-title").append('<i class="fa fa-bank"></i> Editar Entidad Bancaria')
                    $.ajax({
                        url: "../app/controller/BancoController.php",
                        method: "GET",
                        data: {
                            "type": "updatebanco",
                            "idBanco": id
                        },
                        beforeSend: function() {},
                        success: function(result) {
                            $("#modal-Banco-title").empty();
                            $("#modal-Banco-title").append('<i class="fa fa-bank"> </i> Editar Entidad Bancaria');
                            if (result.estado == 1) {
                                let banco = result.banco;
                                idBanco = id;
                                $("#Nombre").val(banco.Nombre);
                                $("#NumeroCuenta").val(banco.NmroCuenta);
                                $("#NumeroCuentaInterbancaria").val(banco.NmroCuentaInterbancaria);
                                $("#NumeroCuentaInterbancaria").val(banco.NmroCuentaInterbancaria);
                                $("#estado").prop('checked', banco.Estado == 1 ? true : false);
                                $("#lblEstado").html($("#estado").is(":checked") ? " Activo" : " Inactivo");

                                tools.AlertInfo("Banco", "Se cargo correctamente los datos.");
                            } else {
                                tools.AlertWarning("Banco", result.message);
                            }
                        },
                        error: function(error) {
                            $("#modal-Banco-title").empty();
                            $("#modal-Banco-title").append('<i class="fa fa-bank"> </i> Entidad Bancaria');
                            tools.AlertError("Error", error.responseText);
                        }
                    });
                }

                function deleteBanco(id) {
                    tools.ModalDialog("Banco", "¿Está seguro de eliminar la entidad bancaria?", function(value) {
                        if (value == true) {
                            $.ajax({
                                url: "../app/controller/BancoController.php",
                                method: "POST",
                                data: {
                                    "type": "deleteBanco",
                                    "idBanco": id,
                                },
                                beforeSend: function() {
                                    clearModalBanco();
                                    tools.ModalAlertInfo("Banco", "Procesando petición..");
                                },
                                success: function(result) {
                                    if (result.estado == 1) {
                                        tools.ModalAlertSuccess("Banco", result.message);
                                        loadInitBancos();
                                    } else {
                                        tools.ModalAlertWarning("Banco", result.message);
                                    }
                                },
                                error: function(error) {
                                    tools.ModalAlertError("Banco", error.responseText);
                                }
                            });
                        }
                    });
                }


                function clearModalBanco() {
                    $("#NuevoBanco").modal("hide");
                    $("#Nombre").val("");
                    $("#NumeroCuenta").val("");
                    $("#NumeroCuentaInterbancaria").val("");
                    $("#Pagina_web").val("");
                    $("#estado").prop('checked', true);
                    $("#lblEstado").html("Activo");
                    idBanco = 0;
                }
            </script>
        </body>

        </html>

<?php
    } else {
        echo '<script>location.href = "./index.php";</script>';
    }
}
