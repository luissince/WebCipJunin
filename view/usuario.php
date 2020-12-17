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
                <div class="modal fade" id="mdAddUser">
                    <div class="modal-dialog modal-xs" style="width: 500px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" id="btnCloseAddUser">
                                    <i class="fa fa-close"></i>
                                </button>
                                <h4 class="modal-title">
                                    <i class="fa fa-user">
                                    </i> Registrar Usuario
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Universidad" class="col-sm-4 control-label">Nombres</label>
                                            <div class="col-sm-8">
                                                <input id="txtAddNombres" type="text" class="form-control" placeholder="Ingrese su(s) nombre(s)" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Universidad" class="col-sm-4 control-label">Apellidos</label>
                                            <div class="col-sm-8">
                                                <input id="txtAddApellidos" type="text" class="form-control" placeholder="Ingrese sus apellidos" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Universidad" class="col-sm-4 control-label">Contraseña</label>
                                            <div class="col-sm-8">
                                                <input id="txtContrasena" type="text" class="form-control" placeholder="Ingrese una contraseña" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Universidad" class="col-sm-4 control-label">Usuario</label>
                                            <div class="col-sm-8">
                                                <input id="txtAddUsuario" type="text" class="form-control" placeholder="Ingrese su usuario" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" id="btnAceptarAddUser">
                                    <i class="fa fa-check"></i> Aceptar</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal" id="cancel-nuevo">
                                    <i class="fa fa-remove"></i> Cancelar</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal añadir usuario -->

            <!-- modal update usuario  -->
            <div class="row">
                <div class="modal fade" id="mdEditUser">
                    <div class="modal-dialog modal-xs" style="width: 500px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" id="btnCloseEditUser">
                                    <i class="fa fa-close"></i>
                                </button>
                                <h4 class="modal-title">
                                    <i class="fa fa-user">
                                    </i> Editar Usuario
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtEditNombres" class="col-sm-4 control-label">Nombres</label>
                                            <div class="col-sm-8">
                                                <input id="txtEditNombres" type="text" class="form-control" placeholder="" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtEditApellidos" class="col-sm-4 control-label">Apellidos</label>
                                            <div class="col-sm-8">
                                                <input id="txtEditApellidos" type="text" class="form-control" placeholder="" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Universidad" class="col-sm-4 control-label">Contraseña</label>
                                            <div class="col-sm-8">
                                                <input id="txtEditContrasena" type="text" class="form-control" placeholder="" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 0.5em;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Universidad" class="col-sm-4 control-label">Usuario</label>
                                            <div class="col-sm-8">
                                                <input id="txtEditUsuario" type="text" class="form-control" placeholder="" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" id="btnAceptarEditUser">
                                    <i class="fa fa-check"></i> Aceptar</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal" id="cancel-edit">
                                    <i class="fa fa-remove"></i> Cancelar</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal update usuario  -->

            <!-- modal eliminar Usuario  -->
            <div class="row">
                <div class="modal fade" id="deleteUser">
                    <div class="modal-dialog modal-xs" style="width: 500px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                </button>
                                <h4 class="modal-title">
                                    <i class="fa fa-user">
                                    </i> Eliminar Usuario
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="Universidad" class="col-sm-12 control-label">¿Estas seguro que deseas elimininar este universidad?</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" id="btnDeleteUser">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="cancel-eliminar">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal eliminar usuario -->

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

            $("#btnNuevo").click(function() {
                $("#mdAddUser").modal("show");
            })

            $("#btnSearch").click(function() {
                paginacion = 1;
                loadTableUsuario($("#buscar").val());
                opcion = 1;
            });

            $("#btnAceptarAddUser").click(function() {
                crudUsuario($("#txtAddNombres").val(), $("#txtAddApellidos").val(), $("#txtAddUsuario").val(), $("#txtContrasena").val());
            });

            $("#cancel-nuevo").click(function() {
                $("#mdAddUser").modal("hide");
                $("#txtAddNombres").val('');
                $("#txAddApellidos").val('');
                $("#txtAddUsuario").val('');
                $("#txtContrasena").val('');
            });

            $("#cancel-edit").click(function() {
                $("#mdEditUser").modal("hide");
                // $("#txtEditNombres").val('');
                // $("#txAddApellidos").val('');
                // $("#txtAddUsuario").val('');
                // $("#txtContrasena").val('');
            });

            $("#cancel-eliminar").click(function() {
                $("#deleteUser").modal("hide");
            });

            $("#btnCloseAddUser").click(function() {
                $("#mdAddUser").modal("hide");
                $("#txtNombres").val('');
                $("#txtApellidos").val('');
                $("#txtUsuario").val('');
            });

            // $("#btnCLoseEditUniversidad").click(function() {
            //     $("#editAddUniversidad").modal("hide");
            //     $("#txtUniversidad1").val('');
            //     $("#txtSiglas1").val('');
            // });
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
                        '<tr class="text-center"><td colspan="6"><img src="./images/spiner.gif"/><p>cargando información.</p></td></tr>'
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

        function crudUsuario(nombres, apellidos, usuarios, contrasenas) {
            let nombre = nombres;
            let apellido = apellidos;
            let usuario = usuarios;
            let contrasena = contrasenas;

            console.log('entro');
            if ($("#txtAddNombres").val() == '') {
                tools.AlertWarning('Usuario', "Ingrese minimo un nombre correcto");
                $("#txtAddNombres").focus();
            } else if ($("#txtAddApellidos").val() == '') {
                tools.AlertWarning('Usuario', "Ingrese apellidos");
                $("#txtAddApellidos").focus();
            } else if ($("#txtContrasena").val() == '') {
                tools.AlertWarning('Usuario', "Digite una contraseña ");
                $("#txtContrasena").focus();
            } else if ($("#txtAddUsuario").val() == '') {
                tools.AlertWarning('Usuario', "Ingrese usuario");
                $("#txtAddUsuario").focus();
            } else {
                $.ajax({
                    url: "../app/controller/UsuarioController.php",
                    method: "POST",
                    data: {
                        "type": "insertUsuario",
                        "nombres": nombre,
                        "apellidos": apellido,
                        "usuarios": usuario,
                        "contrasena": contrasena
                    },
                    beforeSend: function() {
                        tools.AlertInfo("Usuario", "Procesando información.");
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            tools.AlertSuccess("Usuario", "Se registro correctamente.");
                            $("#mdAddUser").modal("hide");
                            // clearModal();
                        } else if (result.estado == 3) {
                            tools.AlertWarning("Usuario", result.message);
                        } else {
                            console.log(result);
                            tools.AlertWarning("Usuario", result.message);
                        }
                    },
                    error: function(error) {
                        console.log(error);
                        tools.AlertError("Usuario", "Error fatal: Comuniquese con el administrador del sistema");
                    }
                });
            }
        }

        function updateUsuario(idUsuario, nombre, apellido, usuario, clave) {
            // let idUsuari = idUsuario;
            // let nombre = nombre;
            // let apellido = apellido;
            // let usuario = usuario;
            // let clave = clave;

            $("#mdEditUser").modal("show");
            $("#txtEditNombres").val(nombre);
            $("#txtEditApellidos").val(apellido);
            $("#txtEditContrasena").val(clave);
            $("#txtEditUsuario").val(usuario);

            $("#btnAceptarEditUser").unbind();

            $("#btnAceptarEditUser").bind("click", function() {
                if ($("#txtEditNombres").val() == '') {
                    tools.AlertWarning('Usuario', "Ingrese un usuario");
                    $("#txtEditNombres").focus();
                } else if ($("#txtEditApellidos").val() == '') {
                    tools.AlertWarning('Usuario', "Ingrese los apellidos");
                    $("#txtEditApellidos").focus();
                } else if ($("#txtEditContrasena").val() == '') {
                    tools.AlertWarning('Usuario', "Ingrese una contraseña");
                    $("#txtEditContrasena").focus();
                } else if ($("#txtEditUsuario").val() == '') {
                    tools.AlertWarning('Usuario', "Ingrese un usuario");
                    $("#txtEditUsuario").focus();
                } else {
                    $.ajax({
                        url: "../app/controller/UsuarioController.php",
                        method: "POST",
                        data: {
                            "type": "updateUsuario",
                            "idusuario": idUsuario,
                            "nombres": $("#txtEditNombres").val(),
                            "apellidos": $("#txtEditApellidos").val(),
                            "contrasena": $("#txtEditContrasena").val(),
                            "usuario": $("#txtEditUsuario").val()
                        },
                        beforeSend: function() {
                            tools.AlertInfo("Usuario", "Procesando información.");
                        },
                        success: function(result) {
                            if (result.estado == 1) {
                                tools.AlertSuccess("Usuario", "Se actualizo correctamente.");
                                $("#mdEditUser").modal("hide");
                            } else if (result.estado == 3) {
                                tools.AlertWarning("Usuario", result.message);
                                // } else if (result.estado == 4) {
                                //     tools.AlertWarning("Universidad", result.message);
                            } else {
                                tools.AlertWarning("Usuario", result.message);
                            }
                        },
                        error: function(error) {
                            console.log(error);
                            tools.AlertError("Usuario", "Error fatal: Comuniquese con el administrador del sistema");
                        }
                    });
                }
            })
        }

        function deleteUser(idU) {
            $("#deleteUser").modal("show");

            let idUser = idU;

            $("#btnDeleteUser").unbind();

            $("#btnDeleteUser").bind("click", function() {
                $.ajax({
                    url: "../app/controller/UsuarioController.php",
                    method: "POST",
                    data: {
                        "type": "deleteUsuario",
                        "idUsuario": idUser,
                    },
                    beforeSend: function() {
                        tools.AlertInfo("Usuario", "Procesando información.");
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            tools.AlertSuccess("Usuario", result.message);
                            $("#deleteUser").modal("hide");
                        } else if (result.estado == 2) {
                            tools.AlertWarning("Usuario", result.message);
                        } else if (result.estado == 3) {
                            tools.AlertWarning("Usuario", result.message);
                        } else {
                            tools.AlertWarning("Usuario", result.message);
                        }
                    },
                    error: function(error) {
                        console.log(error);
                        tools.AlertError("Usuario", "Error fatal: Comuniquese con el administrador del sistema");
                    }
                });
            })
        }
    </script>
</body>

</html>