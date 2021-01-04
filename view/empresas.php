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
                    <h3 class="no-margin"> Empresas <small> Lista </small> </h3>
                </section>

                <!-- modal nueva Empresa  -->
                <div class="row">
                    <div class="modal fade" id="NuevaEmpresaPersona">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" id="btnCloseEmpresa">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <!-- <h4 class="modal-title">
                                            <i class="fa fa-building-o">
                                            </i> Registrar Empresa
                                        </h4> -->
                                    <h4 class="modal-title" id="modal-empresa-title">
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtRuc">RUC: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="txtRuc" type="number" class="form-control" placeholder="Ingrese ruc" required="" minlength="11">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="NombreComercial">Nombre/Razón Social: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="NombreComercial" type="text" class="form-control" placeholder="Nombre Comercial" required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="DireccionEmpresa">Dirección: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="DireccionEmpresa" type="text" class="form-control" placeholder="Dirección" required="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Tlf_Celular">Telefono/Celular:</label>
                                                <input id="Tlf_Celular" type="number" class="form-control" placeholder="telefono o celular" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Pagina_web">Pagina Web:</label>
                                                <input id="Pagina_web" type="text" class="form-control" placeholder="página web" required="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Email_Empresa">Correo Electrónico:</label>
                                                <input id="Email_Empresa" type="text" class="form-control" placeholder="Correo electónico" required="">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <p class="text-left text-danger">Todos los campos marcados con <i class="fa fa-fw fa-asterisk text-danger"></i> son obligatorios</p>
                                    <button type="submit" class="btn btn-danger" id="btnAceptarAddEmpresa">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" id="btnCancelarAddEmpresa">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end modal new Bussinees -->

                <section class="content">

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <button type="button" class="btn btn-success" id="btnNuevo">
                                    <i class="fa fa-plus"></i> Nueva Empresa
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
                                        <th>Numero de Ruc</th>
                                        <th>Nombre</th>
                                        <th>Direccion</th>
                                        <th>Telefono</th>
                                        <th>Página Web</th>
                                        <th>Correo Electrónico</th>
                                        <th colspan="2">Opciones</th>
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

            let idEmpresa = 0;

            $(document).ready(function() {

                loadInitEmpresas();

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
                    loadInitEmpresas();
                });

                $("#buscar").on("keyup", function(event) {
                    if (event.keyCode === 13) {
                        paginacion = 1;
                        loadTableEmpresa($("#buscar").val());
                        opcion = 1;
                    }
                });

                $("#btnSearch").click(function() {
                    paginacion = 1;
                    loadTableEmpresa($("#buscar").val());
                    opcion = 1;
                });

                //---------------------------------------------------------------------------
                $("#btnNuevo").click(function() {
                    clearModalAddEmpresa();
                    $("#NuevaEmpresaPersona").modal("show")
                    $("#modal-empresa-title").empty()
                    $("#modal-empresa-title").append('<i class="fa fa-building-o"></i> Registrar Empresa')
                })

                $("#btnAceptarAddEmpresa").click(function() {
                    crudEmpresa();
                });

                $("#btnCancelarAddEmpresa").click(function() {
                    clearModalAddEmpresa()
                });

                $("#btnCloseEmpresa").click(function() {
                    clearModalAddEmpresa()
                });

            });

            function onEventPaginacion() {
                switch (opcion) {
                    case 0:
                        loadTableEmpresa("");
                        break;
                    case 1:
                        loadTableEmpresa($("#buscar").val());
                        break;
                }
            }

            function loadInitEmpresas() {
                if (!state) {
                    paginacion = 1;
                    loadTableEmpresa("");
                    opcion = 0;
                }
            }

            function loadTableEmpresa(nombres) {
                $.ajax({
                    url: "../app/controller/EmpresaController.php",
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
                            '<tr class="text-center"><td colspan="9"><img src="./images/spiner.gif"/><p>Cargando información.</p></td></tr>'
                        );
                        state = true;
                        totalPaginacion = 0;
                    },
                    success: function(result) {
                        if (result.estado === 1) {
                            tbTable.empty();
                            if (result.empresas.length == 0) {
                                tbTable.append(
                                    '<tr class="text-center"><td colspan="9"><p>No hay datos para mostrar.</p></td></tr>'
                                );

                                $("#lblPaginaActual").html(paginacion);
                                $("#lblPaginaSiguiente").html(totalPaginacion);
                                state = false;
                            } else {

                                for (let empresa of result.empresas) {

                                    let btnUpdate =
                                        '<button class="btn btn-warning btn-sm" onclick="updateEmpresas(\'' + empresa.idEmpresa + '\')">' +
                                        '<i class="fa fa-wrench"></i> Editar' +
                                        '</button>';
                                    let btnDelete =
                                        '<button class="btn btn-danger btn-sm" onclick="deleteEmpresa(\'' + empresa.idEmpresa + '\')">' +
                                        '<i class="fa fa-trash"></i> Eliminar' +
                                        '</button>';

                                    tbTable.append('<tr>' +
                                        '<td style="text-align: center;color: #2270D1;">' +
                                        '' + empresa.Id + '' +
                                        '</td>' +
                                        '<td>' + empresa.numeroRuc + '</td>' +
                                        '<td>' + empresa.nombre + '</td>' +
                                        '<td>' + empresa.direccion + '</td>' +
                                        '<td>' + empresa.telefono + '</td>' +
                                        '<td>' + empresa.paginaWeb + '</td>' +
                                        '<td>' + empresa.email + '</td>' +
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
                            }
                        } else {
                            tbTable.empty();
                            tbTable.append(
                                '<tr class="text-center"><td colspan="9"><p>No se pudo cargar la información.</p></td></tr>'
                            );
                            $("#lblPaginaActual").html(0);
                            $("#lblPaginaSiguiente").html(0);
                            state = false;
                        }
                    },
                    error: function(error) {
                        tbTable.empty();
                        console.log(error);
                        tbTable.append(
                            '<tr class="text-center"><td colspan="9"><p>Se produjo un error, intente nuevamente.</p></td></tr>'
                        );
                        $("#lblPaginaActual").html(0);
                        $("#lblPaginaSiguiente").html(0);
                        state = false;
                    }
                });
            }

            function crudEmpresa() {
                if ($("#txtRuc").val() == '') {
                    $("#txtRuc").focus();
                    tools.AlertWarning("Empresa", "Ingrese un ruc válido")
                } else if ($("#NombreComercial").val() == "") {
                    $("#NombreComercial").focus();
                    tools.AlertWarning("Empresa", "Ingrese Nombre comercial")
                } else if ($("#DireccionEmpresa").val() == "") {
                    $("#DireccionEmpresa").focus();
                    tools.AlertWarning("Empresa", "Ingrese dirección")
                } else {
                    tools.ModalDialog("Empresa", "¿Está seguro de continuar?", function(value) {
                        if (value == true) {
                            $.ajax({
                                url: "../app/controller/EmpresaController.php",
                                method: "POST",
                                data: {
                                    "type": "addEmpresa",
                                    "idEmpresa": idEmpresa,
                                    "ruc": $("#txtRuc").val(),
                                    "nombre": $("#NombreComercial").val(),
                                    "direccion": $("#DireccionEmpresa").val(),
                                    "telefono": $("#Tlf_Celular").val(),
                                    "web": $("#Pagina_web").val(),
                                    "email": $("#Email_Empresa").val()
                                },
                                beforeSend: function() {
                                    tools.ModalAlertInfo("Empresa", "Procesando petición..");
                                },
                                success: function(result) {
                                    if (result.estado === 1) {
                                        loadInitEmpresas();
                                        clearModalAddEmpresa();
                                        tools.ModalAlertSuccess("Empresa", result.mensaje);
                                    } else if (result.estado === 2) {
                                        tools.ModalAlertWarning("Empresa", result.mensaje);
                                    } else if (result.estado === 3) {
                                        loadInitEmpresas();
                                        clearModalAddEmpresa();
                                        tools.ModalAlertSuccess("Empresa", result.mensaje);
                                    } else {
                                        tools.ModalAlertWarning("Empresa", result.mensaje);
                                    }
                                },
                                error: function(error) {
                                    tools.ModalAlertError("Empresa", "Se produjo un error: " + error.responseText);
                                }
                            });
                        }
                    });
                }
            }

            function clearModalAddEmpresa() {
                $("#NuevaEmpresaPersona").modal("hide");
                $("#txtRuc").val("")
                $("#NombreComercial").val("")
                $("#DireccionEmpresa").val("")
                $("#Tlf_Celular").val("")
                $("#Pagina_web").val("")
                $("#Email_Empresa").val("")
                idEmpresa = 0;
            }

            function updateEmpresas(id) {
                $("#NuevaEmpresaPersona").modal("show");
                $("#modal-empresa-title").empty()
                $("#modal-empresa-title").append('<i class="fa fa-building-o"></i> Editar Empresa')
                $.ajax({
                    url: "../app/controller/EmpresaController.php",
                    method: "GET",
                    data: {
                        "type": "updateEmpresa",
                        "idEmpresa": id
                    },
                    beforeSend: function() {},
                    success: function(result) {
                        console.log(result);
                        $("#modal-user-title").empty();
                        $("#modal-user-title").append('<i class="fa fa-building-o"> </i> Editar Empresa');
                        if (result.estado == 1) {
                            let empresa = result.empresa;
                            idEmpresa = id;
                            $("#txtRuc").val(empresa.NumeroRuc);
                            $("#NombreComercial").val(empresa.Nombre);
                            $("#DireccionEmpresa").val(empresa.Direccion);
                            $("#Tlf_Celular").val(empresa.Telefono);
                            $("#Pagina_web").val(empresa.PaginaWeb);
                            $("#Email_Empresa").val(empresa.Email);

                            tools.AlertInfo("Información", "Se cargo correctamente los datos.");
                        } else {
                            tools.AlertWarning("Advertencia", result.message);
                        }
                    },
                    error: function(error) {
                        $("#modal-user-title").empty();
                        $("#modal-user-title").append('<i class="fa fa-building-o"> </i> Editar Usuario');
                        tools.AlertError("Error", error.responseText);
                    }
                });
            }

            function deleteEmpresa(id) {
                tools.ModalDialog("Usuarios", "¿Está seguro de eliminar la empresa?", function(value) {
                    if (value == true) {
                        $.ajax({
                            url: "../app/controller/EmpresaController.php",
                            method: "POST",
                            data: {
                                "type": "deleteEmpresa",
                                "idEmpresa": id,
                            },
                            beforeSend: function() {
                                tools.ModalAlertInfo("Empresas", "Procesando petición..");
                            },
                            success: function(result) {
                                if (result.estado == 1) {
                                    tools.ModalAlertSuccess("Empresas", result.message);
                                    loadInitEmpresas();
                                    clearModalAddEmpresa();

                                } else {
                                    tools.ModalAlertWarning("Empresas", result.message);
                                }
                            },
                            error: function(error) {
                                tools.ModalAlertError("Empresas", error.responseText);
                            }
                        });
                    }
                });
            }
        </script>
    </body>

    </html>

<?php }
