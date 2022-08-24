<?php
session_start();

if (!isset($_SESSION['IdUsuario'])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
    if ($_SESSION["Permisos"][9]["ver"] == 1) {

        if ($_GET['idCurso'] != "") {
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
                        <div class="modal fade" id="mdCurso" data-keyboard="false" data-backdrop="static">
                            <div class="modal-dialog modal-xs" style="width: 500px;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" id="btnCloseModal">
                                            <i class="fa fa-close"></i>
                                        </button>
                                        <h4 class="modal-title" id="titleModal">
                                            <i class="fa fa-book">
                                            </i> Nuevo Curso
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Curso <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <div class="col-sm-8">
                                                        <input id="txtCurso" type="text" class="form-control" placeholder="Ingrese el nombre del curso" required="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="padding-top: 0.5em;">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Instructor<i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <div class="col-sm-8">
                                                        <input id="txtInstructor" type="text" class="form-control" placeholder="Ingrese los apellidos y nombre del instructor" required="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="padding-top: 0.5em;">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Organizador<i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <div class="col-sm-8">
                                                        <input id="txtOrganizador" type="text" class="form-control" placeholder="Ingrese el nombre del organizador" required="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="padding-top: 0.5em;">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Capitulo<i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <div class="col-sm-8">
                                                        <select id="cbxCapitulo" class="form-control">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="padding-top: 0.5em;">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Modalidad</label>
                                                    <div class="col-sm-8">
                                                        <select id="cbxTipo" class="form-control">
                                                            <option value="1">Presencial</option>
                                                            <option value="2">Virtual</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="padding-top: 0.5em;">
                                            <div class="col-md-12">
                                                <div class="form-group" id="box-direccion">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="padding-top: 0.5em;">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Fecha Inicio</label>
                                                    <div class="col-sm-8">
                                                        <input id="txtFechaInicio" type="date" class="form-control" required="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="padding-top: 0.5em;">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Hora Inicio</label>
                                                    <div class="col-sm-8">
                                                        <input id="txtHoraInicio" type="time" class="form-control" step="1" required="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="padding-top: 0.5em;">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Precio curso <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <div class="col-sm-8">
                                                        <input id="txtPrecio" type="number" class="form-control" placeholder="Ingrese el precio del curso" required="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="padding-top: 0.5em;">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Precio certificado</label>
                                                    <div class="col-sm-8">
                                                        <input id="txtPrecioCertificado" type="number" class="form-control" placeholder="Ingrese el precio del certificado" required="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="padding-top: 0.5em;">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Celular <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <div class="col-sm-8">
                                                        <input id="txtCelular" type="number" class="form-control" placeholder="Ingrese el número de celular" required="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="padding-top: 0.5em;">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Correo</label>
                                                    <div class="col-sm-8">
                                                        <input id="txtCorreo" type="email" class="form-control" placeholder="Ingrese el correo">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="padding-top: 0.5em;">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Descripción <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <div class="col-sm-8">
                                                        <textarea id="txtDescripcion" class="form-control" placeholder="Ingrese alguna descripción" required=""></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="padding-top: 0.5em;">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Estado</label>
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
                        <div class="modal fade" id="mdDelete">
                            <div class="modal-dialog modal-xs" style="width: 500px;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" onclick="closeModalDelete()">
                                            <i class="fa fa-close"></i>
                                        </button>
                                        <h4 class="modal-title">
                                            <i class="fa fa-book">
                                            </i> Eliminar curso
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-sm-12 control-label">¿Esta seguro(a) que desea elimininar este curso?</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-warning" id="btnDeleteCurso">
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
                            <h3 class="no-margin"> Inscripción <small>LISTA</small> </h3>
                        </section>

                        <section class="content">

                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label>Curso: <strong class="text-primary" id="lblCurso"></strong></label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label>Capitulo: <strong class="text-primary" id="lblCapitulo"></strong></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label>Precio Curso: <strong class="text-primary" id="lblPrecioCurso"></strong></label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label>Precio Certificado: <strong class="text-primary" id="lblPrecioCertificado"></strong></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label>Fecha Inicio: <strong class="text-primary" id="lblFechaInicio"></strong></label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label>Hora Inicio: <strong class="text-primary" id="lblHoraInicio"></strong></label>
                                </div>
                            </div>

                            <hr/>

                            <div class="row">

                                <?php
                                if ($_SESSION["Permisos"][9]["crear"] == 1) {
                                    echo '<div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <label>Nuevo incripción.</label>
                                <div class="form-group">
                                    <button type="button" class="btn btn-success" id="btnNuevo">
                                        <i class="fa fa-plus"></i> Agregar incripción
                                    </button>
                                </div>
                            </div>';
                                } ?>

                                <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                    <label>Opción.</label>
                                    <div class="form-group">
                                        <button class="btn btn-default" id="btnActualizar">
                                            <i class="fa fa-refresh"></i> Recargar
                                        </button>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label>Filtrar por dni o apellidos.</label>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="search" id="buscar" class="form-control" placeholder="Escribe y presiona enter para filtrar" aria-describedby="search" value="">
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
                                                <th width="20%">Curso</th>
                                                <th width="20%">Organizador</th>
                                                <th width="10%">Capitulo</th>
                                                <th width="15%">Fecha/Hora</th>
                                                <th width="10%">Estado</th>
                                                <th width="10%" class="text-center">Inscripción</th>
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

                    let params = new URLSearchParams(location.search);
                    let idCurso = params.get('idCurso');
                    let nombreCurso = params.get('Nombre');
                    let capituloCurso = params.get('Capitulo');
                    let precioCurso = params.get('PrecioCurso');
                    let precioCertificado = params.get('PrecioCertificado');
                    let fechaInicio = params.get('FechaInicio');
                    let horaInicio = params.get('HoraInicio');

                    let cbxCapitulos = $("#cbxCapitulo");

                    $("#lblCurso").html(nombreCurso);
                    $("#lblCapitulo").html(capituloCurso);
                    $("#lblPrecioCurso").html("S/ "+precioCurso);
                    $("#lblPrecioCertificado").html("S/ "+precioCertificado);
                    $("#lblFechaInicio").html(fechaInicio);
                    $("#lblHoraInicio").html(tools.getTimeForma(horaInicio, true));

                    let editView = "<?= $_SESSION["Permisos"][9]["actualizar"]; ?>";
                    let deleteView = "<?= $_SESSION["Permisos"][9]["eliminar"]; ?>";

                    $(document).ready(function() {

                        // loadInit();
                        console.log(idCurso)


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

                        $("#btnActualizar").click(function() {
                            loadInit()
                        });

                        $("#buscar").on("keyup", function(event) {
                            if (event.keyCode === 13) {
                                if ($("#buscar").val().trim() === '') {
                                    tools.AlertWarning("Curso", "El campo de busqueda esta vacio.");
                                    $("#buscar").focus();
                                } else {
                                    paginacion = 1;
                                    loadTable($("#buscar").val().trim());
                                    opcion = 1;
                                }
                            }
                        });

                        $("#btnNuevo").click(function() {
                            modalCurso('');
                        })

                        $("#btnSearch").click(function() {

                            if ($("#buscar").val().trim() === '') {
                                tools.AlertWarning("Curso", "El campo de busqueda esta vacio.");
                                $("#buscar").focus();
                            } else {
                                paginacion = 1;
                                loadTable($("#buscar").val().trim());
                                opcion = 1;
                            }

                        })

                        $("#btnCloseModal").click(function() {
                            $("#mdCurso").modal("hide");
                            clearModal();
                        });

                        $("#cancel-modal").click(function() {
                            $("#mdCurso").modal("hide");
                            clearModal();
                        });

                        $("#btnAceptar").click(function() {
                            onSave();
                        });

                        $("#cbxTipo").change(function() {
                            if ($("#cbxTipo").val() === '1') {
                                $("#box-direccion").html(`
                            <label class="col-sm-4 control-label">Dirección <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                            <div class="col-sm-8">
                                <input id="txtDireccion" type="text" class="form-control" placeholder="Ingrese la dirección" required="">
                            </div
                        `);

                            } else {
                                $("#box-direccion").html('');
                            }
                        });


                    });

                    function loadInit() {
                        if (!state) {
                            paginacion = 1;
                            loadTable("");
                            opcion = 0;
                        }
                    }

                    function loadTable(text) {
                        $.ajax({
                            url: "../app/controller/CursoController.php",
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

                                if (result.estado === 1) {
                                    tbTable.empty();
                                    if (result.cursos.length == 0) {
                                        tbTable.append(
                                            '<tr class="text-center"><td colspan="9"><p>No hay datos para mostrar</p></td></tr>'
                                        );
                                        $("#lblPaginaActual").html(paginacion);
                                        $("#lblPaginaSiguiente").html(totalPaginacion);
                                        state = false;
                                    } else {
                                        for (let curso of result.cursos) {

                                            let btnUpdate = editView == 0 ? '<i class="fa fa-minus" style="font-size:20px;"></i>' :
                                                `<button class="btn btn-warning btn-xs" title="Editar" onclick="modalCurso(${curso.idCurso} )"><i class="fa fa-edit" style="font-size:25px;"></i></button>`;
                                            let btnDelete = deleteView == 0 ? '<i class="fa fa-minus" style="font-size:20px;"></i>' :
                                                `<button class="btn btn-danger btn-xs" title="Eliminar" onclick="modalDelete(${curso.idCurso})"><i class="fa fa-trash" style="font-size:25px;"></i></button>`
                                            let btnInscripcion = `<button class="btn btn-success btn-xs" title="Inscribir" onclick="Inscripcion(${curso.idCurso})"><i class="fa fa-id-card" style="font-size:25px;"></i></button>`

                                            let estado = curso.Estado == 1 ? '<span class="badge btn-info">ACTIVO</span>' : '<span class="badge btn-danger">INACTIVO</span>'

                                            tbTable.append('<tr>' +
                                                '<td class="text-center text-primary">' + curso.Id + '</td>' +
                                                '<td>' + curso.Nombre + '</td>' +
                                                '<td>' + curso.Organizador + '</td>' +
                                                '<td class="text-danger">' + curso.Capitulo + '</td>' +
                                                '<td>' + curso.FechaInicio + '<br/>' + tools.getTimeForma(curso.HoraInicio, true) + '</td>' +
                                                '<td>' + estado + '</td>' +
                                                '<td class="text-center">' + btnInscripcion + '</td>' +
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
                                tbTable.append(
                                    '<tr class="text-center"><td colspan="9"><p>Se produjo un error, intente nuevamente.</p></td></tr>'
                                );
                                $("#lblPaginaActual").html(0);
                                $("#lblPaginaSiguiente").html(0);
                                state = false;
                            }
                        });
                    }

                    function onEventPaginacion() {
                        switch (opcion) {
                            case 0:
                                loadTable("");
                                break;
                            case 1:
                                loadTable($("#buscar").val());
                                break;
                        }
                    }

                    function modalCurso(idCurso) {

                        $("#titleModal").html('')

                        if (idCurso === '') {

                            loadCapitulos();

                            $("#titleModal").html('<i class="fa fa-book"></i> Nuevo Curso')
                            $("#box-direccion").html(`
                            <label class="col-sm-4 control-label">Dirección <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                            <div class="col-sm-8">
                                <input id="txtDireccion" type="text" class="form-control" placeholder="Ingrese la dirección" required="">
                            </div>
                        `);
                            $("#txtFechaInicio").val(tools.getCurrentDate());
                            $("#txtHoraInicio").val(tools.getCurrentTime());

                        } else {

                            $("#titleModal").html('<i class="fa fa-book"></i> Editar Curso')
                            update(idCurso);

                        }

                        $("#mdCurso").modal("show");

                    }

                    function closeModalDelete() {
                        $("#mdDelete").modal("hide");
                    }

                    function update(id) {

                        $.ajax({
                            url: "../app/controller/CapituloController.php",
                            method: "GET",
                            data: {
                                "type": "allCapitulos"
                            },
                            beforeSend: function() {
                                cbxCapitulos.empty();
                            },
                            success: function(result) {
                                if (result.estado === 1) {
                                    cbxCapitulos.append('<option value="">- Seleccione un capítulo- </option>')
                                    for (let capitulo of result.capitulos) {
                                        cbxCapitulos.append('<option value=' + capitulo.idCapitulo + '> ' + capitulo.Capitulo + '</option>')
                                    }
                                    updateData(id);
                                } else {

                                }

                            },
                            error: function(error) {
                                tools.AlertError("Error", error.responseText);
                            }
                        });
                    }

                    async function updateData(id) {

                        $.ajax({
                            url: "../app/controller/CursoController.php",
                            method: "GET",
                            data: {
                                "type": "id",
                                "idCurso": id
                            },
                            beforeSend: function() {
                                idCurso = '';
                            },
                            success: function(result) {

                                if (result.estado == 1) {

                                    idCurso = id;

                                    $("#txtCurso").val(result.object.Nombre);
                                    $("#txtInstructor").val(result.object.Instructor);
                                    $("#txtOrganizador").val(result.object.Organizador);
                                    // document.getElementById("cbxCapitulo").value = result.object.idCapitulo;
                                    $("#cbxCapitulo").val(result.object.idCapitulo);
                                    $("#cbxTipo").val(result.object.Modalidad);

                                    if ($("#cbxTipo").val() === '1') {
                                        $("#box-direccion").html(`
                                        <label class="col-sm-4 control-label">Dirección <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                        <div class="col-sm-8">
                                            <input id="txtDireccion" type="text" class="form-control" placeholder="Ingrese la dirección" required="">
                                        </div>
                                    `);
                                        $("#txtDireccion").val(result.object.Direccion);
                                    } else {
                                        $("#box-direccion").html('');
                                    }

                                    $("#txtFechaInicio").val(result.object.FechaInicio);
                                    $("#txtHoraInicio").val(result.object.HoraInicio);
                                    //document.getElementById("txtHoraInicio").value = result.object.HoraInicio;
                                    $("#txtPrecio").val(result.object.PrecioCurso);
                                    $("#txtPrecioCertificado").val(result.object.PrecioCertificado);
                                    $("#txtCelular").val(result.object.Celular);
                                    $("#txtCorreo").val(result.object.Correo);
                                    $("#txtDescripcion").val(result.object.Descripcion);
                                    document.getElementById("cbEstado").checked = result.object.Estado == 1 ? true : false;

                                    tools.AlertInfo("Curso", "Se cargo correctamente los datos.");
                                } else {
                                    tools.AlertWarning("Curso", result.message);
                                }
                            },
                            error: function() {
                                tools.AlertError("Curso", error.responseText);
                            }
                        });
                    }

                    function onSave() {
                        if ($("#txtCurso").val() === '') {
                            tools.AlertWarning('Curso', "Ingrese el nombre del curso.");
                            $("#txtCurso").focus();
                        } else if ($("#txtInstructor").val() === '') {
                            tools.AlertWarning('Curso', "Ingrese los apellidos y nombre del instructor.");
                            $("#txtInstructor").focus();
                        } else if ($("#txtOrganizador").val() === '') {
                            tools.AlertWarning('Curso', "Ingrese el nombre del organizador");
                            $("#txtOrganizador").focus();
                        } else if ($("#cbxCapitulo").val() === '') {
                            tools.AlertWarning('Curso', "Seleccione el capítulo.");
                            $("#cbxCapitulo").focus();
                        } else if ($("#box-direccion").html() !== '' && $("#txtDireccion").val() === '') {
                            tools.AlertWarning('Curso', "Ingrese la dirección.");
                            $("#txtDireccion").focus();
                        } else if ($("#txtPrecio").val() === '') {
                            tools.AlertWarning('Curso', "Ingrese el precio del curso.");
                            $("#txtPrecio").focus();
                        } else if ($("#txtCelular").val() === '') {
                            tools.AlertWarning('Curso', "Ingrese el número de celular.");
                            $("#txtCelular").focus();
                        } else if ($("#txtDescripcion").val() === '') {
                            tools.AlertWarning('Curso', "Ingrese alguna descripción.");
                            $("#txtDescripcion").focus();
                        } else {
                            if (idCurso === '') {

                                $.ajax({
                                    url: "../app/controller/CursoController.php",
                                    method: "POST",
                                    data: {
                                        "type": "insert",

                                        "Nombre": $("#txtCurso").val().trim(),
                                        "Instructor": $("#txtInstructor").val().trim(),
                                        "Organizador": $("#txtOrganizador").val().trim(),
                                        "idCapitulo": $("#cbxCapitulo").val(),
                                        "Modalidad": $("#cbxTipo").val().trim(),
                                        "Direccion": $("#cbxTipo").val() === '1' ? $("#txtDireccion").val().trim() : '',

                                        "FechaInicio": $("#txtFechaInicio").val(),
                                        "HoraInicio": $("#txtHoraInicio").val(),
                                        "PrecioCurso": $("#txtPrecio").val().trim(),
                                        "PrecioCertificado": $("#txtPrecioCertificado").val().trim() === '' ? 0 : $("#txtPrecioCertificado").val().trim(),
                                        "Celular": $("#txtCelular").val().trim(),
                                        "Correo": $("#txtCorreo").val().trim(),
                                        "Descripcion": $("#txtDescripcion").val().trim(),
                                        "Estado": $('#cbEstado').is(':checked'),
                                        "idUsuario": idUsuario

                                    },
                                    beforeSend: function() {
                                        tools.AlertInfo("Curso", "Procesando información.");
                                    },
                                    success: function(result) {
                                        if (result.estado == 1) {
                                            $("#mdCurso").modal("hide");
                                            tools.AlertSuccess("Curso", "Se registro correctamente.");
                                            clearModal();
                                        } else if (result.estado == 3) {
                                            tools.AlertWarning("Curso", result.message);
                                        } else {
                                            tools.AlertWarning("Curso", result.message);
                                        }
                                    },
                                    error: function(error) {
                                        tools.AlertError("Curso", "Error fatal: Comuniquese con el administrador del sistema" + error.message);
                                    }
                                });
                            } else {

                                $.ajax({
                                    url: "../app/controller/CursoController.php",
                                    method: "POST",
                                    data: {
                                        "type": "update",

                                        "Nombre": $("#txtCurso").val().trim(),
                                        "Instructor": $("#txtInstructor").val().trim(),
                                        "Organizador": $("#txtOrganizador").val().trim(),
                                        "idCapitulo": $("#cbxCapitulo").val(),
                                        "Modalidad": $("#cbxTipo").val().trim(),
                                        "Direccion": $("#cbxTipo").val() === '1' ? $("#txtDireccion").val().trim() : '',

                                        "FechaInicio": $("#txtFechaInicio").val(),
                                        "HoraInicio": $("#txtHoraInicio").val(),
                                        "PrecioCurso": $("#txtPrecio").val().trim(),
                                        "PrecioCertificado": $("#txtPrecioCertificado").val().trim() === '' ? 0 : $("#txtPrecioCertificado").val().trim(),
                                        "Celular": $("#txtCelular").val().trim(),
                                        "Correo": $("#txtCorreo").val().trim(),
                                        "Descripcion": $("#txtDescripcion").val().trim(),
                                        "Estado": $('#cbEstado').is(':checked'),
                                        "idUsuario": idUsuario,

                                        "idCurso": idCurso

                                    },
                                    beforeSend: function() {
                                        tools.AlertInfo("Curso", "Procesando información.");
                                    },
                                    success: function(result) {
                                        if (result.estado == 1) {
                                            $("#mdCurso").modal("hide");
                                            tools.AlertSuccess("Curso", "Se actualizó correctamente.");
                                            clearModal();
                                        } else if (result.estado == 3) {
                                            tools.AlertWarning("Curso", result.message);
                                        } else {
                                            tools.AlertWarning("Curso", result.message);
                                        }
                                    },
                                    error: function(error) {
                                        tools.AlertError("Curso", "Error fatal: Comuniquese con el administrador del sistema" + error.message);
                                    }
                                });
                            }

                            loadInit();

                        }

                    }

                    function modalDelete(id) {
                        $("#mdDelete").modal("show");

                        $("#btnDeleteCurso").unbind();

                        $("#btnDeleteCurso").bind("click", function() {

                            $.ajax({
                                url: "../app/controller/CursoController.php",
                                method: "POST",
                                data: {
                                    "type": "delete",
                                    "idCurso": id,
                                },
                                beforeSend: function() {
                                    $("#mdDelete").modal("hide");
                                    tools.ModalAlertInfo("Curso", "Procesando petición..");
                                },
                                success: function(result) {
                                    if (result.estado == 1) {
                                        tools.ModalAlertSuccess("Curso", result.message);
                                        loadInit();
                                    } else if (result.estado == 2) {
                                        tools.ModalAlertWarning("Curso", result.message);
                                    } else if (result.estado == 3) {
                                        tools.ModalAlertWarning("Curso", result.message);
                                    } else {
                                        tools.ModalAlertWarning("Curso", result.message);
                                    }
                                },
                                error: function(error) {
                                    tools.ModalAlertError("Curso", error.responseText);
                                }
                            });
                        })
                    }

                    function clearModal() {
                        $("#txtCurso").val('');
                        $("#txtInstructor").val('');
                        $("#txtOrganizador").val('');
                        $("#cbxCapitulo").val('');
                        $("#cbxTipo").val('1');

                        $("#txtDireccion").val('');

                        $("#txtFechaInicio").val(tools.getCurrentDate());
                        $("#txtHoraInicio").val(tools.getCurrentTime());
                        $("#txtPrecio").val('');
                        $("#txtPrecioCertificado").val('');
                        $("#txtCelular").val('');
                        $("#txtCorreo").val('');
                        $("#txtDescripcion").val('');

                        document.getElementById("cbEstado").checked = true;
                        idCurso = '';

                        $("#box-direccion").html('');
                        cbxCapitulos.empty();

                    }

                    function loadCapitulos() {
                        $.ajax({
                            url: "../app/controller/CapituloController.php",
                            method: "GET",
                            data: {
                                "type": "allCapitulos"
                            },
                            beforeSend: function() {
                                cbxCapitulos.empty();
                            },
                            success: function(result) {
                                if (result.estado === 1) {
                                    cbxCapitulos.append('<option value="">- Seleccione un capítulo- </option>')
                                    for (let capitulo of result.capitulos) {
                                        cbxCapitulos.append('<option value=' + capitulo.idCapitulo + '> ' + capitulo.Capitulo + '</option>')
                                    }
                                } else {

                                }

                            },
                            error: function(error) {
                                tools.AlertError("Error", error.responseText);
                            }
                        });
                    }

                    function linkInscripcion(idCurso) {
                        location.href = `../view/incripcion.php?idCurso=${idCurso}}`
                    }
                </script>
            </body>

            </html>
<?php
        } else {
            echo '<script>location.href = "./curso.php";</script>';
        }
    } else {
        echo '<script>location.href = "./index.php";</script>';
    }
}
