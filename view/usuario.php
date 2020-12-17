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
                <h3 class="no-margin"> Usuarios <small> Lista </small> </h3>
            </section>

            <!-- modal añadir usuario  -->
            <div class="row">
                <div class="modal fade" data-backdrop="static" id="mdAddUser">
                    <div class="modal-dialog modal-xs">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" id="btnCloseAddUser">
                                    <i class="fa fa-close"></i>
                                </button>
                                <h4 class="modal-title" id="modal-user-title">
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="Universidad" class="control-label">Nombres</label>
                                        <div class="form-group">
                                            <input id="txtAddNombres" type="text" class="form-control" placeholder="Ingrese su(s) nombre(s)" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="Universidad" class="control-label">Apellidos</label>
                                        <div class="form-group">
                                            <input id="txtAddApellidos" type="text" class="form-control" placeholder="Ingrese sus apellidos" required="">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="Universidad" class="control-label">Usuario</label>
                                        <div class="form-group">
                                            <input id="txtAddUsuario" type="text" class="form-control" placeholder="Ingrese su usuario" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="Universidad" class="control-label">Contraseña</label>
                                        <div class="form-group">
                                            <input id="txtContrasena" type="password" class="form-control" placeholder="Ingrese una contraseña" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="estado">Estado: </label>
                                            <select id="estado" class="form-control">
                                                <option value="1">Activo</option>
                                                <option value="0">Inactivo</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" id="btnAceptarAddUser">
                                    <i class="fa fa-check"></i> Guardar</button>
                                <button type="button" class="btn btn-primary" id="btnCancelAddUser">
                                    <i class="fa fa-remove"></i> Cancelar</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal añadir usuario -->

            <section class="content">

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <button type="button" class="btn btn-danger" id="btnNuevo">
                                <i class="fa fa-plus"></i> Nuevo usuario
                            </button>
                            <button class="btn btn-link" id="btnactualizar">
                                <i class="fa fa-refresh"></i> Actualizar..
                            </button>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <input type="search" id="buscar" class="form-control" placeholder="Buscar por Nombre o Apellido" aria-describedby="search" value="">
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <button class="btn btn-default" id="btnSearch">
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
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Usuario</th>
                                    <th colspan="2" style="padding-left: 10%;">Opciones</th>
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

        let idUsuario = 0;

        $(document).ready(function() {

            loadInitUsuario();

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
                loadInitUsuario();
            });

            $("#buscar").on("keyup", function(event) {
                if (event.keyCode === 13) {
                    paginacion = 1;
                    loadTableUsuario($("#buscar").val());
                    opcion = 1;
                }
            });

            $("#btnSearch").click(function() {
                paginacion = 1;
                loadTableUsuario($("#buscar").val());
                opcion = 1;
            });

            //---------------------------------------------------------------------------
            $("#btnNuevo").click(function() {
                $("#mdAddUser").modal("show");
                $("#modal-user-title").empty()
                $("#modal-user-title").append('<i class="fa fa-user"></i> Registrar Usuario')
            })

            $("#btnAceptarAddUser").click(function() {
                crudUsuario();
            });

            $("#btnCancelAddUser").click(function() {
                clearModalUsuario()
            });

            $("#btnCloseAddUser").click(function() {
                clearModalUsuario()
            });

        });

        function onEventPaginacion() {
            switch (opcion) {
                case 0:
                    loadTableUsuario("");
                    break;
                case 1:
                    loadTableUsuario($("#buscar").val());
                    break;
            }
        }

        function loadInitUsuario() {
            if (!state) {
                paginacion = 1;
                loadTableUsuario("");
                opcion = 0;
            }
        }

        function loadTableUsuario(nombres) {
            $.ajax({
                url: "../app/controller/UsuarioController.php",
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
                        '<tr class="text-center"><td colspan="6"><img src="./images/spiner.gif"/><p>Cargando información.</p></td></tr>'
                    );
                    state = true;
                },
                success: function(result) {
                    if (result.estado === 1) {
                        tbTable.empty();
                        for (let usuario of result.usuarios) {

                            let btnUpdate =
                                '<button class="btn btn-warning btn-sm" onclick="updateUsuario(\'' + usuario.idUsuario + '\',\'' +
                                usuario.Nombres + '\',\'' + usuario.Apellidos + '\',\'' + usuario.Usuario + '\',\'' + usuario.Clave + '\')">' +
                                '<i class="fa fa-wrench"></i> Editar' +
                                '</button>';
                            let btnDelete =
                                '<button class="btn btn-danger btn-sm" onclick="deleteUser(\'' + usuario.idUsuario + '\')">' +
                                '<i class="fa fa-trash"></i> Eliminar' +
                                '</button>';

                            tbTable.append('<tr>' +
                                '<td style="text-align: center;color: #2270D1;">' +
                                '' + usuario.Id + '' +
                                '</td>' +
                                '<td>' + usuario.Nombres + '</td>' +
                                '<td>' + usuario.Apellidos + '</td>' +
                                '<td>' + usuario.Usuario + '</td>' +
                                '<td style="text-align: right;">' +
                                '' + btnUpdate + '' +
                                '</td>' +
                                '<td>' +
                                '' + btnDelete +
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

        function crudUsuario() {
            if ($("#txtAddNombres").val() == '') {
                tools.AlertWarning('Usuario', "Ingrese minimo un nombre correcto");
                $("#txtAddNombres").focus();
            } else if ($("#txtAddApellidos").val() == '') {
                tools.AlertWarning('Usuario', "Ingrese apellidos");
                $("#txtAddApellidos").focus();
            } else if ($("#txtAddUsuario").val() == '') {
                tools.AlertWarning('Usuario', "Ingrese usuario");
                $("#txtAddUsuario").focus();
            } else if ($("#txtContrasena").val() == '') {
                tools.AlertWarning('Usuario', "Digite una contraseña ");
                $("#txtContrasena").focus();
            } else {
                tools.ModalDialog("Usuarios", "¿Está seguro de continuar?", function(value) {
                    if (value == true) {
                        $.ajax({
                            url: "../app/controller/UsuarioController.php",
                            method: "POST",
                            data: {
                                "type": "insertUsuario",
                                "idusuario": idUsuario,
                                "nombres": $("#txtAddNombres").val(),
                                "apellidos": $("#txtAddApellidos").val(),
                                "usuarios": $("#txtAddUsuario").val(),
                                "contrasena": $("#txtContrasena").val()
                            },
                            beforeSend: function() {
                                clearModalUsuario();
                                tools.ModalAlertInfo("Usuarios", "Procesando petición..");
                            },
                            success: function(result) {
                                if (result.estado == 1) {
                                    tools.ModalAlertSuccess("Usuarios", result.message);
                                    loadInitUsuario();
                                } else if (result.estado == 3) {
                                    tools.ModalAlertWarning("Usuarios", result.message);
                                } else {
                                    tools.ModalAlertWarning("Usuarios", result.message);
                                }
                            },
                            error: function(error) {
                                tools.ModalAlertError("Usuarios", error.responseText);
                            }
                        });
                    }
                });
            }
        }

        function clearModalUsuario() {
            $("#mdAddUser").modal("hide")
            $("#modal-user-title").empty()
            $("#txtAddNombres").val("")
            $("#txtAddApellidos").val("")
            $("#txtAddUsuario").val("")
            $("#txtContrasena").val("")
        }

        function updateUsuario(id) {
            $("#mdAddUser").modal("show");
            $("#modal-user-title").empty()
            $("#modal-user-title").append('<i class="fa fa-user"></i> Editar Usuario')
            $.ajax({
                url: "../app/controller/UsuarioController.php",
                method: "GET",
                data: {
                    "type": "usuario",
                    "idUsuario": id
                },
                beforeSend: function() {
                    $("#modal-user-title").append(
                        '<img src="./images/spiner.gif" width="25" height="25" style="margin-left: 10px;"/>'
                    )
                },
                success: function(result) {
                    $("#modal-user-title").empty();
                    $("#modal-user-title").append('<i class="fa fa-address-book"> </i> Editar Usuario');
                    if (result.estado == 1) {
                        idUsuario = id;
                        $("#txtAddNombres").val(result.object.Nombres);
                        $("#txtAddApellidos").val(result.object.Apellidos);
                        $("#txtAddUsuario").val(result.object.Usuario);
                        $("#txtContrasena").val(result.object.Clave);
                        tools.AlertInfo("Información", "Se cargo correctamente los datos.");
                    } else {
                        tools.AlertWarning("Advertencia", result.message);
                    }
                },
                error: function(error) {
                    $("#modal-user-title").empty();
                    $("#modal-user-title").append('<i class="fa fa-address-book"> </i> Editar Usuario');
                    tools.AlertError("Error", error.responseText);
                }
            });
        }

        function deleteUser(id) {
            tools.ModalDialog("Usuarios", "¿Está seguro de eliminar el usuario?", function(value) {
                if (value == true) {
                    $.ajax({
                        url: "../app/controller/UsuarioController.php",
                        method: "POST",
                        data: {
                            "type": "deleteUsuario",
                            "idUsuario": id,
                        },
                        beforeSend: function() {
                            tools.ModalAlertInfo("Usuarios", "Procesando petición..");
                        },
                        success: function(result) {
                            if (result.estado == 1) {
                                tools.ModalAlertSuccess("Usuarios", result.message);
                                loadInitUsuario();
                            } else if (result.estado == 2) {
                                tools.ModalAlertWarning("Usuarios", result.message);

                            } else if (result.estado == 3) {
                                tools.ModalAlertWarning("Usuarios", result.message);

                            } else {
                                tools.ModalAlertWarning("Usuarios", result.message);
                            }
                        },
                        error: function(error) {
                            tools.ModalAlertError("Usuarios", error.responseText);
                        }
                    });
                }
            });
        }
    </script>
</body>

</html>