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
                <h3 class="no-margin"> Conceptos de cobros <small> Lista </small> </h3>
            </section>

            <!-- Modal -->
            <div class="row">
                <div class="modal fade" id="confirmar">
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

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="categoria">Categoria: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <select id="cbCategoria" class="form-control">
                                                <option value="0">- - Seleccione - -</option>
                                                <option value="1">Cuota ordinaria</option>
                                                <option value="2">Cuota ordinaria (Admistia)</option>
                                                <option value="3">Cuota ordinaria (Vitalicio)</option>
                                                <option value="4">Colegiatura</option>
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
                                            <label for="fecha_inicio">Fecha Inicio: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="txtFecha_inicio" type="date" name="fecha_inicio" class="form-control" required="">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="fecha_fin">Fecha Fin: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="txtFecha_fin" type="date" name="fecha_fin" class="form-control" required="">
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
                                            <label for="rbJunin">CIP Junin</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <input type="radio" id="rbNacional" name="referido" value="1">
                                            <label for="rbNacional">CIP Nacional</label>
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
                                            <label for="precio_ordinario">Precio Ordinario</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <input type="radio" id="precio_transeunte" name="espesifico" value="1">
                                            <label for="precio_transeunte">Precio para Transeunte</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <input type="radio" id="precio_vitalicio" name="espesifico" value="2">
                                            <label for="precio_vitalicio">Precio para Vitalicio</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <input type="radio" id="precio_variable" name="espesifico" value="128">
                                            <label for="precio_variable">Precio Variable</label>
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
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->

            <section class="content">

                <div class="row">
                    <div class="col-md-2 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <!-- <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmar"> -->
                            <button type="button" class="btn btn-danger" id="btnNuevo">
                                <i class="fa fa-plus"></i> Nuevo Concepto
                            </button>
                        </div>
                    </div>

                    <div class="col-md-2 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <button type="button" class="btn btn-link" id="btnactualizar">
                                <i class="fa fa-refresh"></i> Actualizar..
                            </button>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <input type="search" id="buscar" class="form-control" placeholder="Buscar por nombres del concepto" aria-describedby="search" value="">
                        </div>
                    </div>

                    <div class="col-md-2 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <button type="button" class="btn btn-default">
                                <i class="fa fa-search"></i> Buscar
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table class="table table-striped" style="border-width: 1px;border-style: dashed;border-color: #E31E25;">
                                <thead style="background-color: #FDB2B1;color: #B72928;">
                                    <th style="text-align: center;">#</th>
                                    <th>Codigo</th>
                                    <th>Categoria</th>
                                    <th>Concepto</th>
                                    <th>Precio</th>
                                    <th>Inicio/Fin</th>
                                    <th>Especificación</th>
                                    <th>Asignado</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
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

            $("#buscar").on("keyup", function(event) {
                if (event.keyCode === 13) {
                    paginacion = 1;
                    loadTableConceptos($("#buscar").val());
                    opcion = 1;
                }
            });

            //-------------------------------------------------------------------
            $("#btnNuevo").click(function() {
                $("#confirmar").modal("show");
            });

            $("#btnNuevo").on("keyup", function(event) {
                if (event.keyCode === 13) {
                    $("#confirmar").modal("show");
                }
            });

            $("#btnAceptarModal").click(function() {
                validateInsertConcepto();
            });

            $("#btnAceptarModal").on("keyup", function(event) {
                if (event.keyCode === 13) {
                    validateInsertConcepto();
                }
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
                    loadTableConceptos("");
                    break;
                case 1:
                    loadTableConceptos($("#buscar").val());
                    break;
            }
        }

        function loadInitConceptos() {
            if (!state) {
                paginacion = 1;
                loadTableConceptos("");
                opcion = 0;
            }
        }

        function loadTableConceptos(nombres) {
            $.ajax({
                url: "../app/controller/ConceptoController.php",
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
                        '<tr class="text-center"><td colspan="9"><img src="./images/spiner.gif"/><p>cargando información.</p></td></tr>'
                    );
                    state = true;

                },
                success: function(result) {
                    if (result.estado === 1) {
                        let lista = result.conceptos;
                        if (lista.length == 0) {
                            tbTable.empty();
                            tbTable.append(
                                '<tr class="text-center"><td colspan="9"><p>No hay conceptos para mostrar.</p></td></tr>'
                            );
                            totalPaginacion = parseInt(Math.ceil((parseFloat(result.total) / parseInt(
                                filasPorPagina))));
                            $("#lblPaginaActual").html("0");
                            $("#lblPaginaSiguiente").html(totalPaginacion);
                            state = false;
                        } else {
                            tbTable.empty();
                            for (let concepto of lista) {
                                let btnUpdate =
                                    '<button class="btn btn-warning btn-sm" onclick="loadUpdateConceptos(\'' +
                                    concepto.idConcepto + '\')">' +
                                    '<i class="fa fa-wrench"></i> Editar' +
                                    '</button>';

                                let estado = '<span class="' + (concepto.Estado == true ? "label label-success" : "label label-danger") + '">' + (concepto.Estado == true ? "Activo" : "Inactivo") + '</span>';

                                let categoria = (concepto.Categoria == '1') ? 'Cuota ordinaria' :
                                    (concepto.Categoria == '2') ? 'Cuota ordinaria (Admistia)' :
                                    (concepto.Categoria == '3') ? 'Cuota ordinaria (Vitalicio)' :
                                    (concepto.Categoria == '4') ? 'Colegiatura' :
                                    (concepto.Categoria == '5') ? 'Certificado de habilidad' :
                                    (concepto.Categoria == '6') ? 'Certificado de residencia de obra' :
                                    (concepto.Categoria == '7') ? 'Certificado de proyecto' :
                                    (concepto.Categoria == '8') ? 'Peritaje' : 'Ingresos Diversos';

                                let propiedad =
                                    concepto.Propiedad == "48" || concepto.Propiedad == "16" ? "Se deriva al CIP NACIONAL" :
                                    "Se deriva al CIP JUNÍN";

                                //0 cip junin
                                //48 cip nacional

                                let Asinador = concepto.Asignado == "0" ? "Precio Ordinario" :
                                    concepto.Propiedad == "1" ? "Precio Transeunte" :
                                    concepto.Propiedad == "2" ? "Precio Vitalicio" : "Precio Variable";

                                tbTable.append('<tr>' +
                                    '<td style="text-align: center;color: #2270D1;">' +
                                    '' + concepto.Id + '' +
                                    '</td>' +
                                    '<td>' + concepto.Codigo + '</td>' +
                                    '<td>' + categoria + '</td>' +
                                    '<td>' + concepto.Concepto + '</td>' +
                                    '<td>' + concepto.Precio + '</td>' +
                                    '<td>' + concepto.Inicio.split(' ')[0] + '<br>' + concepto.Fin.split(' ')[0] + '</td>' +
                                    '<td> ' + propiedad + '</td>' +
                                    '<td>' + Asinador + '</td>' +
                                    '<td>' + estado + '</td>' +
                                    '<td>' + btnUpdate + '</td>' +
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
                        '<tr class="text-center"><td colspan="9"><p>Se produjo un error, intente nuevamente o cumuníquese con su administrador.</p></td></tr>'
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

        function validateInsertConcepto() {
            insertConcepto();
        }

        function insertConcepto() {
            if ($("#cbCategoria").val() == "0") {
                tools.AlertWarning("Advertencia", "Seleccione la categoría del concepto.");
            } else if ($("#txtConcepto").val() == '' || $("#txtConcepto").val().length < 2) {
                tools.AlertWarning("Advertencia", "Ingrese el nombre del concepto.");
            } else if ($("#txtPrecio").val() == '' || $("#txtPrecio").val().length == 0) {
                tools.AlertWarning("Advertencia", "Ingrese el precio del concepto.");
            } else if ($("#txtFecha_inicio").val() == '') {
                tools.AlertWarning("Advertencia", "Seleccione la fecha de inicio.");
            } else if ($("#txtFecha_fin").val() == '') {
                tools.AlertWarning("Advertencia", "Seleccione la fecha de fin.");
            } else {
                tools.ModalDialog("Conceptos", "¿Está seguro de continuar?", function(value) {
                    if (value == true) {
                        $.ajax({
                            url: "../app/controller/ConceptoController.php",
                            method: "POST",
                            data: {
                                "type": "create",
                                "Categoria": categoria,
                                "Concepto": concepto,
                                "Precio": precio,
                                "Propiedad": $("#rbJunin").is(":checked") ? 0 : 48,
                                "Inicio": inicio,
                                "Fin": fin,
                                "Asignado": $("#precio_ordinario").is(":ckecked") ? 0 : $("#precio_transeunte").is(":ckecked") ? 1 : $("#precio_vitalicio").is(":ckecked") ? 2 : 3,
                                "Observacion": observacion.toUpperCase(),
                                "Codigo": codigo,
                                "Estado": estado,
                            },
                            beforeEnd: function() {
                                clearModalConcepto();
                                tools.ModalAlertInfo("Conceptos", "Procesando petición..");
                            },
                            success: function(result) {
                                if (result.estado == 1) {
                                    tools.AlertSuccess("Mensaje", result.message)
                                    tools.ModalAlertSuccess("Conceptos", result.message);
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
            $("#confirmar").modal("hide");
            $("#cbCategoria").val(0);
            $("#txtCodigo").val(null);
            $("#txtConcepto").val(null);
            $("#txtPrecio").val(null);
            $("#txtFecha_inicio").val('');
            $("#txtFecha_fin").val('');
            $("#rbJunin").prop('checked', 'checked');
            $("#precio_ordinario").prop('checked', 'checked');
            $("#estado").prop('checked', false);
            $("#lblEstado").html("Inactivo");
        }
    </script>
</body>

</html>