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
            <!-- modal nuevo rol  -->
            <div class="row">
                <div class="modal fade" data-backdrop="static" id="confirmar">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" id="btnCloseRol">
                                    <i class="fa fa-close"></i>
                                </button>
                                <h4 class="modal-title" id="modal-rol-title">
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="nombre">Nombre: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="nombre" type="text" class="form-control" placeholder="Nombre del rol" required="" minlength="3">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="descripcion">Descripción: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="descripcion" type="text" class="form-control" placeholder="Descripción del rol" required="" minlength="3">
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
                                <p class="text-left text-danger">Todos los campos marcados con <i class="fa fa-fw fa-asterisk text-danger"></i> son obligatorios</p>
                                <button type="submit" class="btn btn-danger" id="btnAceptarRol">
                                    <i class="fa fa-check"></i> Guardar</button>
                                <button type="button" class="btn btn-primary" id="btnCancelarRol">
                                    <i class="fa fa-remove"></i> Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal new enginner -->
            <!-- modal Modulo -->
            <div class="row">
                <div class="modal fade" data-backdrop="static" id="mostrarModulos">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                </button>
                                <h4 class="modal-title">
                                    <i class="fa fa-clone">
                                    </i> Lista de Modulos
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-striped table-hover table-sm">
                                            <thead>
                                                <tr>
                                                    <th width="5%">#</th>
                                                    <th width="30%">Nombre</th>
                                                    <th width="15%">Ver</th>
                                                    <th width="15%">Crear</th>
                                                    <th width="15%">Actualizar</th>
                                                    <th width="15%">Eliminar</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbModulos">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" id="btnAceptarModulos">
                                    <i class="fa fa-check"></i> Aceptar</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal">
                                    <i class="fa fa-remove"></i> Cancelar</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--end modal Modulo  -->
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="background-color: #FFFFFF;">
                <!-- Main content -->
                <section class="content-header">
                    <h3 class="no-margin">Roles <small> Lista </small> </h3>
                </section>

                <section class="content">

                    <div class="row">
                        <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <label>Nuevo Rol.</label>
                            <div class="form-group">
                                <button id="btnNuevoRol" type="button" class="btn btn-success" style="margin-right: 10px;">
                                    <i class="fa fa-plus"></i> Agregar Rol
                                </button>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <label>Opción.</label>
                            <div class="form-group">
                                <button class="btn btn-default" id="btnactualizar">
                                    <i class="fa fa-refresh"></i> Recargar
                                </button>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label>Filtrar por nombre del rol.</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="search" id="buscar" class="form-control" placeholder="Buscar por nombres del rol" aria-describedby="search" value="">
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
                                        <th width="5%" style="text-align: center;">#</th>
                                        <th width="20%">Nombre</th>
                                        <th width="30%">Descripción</th>
                                        <th width="15%">Estado</th>
                                        <th width="5%">Modulos</th>
                                        <th width="5%">Editar</th>
                                        <th width="5%">Eliminar</th>
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

            let idRol = 0;

            $(document).ready(function() {

                loadInitRoles();

                $("#btnactualizar").click(function() {
                    loadInitRoles()
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


                $("#buscar").on("keyup", function(event) {
                    if (!state) {
                        paginacion = 1;
                        loadTableRoles($("#buscar").val());
                        opcion = 1;
                    }
                });

                $("#btnAceptarModulos").click(function() {
                    updateModules();
                });

                //-------------------------------------------------------
                $("#btnNuevoRol").click(function() {
                    $("#confirmar").modal("show");
                    $("#modal-rol-title").empty();
                    $("#modal-rol-title").append('<i class="fa fa-address-book"> </i> Registrar Rol');
                });

                $("#btnAceptarRol").click(function() {
                    insertRol();
                });

                $("#btnCancelarRol").click(function() {
                    clearModalNuevoRol()
                });

                $("#btnCloseRol").click(function() {
                    clearModalNuevoRol()
                });

                //-------------------------------------------------------
            });

            function onEventPaginacion() {
                switch (opcion) {
                    case 0:
                        loadTableRoles("");
                        break;
                    case 1:
                        loadTableRoles($("#buscar").val());
                        break;
                }
            }

            function loadInitRoles() {
                if (!state) {
                    paginacion = 1;
                    loadTableRoles("");
                    opcion = 0;
                }
            }

            function loadTableRoles(nombre) {
                $.ajax({
                    url: "../app/controller/RolController.php",
                    method: "GET",
                    data: {
                        "type": "alldata",
                        "nombre": nombre,
                        "posicionPagina": ((paginacion - 1) * filasPorPagina),
                        "filasPorPagina": filasPorPagina
                    },
                    beforeSend: function() {
                        tbTable.empty();
                        tbTable.append(
                            '<tr class="text-center"><td colspan="7"><img src="./images/spiner.gif"/><p>Cargando información.</p></td></tr>'
                        );
                        state = true;
                        totalPaginacion = 0;
                    },
                    success: function(result) {
                        if (result.estado === 1) {
                            tbTable.empty();
                            if (result.roles.length == 0) {
                                tbTable.append(
                                    '<tr class="text-center"><td colspan="7"><p>No hay datos para mostrar</p></td></tr>'
                                );
                                $("#lblPaginaActual").html(0);
                                $("#lblPaginaSiguiente").html(0);
                                state = false;
                            } else {
                                for (let rol of result.roles) {
                                    let btnModulos =
                                        '<button class="btn btn-info btn-xs" onclick="loadTableModulos(\'' + rol.IdRol + '\')">' +
                                        '<i class="fa fa-eye" style="font-size:25px;"></i> ' +
                                        '</button>';

                                    let btnUpdate =
                                        '<button class="btn btn-warning btn-xs" onclick="loadDataRol(\'' + rol.IdRol + '\')">' +
                                        '<i class="fa fa-edit" style="font-size:25px;"></i>' +
                                        '</button>';

                                    let btnDelete =
                                        '<button class="btn btn-danger btn-xs" onclick="eliminarRol(\'' + rol.IdRol + '\')">' +
                                        '<i class="fa fa-trash" style="font-size:25px;"></i> ' +
                                        '</button>';

                                    let estado = rol.Estado == 1 ? 'Activo' : 'Inactivo'

                                    tbTable.append('<tr>' +
                                        '<td style="text-align: center;color: #2270D1;">' +
                                        '' + rol.Id + '' +
                                        '</td>' +
                                        '<td>' + rol.Nombre + '</td>' +
                                        '<td>' + rol.Descripcion + '</td>' +
                                        '<td>' + estado + '</td>' +
                                        '<td>' + btnModulos + '</td>' +
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
                                '<tr class="text-center"><td colspan="7"><p>' + result.message + '</p></td></tr>'
                            );
                            $("#lblPaginaActual").html(0);
                            $("#lblPaginaSiguiente").html(0);
                            state = false;
                        }
                    },
                    error: function(error) {
                        tbTable.empty();
                        tbTable.append(
                            '<tr class="text-center"><td colspan="7"><p>Se produjo un error, intente nuevamente.</p></td></tr>'
                        );
                        $("#lblPaginaActual").html(0);
                        $("#lblPaginaSiguiente").html(0);
                        state = false;
                    }
                });
            }

            function insertRol() {
                if ($("#nombre").val() == '' || $("#nombre").val().length < 3) {
                    tools.AlertWarning("Advertencia", "Ingrese un nombre de rol por favor.");
                } else if ($("#descripcion").val() == '') {
                    tools.AlertWarning("Advertencia", "Ingrese una descripción por favor.");
                } else {
                    tools.ModalDialog("Roles", "¿Está seguro de continuar?", function(value) {
                        if (value == true) {
                            $.ajax({
                                url: "../app/controller/RolController.php",
                                method: "POST",
                                data: {
                                    "type": "crudRol",
                                    "IdRol": idRol,
                                    "Nombre": $("#nombre").val(),
                                    "Descripcion": $("#descripcion").val(),
                                    "Estado": $("#estado").val()
                                },
                                beforeSend: function() {
                                    clearModalNuevoRol();
                                    tools.ModalAlertInfo("Roles", "Procesando petición..");
                                },
                                success: function(result) {
                                    if (result.estado == 1) {
                                        tools.ModalAlertSuccess("Roles", result.message);
                                        loadInitRoles();
                                    } else {
                                        tools.ModalAlertWarning("Roles", result.message);
                                    }
                                },
                                error: function(error) {
                                    tools.ModalAlertError("Roles", error.responseText);
                                }
                            });
                        }
                    });

                }
            }


            function eliminarRol(idRol) {
                tools.ModalDialog("Roles", "¿Está seguro eliminar el rol?", function(value) {
                    if (value == true) {
                        $.ajax({
                            url: "../app/controller/RolController.php",
                            method: "POST",
                            data: {
                                "type": "deletedRol",
                                "idRol": idRol,
                            },
                            beforeSend: function() {
                                tools.ModalAlertInfo("Roles", "Procesando petición..");
                            },
                            success: function(result) {
                                if (result.estado == 1) {
                                    tools.ModalAlertSuccess("Roles", result.message);
                                    loadInitRoles();
                                } else if (result.estado == 2) {
                                    tools.ModalAlertWarning("Roles", result.message);
                                } else {
                                    tools.ModalAlertWarning("Roles", result.message);
                                }
                            },
                            error: function(error) {
                                tools.ModalAlertError("Roles", error.responseText);
                            }
                        });
                    }
                });

            }

            function updateModules() {
                let modulos = [];
                $("#tbModulos tr").each(function(row, tr) {
                    modulos.push({
                        "idPermiso": $(this).attr('id'),
                        "ver": $(tr).find("td:eq(2)").find('input[type="checkbox"]').is(':checked'),
                        "crear": $(tr).find("td:eq(3)").find('input[type="checkbox"]').is(':checked'),
                        "actualizar": $(tr).find("td:eq(4)").find('input[type="checkbox"]').is(':checked'),
                        "eliminar": $(tr).find("td:eq(5)").find('input[type="checkbox"]').is(':checked'),
                    });
                });
                tools.ModalDialog("Modulos", "¿Está seguro de continuar?", function(value) {
                    if (value == true) {
                        $.ajax({
                            url: '../app/controller/ModuloController.php',
                            method: 'POST',
                            accepts: "application/json",
                            contentType: "application/json",
                            data: JSON.stringify({
                                "type": "updateModulo",
                                "modulos": modulos
                            }),
                            beforeSend: function() {
                                $("#mostrarModulos").modal("hide");
                                tools.ModalAlertInfo("Roles", "Procesando petición..");
                            },
                            success: function(result) {
                                if (result.estado == 1) {
                                    tools.ModalAlertSuccess("Modulos", result.message);
                                    loadInitRoles();
                                } else {
                                    tools.ModalAlertWarning("Modulos", result.message);
                                }
                            },
                            error: function(error) {
                                tools.ModalAlertError("Modulos", error.responseText);
                            }
                        });
                    }
                });
            }

            function loadDataRol(id) {
                $("#confirmar").modal("show");
                $("#modal-rol-title").empty();
                $("#modal-rol-title").append('<i class="fa fa-address-book"> </i> Editar Rol');

                $.ajax({
                    url: "../app/controller/RolController.php",
                    method: "GET",
                    data: {
                        "type": "data",
                        "idRol": id
                    },
                    beforeSend: function() {
                        $("#modal-rol-title").append(
                            '<img src="./images/spiner.gif" width="25" height="25" style="margin-left: 10px;"/>'
                        )
                    },
                    success: function(result) {
                        $("#modal-rol-title").empty();
                        $("#modal-rol-title").append('<i class="fa fa-address-book"> </i> Editar Rol');
                        if (result.estado === 1) {
                            let rol = result.object;
                            idRol = id;
                            $("#nombre").val(rol.Nombre)
                            $("#descripcion").val(rol.Descripcion)
                            $("#estado").val(rol.Estado)
                            tools.AlertInfo("Información", "Se cargo correctamente los datos.");
                        } else {
                            tools.AlertWarning("Advertencia", result.message);
                        }
                    },
                    error: function(error) {
                        $("#modal-rol-title").empty();
                        $("#modal-rol-title").append('<i class="fa fa-address-book"> </i> Editar Rol');
                        tools.AlertError("Error", error.responseText);
                    }
                });
            }

            function clearModalNuevoRol() {
                $("#confirmar").modal("hide");
                $("#modal-rol-title").empty();
                $("#nombre").val("");
                $("#descripcion").val("");
                $("#estado").val("1");
                idRol = 0;
            }

            function loadTableModulos(idRol) {
                $("#mostrarModulos").modal("show");
                $.ajax({
                    url: "../app/controller/RolController.php",
                    method: "GET",
                    data: {
                        "type": 'modulos',
                        "idRol": idRol,
                    },
                    beforeSend: function() {
                        $("#tbModulos").empty();
                        $("#tbModulos").append(
                            '<tr class="text-center"><td colspan="6"><img src="./images/spiner.gif"/><p>Cargando información.</p></td></tr>'
                        );

                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            $("#tbModulos").empty();
                            for (let modulo of result.modulos) {
                                $("#tbModulos").append('<tr id="' + modulo.idPermiso + '">' +
                                    '          <td>' + modulo.id + '</td>' +
                                    '          <td>' + modulo.nombre + '</td>' +
                                    '          <td>' +
                                    '          ' + (modulo.ver == 1 ? '<input class="form-group checkbox" type="checkbox" checked>' : '<input class="form-group checkbox" type="checkbox" >') + '' +
                                    '          </td>' +
                                    '          <td>' +
                                    '          ' + (modulo.crear == 1 ? '<input class="form-group checkbox" type="checkbox" checked>' : '<input class="form-group checkbox" type="checkbox" >') + '' +
                                    '          </td>' +
                                    '          <td>' +
                                    '          ' + (modulo.actualizar == 1 ? '<input class="form-group checkbox" type="checkbox" checked>' : '<input class="form-group checkbox" type="checkbox" >') + '' +
                                    '          </td>' +
                                    '          <td>' +
                                    '          ' + (modulo.eliminar == 1 ? '<input class="form-group checkbox" type="checkbox" checked>' : '<input class="form-group checkbox" type="checkbox" >') + '' +
                                    '          </td>' +
                                    '      </tr>');
                            }
                        } else {
                            $("#tbModulos").empty();
                            $("#tbModulos").append(
                                '<tr class="text-center"><td colspan="6"><p>' + result.message + '</p></td></tr>'
                            );
                        }
                    },
                    error: function(error) {
                        $("#tbModulos").empty();
                        $("#tbModulos").append(
                            '<tr class="text-center"><td colspan="6"><p>' + error.responseText + '</p></td></tr>'
                        );
                    }
                });
            }
        </script>
    </body>

    </html>
<?php }
