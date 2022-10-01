<?php
session_start();

if (!isset($_SESSION['IdUsuario'])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
    if ($_SESSION["Permisos"][28]["ver"] == 1) {
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
                    <div class="modal fade" id="mdDirectorio" data-keyboard="false" data-backdrop="static">
                        <div class="modal-dialog modal-xs">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title" id="titleModal">
                                    </h4>
                                </div>

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Seleccione el Ingeniero <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <select class="form-control select2" id="cbIngeniero" style="width: 100%;">
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Fecha Inicio (Gestión) <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="txtFechaInicio" type="date" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Fecha Fin (Gestión) <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="txtFechaFinal" type="date" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Puesto <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <select id="cbTipoDirectivo" class="form-control">
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" id="cbEstado"> Estado
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" id="cbUsarFirma"> Usar Firma
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <img class="profile-user-img img-responsive" id="lblFirma" src="./images/noimage.jpg" alt="User profile picture">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 text-center">
                                            <div class="form-group">
                                                <input type="file" id="fileFirma" accept="image/png, image/jpge, image/jpg" class="d-none" />
                                                <label class="btn btn-default" for="fileFirma"><i class="fa fa-photo"></i> Subir Imagen </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-center">
                                            <div class="form-group">
                                                <label class="btn btn-danger"><i class="fa fa-trash"></i> Quitar Imagen </label>
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
                        <h3 class="no-margin"> Directivos <small> Lista </small> </h3>
                        <ol class="breadcrumb">
                            <li><a href="index.php"><i class="fa fa-home"></i> Inicio</a></li>
                            <li class="active">Directivo</li>
                        </ol>
                    </section>

                    <section class="content">
                        <div class="invoice">
                            <div class="row">
                                <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                    <label>Nueva Persona</label>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-success" id="btnNuevo">
                                            <i class="fa fa-plus"></i> Agregar
                                        </button>
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                    <label>Opción</label>
                                    <div class="form-group">
                                        <button class="btn btn-default" id="btnActualizar">
                                            <i class="fa fa-refresh"></i> Recargar
                                        </button>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label>Filtrar por cipo o nombre y apellido.</label>
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
                                                <th width="10%">Cip</th>
                                                <th width="20%">Ingeniero</th>
                                                <th width="10%">Fecha Inicio</th>
                                                <th width="10%">Fecha Final</th>
                                                <th width="15%">Puesto</th>
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
                let lblFirma = $("#lblFirma");

                let idUsuario = <?= $_SESSION['IdUsuario'] ?>;

                let idDirectivo = '';
                let rutaImagen = '';
                let valImagen = 0;

                $(document).ready(function() {
                    loadInit();
                    loadComponents();
                    loadModalDirectorio();
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

                    $("#btnActualizar").keypress(function(event) {
                        if (event.keyCode === 13) {
                            loadInit();
                            event.preventDefault();
                        }
                    });

                    $("#buscar").on("keyup", function(event) {
                        if (event.keyCode === 13) {
                            if ($("#buscar").val().trim() !== '') {
                                paginacion = 1;
                                loadTable(1, $("#buscar").val().trim());
                                opcion = 1;
                            }
                        }
                    });

                    $("#btnSearch").click(function() {
                        if ($("#buscar").val().trim() !== '') {
                            paginacion = 1;
                            loadTable(1, $("#buscar").val().trim());
                            opcion = 1;
                        }
                    });

                    $("#btnSearch").keypress(function(event) {
                        if (event.keyCode == 13) {
                            if ($("#buscar").val().trim() !== '') {
                                paginacion = 1;
                                loadTable(1, $("#buscar").val().trim());
                                opcion = 1;
                            }
                            event.preventDefault();
                        }
                    });

                    $("#fileFirma").on("change", function(event) {
                        if (event.target.files.length > 0) {
                            lblFirma.attr("src", URL.createObjectURL(event.target.files[0]));
                            valImagen = 2;
                        } else {
                            valImagen = rutaImagen == "" ? 0 : 1;
                            if (valImagen == 0) {
                                lblFirma.attr("src", "./images/noimage.jpg");
                                $("#fileFirma").val(null);
                                valImagen = 0;
                            } else {
                                lblFirma.attr("src", rutaImagen);
                                $("#fileFirma").val(null);
                                valImagen = 1;
                            }
                        }
                    });
                }

                function loadInit() {
                    if (!state) {
                        paginacion = 1;
                        loadTable(0, "");
                        opcion = 0;
                    }
                }

                async function loadTable(opcion, text) {
                    try {
                        tbTable.empty();
                        tbTable.append(
                            '<tr class="text-center"><td colspan="9"><img src="./images/spiner.gif"/><p>Cargando información.</p></td></tr>'
                        );
                        state = true;
                        totalPaginacion = 0;

                        const result = await axios.get("../app/web/DirectorioWeb.php", {
                            params: {
                                "type": "list",
                                "opcion": opcion,
                                "text": text,
                                "posicionPagina": ((paginacion - 1) * filasPorPagina),
                                "filasPorPagina": filasPorPagina
                            }
                        });

                        tbTable.empty();
                        if (result.data.directivos.length == 0) {
                            tbTable.append(
                                '<tr class="text-center"><td colspan="9"><p>No hay datos para mostrar.</p></td></tr>'
                            );
                            $("#lblPaginaActual").html(paginacion);
                            $("#lblPaginaSiguiente").html(totalPaginacion);
                            state = false;
                        } else {
                            for (let directivo of result.data.directivos) {

                                let btnUpdate =
                                    `<button class="btn btn-warning btn-xs" title="Editar" onclick="openUpdateModalDirectorio(${directivo.IdDirectivo} )"><i class="fa fa-edit" style="font-size:25px;"></i></button>`;
                                let btnDelete =
                                    `<button class="btn btn-danger btn-xs" title="Eliminar" onclick="deleteModalDirectorio(${directivo.IdDirectivo})"><i class="fa fa-trash" style="font-size:25px;"></i></button>`

                                let estado = directivo.Estado == 1 ? '<span class="badge btn-info">ACTIVO</span>' : '<span class="badge btn-danger">INACTIVO</span>'

                                tbTable.append(`<tr>
                                <td class="text-center text-primary"> ${directivo.Id} </td>
                                <td> ${directivo.CIP} </td>
                                <td> ${directivo.NumDoc+ "<br />"+directivo.Apellidos+", "+directivo.Nombres} </td>
                                <td> ${tools.getDateForma(directivo.FechaInicio)} </td>
                                <td> ${tools.getDateForma(directivo.FechaFinal)} </td>
                                <td> ${directivo.Directivo } </td>
                                <td> ${estado} </td>
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
                            '<tr class="text-center"><td colspan="9"><p>Se produjo un error, intente nuevamente.</p></td></tr>'
                        );
                        $("#lblPaginaActual").html(0);
                        $("#lblPaginaSiguiente").html(0);
                        state = false;
                    }
                }

                function onEventPaginacion() {
                    switch (opcion) {
                        case 0:
                            loadTable(0, "");
                            break;
                        case 1:
                            loadTable(1, $("#buscar").val());
                            break;
                    }
                }

                //==================TABLE FUNCIONES =========================

                //==================MODAL FUNCIONES =========================
                async function loadModalDirectorio() {
                    $("#btnNuevo").click(function() {
                        openAddModalDirectorio();
                    });

                    $("#mdDirectorio").on('shown.bs.modal', function() {
                        if (idDirectivo == "") $("#cbIngeniero").select2("open");
                    });

                    $("#mdDirectorio").on('hidden.bs.modal', function() {
                        clearModalDirectorio();
                    });

                    $("#btnAceptar").click(function() {
                        crudModalDirectorio();
                    });

                    $("#btnAceptar").keypress(function(event) {
                        if (event.keyCode === 13) {
                            crudModalDirectorio();
                            event.preventDefault();
                        }
                    });

                    $("#cbIngeniero").select2({
                        placeholder: "Buscar Ingeniero",
                        width: '100%',
                        ajax: {
                            url: "../app/controller/ListarIngenierosController.php",
                            type: "GET",
                            dataType: 'json',
                            delay: 250,
                            data: function(params) {
                                return {
                                    type: "alldata",
                                    search: params.term
                                };
                            },
                            processResults: function(response) {
                                return {
                                    results: response
                                };
                            },
                            cache: true
                        }
                    });

                    try {
                        const result = await axios.get("../app/web/DirectorioWeb.php", {
                            params: {
                                type: "listTbDirectorio",
                            }
                        });
                        $("#cbTipoDirectivo").append("<option value=''>- Seleccione -</option>");
                        for (const value of result.data) {
                            $("#cbTipoDirectivo").append("<option value=" + value.IdTablaTipoDirectivo + ">" + value.Nombre + "</option>");
                        }
                    } catch (error) {
                        $("#cbTipoDirectivo").append("<option value=''>- Seleccione -</option>");
                    }
                }

                function openAddModalDirectorio() {
                    $("#titleModal").html('<i class="fa fa-plus"></i> Nueva Persona');
                    $("#mdDirectorio").modal("show");
                }

                async function openUpdateModalDirectorio(id) {
                    try {
                        $("#titleModal").html('<i class="fa fa-plus"></i> Editar Persona <span><img src="./images/spiner.gif" width="25" height="25" style="margin-left: 10px;" /></span>');
                        $("#mdDirectorio").modal("show");

                        let result = await axios.get("../app/web/DirectorioWeb.php", {
                            params: {
                                "type": "id",
                                "IdDirectivo": id
                            }
                        });

                        idDirectivo = id;
                        let data = [{
                            id: result.data.IdDNI,
                            text: result.data.Apellidos + ", " + result.data.Nombres
                        }]

                        $("#cbIngeniero").select2('destroy');
                        $("#cbIngeniero").select2({
                            placeholder: "Buscar Ingeniero",
                            width: '100%',
                            // disabled: 'false',
                            data: data,
                            ajax: {
                                url: "../app/controller/ListarIngenierosController.php",
                                type: "GET",
                                dataType: 'json',
                                delay: 250,
                                data: function(params) {
                                    return {
                                        type: "alldata",
                                        search: params.term
                                    };
                                },
                                processResults: function(response) {
                                    return {
                                        results: response
                                    };
                                },
                                cache: true
                            }
                        });
                        $("#cbIngeniero").select2("enable", false);

                        $("#txtFechaInicio").val(result.data.FechaInicio);
                        $("#txtFechaFinal").val(result.data.FechaFinal);
                        $("#cbTipoDirectivo").val(result.data.IdTablaTipoDirectivo);
                        $("#cbEstado").prop("checked", result.data.Estado === "1" ? true : false);
                        $("#cbUsarFirma").prop("checked", result.data.Firma === "1" ? true : false);
                        if (result.data.Ruta !== "") {
                            lblFirma.attr("src", "./../app/resources/images/" + result.data.Ruta);
                            valImagen = 1;
                            rutaImagen = "./../app/resources/images/" + result.data.Ruta;
                        } else {
                            valImagen = 0;
                        }
                        $("#titleModal").html('<i class="fa fa-plus"></i> Editar Persona </span>');
                    } catch (error) {
                        $("#mdDirectorio").modal("hide");
                    }
                }

                async function deleteModalDirectorio(idDirectivo) {
                    tools.ModalDialog("Directorio", "¿Está seguro de continuar?", async function(value) {
                        if (value) {
                            try {
                                tools.ModalAlertInfo("Directorio", "Procesando petición...");

                                const result = await axios.get("../app/web/DirectorioWeb.php", {
                                    params: {
                                        "type": "delete",
                                        "IdDirectivo": idDirectivo
                                    }
                                });

                                tools.ModalAlertSuccess("Directorio", result.data, () => {
                                    loadInit();
                                });
                            } catch (error) {
                                if (error.response) {
                                    tools.ModalAlertWarning("Directorio", error.response.data);
                                } else {
                                    tools.ModalAlertError("Directorio", "Se genero un error interno, comuníquese con el administrador del sistema.");
                                }
                            }
                        }
                    });
                }

                function clearModalDirectorio() {
                    $("#titleModal").html("");
                    $("#cbIngeniero").select2("val", "0");
                    $("#cbIngeniero").select2("enable");
                    $("#txtFechaInicio").val("");
                    $("#txtFechaFinal").val("");
                    $("#cbTipoDirectivo").val("");
                    $("#cbEstado").prop("checked", false);
                    $("#cbUsarFirma").prop("checked", false);
                    lblFirma.attr("src", "./images/noimage.jpg");
                    $("#fileFirma").val(null);
                    valImagen = 0;
                    rutaImagen = "";
                    idDirectivo = "";
                }

                async function crudModalDirectorio() {
                    if ($("#cbIngeniero").val() == null) {
                        $("#cbIngeniero").select2("open");
                        return;
                    }

                    if ($("#txtFechaInicio").val() == "") {
                        $("#txtFechaInicio").focus();
                        return;
                    }

                    if ($("#txtFechaFinal").val() == "") {
                        $("#txtFechaFinal").focus();
                        return;
                    }

                    if ($("#cbTipoDirectivo").val() == "") {
                        $("#cbTipoDirectivo").focus();
                        return;
                    }

                    tools.ModalDialog("Directorio", "¿Está seguro de continuar?", async function(value) {
                        if (value) {
                            try {
                                $("#mdDirectorio").modal("hide");
                                tools.ModalAlertInfo("Directorio", "Procesando petición...");

                                if (idDirectivo === "") {
                                    const image = await tools.imageBase64($("#fileFirma")[0].files);

                                    let result = await axios.post("../app/web/DirectorioWeb.php", {
                                        "type": "insert",
                                        "IdDNI": $("#cbIngeniero").val(),
                                        "FechaInicio": $("#txtFechaInicio").val(),
                                        "FechaFinal": $("#txtFechaFinal").val(),
                                        "idUsuario": idUsuario,
                                        "Estado": $("#cbEstado").is(":checked"),
                                        "Firma": $("#cbUsarFirma").is(":checked"),
                                        "IdTablaTipoDirectivo": $("#cbTipoDirectivo").val(),
                                        "imagen": image == false ? "" : image.base64String,
                                        "extension": image == false ? "" : image.extension,
                                    });

                                    tools.ModalAlertSuccess("Directorio", result.data, () => {
                                        loadInit();
                                    });
                                } else {
                                    const image = await tools.imageBase64($("#fileFirma")[0].files);

                                    let result = await axios.post("../app/web/DirectorioWeb.php", {
                                        "type": "update",
                                        "IdDNI": $("#cbIngeniero").val(),
                                        "FechaInicio": $("#txtFechaInicio").val(),
                                        "FechaFinal": $("#txtFechaFinal").val(),
                                        "idUsuario": idUsuario,
                                        "Estado": $("#cbEstado").is(":checked"),
                                        "Firma": $("#cbUsarFirma").is(":checked"),
                                        "IdTablaTipoDirectivo": $("#cbTipoDirectivo").val(),
                                        "valImagen": valImagen,
                                        "imagen": image == false ? "" : image.base64String,
                                        "extension": image == false ? "" : image.extension,
                                        "IdDirectivo": idDirectivo
                                    });

                                    tools.ModalAlertSuccess("Directorio", result.data, () => {
                                        onEventPaginacion();
                                    });
                                }
                            } catch (error) {
                                if (error.response) {
                                    tools.ModalAlertWarning("Directorio", error.response.data);
                                } else {
                                    tools.ModalAlertError("Directorio", "Se genero un error interno, comuníquese con el administrador del sistema.");
                                }
                            }
                        }
                    });
                }
                //==================MODAL FUNCIONES =========================
            </script>
        </body>

        </html>
<?php
    } else {
        echo '<script>location.href = "./index.php";</script>';
    }
}
