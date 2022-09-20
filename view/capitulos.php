<?php
session_start();

if (!isset($_SESSION['IdUsuario'])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
    if ($_SESSION["Permisos"][8]["ver"] == 1) {
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
                <!-- modal nuevo capitulo o especialidad  -->
                <div class="row">
                    <div class="modal fade" id="confirmar" data-backdrop="static">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" id="close">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-indent">
                                        </i> Registrar Capitulo y/o Especialidad
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <form role="form">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input class="form-check-input" type="radio" name="RadioOptions" id="btnRadio1" checked>
                                                    <label class="form-check-label" for="btnRadio1" style="margin-left: 0.5em;">Nuevo Capitulo</label>

                                                    <input class="form-check-input" style="margin-left: 2em;" type="radio" name="RadioOptions" id="btnRadio2">
                                                    <label class="form-check-label" for="btnRadio2" style="margin-left: 0.5em;">Nueva Especialidad</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="txtCapitulo">Capitulo: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <input id="txtCapitulo" type="text" name="txtCapitulo" class="form-control" placeholder="Dijite el nuevo Capitulo" required="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="cbxCapitulo">Capitulo: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <select id="cbxCapitulo" class="form-control">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="txtEspecialidad">Especialidad: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <input id="txtEspecialidad" type="text" class="form-control" placeholder="Dijite la nueva Especialidad" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <p class="text-left text-danger">Todos los campos marcados con <i class="fa fa-fw fa-asterisk text-danger"></i> son obligatorios</p>
                                    <button type="submit" class="btn btn-warning" name="btnaceptar-Capitulo" id="btnaceptar-Capitulo">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" id="cancel-nuevo">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end modal nuevo capitulo o especialidad -->
                <!-- modal editar capitulo o especialidad  -->
                <div class="row">
                    <div class="modal fade" id="editar" data-backdrop="static">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" id="close1">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-indent">
                                        </i> Editar Capitulo y/o Especialidad
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <form role="form">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input class="form-check-input" type="radio" name="RadioOptions" id="btnRadio01" checked>
                                                    <label class="form-check-label" for="btnRadio01" style="margin-left: 0.5em;">Editar Capitulo</label>

                                                    <input class="form-check-input" style="margin-left: 2em;" type="radio" name="RadioOptions" id="btnRadio02">
                                                    <label class="form-check-label" for="btnRadio02" style="margin-left: 0.5em;">Editar Especialidad</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="txtCapitulo1">Capitulo: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <input id="txtCapitulo1" type="text" name="txtCapitulo1" class="form-control" required="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="cbxCapitulo1">Capitulo: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <select id="cbxCapitulo1" class="form-control">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="txtEspecialidad1">Especialidad: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <input id="txtEspecialidad1" type="text" class="form-control" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <p class="text-left text-danger">Todos los campos marcados con <i class="fa fa-fw fa-asterisk text-danger"></i> son obligatorios</p>
                                    <button type="submit" class="btn btn-warning" name="btnaceptar-editar-Capitulo" id="btnaceptar-editar-Capitulo">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" id="cancel-editar">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end modal editar capitulo o especialidad -->
                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper" style="background-color: #FFFFFF;">
                    <!-- Main content -->
                    <section class="content-header">
                        <h3 class="no-margin"> Capitulos <small> Lista </small> </h3>
                    </section>

                    <section class="content">

                        <div class="row">
                            <?php
                            if ($_SESSION["Permisos"][8]["crear"]) {
                                echo '<div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <label>Nuevo Cap./Espe.</label>
                                <div class="form-group">
                                    <button type="button" class="btn btn-success" id="btnNuevo">
                                        <i class="fa fa-plus"></i> Agregar Cap./Espe.
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
                                <label>Filtrar por capítulo o especialidad.</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="search" id="buscar" class="form-control" placeholder="Buscar por Capitulo o Especialidad" aria-describedby="search" value="">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-primary" id="btnbuscar">Buscar</button>
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
                                            <th width="20%">Capitulo</th>
                                            <th width="40%">Especialidad</th>
                                            <th width="10%" class="text-center">Editar</th>
                                            <th width="10%" class="text-center">Elim. Capit.</th>
                                            <th width="10%" class="text-center">Elim. Espec.</th>
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
                let cbxCapitulos = $("#cbxCapitulo");
                let cbxCapitulos1 = $("#cbxCapitulo1");

                let editView = "<?= $_SESSION["Permisos"][8]["actualizar"]; ?>";
                let deleteView = "<?= $_SESSION["Permisos"][8]["eliminar"]; ?>";

                $(document).ready(function() {

                    loadInitCapitulos();

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
                        loadInitCapitulos()
                    });

                    $("#btnbuscar").click(function() {
                        paginacion = 1;
                        loadTableCapitulos($("#buscar").val());
                        opcion = 1;
                    });

                    $("#buscar").on("keyup", function(event) {
                        if (event.keyCode === 13) {
                            paginacion = 1;
                            loadTableCapitulos($("#buscar").val());
                            opcion = 1;
                        }
                    });

                    $("#btnNuevo").click(function() {
                        $("#confirmar").modal("show");
                        $("#txtEspecialidad").attr('disabled', true);
                        $("#cbxCapitulo").attr('disabled', true);

                        $(".form-check-input").on('change', function() {
                            if ($("#btnRadio1").is(':checked')) {
                                $("#txtEspecialidad").val('');
                                $("#txtEspecialidad").prop('disabled', 'disabled');
                                $("#cbxCapitulo").attr('disabled', true);
                                $("#cbxCapitulo").val($("#cbxCapitulo option:first").val());
                                $("#txtCapitulo").attr('disabled', false);
                            } else {
                                $("#txtCapitulo").val('');
                                $("#txtEspecialidad").prop('disabled', '');
                                $("#cbxCapitulo").attr('disabled', false);
                                $("#txtCapitulo").attr('disabled', true);
                            }
                        });

                        loadCapitulos();
                    })

                    $("#btnaceptar-Capitulo").click(function() {
                        if ($("#btnRadio1").is(':checked')) {
                            crudCapitulo();
                        } else {
                            crudEspecialidad();
                        }
                    });

                    $("#cancel-nuevo").click(function() {
                        $("#confirmar").modal("hide");
                        clearModal();
                    });

                    $("#cancel-editar").click(function() {
                        $("#editar").modal("hide");
                        clearModal();
                    });

                    $("#close").click(function() {
                        $("#confirmar").modal("hide");
                        clearModal();
                    });

                    $("#close1").click(function() {
                        $("#editar").modal("hide");
                        clearModal();
                    });
                });

                function onEventPaginacion() {
                    switch (opcion) {
                        case 0:
                            loadTableCapitulos("");
                            break;
                        case 1:
                            loadTableCapitulos($("#buscar").val());
                            break;
                    }
                }

                function loadInitCapitulos() {
                    if (!state) {
                        paginacion = 1;
                        loadTableCapitulos("");
                        opcion = 0;
                    }
                }

                async function loadTableCapitulos(nombres) {
                    try {
                        tbTable.empty();
                        tbTable.append(
                            '<tr class="text-center"><td colspan="6"><img src="./images/spiner.gif"/><p>Cargando información.</p></td></tr>'
                        );
                        state = true;
                        totalPaginacion = 0;

                        const result = await axios.get("../app/web/CapituloWeb.php", {
                            params: {
                                "type": "list",
                                "nombres": nombres,
                                "posicionPagina": ((paginacion - 1) * filasPorPagina),
                                "filasPorPagina": filasPorPagina
                            }
                        });

                        tbTable.empty();
                        if (result.data.especialidades.length == 0) {
                            tbTable.append(
                                '<tr class="text-center"><td colspan="6"><p>No hay información para mostrar.</p></td></tr>'
                            );
                            $("#lblPaginaActual").html(paginacion);
                            $("#lblPaginaSiguiente").html(totalPaginacion);
                            state = false;
                        } else {
                            for (let especialidad of result.data.especialidades) {

                                let btnUpdate = editView == 0 ? '<i class="fa fa-minus" style="font-size:20px;"></i>' :
                                    '<button class="btn btn-warning btn-xs" onclick="updateCapituloModal(\'' +
                                    especialidad.idCapitulo + '\',\'' + especialidad.Capitulo + '\',\'' + especialidad.idEspecialidad + '\',\'' + especialidad.Especialidad + '\')">' +
                                    '<i class="fa fa-edit" style="font-size:25px;"></i>' +
                                    '</button>';

                                let btnDeleteCapitulo = deleteView == 0 ? '<i class="fa fa-minus" style="font-size:20px;"></i>' :
                                    '<button class="btn btn-danger btn-xs" onclick="deleteCapitulo(\'' + especialidad.idCapitulo + '\')">' +
                                    '<i class="fa fa-trash" style="font-size:25px;"></i> ' +
                                    '</button>';

                                let btnDeleteEspecialidad = deleteView == 0 ? '<i class="fa fa-minus" style="font-size:20px;"></i>' :
                                    '<button class="btn btn-danger btn-xs" onclick="deleteEspecialidad(\'' + especialidad.idEspecialidad + '\')">' +
                                    '<i class="fa fa-trash" style="font-size:25px;"></i> ' +
                                    '</button>';

                                tbTable.append('<tr>' +
                                    '<td class="text-center text-primary">' + especialidad.Id + '</td>' +
                                    '<td>' + especialidad.Capitulo + '</td>' +
                                    '<td>' + especialidad.Especialidad + '</td>' +
                                    '<td class="text-center">' + btnUpdate + '</td>' +
                                    '<td class="text-center">' + btnDeleteCapitulo + '</td>' +
                                    '<td class="text-center">' + btnDeleteEspecialidad + '</td>' +
                                    '</tr>');
                            }
                            totalPaginacion = parseInt(Math.ceil((parseFloat(result.data.total) / parseInt(
                                filasPorPagina))));
                            $("#lblPaginaActual").html(paginacion);
                            $("#lblPaginaSiguiente").html(totalPaginacion);
                            state = false;
                        }
                    } catch (error) {
                        tbTable.empty();
                        tbTable.append(
                            '<tr class="text-center"><td colspan="6"><p> Se produjo un error, intente nuevamente.</p></td></tr>'
                        );
                        $("#lblPaginaActual").html(0);
                        $("#lblPaginaSiguiente").html(0);
                        state = false;
                    }
                }

                async function crudCapitulo() {
                    if ($("#txtCapitulo").val() == '') {
                        tools.AlertWarning("Advertencia", "Digite un capitulo.");
                        $("#txtCapitulo").focus();
                        return;
                    }

                    try {
                        tools.ModalAlertInfo("Capítulo", "Procesando petición..")
                        $("#confirmar").modal("hide");

                        const result = await axios.post("../app/web/CapituloWeb.php", {
                            "type": "insertCapitulo",
                            "capitulo": jQuery.trim($("#txtCapitulo").val()),
                        });

                        tools.ModalAlertSuccess("Capítulo", result.data, () => {
                            loadInitCapitulos();
                            clearModal();
                        });
                    } catch (error) {
                        if (error.response) {
                            tools.ModalAlertWarning("Capítulo", error.response.data)
                        } else {
                            tools.ModalAlertError("Capítulo", "Se produjo un error, intente nuevamente.")
                        }

                    }
                }

                async function crudEspecialidad() {
                    if ($("#cbxCapitulo").val() == '') {
                        tools.AlertWarning("Advertencia", "Seleccione un capitulos.");
                        $("#cbxCapitulo").focus();
                        return;
                    }

                    if ($("#txtEspecialidad").val() == '') {
                        tools.AlertWarning("Advertencia", "Digite una especialidad valida.");
                        $("#txtEspecialidad").focus();
                        return;
                    }
                    try {
                        tools.ModalAlertInfo("Especialidad", "Procesando petición..")
                        $("#confirmar").modal("hide");

                        const result = await axios.post("../app/web/CapituloWeb.php", {
                            "type": "insertEspecialidad",
                            "capitulo": $("#cbxCapitulo").val().trim(),
                            "especialidad": $("#txtEspecialidad").val().trim(),
                        });

                        tools.ModalAlertSuccess("Especialidad", result.data, () => {
                            loadInitCapitulos();
                            clearModal();
                        })

                    } catch (error) {
                        if (error.response) {
                            tools.ModalAlertWarning("Especialidad", error.response.data)
                        } else {
                            tools.ModalAlertError("Especialidad", "Se produjo un error, intente nuevamente.")
                        }
                    }
                }

                function updateCapituloModal(idC, capitulo, idE, especialidad) {
                    let idCapitulo = idC;
                    let Capitulo = capitulo;
                    let idEspecialidad = idE;
                    let Especialidaddd = especialidad;

                    $("#editar").modal("show");
                    $("#btnRadio01").prop('checked', true);
                    $("#txtCapitulo1").val(Capitulo);
                    $("#txtCapitulo1").attr('disabled', false);
                    $("#cbxCapitulo1").attr('disabled', true);
                    $("#txtEspecialidad1").val(Especialidaddd);
                    $("#txtEspecialidad1").attr('disabled', true);

                    $(".form-check-input").on('change', function() {
                        if ($("#btnRadio01").is(':checked')) {
                            $("#txtCapitulo1").val(Capitulo);
                            $("#txtCapitulo1").attr('disabled', false);
                            $("#txtEspecialidad1").val(Especialidaddd);
                            $("#txtEspecialidad1").prop('disabled', 'disabled');
                            $("#cbxCapitulo1").attr('disabled', true);
                            loadUpdateCapitulos(idCapitulo);
                        } else {
                            if ($("#txtEspecialidad1").val(Especialidaddd) != "No tiene asignado ninguna especialidad") {
                                $
                                $("#txtCapitulo1").val(Capitulo);
                                $("#txtCapitulo1").attr('disabled', true);
                                $("#txtEspecialidad1").prop('disabled', '');
                                $("#cbxCapitulo1").attr('disabled', false);
                            } else {
                                $("#txtCapitulo1").val(Capitulo);
                                $("#txtCapitulo1").attr('disabled', true);
                                $("#txtEspecialidad1").prop('disabled', '');
                                $("#cbxCapitulo1").attr('disabled', false);
                            }
                        }
                    });

                    loadUpdateCapitulos(idCapitulo);

                    $("#btnaceptar-editar-Capitulo").unbind();
                    $("#btnaceptar-editar-Capitulo").bind("click", function() {
                        updateCapituloOEspecialidad(idCapitulo, idEspecialidad);
                    });
                }

                async function updateCapituloOEspecialidad(idCapitulo, idEspecialidad) {

                    if ($("#btnRadio01").is(':checked')) {
                        if ($("#txtCapitulo1").val() == "") {
                            tools.AlertWarning("Advertencia", "Ingrese un capitulo.");
                            $("#txtCapitulo1").focus();
                        } else {
                            try {
                                tools.ModalAlertInfo("Capítulo", "Procesando petición..");
                                $("#editar").modal("hide");

                                const result = await axios.post("../app/web/CapituloWeb.php", {
                                    "type": "updateCapitulo",
                                    "idcapitulo": idCapitulo,
                                    "capitulo": $("#txtCapitulo1").val().trim(),
                                });

                                tools.ModalAlertSuccess("Capítulo", result.data, () => {
                                    onEventPaginacion();
                                    clearModal();
                                })

                            } catch (error) {
                                if (error.response) {
                                    tools.ModalAlertWarning("Capítulo", error.response.data)
                                } else {
                                    tools.ModalAlertError("Capítulo", "Se produjo un error, intente nuevamente.")
                                }
                            }
                        }
                    } else {
                        if ($("#cbxCapitulo1").val() == '') {
                            tools.AlertWarning("Advertencia", "Seleccione un capitulos.");
                            $("#cbxCapitulo1").focus();
                        } else if (($("#txtEspecialidad1").val() == '') || ($("#txtEspecialidad1").val() == "No tiene asignado ninguna especialidad")) {
                            tools.AlertWarning("Advertencia", "Digite una especialidad valida.");
                            $("#txtEspecialidad1").focus();
                        } else {
                            try {
                                tools.ModalAlertInfo("Especialidad", "Procesando petición..");
                                $("#editar").modal("hide");

                                const result = await axios.post("../app/web/CapituloWeb.php", {
                                    "type": "updateEspecialidad",
                                    "idCapitulo": $("#cbxCapitulo1").val(),
                                    "idEspecialidad": idEspecialidad,
                                    "especialidad": $("#txtEspecialidad1").val().trim(),
                                });

                                tools.ModalAlertSuccess("Especialidad", result.data, () => {
                                    clearModal();
                                    onEventPaginacion();
                                });
                            } catch (error) {
                                if (error.response) {
                                    tools.ModalAlertWarning("Especialidad", error.response.data)
                                } else {
                                    tools.ModalAlertError("Especialidad", "Se produjo un error, intente nuevamente.")
                                }
                            }
                        }
                    }
                }

                async function loadCapitulos() {
                    try {
                        cbxCapitulos.empty();

                        const result = await axios.get("../app/web/CapituloWeb.php", {
                            params: {
                                "type": "allCapitulos"
                            }
                        });

                        cbxCapitulos.append('<option value="">- Seleccione un capítulo- </option>')
                        for (let capitulo of result.data) {
                            cbxCapitulos.append('<option value=' + capitulo.idCapitulo + '> ' + capitulo.Capitulo + '</option>')
                        }
                    } catch (error) {}
                }

                async function loadUpdateCapitulos(idCapitulo) {
                    try {
                        cbxCapitulos1.empty();

                        const result = await axios.get("../app/web/CapituloWeb.php", {
                            params: {
                                "type": "allCapitulos"
                            }
                        });

                        cbxCapitulos1.append('<option value="">- Seleccione un capítulo- </option>')
                        for (let capitulo of result.data) {
                            cbxCapitulos1.append('<option value=' + capitulo.idCapitulo + '> ' + capitulo.Capitulo + '</option>')
                        }
                        cbxCapitulos1.val(idCapitulo);
                    } catch (error) {

                    }
                }

                function deleteCapitulo(idCapitulo) {
                    tools.ModalDialog("Capítulo", "¿Está seguro de eliminar ?", async function(value) {
                        if (value == true) {
                            try {
                                tools.ModalAlertInfo("Capítulo", "Procesando petición..");

                                const result = await axios.post("../app/web/CapituloWeb.php", {
                                    "type": "deleteCapitulo",
                                    "idCapitulo": idCapitulo
                                });

                                tools.ModalAlertSuccess("Capítulo", result.data, () => {
                                    loadInitCapitulos();
                                });
                            } catch (error) {
                                if (error.response) {
                                    tools.ModalAlertWarning("Capítulo", error.response.data)
                                } else {
                                    tools.ModalAlertError("Capítulo", "Se produjo un error, intente nuevamente.")
                                }
                            }
                        }
                    });
                }

                function deleteEspecialidad(idEspecialidad) {
                    tools.ModalDialog("Especialidad", "¿Está seguro de eliminar ?", async function(value) {
                        if (value == true) {
                            try {
                                tools.ModalAlertInfo("Especialidad", "Procesando petición..");

                                const result = await axios.post("../app/web/CapituloWeb.php", {
                                    "type": "deleteEspecialidad",
                                    "idEspecialidad": idEspecialidad
                                });

                                tools.ModalAlertSuccess("Especialidad", result.data, () => {
                                    loadInitCapitulos();
                                });

                            } catch (error) {
                                if (error.response) {
                                    tools.ModalAlertWarning("Especialidad", error.response.data)
                                } else {
                                    tools.ModalAlertError("Especialidad", "Se produjo un error, intente nuevamente.")
                                }
                            }
                        }
                    });
                }

                function clearModal() {
                    $("#btnRadio1").prop('checked', true);
                    $("#txtCapitulo").val('');
                    $("#txtCapitulo").attr('disabled', false);
                    $("#cbxCapitulo").attr('disabled', true);
                    $("#cbxCapitulo").val($("#cbxCapitulo option:first").val());
                    $("#txtEspecialidad").val('');
                }
            </script>
        </body>

        </html>
<?php
    } else {
        echo '<script>location.href = "./index.php";</script>';
    }
}
