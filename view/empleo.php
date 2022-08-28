<?php
session_start();

if (!isset($_SESSION['IdUsuario'])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
    if ($_SESSION["Permisos"][9]["ver"] == 1) {
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

                <!-- modal añadir  -->
                <div class="row">
                    <div class="modal fade" id="mdEmpleo" data-keyboard="false" data-backdrop="static">
                        <div class="modal-dialog modal-xs">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" id="btnCloseModal">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title" id="titleModal">
                                        <i class="fa fa-address-card">
                                        </i> Nueva Oferta Laboral
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtTitulo" class="col-sm-4 control-label">Titulo <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <div class="col-sm-8">
                                                    <input id="txtTitulo" type="text" class="form-control" placeholder="Ingrese el titulo" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-top: 0.5em;">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtDescripcion" class="col-sm-4 control-label">Descripción <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <div class="col-sm-8">
                                                    <textarea id="txtDescripcion" type="text" class="form-control" placeholder="Ingrese la descripción" required=""></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-top: 0.5em;">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtEmpresa" class="col-sm-4 control-label">Empresa <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <div class="col-sm-8">
                                                    <input id="txtEmpresa" type="text" class="form-control" placeholder="Ingrese el nombre de la empresa" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-top: 0.5em;">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtCelular" class="col-sm-4 control-label">Celular <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <div class="col-sm-8">
                                                    <input id="txtCelular" type="number" class="form-control" placeholder="Ingrese el número de celular" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-top: 0.5em;">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtTelefono" class="col-sm-4 control-label">Telefono</label>
                                                <div class="col-sm-8">
                                                    <input id="txtTelefono" type="number" class="form-control" placeholder="Ingrese el número de telefono">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-top: 0.5em;">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtCorreo" class="col-sm-4 control-label">Correo</label>
                                                <div class="col-sm-8">
                                                    <input id="txtCorreo" type="email" class="form-control" placeholder="Ingrese el correo">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-top: 0.5em;">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtDireccion" class="col-sm-4 control-label">Dirección</label>
                                                <div class="col-sm-8">
                                                    <input id="txtDireccion" type="text" class="form-control" placeholder="Ingrese la dirección">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-top: 0.5em;">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtDireccion" class="col-sm-4 control-label">Estado</label>
                                                <div class="col-sm-8">
                                                    <div class="checkbox">
                                                        <label for="cbEstado">
                                                            <input type="checkbox" id="cbEstado" checked>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" id="btnAceptar">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" id="cancel-modal">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end modal añadir -->

                <!-- modal eliminar  -->
                <div class="row">
                    <div class="modal fade" id="mdDeleteEmpleo">
                        <div class="modal-dialog modal-xs">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" onclick="closeModalDelete()">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-address-card">
                                        </i> Eliminar oferta laboral
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label">¿Estas seguro que deseas elimininar esta oferta laboral?</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-warning" id="btnDeleteEmpleo">
                                            <i class="fa fa-check"></i> Aceptar</button>
                                        <button type="button" class="btn btn-primary" onclick="closeModalDelete()">
                                            <i class="fa fa-remove"></i> Cancelar</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end modal eliminar  -->
                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper" style="background-color: #FFFFFF;">
                    <!-- Main content -->
                    <section class="content-header">
                        <h3 class="no-margin"> Oferta Laboral <small> Lista </small> </h3>
                    </section>

                    <section class="content">

                        <div class="row">
                            <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <label>Nueva oferta.</label>
                                <div class="form-group">
                                    <button type="button" class="btn btn-success" id="btnNuevo">
                                        <i class="fa fa-plus"></i> Agregar oferta
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
                                <label>Filtrar por titulo o descripcíon.</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="search" id="buscar" class="form-control" placeholder="Buscar por titulo o descripcíon" aria-describedby="search" value="">
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
                                            <th width="5%" class="text-center">#</th>
                                            <th width="30%">Titulo</th>
                                            <th width="15%">Fecha/Hora</th>
                                            <th width="10%">Celular</th>
                                            <th width="20%">Empresa</th>
                                            <th width="10%">Estado</th>
                                            <th width="5%" class="text-center">Editar</th>
                                            <th width="5%" class="text-center">Eliminar</th>
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

                let idUsuario = <?= $_SESSION['IdUsuario'] ?>;

                let idEmpleo = '';

                $(document).ready(function() {

                    loadInitEmpleos();

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
                        loadInitEmpleos()
                    });

                    $("#buscar").on("keyup", function(event) {
                        if (event.keyCode === 13) {
                            paginacion = 1;
                            loadTableEmpleos($("#buscar").val());
                            opcion = 1;
                        }
                    });

                    $("#btnNuevo").click(function() {
                        openModalEmpleo('');
                    })

                    $("#btnCloseModal").click(function() {
                        $("#mdEmpleo").modal("hide");
                        clearModal();
                    });

                    $("#cancel-modal").click(function() {
                        $("#mdEmpleo").modal("hide");
                        clearModal();
                    });

                    $("#btnAceptar").click(function() {
                        onSaveEmpleo(
                            $("#txtTitulo").val(),
                            $("#txtDescripcion").val(),
                            $("#txtEmpresa").val(),
                            $("#txtCelular").val(),
                            $("#txtTelefono").val(),
                            $("#txtCorreo").val(),
                            $("#txtDireccion").val());
                    });


                });

                function closeModalDelete() {
                    $("#mdDeleteEmpleo ").modal("hide");
                }

                function updateEmpleoData(id) {
                    $.ajax({
                        url: "../app/controller/EmpleoController.php",
                        method: "GET",
                        data: {
                            "type": "id",
                            "idEmpleo": id
                        },
                        beforeSend: function() {
                            idEmpleo = 0;
                        },
                        success: function(result) {
                            idEmpleo = id;
                            $("#txtTitulo").val(result.object.Titulo);
                            $("#txtDescripcion").val(result.object.Descripcion);
                            $("#txtEmpresa").val(result.object.Empresa);
                            $("#txtCelular").val(result.object.Celular);
                            $("#txtTelefono").val(result.object.Telefono);
                            $("#txtCorreo").val(result.object.Correo);
                            $("#txtDireccion").val(result.object.Direccion);

                            document.getElementById("cbEstado").checked = result.object.Estado == 1 ? true : false;

                            tools.AlertInfo("Empleo", "Se cargo correctamente los datos.");
                        },
                        error: function() {
                            tools.AlertError("Empleo", error.responseText);
                        }
                    });
                }

                function openModalEmpleo(idEmpleo) {

                    $("#titleModal").html('')

                    if (idEmpleo === '') {

                        $("#titleModal").html('<i class="fa fa-address-card"></i> Nueva Oferta Laboral')

                        $("#mdEmpleo").modal("show");
                    } else {

                        $("#titleModal").html('<i class="fa fa-address-card"></i> Editar Oferta Laboral')

                        $("#mdEmpleo").modal("show");

                        updateEmpleoData(idEmpleo);

                    }
                }

                function onEventPaginacion() {
                    switch (opcion) {
                        case 0:
                            loadTableEmpleos("");
                            break;
                        case 1:
                            loadTableEmpleos($("#buscar").val());
                            break;
                    }
                }

                function loadInitEmpleos() {
                    if (!state) {
                        paginacion = 1;
                        loadTableEmpleos("");
                        opcion = 0;
                    }
                }

                function loadTableEmpleos(text) {
                    $.ajax({
                        url: "../app/controller/EmpleoController.php",
                        method: "GET",
                        data: {
                            "type": "alldata",
                            "text": text,
                            "posicionPagina": ((paginacion - 1) * filasPorPagina),
                            "filasPorPagina": filasPorPagina
                        },
                        beforeSend: function() {
                            tbTable.empty();
                            tbTable.append(
                                '<tr class="text-center"><td colspan="8"><img src="./images/spiner.gif"/><p>Cargando información.</p></td></tr>'
                            );
                            state = true;
                            totalPaginacion = 0;
                        },
                        success: function(result) {
                            tbTable.empty();
                            if (result.empleos.length == 0) {
                                tbTable.append(
                                    '<tr class="text-center"><td colspan="8"><p>No hay datos para mostrar</p></td></tr>'
                                );
                                $("#lblPaginaActual").html(0);
                                $("#lblPaginaSiguiente").html(0);
                                state = false;
                            } else {
                                for (let empleo of result.empleos) {

                                    let btnUpdate = `<button class="btn btn-warning btn-xs" onclick="openModalEmpleo(${empleo.idEmpleo} )"><i class="fa fa-edit" style="font-size:25px;"></i></button>`;
                                    let btnDelete = `<button class="btn btn-danger btn-xs" onclick="deleteEmpleo(${empleo.idEmpleo})"><i class="fa fa-trash" style="font-size:25px;"></i></button>`

                                    let estado = empleo.Estado == 1 ? '<span class="badge btn-info">ACTIVO</span>' : '<span class="badge btn-danger">INACTIVO</span>'

                                    tbTable.append('<tr>' +
                                        '<td class="text-center text-primary">' + empleo.Id + '</td>' +
                                        '<td>' + empleo.Titulo + '</td>' +
                                        '<td>' + empleo.Fecha + '<br/>' + tools.getTimeForma(empleo.Hora, true) + '</td>' +
                                        '<td>' + empleo.Celular + '</td>' +
                                        '<td>' + empleo.Empresa + '</td>' +
                                        '<td>' + estado + '</td>' +
                                        '<td class="text-center">' + btnUpdate + '' + '</td>' +
                                        '<td class="text-center">' + btnDelete + '</td>' +
                                        '</tr>');
                                }
                                totalPaginacion = parseInt(Math.ceil((parseFloat(result.total) / parseInt(
                                    filasPorPagina))));
                                $("#lblPaginaActual").html(paginacion);
                                $("#lblPaginaSiguiente").html(totalPaginacion);
                                state = false;
                            }
                        },
                        error: function(error) {
                            console.log(error.responseText)
                            tbTable.empty();
                            tbTable.append(
                                '<tr class="text-center"><td colspan="8"><p>Se produjo un error, intente nuevamente.</p></td></tr>'
                            );
                            $("#lblPaginaActual").html(0);
                            $("#lblPaginaSiguiente").html(0);
                            state = false;
                        }
                    });
                }

                function onSaveEmpleo(titulo, descripcion, empresa, celular, telefono, correo, direccion) {
                    if (titulo === '') {
                        tools.AlertWarning('Empleo', "Ingrese el titulo");
                        $("#txtTitulo").focus();
                        return;
                    }

                    if (descripcion === '') {
                        tools.AlertWarning('Empleo', "Ingrese la descripción");
                        $("#txtDescripcion").focus();
                        return;
                    }

                    if (empresa === '') {
                        tools.AlertWarning('Empleo', "Ingrese el nombre de la empresa");
                        $("#txtEmpresa").focus();
                        return;
                    }
                    if (celular === '') {
                        tools.AlertWarning('Empleo', "Ingrese el número de celular");
                        $("#txtCelular").focus();
                        return;
                    }

                    if (idEmpleo === '') {

                        $.ajax({
                            url: "../app/controller/EmpleoController.php",
                            method: "POST",
                            data: {
                                "type": "insert",
                                "Titulo": titulo.trim(),
                                "Descripcion": descripcion.trim(),
                                "Empresa": empresa.trim(),
                                "Celular": celular.trim(),

                                "Telefono": telefono.trim(),
                                "Correo": correo.trim(),
                                "Direccion": direccion.trim(),
                                "Estado": $('#cbEstado').is(':checked'),
                                "Tipo": 1,
                                "idUsuario": idUsuario

                            },
                            beforeSend: function() {
                                tools.AlertInfo("Empleo", "Procesando información.");
                            },
                            success: function(result) {
                                $("#mdEmpleo").modal("hide");
                                tools.AlertSuccess("Empleo", "Se registro correctamente.");
                                clearModal();
                            },
                            error: function(error) {
                                tools.AlertError("Empleo", "Error fatal: Comuniquese con el administrador del sistema.");
                            }
                        });
                    } else {

                        $.ajax({
                            url: "../app/controller/EmpleoController.php",
                            method: "POST",
                            data: {
                                "type": "update",
                                "Titulo": titulo.trim(),
                                "Descripcion": descripcion.trim(),
                                "Empresa": empresa.trim(),
                                "Celular": celular.trim(),

                                "Telefono": telefono.trim(),
                                "Correo": correo.trim(),
                                "Direccion": direccion.trim(),
                                "Estado": $('#cbEstado').is(':checked'),
                                "Tipo": 1,
                                "idUsuario": idUsuario,
                                "idEmpleo": idEmpleo

                            },
                            beforeSend: function() {
                                tools.AlertInfo("Empleo", "Procesando información.");
                            },
                            success: function(result) {
                                $("#mdEmpleo").modal("hide");
                                tools.AlertSuccess("Empleo", "Se actualizó correctamente.");
                                clearModal();
                            },
                            error: function(error) {
                                tools.AlertError("Empleo", "Error fatal: Comuniquese con el administrador del sistema.");
                            }
                        });
                    }
                }

                function deleteEmpleo(id) {
                    $("#mdDeleteEmpleo ").modal("show");

                    let idEmpleo = id;

                    $("#btnDeleteEmpleo").unbind();

                    $("#btnDeleteEmpleo").bind("click", function() {

                        $.ajax({
                            url: "../app/controller/EmpleoController.php",
                            method: "POST",
                            data: {
                                "type": "delete",
                                "idEmpleo": idEmpleo,
                            },
                            beforeSend: function() {
                                $("#mdDeleteEmpleo").modal("hide");
                                tools.ModalAlertInfo("Empleo", "Procesando petición..");
                            },
                            success: function(result) {
                                tools.ModalAlertSuccess("Empleo", result.message);
                                loadInitEmpleos()
                            },
                            error: function(error) {
                                tools.AlertError("Empleo", "Error fatal: Comuniquese con el administrador del sistema.");
                            }
                        });
                    })
                }

                function clearModal() {
                    $("#txtTitulo").val('');
                    $("#txtDescripcion").val('');
                    $("#txtEmpresa").val('');
                    $("#txtCelular").val('');
                    $("#txtTelefono").val('');
                    $("#txtCorreo").val('');
                    $("#txtDireccion").val('');
                    document.getElementById("cbEstado").checked = true;
                    idEmpleo = '';
                }
            </script>
        </body>

        </html>
<?php
    } else {
        echo '<script>location.href = "./index.php";</script>';
    }
}
