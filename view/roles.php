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
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="background-color: #FFFFFF;">
            <!-- Main content -->
            <section class="content-header">
                <h3 class="no-margin">Roles <small> Lista </small> </h3>
            </section>

            <!-- modal nuevo ingeniero  -->
            <div class="row">
                <div class="modal fade" id="confirmar">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                </button>
                                <h4 class="modal-title">
                                    <i class="fa fa-address-book">
                                    </i> Registrar Rol
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="nombre">Nombre: <i
                                                    class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="nombre" type="text" name="nombre" class="form-control"
                                                placeholder="Nombre del rol" required="" minlength="3">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="descripcion">Descripción: <i
                                                    class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="descripcion" type="text" name="descripcion" class="form-control"
                                                placeholder="Descripción del rol" required="" minlength="3">
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
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="condicion">Habilitar: </label>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" id="condicion">Sistema
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="sistema">Sistema: </label>
                                            <select id="sistema" class="form-control" disabled>
                                                <option value="0">Indeterminado</option>
                                                <option value="1">Predeterminado</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="modal-footer">
                                <p class="text-left text-danger">Todos los campos marcados con <i
                                        class="fa fa-fw fa-asterisk text-danger"></i> son obligatorios</p>
                                <button type="submit" class="btn btn-danger" name="btnaceptar" id="btnaceptar">
                                    <i class="fa fa-check"></i> Aceptar</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal">
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
                    <div class="modal-dialog modal-xs">
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
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <button class="btn btn-primary" id="btnLeft">
                                            <i class="fa fa-toggle-left"></i>
                                        </button>
                                        <span id="lblPagActual" class="font-weight-bold">0</span>
                                        <span>&nbsp;</span>
                                        <span>a</span>
                                        <span>&nbsp;</span>
                                        <span id="lblPagSiguiente" class="font-weight-bold">0</span>
                                        <button class="btn btn-primary" id="btnRight">
                                            <i class="fa fa-toggle-right"></i>
                                        </button>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <input type="search" id="txtBuscarModulo" class="form-control"
                                                placeholder="Buscar por nombre del modulo" aria-describedby="search">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12 col-xs-12">
                                        <button id="btnBuscarModulo"
                                            class="btn btn-default col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <i class="fa fa-search"></i> Buscar
                                        </button>
                                    </div>
                                </div>
                                <div class="row" style="overflow-x: auto; height:280px">
                                    <div class="col-md-12">
                                        <table class="table table-striped table-hover table-sm">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nombre</th>
                                                    <th>Descripción</th>
                                                    <th>Lectuta</th>
                                                    <th>Escritura</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbModulos">
                                                <tr>
                                                    <td>1</td>
                                                    <td>Nombre del Moduo</td>
                                                    <td>Descripción del Modulo</td>
                                                    <td>                                           
                                                        <input class="form-group checkbox" type="checkbox" id="lectura">                                             
                                                    </td>
                                                    <td>
                                                        <input class="form-group checkbox" type="checkbox" id="escritura">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" id="btnAceptarIngenieros">
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
                            <button type="button" class="btn btn-danger" style="margin-right: 10px;" data-toggle="modal"
                                data-target="#confirmar">
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
                            <input type="search" id="buscar" class="form-control"
                                placeholder="Buscar por nombres del rol" aria-describedby="search" value="">
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

                <div class="row" style="margin-top: -5px;">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <table class="table table-striped"
                            style="border-width: 1px;border-style: dashed;border-color: #E31E25;">
                            <thead style="background-color: #FDB2B1;color: #B72928;">
                                <th style="text-align: center;">#</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                                <th>Sistema</th>
                                <th>Modulos</th>
                                <th>Opciones</th>
                            </thead>
                            <tbody id="tbTable">

                            </tbody>

                        </table>
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

    $(document).ready(function() {

        loadInitRoles();

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

        $("#condicion").on("change", function() {
            $("#sistema").prop("disabled", !this.checked);
        });

        $("#btnactualizar").click(function() {
            loadInitRoles()
        });

        $("#buscar").on("keyup", function(event) {
            if (event.keyCode === 13) {
                paginacion = 1;
                loadTableRoles($("#buscar").val());
                opcion = 1;
            }
        });

        $("#btnaceptar").click(function() {
            if ($("#nombre").val() == '' || $("#nombre").val().length < 3) {
                tools.AlertWarning("Advertencia", "Ingrese un nombre de rol por favor.");
            } else if ($("#descripcion").val() == '' || $("#descripcion").val().length < 4) {
                tools.AlertWarning("Advertencia", "Ingrese una descripción por favor.");
            } else {
                insertRol($("#nombre").val(), $("#descripcion").val(), $("#estado").val(), $("#sistema")
                    .val());
            }
        });

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
                    '<tr class="text-center"><td colspan="10"><img src="./images/spiner.gif"/><p>cargando información.</p></td></tr>'
                );
                state = true;
            },
            success: function(result) {

                if (result.estado === 1) {
                    tbTable.empty();
                    for (let rol of result.roles) {
                        let btnModulos =
                            '<button class="btn btn-info btn-sm"  data-toggle="modal" data-target="#mostrarModulos">' +
                            '<i class="fa fa-eye"></i> Permisos' +
                            '</button>';

                        let btnUpdate =
                            '<button class="btn btn-warning btn-sm" onclick="loadUpdateRoles(\'' +
                            rol.IdRol + '\')">' +
                            '<i class="fa fa-wrench"></i> Editar' +
                            '</button>';

                        let estado = rol.Estado == 1 ? 'Activo' : 'Inactivo'
                        let sistema = rol.Sistema == 1 ? 'Predeterminado' : ' '

                        tbTable.append('<tr>' +
                            '<td style="text-align: center;color: #2270D1;">' +
                            '' + rol.Id + '' +
                            '</td>' +
                            '<td>' + rol.Nombre + '</td>' +
                            '<td>' + rol.Descripcion + '</td>' +
                            '<td>' + estado + '</td>' +
                            '<td>' + sistema + '</td>' +
                            '<td>' + btnModulos + '</td>' +
                            '<td>' + btnUpdate + '</td>' +
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
                        '<tr class="text-center"><td colspan="10"><p>No se pudo cargar la información.</p></td></tr>'
                    );
                    $("#lblPaginaActual").html(0);
                    $("#lblPaginaSiguiente").html(0);
                    state = false;
                }
            },
            error: function(error) {
                tbTable.empty();
                tbTable.append(
                    '<tr class="text-center"><td colspan="10"><p>Se produjo un error, intente nuevamente.</p></td></tr>'
                );
                $("#lblPaginaActual").html(0);
                $("#lblPaginaSiguiente").html(0);
                state = false;
            }
        });
    }

    // function showHistorialIngenieros(idPersona) {
    //     location.href = "update_ingenieros.php?idPersona=" + idPersona;
    // }

    function loadUpdateRoles(idRol) {
        location.href = "update_roles.php?idRol=" + idRol
    }

    function insertRol(nombre, descripcion, estado, sistema) {

        $.ajax({
            url: "../app/controller/RolController.php",
            method: "POST",
            data: {
                "type": "insertRol",
                "Nombre": nombre.toUpperCase(),
                "Descripcion": descripcion.toUpperCase(),
                "Estado": estado,
                "Sistema": sistema
            },
            beforeSend: function() {
                $("#btnaceptar").empty();
                $("#btnaceptar").append('<img src="./images/spiner.gif" width="25" height="25" />')
            },
            success: function(result) {
                if (result.estado == 1) {
                    tools.AlertSuccess("Mensaje", result.message)
                    setTimeout(function() {
                        location.href = "roles.php"
                    }, 1000);
                } else {
                    tools.AlertWarning("Mensaje", result.message)
                    console.log(result.message)
                    setTimeout(function() {
                        $("#btnaceptar").empty();
                        $("#btnaceptar").append('<i class="fa fa-check"></i> Aceptar');
                    }, 1000);
                }
            },
            error: function(error) {
                tools.AlertError("Error", error.responseText);

                $("#btnaceptar").empty();
                $("#btnaceptar").append('<i class="fa fa-check"></i> Aceptar');
            }
        });
    }
    </script>
</body>

</html>
<?php
}