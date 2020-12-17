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
                <h3 class="no-margin">Roles <small> Lista </small> </h3>
            </section>

            <!-- modal nuevo rol  -->
            <div class="row">
                <div class="modal fade" id="confirmar">
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
                                            <input id="nombre" type="text" name="nombre" class="form-control" placeholder="Nombre del rol" required="" minlength="3">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="descripcion">Descripción: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="descripcion" type="text" name="descripcion" class="form-control" placeholder="Descripción del rol" required="" minlength="3">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
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
                                    <i class="fa fa-check"></i> Aceptar</button>
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
                <div class="modal fade" id="mostrarModulos">
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
                                <div class="row" style="overflow-x: auto; height:280px">
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

            <section class="content">

                <div class="row">
                    <div class="col-md-2 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <button id="btnNuevoRol" type="button" class="btn btn-danger" style="margin-right: 10px;">
                                <i class="fa fa-plus"></i> Nuevo Rol
                            </button>
                        </div>
                    </div>

                    <div class="col-md-2 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <button class="btn btn-link" id="btnactualizar">
                                <i class="fa fa-refresh"></i> Actualizar..
                            </button>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <input type="search" id="buscar" class="form-control" placeholder="Buscar por nombres del rol" aria-describedby="search" value="">
                        </div>
                    </div>

                    <div class="col-md-2 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <button class="btn btn-default">
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
                                    <th width="5%" style="text-align: center;">#</th>
                                    <th width="20%">Nombre</th>
                                    <th width="30%">Descripción</th>
                                    <th width="15%">Estado</th>
                                    <th width="10%">Modulos</th>
                                    <th width="10%">Opciones</th>
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
        let tbTable = $("#tbTable");

        $(document).ready(function() {

            loadInitRoles();

            $("#btnactualizar").click(function() {
                loadInitRoles()
            });

            $("#buscar").on("keyup", function(event) {
                if (event.keyCode === 13) {
                    loadTableRoles($("#buscar").val());
                }
            });

            $("#btnAceptarModulos").click(function() {
                $("#tbModulos tr").each(function(row, tr) {
                    console.log($(tr).find("td:eq(2)").find('input[type="checkbox"]').is(':checked'))
                    //   $(tr).find("td:eq(0)").find("input").val();
                    //      $(tr).find("td:eq(1)").find("input").val();
                    // $(tr).find("td:eq(2)").find('input[type="checkbox"]').is(':checked');

                });
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

        function loadInitRoles() {
            if (!state) {
                loadTableRoles("");
            }
        }

        function loadTableRoles(nombre) {
            $.ajax({
                url: "../app/controller/RolController.php",
                method: "GET",
                data: {
                    "type": "alldata",
                    "nombre": nombre,
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
                        if (result.roles.length == 0) {
                            tbTable.append(
                                '<tr class="text-center"><td colspan="6"><p>No hay datos para mostrar</p></td></tr>'
                            );
                            state = false;
                        } else {
                            for (let rol of result.roles) {
                                let btnModulos =
                                    '<button class="btn btn-info btn-sm" onclick="loadTableModulos(\'' + rol.IdRol + '\')">' +
                                    '<i class="fa fa-eye"></i> Permisos' +
                                    '</button>';

                                let btnUpdate =
                                    '<button class="btn btn-warning btn-sm" onclick="loadUpdateRoles(\'' +
                                    rol.IdRol + '\')">' +
                                    '<i class="fa fa-wrench"></i> Editar' +
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
                                    '</tr>');
                            }
                            state = false;
                        }
                    } else {
                        tbTable.empty();
                        tbTable.append(
                            '<tr class="text-center"><td colspan="6"><p>' + result.message + '</p></td></tr>'
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


        function loadUpdateRoles(idRol) {
            location.href = "update_roles.php?idRol=" + idRol
        }

        function insertRol(nombre, descripcion, estado) {
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
                                "type": "insertRol",
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

        function clearModalNuevoRol() {
            $("#confirmar").modal("hide");
            $("#modal-rol-title").empty();
            $("#nombre").val("");
            $("#descripcion").val("");
            $("#estado").val("1");
        }

        function loadDataRol(idRol) {
            $.ajax({
                url: "../app/controller/RolController.php",
                method: "GET",
                data: {
                    "type": "data",
                    "idRol": idRol
                },
                beforeSend: function() {
                    spiner.append(
                        '<img src="./images/spiner.gif" width="25" height="25" style="margin-left: 10px;"/>'
                    )
                },
                success: function(result) {
                    // console.log(result)
                    spiner.remove()
                    if (result.estado === 1) {
                        let rol = result.object;
                        $("#nombre").val(rol.Nombre)
                        $("#descripcion").val(rol.Descripcion)
                        $("#estado").val(rol.Estado)
                        tools.AlertInfo("Información", "Se cargo correctamente los datos.");
                        state = true;
                    } else {
                        tools.AlertWarning("Advertencia", result.message);
                        state = false;
                    }
                },
                error: function(error) {
                    tools.AlertError("Error", error);
                    state = false;
                }
            });
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
                },
                success: function(result) {
                    console.log(result)
                    if (result.estado == 1) {
                        for (let modulo of result.modulos) {
                            $("#tbModulos").append('<tr>' +
                                '          <td>' + modulo.id + '</td>' +
                                '          <td>' + modulo.nombre + '</td>' +
                                '          <td>' +
                                '          ' + (modulo.ver == 1 ? '<input class="form-group checkbox" type="checkbox" checked>' : '<input class="form-group checkbox" type="checkbox" checked>') + '' +
                                '          </td>' +
                                '          <td>' +
                                '          ' + (modulo.crear == 1 ? '<input class="form-group checkbox" type="checkbox" checked>' : '<input class="form-group checkbox" type="checkbox" checked>') + '' +
                                '          </td>' +
                                '          <td>' +
                                '          ' + (modulo.actualizar == 1 ? '<input class="form-group checkbox" type="checkbox" checked>' : '<input class="form-group checkbox" type="checkbox" checked>') + '' +
                                '          </td>' +
                                '          <td>' +
                                '          ' + (modulo.eliminar == 1 ? '<input class="form-group checkbox" type="checkbox" checked>' : '<input class="form-group checkbox" type="checkbox" checked>') + '' +
                                '          </td>' +
                                '      </tr>');
                        }
                    } else {

                    }
                },
                error: function(error) {
                    console.log(error)
                }
            });
        }
    </script>
</body>

</html>