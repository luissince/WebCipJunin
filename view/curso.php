<?php
session_start();

if (!isset($_SESSION['IdUsuario'])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
    if ($_SESSION["Permisos"][26]["ver"] == 1) {
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
                        <div class="modal-dialog modal-xs">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
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
                                                <label class="control-label">Curso <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="txtCurso" type="text" class="form-control" placeholder="Ingrese el nombre del curso" required="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Serie o Código<i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="txtSerie" type="text" class="form-control" placeholder="Ingrese la serie o código del curso." required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Correlativo<i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="txtCorrelativo" type="text" class="form-control" placeholder="Ingrese la numeración del curso." required="">
                                                <h6 class="text-left text-warning text-small"> <i class="fa fa-fw fa-warning"></i>El correlativo puede ser cambiado mientras no se generen inscripciones.</h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Instructor<i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="txtInstructor" type="text" class="form-control" placeholder="Ingrese los apellidos y nombre del instructor" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Organizador<i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="txtOrganizador" type="text" class="form-control" placeholder="Ingrese el nombre del organizador" required="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Capitulo<i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <select id="cbCapitulo" class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Modalidad</label>
                                                <select id="cbTipo" class="form-control">
                                                    <option value="1">Presencial</option>
                                                    <option value="2">Virtual</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Dirección</label>
                                                <input type="text" class="form-control" id="txtDireccion" placeholder="Ingrese la dirección" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Fecha Inicio</label>
                                                <input id="txtFechaInicio" type="date" class="form-control" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Hora Inicio</label>
                                                <input id="txtHoraInicio" type="time" class="form-control" step="1" required="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Fecha Final</label>
                                                <input id="txtFechaFin" type="date" class="form-control" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Hora Final</label>
                                                <input id="txtHoraFin" type="time" class="form-control" step="1" required="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Fecha Emisión</label>
                                                <input id="txtFechaEmision" type="date" class="form-control" required="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Precio curso</i></label>
                                                <input id="txtPrecio" type="text" class="form-control" placeholder="Ingrese el precio del curso" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Precio certificado</label>
                                                <input id="txtPrecioCertificado" type="text" class="form-control" placeholder="Ingrese el precio del certificado" required="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Celular <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="txtCelular" type="text" class="form-control" placeholder="Ingrese el número de celular" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Correo</label>
                                                <input id="txtCorreo" type="email" class="form-control" placeholder="Ingrese el correo">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Descripción</label>
                                                <textarea id="txtDescripcion" class="form-control" placeholder="Ingrese alguna descripción" required=""></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Título Reporte</label>
                                                <input id="txtTitulo" type="text" class="form-control" placeholder="Ingrese el número de celular" required="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Detalle Reporte</label>
                                                <textarea id="txtDetalle" class="form-control" placeholder="Ingrese alguna descripción" required=""></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Estado</label>
                                                <div class="checkbox">
                                                    <label for="cbEstado">
                                                        <input type="checkbox" id="cbEstado" checked>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" id="btnAceptar">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end modal añadir -->

                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper">
                    <!-- Main content -->
                    <section class="content-header">
                        <h3 class="no-margin"> Cursos <small> Lista </small> </h3>
                        <ol class="breadcrumb">
                            <li><a href="index.php"><i class="fa fa-home"></i> Inicio</a></li>
                            <li class="active">Curso</li>
                        </ol>
                    </section>

                    <section class="content">
                        <div class="invoice">
                            <div class="row">
                                <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                    <label>Nuevo curso.</label>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-success" id="btnNuevo" <?php $_SESSION["Permisos"][12]["crear"] ? "disabled" : "" ?>>
                                            <i class="fa fa-plus"></i> Agregar curso
                                        </button>
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                    <label>Opción.</label>
                                    <div class="form-group">
                                        <button class="btn btn-default" id="btnActualizar">
                                            <i class="fa fa-refresh"></i> Recargar
                                        </button>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label>Filtrar por curso o capitulo.</label>
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
                                                <th width="10%">Serie/Correlativo</th>
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
                let editView = "<?= $_SESSION["Permisos"][26]["actualizar"]; ?>";
                let deleteView = "<?= $_SESSION["Permisos"][26]["eliminar"]; ?>";

                let idCurso = '';

                $(document).ready(function() {

                    loadInit();
                    loadComponents();
                    loadModalCurso();
                });

                //==================TABLE FUNCIONES =========================

                function loadComponents() {

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

                    $("#btnSearch").click(function() {
                        if ($("#buscar").val().trim() === '') {
                            tools.AlertWarning("Curso", "El campo de busqueda esta vacio.");
                            $("#buscar").focus();
                        } else {
                            paginacion = 1;
                            loadTable($("#buscar").val().trim());
                            opcion = 1;
                        }
                    });
                }

                function loadInit() {
                    if (!state) {
                        paginacion = 1;
                        loadTable("");
                        opcion = 0;
                    }
                }

                async function loadTable(text) {
                    try {
                        tbTable.empty();
                        tbTable.append('<tr class="text-center"><td colspan="10"><img src="./images/spiner.gif"/><p>Cargando información.</p></td></tr>');
                        state = true;
                        totalPaginacion = 0;

                        const result = await axios.get("../app/web/CursoWeb.php", {
                            params: {
                                "type": "alldata",
                                "text": text,
                                "posicionPagina": ((paginacion - 1) * filasPorPagina),
                                "filasPorPagina": filasPorPagina
                            }
                        });

                        tbTable.empty();
                        if (result.data.cursos.length == 0) {
                            tbTable.append(
                                '<tr class="text-center"><td colspan="10"><p>No hay datos para mostrar</p></td></tr>'
                            );
                            $("#lblPaginaActual").html(paginacion);
                            $("#lblPaginaSiguiente").html(totalPaginacion);
                            state = false;
                        } else {
                            for (let curso of result.data.cursos) {

                                let btnUpdate =
                                    `<button class="btn btn-warning btn-xs" title="Editar" onclick="openUpdateModalCurso(${curso.idCurso} )"><i class="fa fa-edit" style="font-size:25px;"></i></button>`;
                                let btnDelete =
                                    `<button class="btn btn-danger btn-xs" title="Eliminar" onclick="delteModalCurso(${curso.idCurso})"><i class="fa fa-trash" style="font-size:25px;"></i></button>`
                                let btnInscripcion = '<button class="btn btn-success btn-xs" title="Inscribir" onclick="linkInscripcion(\'' + curso.idCurso + '\',\'' +
                                    curso.Nombre + '\',\'' + curso.Capitulo + '\',\'' + curso.PrecioCurso + '\',\'' + curso.PrecioCertificado + '\',\'' + curso.FechaInicio + '\',\'' + curso.HoraInicio + '\')"><i class="fa fa-id-card" style="font-size:25px;"></i></button>'

                                let estado = curso.Estado == 1 ? '<span class="badge btn-info">ACTIVO</span>' : '<span class="badge btn-danger">INACTIVO</span>'

                                tbTable.append(`<tr>
                                <td class="text-center text-primary"> ${curso.Id} </td>
                                <td> ${curso.Nombre} </td>
                                <td> ${curso.Serie+ "-"+curso.Correlativo} </td>
                                <td> ${curso.Organizador} </td>
                                <td class="text-danger"> ${curso.Capitulo} </td>
                                <td> ${curso.FechaInicio} <br/> ${tools.getTimeForma(curso.HoraInicio, true)} </td>
                                <td> ${estado} </td>
                                <td class="text-center"> ${btnInscripcion} </td>
                                <td class="text-center"> ${btnUpdate} </td>
                                <td class="text-center"> ${btnDelete} </td>
                                </tr`);
                            }
                            totalPaginacion = parseInt(Math.ceil((parseFloat(result.data.total) / parseInt(
                                filasPorPagina))));
                            $("#lblPaginaActual").html(paginacion);
                            $("#lblPaginaSiguiente").html(totalPaginacion);
                            state = false;
                        }
                    } catch (error) {
                        tbTable.empty();
                        tbTable.append(
                            '<tr class="text-center"><td colspan="10"><p>Se produjo un error, intente nuevamente.</p></td></tr>'
                        );
                        $("#lblPaginaActual").html(0);
                        $("#lblPaginaSiguiente").html(0);
                        state = false;
                    }
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

                this.linkInscripcion = (idCurso) => {
                    location.href = `./inscripcion.php?idCurso=${idCurso}`;
                }
                //==================TABLE FUNCIONES =========================

                //==================MODAL FUNCIONES =========================

                function loadModalCurso() {
                    $("#btnNuevo").click(function() {
                        openAddModalCurso();
                    });

                    $("#mdCurso").on('shown.bs.modal', function() {
                        $("#txtCurso").focus();
                    });

                    $("#mdCurso").on('hidden.bs.modal', function() {
                        clearModalCurso();
                    });

                    $("#btnAceptar").click(function() {
                        crudModalCurso();
                    });

                    $("#btnAceptar").keypress(function(event) {
                        if (event.keyCode === 13) {
                            crudModalCurso();
                            event.preventDefault();
                        }
                    });

                    $("#txtCorrelativo").keypress(function(event) {
                        var key = window.Event ? event.which : event.keyCode;
                        var c = String.fromCharCode(key);
                        if ((c < '0' || c > '9') && (c != '\b')) {
                            event.preventDefault();
                        }
                    });

                    $("#txtPrecio").keypress(function(event) {
                        var key = window.Event ? event.which : event.keyCode;
                        var c = String.fromCharCode(key);
                        if ((c < '0' || c > '9') && (c != '\b') && (c != '.')) {
                            event.preventDefault();
                        }
                        if (c == '.' && $("#txtPrecio").val().includes(".")) {
                            event.preventDefault();
                        }
                    });

                    $("#txtPrecioCertificado").keypress(function(event) {
                        var key = window.Event ? event.which : event.keyCode;
                        var c = String.fromCharCode(key);
                        if ((c < '0' || c > '9') && (c != '\b') && (c != '.')) {
                            event.preventDefault();
                        }
                        if (c == '.' && $("#txtPrecioCertificado").val().includes(".")) {
                            event.preventDefault();
                        }
                    });

                    $("#txtCelular").keypress(function(event) {
                        var key = window.Event ? event.which : event.keyCode;
                        var c = String.fromCharCode(key);
                        if ((c < '0' || c > '9') && (c != '\b') && (c != '-') && (c != '+')) {
                            event.preventDefault();
                        }
                        if (c == '-' && $("#txtCelular").val().includes("-")) {
                            event.preventDefault();
                        }
                        if (c == '+' && $("#txtCelular").val().includes("+")) {
                            event.preventDefault();
                        }
                    });

                    $("#txtFechaInicio").val(tools.getCurrentDate());
                    $("#txtHoraInicio").val(tools.getCurrentTime());
                    $("#txtFechaFin").val(tools.getCurrentDate());
                    $("#txtHoraFin").val(tools.getCurrentTime());
                    $("#txtFechaEmision").val(tools.getCurrentDate());
                }

                //==================MODAL FUNCIONES =========================


                async function openAddModalCurso(idCurso) {
                    $("#titleModal").html('<i class="fa fa-book"></i> Nuevo Curso');
                    $("#mdCurso").modal("show");

                    try {
                        const capitulos = await axios.get("../app/web/CapituloWeb.php", {
                            params: {
                                "type": "allCapitulos"
                            }
                        });

                        $("#cbCapitulo").append('<option value="">- Seleccione un capítulo -</option>')
                        for (let capitulo of capitulos.data) {
                            $("#cbCapitulo").append('<option value=' + capitulo.idCapitulo + '> ' + capitulo.Capitulo + '</option>')
                        }
                    } catch (error) {
                        tools.AlertError("Error", "Se genero un problema, comuníquese con el administrador del sistema.");
                    }
                }

                async function openUpdateModalCurso(id) {
                    $("#titleModal").html('<i class="fa fa-book"></i> Editar Curso');
                    $("#mdCurso").modal("show");
                    try {
                        const capitulos = await axios.get("../app/web/CapituloWeb.php", {
                            params: {
                                "type": "allCapitulos"
                            }
                        });

                        $("#cbCapitulo").append('<option value="">- Seleccione un capítulo -</option>')
                        for (let capitulo of capitulos.data) {
                            $("#cbCapitulo").append('<option value=' + capitulo.idCapitulo + '> ' + capitulo.Capitulo + '</option>')
                        }

                        const curso = await axios.get("../app/web/CursoWeb.php", {
                            params: {
                                "type": "id",
                                "idCurso": id
                            }
                        });

                        const result = curso.data;

                        idCurso = id;
                        $("#txtCurso").val(result.Nombre);
                        $("#txtSerie").val(result.Serie);
                        $("#txtCorrelativo").val(result.Correlativo);
                        $("#txtInstructor").val(result.Instructor);
                        $("#txtOrganizador").val(result.Organizador);
                        $("#cbCapitulo").val(result.idCapitulo);
                        $("#cbTipo").val(result.Modalidad);
                        $("#txtDireccion").val(result.Direccion);

                        $("#txtFechaInicio").val(result.FechaInicio);
                        $("#txtHoraInicio").val(result.HoraInicio);
                        $("#txtFechaFin").val(result.FechaFin);
                        $("#txtHoraFin").val(result.HoraFin);
                        $("#txtFechaEmision").val(result.FechaEmision);

                        $("#txtPrecio").val(result.PrecioCurso);
                        $("#txtPrecioCertificado").val(result.PrecioCertificado);
                        $("#txtCelular").val(result.Celular);
                        $("#txtCorreo").val(result.Correo);
                        $("#txtDescripcion").val(result.Descripcion);
                        $("#cbEstado").attr("checked", result.Estado == 1 ? true : false);
                        $("#txtTitulo").val(result.Titulo);
                        $("#txtDetalle").val(result.Detalle);

                        tools.AlertInfo("Curso", "Se cargo correctamente los datos.");
                    } catch (error) {
                        tools.AlertError("Curso", "Se genero un problema, comuníquese con el administrador del sistema.");
                    }
                }

                async function crudModalCurso() {
                    if ($("#txtCurso").val() === '') {
                        tools.AlertWarning('Curso', "Ingrese el nombre del curso.");
                        $("#txtCurso").focus();
                        return;
                    }

                    if ($("#txtSerie").val() === '') {
                        tools.AlertWarning('Curso', "Ingrese la seríe o código del curso.");
                        $("#txtSerie").focus();
                        return;
                    }

                    if ($("#txtCorrelativo").val() === '') {
                        tools.AlertWarning('Curso', "Ingrese la numeración del curso.");
                        $("#txtCorrelativo").focus();
                        return;
                    }

                    if ($("#txtInstructor").val() === '') {
                        tools.AlertWarning('Curso', "Ingrese los apellidos y nombre del instructor.");
                        $("#txtInstructor").focus();
                        return;
                    }

                    if ($("#txtOrganizador").val() === '') {
                        tools.AlertWarning('Curso', "Ingrese el nombre del organizador");
                        $("#txtOrganizador").focus();
                        return;
                    }

                    if ($("#cbCapitulo").val() === '') {
                        tools.AlertWarning('Curso', "Seleccione el capítulo.");
                        $("#cbCapitulo").focus();
                        return;
                    }

                    if ($("#txtCelular").val() === '') {
                        tools.AlertWarning('Curso', "Ingrese el número de celular.");
                        $("#txtCelular").focus();
                        return;
                    }

                    if ($("#txtCorreo").val() !== '') {
                        if (!tools.validateEmail($("#txtCorreo").val())) {
                            tools.AlertWarning('Curso', "El formato de correo es incorrecto.");
                            $("#txtCorreo").focus();
                            return;
                        }
                    }

                    try {
                        if (idCurso === '') {
                            $("#mdCurso").modal("hide");
                            tools.ModalAlertInfo("Curso", "Procesando petición..");

                            const result = await axios.post("../app/web/CursoWeb.php", {
                                "type": "insert",

                                "Nombre": $("#txtCurso").val().trim(),
                                "Serie": $("#txtSerie").val().trim(),
                                "Correlativo": $("#txtCorrelativo").val().trim(),
                                "Instructor": $("#txtInstructor").val().trim(),
                                "Organizador": $("#txtOrganizador").val().trim(),
                                "idCapitulo": $("#cbCapitulo").val(),
                                "Modalidad": $("#cbTipo").val().trim(),
                                "Direccion": $("#cbTipo").val() === '1' ? $("#txtDireccion").val().trim() : '',

                                "FechaInicio": $("#txtFechaInicio").val(),
                                "HoraInicio": $("#txtHoraInicio").val(),
                                "FechaFin": $("#txtFechaFin").val(),
                                "HoraFin": $("#txtHoraFin").val(),
                                "FechaEmision": $("#txtFechaEmision").val(),
                                "PrecioCurso": $("#txtPrecio").val().trim() === '' ? 0 : $("#txtPrecio").val().trim(),
                                "PrecioCertificado": $("#txtPrecioCertificado").val().trim() === '' ? 0 : $("#txtPrecioCertificado").val().trim(),
                                "Celular": $("#txtCelular").val().trim(),
                                "Correo": $("#txtCorreo").val().trim(),
                                "Descripcion": $("#txtDescripcion").val().trim(),
                                "Titulo": $("#txtTitulo").val().trim(),
                                "Detalle": $("#txtDetalle").val().trim(),
                                "Estado": $('#cbEstado').is(':checked'),
                                "idUsuario": idUsuario
                            });

                            tools.ModalAlertSuccess("Curso", result.data, () => {
                                loadInit();
                            });
                        } else {

                            $("#mdCurso").modal("hide");
                            tools.ModalAlertInfo("Curso", "Procesando petición..");

                            const result = await axios.post("../app/web/CursoWeb.php", {
                                "type": "update",

                                "Nombre": $("#txtCurso").val(),
                                "Serie": $("#txtSerie").val().trim(),
                                "Correlativo": $("#txtCorrelativo").val().trim(),
                                "Instructor": $("#txtInstructor").val(),
                                "Organizador": $("#txtOrganizador").val(),
                                "idCapitulo": $("#cbCapitulo").val(),
                                "Modalidad": $("#cbTipo").val(),
                                "Direccion": $("#cbTipo").val() === '1' ? $("#txtDireccion").val() : '',

                                "FechaInicio": $("#txtFechaInicio").val(),
                                "HoraInicio": $("#txtHoraInicio").val(),
                                "FechaFin": $("#txtFechaFin").val(),
                                "HoraFin": $("#txtHoraFin").val(),
                                "FechaEmision": $("#txtFechaEmision").val(),
                                "PrecioCurso": $("#txtPrecio").val() === '' ? 0 : $("#txtPrecio").val(),
                                "PrecioCertificado": $("#txtPrecioCertificado").val() === '' ? 0 : $("#txtPrecioCertificado").val(),
                                "Celular": $("#txtCelular").val(),
                                "Correo": $("#txtCorreo").val(),
                                "Descripcion": $("#txtDescripcion").val(),
                                "Titulo": $("#txtTitulo").val().trim(),
                                "Detalle": $("#txtDetalle").val().trim(),
                                "Estado": $('#cbEstado').is(':checked'),
                                "idUsuario": idUsuario,

                                "idCurso": idCurso
                            });

                            tools.ModalAlertSuccess("Curso", result.data, () => {
                                loadInit();
                            });
                        }
                    } catch (error) {
                        if (error.response) {
                            tools.ModalAlertWarning("Curso", error.response.data);
                        } else {
                            tools.ModalAlertError("Curso", "Se genero un error interno, comuníquese con el administrador del sistema.");
                        }
                    }
                }

                function delteModalCurso(id) {
                    tools.ModalDialog("Curso", "¿Está seguro de eliminar el curso?", async function(value) {
                        if (value) {
                            try {
                                tools.ModalAlertInfo("Curso", "Procesando petición..");

                                const result = await axios.post("../app/web/CursoWeb.php", {
                                    "type": "delete",
                                    "idCurso": id,
                                });

                                tools.ModalAlertSuccess("Curso", result.data, () => {
                                    loadInit();
                                });
                            } catch (error) {
                                if (error.response) {
                                    tools.ModalAlertWarning("Curso", error.response.data);
                                } else {
                                    tools.ModalAlertError("Curso", "Se genero un error interno, comuníquese con el administrador del sistema.");
                                }
                            }
                        }
                    });
                }

                function clearModalCurso() {
                    $("#txtCurso").val('');
                    $("#txtSerie").val('');
                    $("#txtCorrelativo").val('');
                    $("#txtInstructor").val('');
                    $("#txtOrganizador").val('');
                    $("#cbCapitulo").val('');
                    $("#cbTipo").val('1');

                    $("#txtDireccion").val('');

                    $("#txtFechaInicio").val(tools.getCurrentDate());
                    $("#txtHoraInicio").val(tools.getCurrentTime());
                    $("#txtFechaFin").val(tools.getCurrentDate());
                    $("#txtHoraFin").val(tools.getCurrentTime());
                    $("#txtFechaEmision").val(tools.getCurrentDate());

                    $("#txtPrecio").val('');
                    $("#txtPrecioCertificado").val('');
                    $("#txtCelular").val('');
                    $("#txtCorreo").val('');
                    $("#txtDescripcion").val('');
                    $("#txtTitulo").val('');
                    $("#txtDetalle").val('');
                    $("#cbEstado").attr("checked", true);
                    idCurso = '';

                    $("#cbCapitulo").empty();
                }
            </script>
        </body>

        </html>
<?php
    } else {
        echo '<script>location.href = "./index.php";</script>';
    }
}
