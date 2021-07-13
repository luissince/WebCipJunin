<?php
session_start();

if (!isset($_SESSION['IdUsuario'])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
    if ($_SESSION["Permisos"][10]["ver"] == 1) {
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
                <!-- Modal -->
                <div class="row">
                    <div class="modal fade" data-backdrop="static" id="modalNuevoConcepto">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" id="btnCloseModal">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-list-alt">
                                        </i> Registrar Concepto
                                    </h4>
                                </div>
                                <div class="modal-body">

                                    <div class="modal-overlay d-none" id="divOverlayModal">
                                        <div class="modal-overlay-content">
                                            <div>
                                                <i class="fa fa-refresh fa-spin"></i>
                                            </div>
                                            <div>
                                                <label id="lblOverlayModal">Cargando información...</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="categoria">Categoria: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <select id="cbCategoria" class="form-control">
                                                    <option value="0">- - Seleccione - -</option>
                                                    <option value="1">Cuota ordinaria</option>
                                                    <option value="2">Cuota ordinaria (Admistia)</option>
                                                    <option value="3">Cuota ordinaria (Vitalicio)</option>
                                                    <option value="12">Cuota ordinaria (Resolución 15)</option>
                                                    <option value="4">Colegiatura ordinaria</option>
                                                    <option value="9">Colegiatura otras modalidades</option>
                                                    <option value="10">Colegiatura por tesis local</option>
                                                    <option value="11">Colegiatura por tesis externa</option>
                                                    <option value="5">Certificado de habilidad</option>
                                                    <option value="6">Certificado de residencia de obra</option>
                                                    <option value="7">Certificado de Proyecto</option>
                                                    <option value="8">Peritaje</option>
                                                    <option value="100">Ingresos Diversos</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="codigo">Codigo: </label>
                                                <input id="txtCodigo" type="text" name="codigo" class="form-control" placeholder="Codigo del concepto" required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="concepto">Concepto: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="txtConcepto" type="text" name="concepto" class="form-control" placeholder="Nombre del concepto" required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="precio">Precio: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="txtPrecio" type="number" name="precio" class="form-control" placeholder="Monto del concepto" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="txtFecha_inicio">Fecha Inicio: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="txtFecha_inicio" type="date" class="form-control" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="txtFecha_fin">Fecha Fin: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="txtFecha_fin" type="date" class="form-control" required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>Referido a: <i class="fa fa-fw fa-asterisk text-danger"></i></p>

                                        </div>
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <input type="radio" id="rbJunin" name="referido" value="" checked="checked">
                                                <label for="rbJunin"> CIP Junin</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <input type="radio" id="rbNacional" name="referido" value="1">
                                                <label for="rbNacional"> CIP Nacional</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>Modalidad de ingeniero: <i class="fa fa-fw fa-asterisk text-danger"></i></p>
                                        </div>
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <input type="radio" id="precio_ordinario" name="espesifico" value="0" checked="checked">
                                                <label for="precio_ordinario"> Precio Ordinario</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <input type="radio" id="precio_transeunte" name="espesifico" value="1">
                                                <label for="precio_transeunte"> Precio para Transeunte</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <input type="radio" id="precio_vitalicio" name="espesifico" value="2">
                                                <label for="precio_vitalicio"> Precio para Vitalicio</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <input type="radio" id="precio_variable" name="espesifico" value="128">
                                                <label for="precio_variable"> Precio Variable</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>Impuesto: <i class="fa fa-fw fa-asterisk text-danger"></i></p>
                                        </div>
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <select class="form-control" id="cbImpuesto">
                                                    <option value="">- - Seleccione - -</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="checkbox" id="estado">
                                                <label for="estado" id="lblEstado">Inactivo</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <p class="text-left text-danger">Todos los campos marcados con <i class="fa fa-fw fa-asterisk text-danger"></i> son obligatorios</p>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <button type="button" class="btn btn-warning" id="btnAceptarModal">
                                            <i class="fa fa-check"></i> Aceptar</button>
                                        <button type="button" class="btn btn-primary" id="btnCancelarModal">
                                            <i class="fa fa-remove"></i> Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper" style="background-color: #FFFFFF;">
                    <!-- Main content -->
                    <section class="content-header">
                        <h3 class="no-margin"> Conceptos de cobros <small> Lista </small> </h3>
                    </section>

                    <section class="content">

                        <div class="row">
                            <?php
                            if ($_SESSION["Permisos"][10]["crear"]) {
                                echo ' 
                                <div class="col-md-2 col-sm-12 col-xs-12">
                                    <label>Nuevo Concepto.</label>
                                    <div class="form-group">
                                        <!-- <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmar"> -->
                                        <button type="button" class="btn btn-success" id="btnNuevo">
                                            <i class="fa fa-plus"></i> Agregar
                                        </button>
                                    </div>
                                </div>';
                            } ?>

                            <div class="col-md-2 col-sm-12 col-xs-12">
                                <label>Opción.</label>
                                <div class="form-group">
                                    <button type="button" class="btn btn-default" id="btnactualizar">
                                        <i class="fa fa-refresh"></i> Recargar
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-12 col-xs-12">
                                <label>Categoría.</label>
                                <div class="form-group">
                                    <select class="form-control" id="cbTipoCategorias">
                                        <option value="0">- - Seleccione - -</option>
                                        <option value="1">Cuota ordinaria</option>
                                        <option value="2">Cuota ordinaria (Admistia)</option>
                                        <option value="3">Cuota ordinaria (Vitalicio)</option>
                                        <option value="12">Cuota ordinaria (Resolución 15)</option>
                                        <option value="4">Colegiatura ordinaria</option>
                                        <option value="9">Colegiatura otras modalidades</option>
                                        <option value="10">Colegiatura por tesis local</option>
                                        <option value="11">Colegiatura por tesis externa</option>
                                        <option value="5">Certificado de habilidad</option>
                                        <option value="6">Certificado de residencia de obra</option>
                                        <option value="7">Certificado de Proyecto</option>
                                        <option value="8">Peritaje</option>
                                        <option value="100">Ingresos Diversos</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-5 col-sm-12 col-xs-12">
                                <label>Filtrar por categoría, concepto.</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="search" id="buscar" class="form-control" placeholder="Buscar por nombres del concepto" aria-describedby="search" value="">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-primary" id="btnBuscar">Buscar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="table-responsive">
                                    <table class="table table-striped" style="border-width: 1px;border-style: dashed;border-color: #E31E25;">
                                        <thead style="background-color: #FDB2B1;color: #B72928;">
                                            <th width="5%" class="text-center">#</th>
                                            <th width="7%">Codigo</th>
                                            <th width="10%">Categoria</th>
                                            <th width="17%">Concepto</th>
                                            <th width="10%">Precio</th>
                                            <th width="10%">Especificación</th>
                                            <th width="10%">Asignado</th>
                                            <th width="15%">Impuesto</th>
                                            <th width="5%">Estado</th>
                                            <th width="5%">Editar</th>
                                            <th width="5%">Eliminar</th>
                                        </thead>
                                        <tbody id="tbTable">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                <ul class="pagination">
                                    <li>
                                        <button class="btn btn-primary" id="btnIzquierda">
                                            <i class="fa fa-toggle-left"></i>
                                        </button>
                                    </li>
                                    <li>
                                        <span id="lblPaginaActual" class="font-weight-bold">0</span>
                                    </li>
                                    <li><span>de</span></li>
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

                let editView = "<?= $_SESSION["Permisos"][10]["actualizar"]; ?>";
                let deleteView = "<?= $_SESSION["Permisos"][10]["eliminar"]; ?>";

                $(document).ready(function() {

                    loadInitConceptos();

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
                        loadInitConceptos()
                    });

                    $("#buscar").keyup(function(event) {
                        if (event.keyCode === 13) {
                            if (!state) {
                                paginacion = 1;
                                loadTableConceptos(1, 0, $("#buscar").val());
                                opcion = 1;
                            }
                        }
                    });

                    $("#btnBuscar").click(function() {
                        if (!state) {
                            paginacion = 1;
                            loadTableConceptos(1, 0, $("#buscar").val());
                            opcion = 1;
                        }
                    });

                    $("#cbTipoCategorias").change(function() {
                        if ($("#cbTipoCategorias").val() != '') {
                            if (!state) {
                                paginacion = 1;
                                loadTableConceptos(2, $("#cbTipoCategorias").val(), "");
                                opcion = 2;
                            }
                        }
                    });

                    //--------------------- abrir modal de nuevo concepto ---------------------------------------------------
                    $("#btnNuevo").click(function() {
                        loadModalNuevoConcepto();
                    });

                    $("#btnNuevo").on("keyup", function(event) {
                        if (event.keyCode === 13) {
                            loadModalNuevoConcepto();
                        }
                        event.preventDefault();
                    });

                    $("#btnAceptarModal").click(function() {
                        insertConcepto();
                    });

                    $("#btnAceptarModal").on("keyup", function(event) {
                        if (event.keyCode === 13) {
                            insertConcepto();
                        }
                        event.preventDefault();
                    });

                    $("#modalNuevoConcepto").on("shown.bs.modal", function() {
                        $("#cbCategoria").focus();
                    });

                    $("#cbCategoria").change(function(event) {

                    });

                    $("#btnCancelarModal").click(function() {
                        clearModalConcepto();
                    });

                    $("#btnCloseModal").click(function() {
                        clearModalConcepto();
                    });

                    $("#estado").change(function() {
                        $("#lblEstado").html($("#estado").is(":checked") ? "Activo" : "Inactivo");
                    });

                });

                function onEventPaginacion() {
                    switch (opcion) {
                        case 0:
                            loadTableConceptos(0, 0, "");
                            break;
                        case 1:
                            loadTableConceptos(1, 0, $("#buscar").val());
                            break;
                        case 2:
                            loadTableConceptos(2, $("#cbTipoCategorias").val(), "");
                            break;
                    }
                }

                function loadInitConceptos() {
                    if (!state) {
                        paginacion = 1;
                        loadTableConceptos(0, 0, "");
                        opcion = 0;
                    }
                }

                function loadTableConceptos(opcion, categoria, nombres) {
                    $.ajax({
                        url: "../app/controller/ConceptoController.php",
                        method: "GET",
                        data: {
                            "type": "alldata",
                            "opcion": opcion,
                            "categoria": categoria,
                            "nombres": nombres,
                            "posicionPagina": ((paginacion - 1) * filasPorPagina),
                            "filasPorPagina": filasPorPagina
                        },
                        beforeSend: function() {
                            tbTable.empty();
                            tbTable.append(
                                '<tr class="text-center"><td colspan="11"><img src="./images/spiner.gif"/><p>cargando información.</p></td></tr>'
                            );
                            state = true;

                        },
                        success: function(result) {
                            if (result.estado === 1) {
                                let lista = result.conceptos;
                                if (lista.length == 0) {
                                    tbTable.empty();
                                    tbTable.append(
                                        '<tr class="text-center"><td colspan="11"><p>No hay conceptos para mostrar.</p></td></tr>'
                                    );
                                    totalPaginacion = parseInt(Math.ceil((parseFloat(result.total) / parseInt(
                                        filasPorPagina))));
                                    $("#lblPaginaActual").html("0");
                                    $("#lblPaginaSiguiente").html(totalPaginacion);
                                    state = false;
                                } else {
                                    tbTable.empty();
                                    for (let concepto of lista) {
                                        let btnUpdate = editView == 0 ? '<i class="fa fa-minus" style="font-size:20px;"></i>' :
                                            '<button class="btn btn-warning btn-xs" onclick="loadUpdateConceptos(\'' +
                                            concepto.idConcepto + '\')">' +
                                            '<i class="fa fa-edit" style="font-size:25px;"></i> </button>';

                                        let btndelete = deleteView == 0 ? '<i class="fa fa-minus" style="font-size:20px;"></i>' :
                                            '<button class="btn btn-danger btn-xs" onclick="DeleteConcepto(\'' + concepto.idConcepto + '\')">' +
                                            '<i class="fa fa-trash" style="font-size:25px;"></i> </button>';

                                        let Estado = '<span class="' + (concepto.Estado == true ? "label label-success" : "label label-danger") + '">' + (concepto.Estado == true ? "Activo" : "Inactivo") + '</span>';

                                        let categoria = (concepto.Categoria == '1') ? 'Cuota ordinaria' :
                                            (concepto.Categoria == '2') ? 'Cuota ordinaria (Admistia)' :
                                            (concepto.Categoria == '3') ? 'Cuota ordinaria (Vitalicio)' :
                                            (concepto.Categoria == '4') ? 'Colegiatura Ordinaria' :
                                            (concepto.Categoria == '5') ? 'Certificado de habilidad' :
                                            (concepto.Categoria == '6') ? 'Certificado de residencia de obra' :
                                            (concepto.Categoria == '7') ? 'Certificado de proyecto' :
                                            (concepto.Categoria == '8') ? 'Peritaje' :
                                            (concepto.Categoria == '9') ? 'Colegiatura otras Modalidades' :
                                            (concepto.Categoria == '10') ? 'Colegiatura por Tesis' :
                                            (concepto.Categoria == '11') ? 'Colegiatura pro Tesis Externo' :
                                            (concepto.Categoria == '12') ? 'Cuota ordinaria (Resolución N° 15)' :
                                            'Ingresos Diversos';

                                        let propiedad =
                                            concepto.Propiedad == "48" || concepto.Propiedad == "16" ? "Se deriva al CIP NACIONAL" :
                                            "Se deriva al CIP JUNÍN";

                                        //0 cip junin
                                        //48 cip nacional

                                        let Impuesto = concepto.Impuesto;

                                        let Asinador = concepto.Asignado == "0" ? "Precio Ordinario" :
                                            concepto.Asignado == "1" ? "Precio Transeunte" :
                                            concepto.Asignado == "2" ? "Precio Vitalicio" : "Precio Variable";

                                        tbTable.append('<tr>' +
                                            '<td class="text-center text-primary">' + concepto.Id + '</td>' +
                                            '<td class="text-left">' + concepto.Codigo + '</td>' +
                                            '<td class="text-left">' + categoria + '</td>' +
                                            '<td class="text-left">' + concepto.Concepto + '</td>' +
                                            '<td class="text-left">' + concepto.Precio + '</td>' +
                                            '<td class="text-left">' + propiedad + '</td>' +
                                            '<td class="text-left">' + Asinador + '</td>' +
                                            '<td class="text-left">' + Impuesto + '</td>' +
                                            '<td class="text-center">' + Estado + '</td>' +
                                            '<td class="text-center">' + btnUpdate + '</td>' +
                                            '<td class="text-center">' + btndelete + '</td>' +
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
                                    '<tr class="text-center"><td colspan="11"><p>' + result.message + '</p></td></tr>'
                                );
                                $("#lblPaginaActual").html(0);
                                $("#lblPaginaSiguiente").html(0);

                                state = false;
                            }
                        },
                        error: function(error) {
                            tbTable.empty();
                            tbTable.append(
                                '<tr class="text-center"><td colspan="11"><p>' + error.responseText + '</p></td></tr>'
                            );
                            $("#lblPaginaActual").html(0);
                            $("#lblPaginaSiguiente").html(0);
                            state = false;
                        }
                    });
                }

                function loadUpdateConceptos(idConcepto) {
                    location.href = "update_conceptos.php?idConcepto=" + idConcepto
                }


                function loadModalNuevoConcepto() {
                    $("#modalNuevoConcepto").modal("show");
                    $.ajax({
                        url: "../app/controller/ImpuestoController.php",
                        method: "GET",
                        data: {
                            "type": "allForComboBox"
                        },
                        beforeSend: function() {
                            $("#cbImpuesto").empty();
                            $("#divOverlayModal").removeClass("d-none");
                            $("#lblOverlayModal").html("Cargando información...");
                        },
                        success: function(result) {
                            if (result.estado == 1) {
                                $("#cbImpuesto").append('<option value="">- - Seleccione - -</option>');
                                for (let value of result.data) {
                                    $("#cbImpuesto").append("<option value=" + value.IdImpuesto + ">" + value.Nombre + "</option>");
                                }
                                $("#divOverlayModal").addClass("d-none");
                            } else {
                                $("#lblOverlayModal").html(result.mensaje);
                            }
                        },
                        error: function(error) {
                            $("#lblOverlayModal").html(error.responseText);
                        }
                    });
                }

                function insertConcepto() {
                    if ($("#cbCategoria").val() == "0") {
                        tools.AlertWarning("Advertencia", "Seleccione la categoría del concepto.");
                        $("#cbCategoria").focus();
                    } else if ($("#txtConcepto").val() == '' || $("#txtConcepto").val().length < 2) {
                        tools.AlertWarning("Advertencia", "Ingrese el nombre del concepto.");
                        $("#txtConcepto").focus();
                    } else if ($("#txtPrecio").val() == '' || $("#txtPrecio").val().length == 0) {
                        tools.AlertWarning("Advertencia", "Ingrese el precio del concepto.");
                        $("#txtPrecio").focus();
                    } else if ($("#txtFecha_inicio").val() == '') {
                        tools.AlertWarning("Advertencia", "Seleccione la fecha de inicio.");
                        $("#txtFecha_inicio").focus();
                    } else if ($("#txtFecha_fin").val() == '') {
                        tools.AlertWarning("Advertencia", "Seleccione la fecha de fin.");
                        $("#txtFecha_fin").focus();
                    } else if ($('#cbImpuesto option').length != 0 && $("#cbImpuesto").val() == "") {
                        tools.AlertWarning("Advertencia", "Seleccione el impuesto a incluir.");
                        $("#cbImpuesto").focus();
                    } else {
                        tools.ModalDialog("Conceptos", "¿Está seguro de continuar?", function(value) {
                            if (value == true) {
                                $.ajax({
                                    url: "../app/controller/ConceptoController.php",
                                    method: "POST",
                                    data: {
                                        "type": "create",
                                        "Categoria": $("#cbCategoria").val(),
                                        "Concepto": $("#txtConcepto").val(),
                                        "Precio": $("#txtPrecio").val(),
                                        "Propiedad": $("#rbJunin").is(":checked") ? 0 : 48,
                                        "Inicio": $("#txtFecha_inicio").val(),
                                        "Fin": $("#txtFecha_fin").val(),
                                        "Asignado": $("#precio_ordinario").is(":checked") ? 0 : $("#precio_transeunte").is(":checked") ? 1 : $("#precio_vitalicio").is(":checked") ? 2 : 3,
                                        "Observacion": "",
                                        "Codigo": $("#txtCodigo").val(),
                                        "Estado": $("#estado").is(":checked"),
                                        "Impuesto": $("#cbImpuesto").val()
                                    },
                                    beforeSend: function() {
                                        clearModalConcepto();
                                        tools.ModalAlertInfo("Conceptos", "Procesando petición..");
                                    },
                                    success: function(result) {
                                        if (result.estado == 1) {
                                            tools.ModalAlertSuccess("Conceptos", result.message);
                                            loadInitConceptos()
                                        } else {
                                            tools.ModalAlertWarning("Conceptos", result.message);
                                        }
                                    },
                                    error: function(error) {
                                        tools.ModalAlertError("Conceptos", error.responseText);
                                    }
                                });
                            }
                        });
                    }
                }

                function clearModalConcepto() {
                    $("#modalNuevoConcepto").modal("hide");
                    $("#cbCategoria").val(0);
                    $("#txtCodigo").val("");
                    $("#txtConcepto").val("");
                    $("#txtPrecio").val("");
                    $("#txtFecha_inicio").val(null);
                    $("#txtFecha_fin").val(null);
                    $("#rbJunin").prop('checked', 'checked');
                    $("#precio_ordinario").prop('checked', 'checked');
                    $("#estado").prop('checked', false);
                    $("#cbImpuesto").empty();
                    $("#lblEstado").html("Inactivo");
                }


                function DeleteConcepto(idConcepto) {
                    tools.ModalDialog("Concepto", "¿Está seguro de continuar?", function(value) {
                        if (value == true) {
                            $.ajax({
                                url: "../app/controller/ConceptoController.php",
                                method: "POST",
                                data: {
                                    "type": "deleteConcepto",
                                    "idconcepto": idConcepto,
                                },
                                beforeSend: function() {
                                    tools.ModalAlertInfo("Concepto", "Procesando petición..");
                                },
                                success: function(result) {
                                    if (result.estado == 1) {
                                        tools.ModalAlertSuccess("Concepto", result.message);
                                        loadInitConceptos()
                                    } else {
                                        tools.ModalAlertWarning("Concepto", result.message);
                                    }
                                },
                                error: function(error) {
                                    tools.ModalAlertError("Concepto", "Se produjo un error: " + error.responseText);
                                }
                            });
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
