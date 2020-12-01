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
                <h3 class="no-margin"> Capitulos <small> Lista </small> </h3>
            </section>

            <section class="content">

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
                                                    <input id="txtEspecialidad" type="text" name="txtEspecialidad" class="form-control" placeholder="Dijite la nueva Especialidad" required="">
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
                                                    <input id="txtEspecialidad1" type="text" name="txtEspecialidad" class="form-control" required="">
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

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <button type="button" class="btn btn-warning" id="btnNuevo">
                                <i class="fa fa-plus"></i> Nuevo Capitulo y/o Especialidad
                            </button>
                            <button class="btn btn-link" id="btnactualizar">
                                <i class="fa fa-refresh"></i> Actualizar..
                            </button>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <input type="search" id="buscar" class="form-control" placeholder="Buscar por Capitulo o Especialidad" aria-describedby="search" value="">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <button class="btn btn-default" id="btnbuscar">
                                <i class="fa fa-search"></i> Buscar
                            </button>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table class="table table-striped" style="border-width: 1px;border-style: dashed;border-color: #E31E25;">
                                <thead style="background-color: #FDB2B1;color: #B72928;">
                                    <th style="text-align: center;">#</th>
                                    <th>Capitulo</th>
                                    <th>Especialidad</th>
                                    <th>Opciones</th>
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
        // let cbxCapitulo = $("#Capitulo")

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

        function clearModal() {
            $("#btnRadio1").prop('checked', true);
            // $("#btnRadio01").prop('checked', true);
            $("#txtCapitulo").val('');
            $("#txtCapitulo").attr('disabled', false);
            // $("#txtCapitulo1").val('');
            // $("#txtCapitulo1").attr('disabled', false);
            $("#cbxCapitulo").attr('disabled', true);
            $("#cbxCapitulo").val($("#cbxCapitulo option:first").val());
            // $("#cbxCapitulo1").attr('disabled', true);
            // $("#cbxCapitulo1").val($("#cbxCapitulo1 option:first").val());
            $("#txtEspecialidad").val('');
            // $("#txtEspecialidad1").val('');
        }

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

        function loadTableCapitulos(nombres) {
            $.ajax({
                url: "../app/controller/CapituloController.php",
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
                        '<tr class="text-center"><td colspan="4"><img src="./images/spiner.gif"/><p>cargando información.</p></td></tr>'
                    );
                    state = true;
                },
                success: function(result) {

                    if (result.estado === 1) {
                        tbTable.empty();
                        for (let especialidad of result.especialidades) {

                            let btnUpdate =
                                '<button class="btn btn-success btn-sm" onclick="updateCapituloEspecialidad(\'' +
                                especialidad.idCapitulo + '\',\'' + especialidad.Capitulo + '\',\'' + especialidad.idEspecialidad + '\',\'' + especialidad.Especialidad + '\')">' +
                                '<i class="fa fa-wrench"></i> Editar' +
                                '</button>';

                            tbTable.append('<tr>' +
                                '<td style="text-align: center;color: #2270D1;">' +
                                '' + especialidad.Id + '' +
                                '</td>' +
                                '<td>' + especialidad.Capitulo + '</td>' +
                                '<td>' + especialidad.Especialidad + '</td>' +
                                '<td>' +
                                '' + btnUpdate + '' +
                                '</td>' +
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
                            '<tr class="text-center"><td colspan="4"><p>No se pudo cargar la información.</p></td></tr>'
                        );
                        $("#lblPaginaActual").html(0);
                        $("#lblPaginaSiguiente").html(0);
                        state = false;
                    }
                },
                error: function(error) {
                    tbTable.empty();
                    tbTable.append(
                        '<tr class="text-center"><td colspan="4"><p>Se produjo un error, intente nuevamente.</p></td></tr>'
                    );
                    $("#lblPaginaActual").html(0);
                    $("#lblPaginaSiguiente").html(0);
                    state = false;
                }
            });
        }

        function loadCapitulos() {
            $.ajax({
                url: "../app/controller/CapituloController.php",
                method: "GET",
                data: {
                    "type": "allCapitulos"
                },
                beforeSend: function() {
                    state = true;
                },
                success: function(result) {

                    if (result.estado === 1) {
                        cbxCapitulos.append('<option value="">- Seleccione un capítulo- </option>')
                        for (let capitulo of result.capitulos) {
                            cbxCapitulos.append('<option value=' + capitulo.idCapitulo + '> ' + capitulo.Capitulo + '</option>')
                        }
                        state = false;

                    } else {

                        state = false;
                    }
                },
                error: function(error) {
                    state = false;
                }
            });
        }

<<<<<<< HEAD
        function crudCapitulo() {
            if ($("#txtCapitulo").val() == '') {
                tools.AlertWarning("Advertencia", "Digite un capitulo.");
                $("#txtCapitulo").focus();
            } else {
                $.ajax({
                    url: "../app/controller/CapituloController.php",
                    method: "POST",
                    data: {
                        "type": "insertCapitulo",
                        "capitulo": jQuery.trim($("#txtCapitulo").val()),
                    },
                    beforeSend: function() {
                        tools.AlertInfo("Capitulo", "Procesando información.");
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            tools.AlertSuccess("Capitulo", "Se registro correctamente.");
                            $("#confirmar").modal("hide");
                            clearModal();
                        } else if (result.estado == 3) {
                            tools.AlertWarning("Capitulo", result.message);
                        } else {
                            tools.AlertWarning("Capitulo", result.message);
=======
        function loadEspecialidades(){
            $.ajax({
                url: "../app/controller/CapituloController.php",
                method: "GET",
                data: {
                    "type": "allEspecialidades"
                },
                beforeSend: function() {
                    state = true
                },
                success: function(result) {
                    console.log(result)
                    if (result.estado === 1) {
                        for(let especialidad of result.especialidades){
                            cbxEspecialidad.append('<option value='+especialidad.Especialidad+'> '+especialidad.Especialidad+'</option>')
>>>>>>> cc2ead0103e2fa576b96025b01868602687fd121
                        }
                    },
                    error: function(error) {
                        tools.AlertError("Capitulo", "Error fatal: Comuniquese con el administrador del sistema");
                    }
                });
            }
        }

        function crudEspecialidad() {
            if ($("#cbxCapitulo").val() == '') {
                tools.AlertWarning("Advertencia", "Seleccione un capitulos.");
                $("#cbxCapitulo").focus();
            } else if ($("#txtEspecialidad").val() == '') {
                tools.AlertWarning("Advertencia", "Digite una especialidad valida.");
                $("#txtEspecialidad").focus();
            } else {
                $.ajax({
                    url: "../app/controller/CapituloController.php",
                    method: "POST",
                    data: {
                        "type": "insertEspecialidad",
                        "capitulo": jQuery.trim($("#cbxCapitulo").val()),
                        "especialidad": jQuery.trim(("#txtEspecialidad").val()),
                    },
                    beforeSend: function() {
                        tools.AlertInfo("Especialidad", "Procesando información.");
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            tools.AlertSuccess("Especialidad", "Se registro correctamente.");
                            $("#confirmar").modal("hide");
                            clearModal();
                        } else if (result.estado == 3) {
                            tools.AlertWarning("Especialidad", result.message);
                        } else {
                            tools.AlertWarning("Especialidad", "Error al tratar de registrar los datos " + result.message);
                        }
                    },
                    error: function(error) {
                        tools.AlertError("Especialidad", "Error fatal: Comuniquese con el administrador del sistema");
                    }
                });
            }
        }

        function updateCapituloEspecialidad(idC, capitulo, idE, especialidad) {

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
                    loadEditCapitulos(idCapitulo);
                } else {
                    if ($("#txtEspecialidad1").val(Especialidaddd) != "No tiene asignado ninguna especialidad") {
                        $("#txtEspecialidad1").val('')
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

            loadEditCapitulos(idCapitulo);

            $("#btnaceptar-editar-Capitulo").click(function() {
                AceptarUpdate(idCapitulo, idEspecialidad);
            });
        }

        function AceptarUpdate(idC, idE) {
            let idCapitulo = idC;
            let idEspecialidad = idE;

            // $(".form-check-input").on('change', function() {
            if ($("#btnRadio01").is(':checked')) {

                if ($("#txtCapitulo1").val() == "") {
                    tools.AlertWarning("Advertencia", "Ingrese un capitulo.");
                    $("#txtCapitulo1").focus();
                } else {
                    console.log('entro');
                    $.ajax({
                        url: "../app/controller/CapituloController.php",
                        method: "POST",
                        data: {
                            "type": "updateCapitulo",
                            "idcapitulo": idCapitulo,
                            "capitulo": jQuery.trim($("#txtCapitulo1").val()),
                        },
                        beforeSend: function() {
                            tools.AlertInfo("Capitulo", "Procesando información.");
                        },
                        success: function(result) {
                            if (result.estado == 1) {
                                tools.AlertSuccess("Capitulo", "Se actualizo correctamente.");
                                $("#editar").modal("hide");
                                clearModal();
                            } else if (result.estado == 3) {
                                tools.AlertWarning("Capitulo", result.message);
                            } else {
                                tools.AlertWarning("Capitulo", "Error al tratar de actualizar los datos " + result.message);
                            }
                        },
                        error: function(error) {
                            tools.AlertError("Capitulo", "Error fatal: Comuniquese con el administrador del sistema");
                        }
                    });
                }
            } else {
                if ($("#cbxCapitulo").val() == '') {
                    tools.AlertWarning("Advertencia", "Seleccione un capitulos.");
                    $("#cbxCapitulo").focus();
                } else if (($("#txtEspecialidad").val() == '') || ($("#txtEspecialidad").val() == "No tiene asignado ninguna especialidad")) {
                    tools.AlertWarning("Advertencia", "Digite una especialidad valida.");
                    $("#txtEspecialidad").focus();
                } else {
                    $.ajax({
                        url: "../app/controller/CapituloController.php",
                        method: "POST",
                        data: {
                            "type": "updateEspecialidad",
                            "idCapitulo": idCapitulo,
                            "idEspecialidad": idEspecialidad,
                            "especialidad": jQuery.trim(("#txtEspecialidad").val()),
                        },
                        beforeSend: function() {
                            tools.AlertInfo("Especialidad", "Procesando información.");
                        },
                        success: function(result) {
                            if (result.estado == 1) {
                                tools.AlertSuccess("Especialidad", "Se actualizo correctamente.");
                                $("#editar").modal("hide");
                                clearModal();
                            } else if (result.estado == 3) {
                                tools.AlertWarning("Especialidad", result.message);
                            } else {
                                tools.AlertWarning("Especialidad", "Error al tratar de actualizar los datos " + result.message);
                            }
                        },
                        error: function(error) {
                            tools.AlertError("Especialidad", "Error fatal: Comuniquese con el administrador del sistema");
                        }
                    });
                }
            }
            // });
        }

        function loadEditCapitulos(capitulo) {
            $.ajax({
                url: "../app/controller/CapituloController.php",
                method: "GET",
                data: {
                    "type": "allCapitulos"
                },
                beforeSend: function() {
                    state = true;
                },
                success: function(result) {

                    if (result.estado === 1) {

                        cbxCapitulos1.append('<option value="">- Seleccione un capítulo- </option>')
                        for (let capitulo of result.capitulos) {
                            cbxCapitulos1.append('<option value=' + capitulo.idCapitulo + '> ' + capitulo.Capitulo + '</option>')
                        }
                        $("#cbxCapitulo1").val(capitulo);

                    } else {


                    }
                },
                error: function(error) {

                }
            });
        }
    </script>
</body>

</html>