<?php
session_start();

if (!isset($_SESSION['IdUsuario'])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
    if ($_SESSION["Permisos"][1]["ver"] == 1) {
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

                <!-- modal añadir usuario  -->
                <div class="row">
                    <div class="modal fade" data-backdrop="static" id="mdAddUser">
                        <div class="modal-dialog modal-xs">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title" id="modal-user-title">
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="txtAddNombres" class="control-label">Nombres <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <div class="form-group">
                                                <input id="txtAddNombres" type="text" class="form-control" placeholder="Ingrese su(s) nombre(s)" required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="txtAddApellidos" class="control-label">Apellidos <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <div class="form-group">
                                                <input id="txtAddApellidos" type="text" class="form-control" placeholder="Ingrese sus apellidos" required="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="txtAddUsuario" class="control-label">Usuario <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <div class="form-group">
                                                <input id="txtAddUsuario" type="text" class="form-control" placeholder="Ingrese su usuario" required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="txtClave" class="control-label">Contraseña <i class="fa fa-fw fa-asterisk text-danger"></i></label>
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
                                                <label for="estado">Estado </label>
                                                <select id="estado" class="form-control">
                                                    <option value="1">Activo</option>
                                                    <option value="0">Inactivo</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="rol">Rol <i class="fa fa-fw fa-asterisk text-danger"></i></label>
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
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end modal añadir usuario -->

                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper">
                    <!-- Main content -->
                    <section class="content-header">
                        <h3 class="no-margin"> Usuarios <small> Lista 2 </small> </h3>
                        <ol class="breadcrumb">
                            <li><a href="index.php"><i class="fa fa-home"></i> Inicio</a></li>
                            <li class="active">usuario</li>
                        </ol>
                    </section>

                    <section class="content">
                        <div class="invoice">
                            <div class="row">
                                <?php

                                if ($_SESSION["Permisos"][1]["crear"] == 1) {
                                    echo '
                                <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                    <label>Nuevo Usuario.</label>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-success" id="btnNuevo">
                                            <i class="fa fa-plus"></i> Agregar Usuario
                                        </button>
                                    </div>
                                </div>';
                                } ?>

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

                let editView = "<?= $_SESSION["Permisos"][1]["actualizar"]; ?>";
                let deleteView = "<?= $_SESSION["Permisos"][1]["eliminar"]; ?>";

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
                        $("#mdAddUser").modal("show");
                        $("#modal-user-title").empty();
                        $("#modal-user-title").append('<i class="fa fa-user"></i> Registrar Usuario');
                        listarRoles();
                    });

                    $("#mdAddUser").on('shown.bs.modal', function() {
                        $("#txtAddNombres").focus();
                    });

                    $("#mdAddUser").on('hidden.bs.modal', function() {
                        clearModalUsuario();
                    });

                    $("#btnAceptarAddUser").click(function() {
                        crudUsuario();
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

                async function loadTableUsuario(nombres) {
                    try {
                        tbTable.empty();
                        tbTable.append(
                            '<tr class="text-center"><td colspan="8"><img src="./images/spiner.gif"/><p>Cargando información.</p></td></tr>'
                        );
                        state = true;

                        let result = await axios.get("../app/web/UsuarioWeb.php", {
                            params: {
                                "type": "alldata",
                                "nombres": nombres,
                                "posicionPagina": ((paginacion - 1) * filasPorPagina),
                                "filasPorPagina": filasPorPagina
                            }
                        });

                        tbTable.empty();
                        for (let usuario of result.data.usuarios) {

                            let btnUpdate = editView == 0 ? '<i class="fa fa-minus" style="font-size:20px;"></i>' :
                                '<button class="btn btn-warning btn-xs" onclick="updateUsuario(\'' + usuario.idUsuario + '\',\'' +
                                usuario.Nombres + '\',\'' + usuario.Apellidos + '\',\'' + usuario.Usuario + '\',\'' + usuario.Clave + '\')">' +
                                '<i class="fa fa-edit" style="font-size:25px;"></i> ' +
                                '</button>';

                            let btnDelete = deleteView == 0 ? '<i class="fa fa-minus" style="font-size:20px;"></i>' :
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
                        totalPaginacion = parseInt(Math.ceil((parseFloat(result.data.total) / parseInt(
                            filasPorPagina))));
                        $("#lblPaginaActual").html(paginacion);
                        $("#lblPaginaSiguiente").html(totalPaginacion);
                        state = false;
                    } catch (error) {
                        tbTable.empty();
                        tbTable.append(
                            '<tr class="text-center"><td colspan="8"><p>' + error.response.data + '</p></td></tr>'
                        );
                        $("#lblPaginaActual").html(0);
                        $("#lblPaginaSiguiente").html(0);
                        state = false;
                    }
                }

                async function crudUsuario() {
                    if ($("#txtAddNombres").val() == '') {
                        tools.AlertWarning('Usuario', "Ingrese su(s) nombre(s)");
                        $("#txtAddNombres").focus();
                        return;
                    }

                    if ($("#txtAddApellidos").val() == '') {
                        tools.AlertWarning('Usuario', "Ingrese sus apellidos");
                        $("#txtAddApellidos").focus();
                        return;
                    }

                    if ($("#txtAddUsuario").val() == '') {
                        tools.AlertWarning('Usuario', "Ingrese su usuario para el ingreso");
                        $("#txtAddUsuario").focus();
                        return;
                    }

                    if ($("#txtClave").val() == '') {
                        tools.AlertWarning('Usuario', "Digite una contraseña para el ingreso");
                        $("#txtClave").focus();
                        return;
                    }

                    if ($("#rol").val() == '') {
                        tools.AlertWarning('Usuario', "Seleccione un rol");
                        $("#rol").focus();
                        return;
                    }

                    tools.ModalDialog("Usuarios", "¿Está seguro de continuar?", async function(value) {
                        if (value == true) {
                            try {
                                $("#mdAddUser").modal("hide");
                                tools.ModalAlertInfo("Usuarios", "Procesando petición..");

                                let result = await axios.post("../app/web/UsuarioWeb.php", {
                                    "type": "insertUsuario",
                                    "idusuario": idUsuario,
                                    "nombres": $("#txtAddNombres").val(),
                                    "apellidos": $("#txtAddApellidos").val(),
                                    "usuarios": $("#txtAddUsuario").val(),
                                    "contrasena": $("#txtClave").val(),
                                    "rol": $("#rol").val(),
                                    "estado": $("#estado").val()
                                });

                                tools.ModalAlertSuccess("Usuarios", result.data);
                                onEventPaginacion();
                            } catch (error) {
                                if (error.response) {
                                    tools.ModalAlertWarning("Usuarios", error.response.data);
                                } else {
                                    tools.ModalAlertError("Usuarios", "Se produjo un error interno, intente nuevamente.");
                                }
                            }
                        }
                    });

                }

                function clearModalUsuario() {
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
                                updateUsuarioData(id);
                            } else {

                            }
                        },
                        error: function(error) {
                            $("#modal-user-title").empty();
                            $("#modal-user-title").append('<i class="fa fa-address-book"> </i> Editar Usuario');
                            tools.AlertError("Error", error.responseText);
                        }
                    });
                }

                async function updateUsuarioData(id) {
                    try {
                        idUsuario = 0;

                        let result = await axios.get("../app/web/UsuarioWeb.php", {
                            params: {
                                "type": "usuario",
                                "idUsuario": id
                            }
                        });

                        $("#modal-user-title").empty();
                        $("#modal-user-title").append('<i class="fa fa-address-book"> </i> Editar Usuario');

                        idUsuario = id;
                        $("#txtAddNombres").val(result.data.Nombres);
                        $("#txtAddApellidos").val(result.data.Apellidos);
                        $("#txtAddUsuario").val(result.data.Usuario);
                        $("#txtClave").val(result.data.Clave);
                        $("#rol").val(result.data.Rol);
                        $("#estado").val(result.data.Estado);
                        tools.AlertInfo("Información", "Se cargo correctamente los datos.");
                    } catch (error) {
                        $("#modal-user-title").empty();
                        $("#modal-user-title").append('<i class="fa fa-address-book"> </i> Editar Usuario');
                        if (error.response) {
                            tools.AlertWarning("Advertencia", error.response.data);
                        } else {
                            tools.AlertError("Advertencia", "Se produjo un error interno, intente nuevamente.");
                        }
                    }
                }

                function deleteUser(id) {
                    tools.ModalDialog("Usuarios", "¿Está seguro de eliminar el usuario?", async function(value) {
                        if (value == true) {
                            try {
                                tools.ModalAlertInfo("Usuarios", "Procesando petición..");
                                idUsuario = 0;

                                let result = await axios.post("../app/web/UsuarioWeb.php", {
                                    "type": "deleteUsuario",
                                    "idUsuario": id,
                                });

                                tools.ModalAlertSuccess("Usuarios", result.data);
                                loadInitUsuario();
                            } catch (error) {
                                if (error.response) {
                                    tools.ModalAlertWarning("Usuarios", error.response.data);
                                } else {
                                    tools.ModalAlertError("Usuarios", "Se produjo un error interno, intente nuevamente.");
                                }
                            }
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

<?php
    } else {
        echo '<script>location.href = "./index.php";</script>';
    }
}
