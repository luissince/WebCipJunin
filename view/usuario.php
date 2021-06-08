<?php
session_start();

if (!isset($_SESSION['IdUsuario'])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
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
                                        <label for="txtAddNombres" class="control-label">Nombres</label>
                                        <div class="form-group">
                                            <input id="txtAddNombres" type="text" class="form-control" placeholder="Ingrese su(s) nombre(s)" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="txtAddApellidos" class="control-label">Apellidos</label>
                                        <div class="form-group">
                                            <input id="txtAddApellidos" type="text" class="form-control" placeholder="Ingrese sus apellidos" required="">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="txtAddUsuario" class="control-label">Usuario</label>
                                        <div class="form-group">
                                            <input id="txtAddUsuario" type="text" class="form-control" placeholder="Ingrese su usuario" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="txtClave" class="control-label">Contraseña</label>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input id="txtClave" type="password" class="form-control" placeholder="Ingrese una contraseña" required="">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-success" id="btnView"><i class="fa fa-eye"></i></button>
                                                </div>
                                            </div>
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rol">Rol: </label>
                                            <select id="rol" class="form-control">
                                                <option value="">- Seleccione -</option>
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
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="background-color: #FFFFFF;">
                <!-- Main content -->
                <section class="content-header">
                    <h3 class="no-margin"> Usuarios <small> Lista </small> </h3>
                </section>

                <section class="content">

                    <div class="row">
                        <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <label>Nuevo Usuario.</label>
                            <div class="form-group">
                                <button type="button" class="btn btn-success" id="btnNuevo">
                                    <i class="fa fa-plus"></i> Agregar Usuario
                                </button>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <label>Opción.</label>
                            <div class="form-group">
                                <button class="btn btn-default" id="btnactualizar">
                                    <i class="fa fa-refresh"></i> Recargar </button>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label>Filtrar por nombres, apellidos y rol.</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="search" id="buscar" class="form-control" placeholder="Buscar por Nombre o Apellido" aria-describedby="search" value="">
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
                                        <tr>
                                            <th wid class="text-center">#</th>
                                            <th>Nombre</th>
                                            <th>Apellido</th>
                                            <th>Usuario</th>
                                            <th>Rol</th>
                                            <th>Estado</th>
                                            <th class="text-center">Editar</th>
                                            <th class="text-center">Eliminar</th>
                                        </tr>
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

            let idUsuario = 0;

            $(document).ready(function() {

                loadInitUsuario();

                $("#btnView").click(function() {
                    $("#txtClave").attr("type", $("#txtClave").prop("type") == "text" ? "password" : "text");
                });

                $("#btnView").keypress(function(event) {
                    if (event.keyCode == 13) {
                        $("#txtClave").attr("type", $("#txtClave").prop("type") == "text" ? "password" : "text");
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
                    $("#mdAddUser").modal("show")
                    $("#modal-user-title").empty()
                    $("#modal-user-title").append('<i class="fa fa-user"></i> Registrar Usuario')
                    listarRoles()
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
                            '<tr class="text-center"><td colspan="8"><img src="./images/spiner.gif"/><p>Cargando información.</p></td></tr>'
                        );
                        state = true;
                    },
                    success: function(result) {
                        if (result.estado === 1) {
                            tbTable.empty();
                            for (let usuario of result.usuarios) {

                                let btnUpdate =
                                    '<button class="btn btn-warning btn-xs" onclick="updateUsuario(\'' + usuario.idUsuario + '\',\'' +
                                    usuario.Nombres + '\',\'' + usuario.Apellidos + '\',\'' + usuario.Usuario + '\',\'' + usuario.Clave + '\')">' +
                                    '<i class="fa fa-edit" style="font-size:25px;"></i> ' +
                                    '</button>';
                                let btnDelete =
                                    '<button class="btn btn-danger btn-xs" onclick="deleteUser(\'' + usuario.idUsuario + '\')">' +
                                    '<i class="fa fa-trash" style="font-size:25px;"></i> ' +
                                    '</button>';

                                tbTable.append('<tr>' +
                                    '<td class="text-center text-primary">' + usuario.Id + '</td>' +
                                    '<td class="text-left">' + usuario.Nombres + '</td>' +
                                    '<td class="text-left">' + usuario.Apellidos + '</td>' +
                                    '<td class="text-left">' + usuario.Usuario + '</td>' +
                                    '<td class="text-left">' + usuario.Rol + '</td>' +
                                    '<td class="text-left">' + (usuario.Estado == "1" ? '<label class="text-success">Activo<label>' : '<label class="text-danger">Inactivo</label>') + '</td>' +
                                    '<td class="text-center">' + btnUpdate + '</td>' +
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
                                '<tr class="text-center"><td colspan="8"><p>' + result.message + '</p></td></tr>'
                            );
                            $("#lblPaginaActual").html(0);
                            $("#lblPaginaSiguiente").html(0);
                            state = false;
                        }
                    },
                    error: function(error) {
                        tbTable.empty();
                        tbTable.append(
                            '<tr class="text-center"><td colspan="8"><p>' + error.responseText + '</p></td></tr>'
                        );
                        $("#lblPaginaActual").html(0);
                        $("#lblPaginaSiguiente").html(0);
                        state = false;
                    }
                });
            }

            function crudUsuario() {
                if ($("#txtAddNombres").val() == '') {
                    tools.AlertWarning('Usuario', "Ingrese su(s) nombre(s)");
                    $("#txtAddNombres").focus();
                } else if ($("#txtAddApellidos").val() == '') {
                    tools.AlertWarning('Usuario', "Ingrese sus apellidos");
                    $("#txtAddApellidos").focus();
                } else if ($("#txtAddUsuario").val() == '') {
                    tools.AlertWarning('Usuario', "Ingrese su usuario para el ingreso");
                    $("#txtAddUsuario").focus();
                } else if ($("#txtClave").val() == '') {
                    tools.AlertWarning('Usuario', "Digite una contraseña para el ingreso");
                    $("#txtClave").focus();
                } else if ($("#rol").val() == '') {
                    tools.AlertWarning('Usuario', "Seleccione un rol");
                    $("#rol").focus();
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
                                    "contrasena": $("#txtClave").val(),
                                    "rol": $("#rol").val(),
                                    "estado": $("#estado").val()
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
                $("#mdAddUser").modal("hide");
                $("#modal-user-title").empty();
                $("#txtAddNombres").val("");
                $("#txtAddApellidos").val("");
                $("#txtAddUsuario").val("");
                $("#txtClave").val("");
                $("#txtClave").attr("type", "password");
                $("#estado").val("1");
                idUsuario = 0;
            }

            function updateUsuario(id) {
                $("#mdAddUser").modal("show");
                $("#modal-user-title").empty()
                $("#modal-user-title").append('<i class="fa fa-user"></i> Editar Usuario')
                $.ajax({
                    url: "../app/controller/RolController.php",
                    method: "GET",
                    data: {
                        "type": "roles"
                    },
                    beforeSend: function() {
                        $("#rol").empty();
                        $("#rol").append('<option value="">- Seleccione -</option>');
                        $("#modal-user-title").append(
                            '<img src="./images/spiner.gif" width="25" height="25" style="margin-left: 10px;"/>'
                        )
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            for (let rol of result.roles) {
                                $("#rol").append('<option value="' + rol.IdRol + '">' + rol.Nombre + '</option>');
                            }
                            $.ajax({
                                url: "../app/controller/UsuarioController.php",
                                method: "GET",
                                data: {
                                    "type": "usuario",
                                    "idUsuario": id
                                },
                                beforeSend: function() {
                                    idUsuario = 0;
                                },
                                success: function(result) {
                                    $("#modal-user-title").empty();
                                    $("#modal-user-title").append('<i class="fa fa-address-book"> </i> Editar Usuario');
                                    if (result.estado == 1) {
                                        idUsuario = id;
                                        $("#txtAddNombres").val(result.object.Nombres);
                                        $("#txtAddApellidos").val(result.object.Apellidos);
                                        $("#txtAddUsuario").val(result.object.Usuario);
                                        $("#txtClave").val(result.object.Clave);
                                        $("#rol").val(result.object.Rol);
                                        $("#estado").val(result.object.Estado);
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
                        } else {
                            $("#modal-user-title").empty();
                            $("#modal-user-title").append('<i class="fa fa-address-book"> </i> Editar Usuario');
                            tools.AlertWarning("Advertencia", "No se pudo cargar correctamente los datos.");
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
                                idUsuario = 0;
                            },
                            success: function(result) {
                                if (result.estado == 1) {
                                    tools.ModalAlertSuccess("Usuarios", result.message);
                                    loadInitUsuario();
                                } else if (result.estado == 2) {
                                    tools.ModalAlertWarning("Usuarios", result.message);

                                } else if (result.estado == 3) {
                                    tools.ModalAlertWarning("Usuarios", result.message);

                                } else if (result.estado == 4) {
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

            function listarRoles() {
                $.ajax({
                    url: "../app/controller/RolController.php",
                    method: "GET",
                    data: {
                        "type": "roles"
                    },
                    beforeSend: function() {
                        $("#rol").empty();
                        $("#rol").append('<option value="">- Seleccione -</option>');
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            for (let rol of result.roles) {
                                $("#rol").append('<option value="' + rol.IdRol + '">' + rol.Nombre + '</option>');
                            }
                        }
                    },
                    error: function(error) {

                    }
                });
            }
        </script>
    </body>

    </html>

<?php }
