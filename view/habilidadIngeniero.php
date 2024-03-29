<?php
session_start();

if (!isset($_SESSION['IdUsuario'])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
    if ($_SESSION["Permisos"][13]["ver"] == 1) {
?>
        <!DOCTYPE html>
        <html lang="es">

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
                        <h3 class="no-margin">Habilidad <small> Lista </small> </h3>
                    </section>

                    <section class="content">

                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <button type="button" class="btn btn-default" id="btnRecargar"><i class="fa fa-refresh"></i> Recargar Vista</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <button class="btn btn-success" id="btnExportExcel">
                                        <i class="fa fa-file-excel-o"></i> Generar Excel
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <label>Habilidad.</label>
                                <div class="form-group">
                                    <select class="form-control" id="cbTipoHabilidad">
                                        <option value="0">- Todos -</option>
                                        <option value="1">Habilitado</option>
                                        <option value="2">No habilitados</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <label>Capitulo.</label>
                                <div class="form-group">
                                    <select class="form-control select2" id="cbCapitulo" style="width: 100%;">
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <label>Especialidad.</label>
                                <div class="form-group">
                                    <select class="form-control select2" id="cbEspecialidad">
                                        <option value="0">- Seleccione -</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <label>Filtrar por cip,dni, apellidos y nombres.</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="search" id="txtBuscar" class="form-control" placeholder="Buscar por n° cip, ° dni, nombres y/o apellidos" aria-describedby="search" value="">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-primary" id="btnBuscar">Buscar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <label>Fecha Inicial Pago Cuota.</label>
                                <div class="form-group">
                                    <input type="date" id="txtFechaPago" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <label>Fecha Final Pago Cuota.</label>
                                <div class="form-group">
                                    <input type="date" id="txtFechaFinal" class="form-control">
                                </div>
                            </div>
                        </div>


                        <!-- TABLA -->
                        <div class="row" style="margin-top: -5px;">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="table-responsive">
                                    <table class="table table-striped" style="border-width: 1px;border-style: dashed;border-color: #E31E25;">
                                        <thead style="background-color: #FDB2B1;color: #B72928;">
                                            <th width="5%" class="text-center">#</th>
                                            <th width="5%">Cip</th>
                                            <th width="20%">Colegiado</th>
                                            <th width="7%">Condicion</th>
                                            <th width="18%">Capit./Espe.</th>
                                            <th width="10%">Fecha Colegiado</th>
                                            <th width="10%">Fecha Ult. Cuota</th>
                                            <th width="10%">Habilidad</th>
                                            <th width="10%">Habilitado Hasta</th>
                                        </thead>
                                        <tbody id="tbTableHabilidad">

                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
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
                </div>
                <!-- /.content-wrapper -->
                <!-- start footer -->
                <?php include('./layout/footer.php') ?>
                <!-- end footer -->
            </div>

            <script src="js/tools.js"></script>
            <script>
                let tools = new Tools();

                let state = false;
                let opcion = 0;
                let totalPaginacion = 0;
                let paginacion = 0;
                let filasPorPagina = 20;
                let tbTable = $("#tbTableHabilidad");
                let arrayIngenieros = [];

                let dni = 0;

                let editView = "<?= $_SESSION["Permisos"][13]["actualizar"]; ?>";
                let deleteView = "<?= $_SESSION["Permisos"][13]["eliminar"]; ?>";

                $(document).ready(function() {

                    loadCapitulos();

                    loadInitHabilidad();

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

                    $("#cbTipoHabilidad").change(function() {
                        if (!state) {
                            if ($("#cbCapitulo").val() != 0) {
                                paginacion = 1;
                                loadTableHabilidad(3, '', $("#cbTipoHabilidad").val(), $("#cbCapitulo").val(), 0, "", "");
                                opcion = 3;
                            } else {
                                paginacion = 1;
                                loadTableHabilidad(2, '', $("#cbTipoHabilidad").val(), 0, 0, "", "");
                                opcion = 2;
                            }
                        }
                    });

                    $("#cbCapitulo").change(function() {
                        loadEspecialidades($("#cbCapitulo").val());
                        if (!state) {
                            if ($("#cbCapitulo").val() != 0) {
                                paginacion = 1;
                                loadTableHabilidad(3, $("#txtBuscar").val(), $("#cbTipoHabilidad").val(), $("#cbCapitulo").val(), 0, "", "");
                                opcion = 3;
                            } else {
                                paginacion = 1;
                                loadTableHabilidad(2, $("#txtBuscar").val(), $("#cbTipoHabilidad").val(), 0, 0, "", "");
                                opcion = 2;
                            }
                        }
                    });

                    $("#cbEspecialidad").change(function() {
                        if (!state) {
                            if ($("#cbEspecialidad").val() != 0) {
                                paginacion = 1;
                                loadTableHabilidad(4, $("#txtBuscar").val(), $("#cbTipoHabilidad").val(), $("#cbCapitulo").val(), $("#cbEspecialidad").val(), "", "");
                                opcion = 4;
                            } else {
                                paginacion = 1;
                                loadTableHabilidad(3, $("#txtBuscar").val(), $("#cbTipoHabilidad").val(), $("#cbCapitulo").val(), 0, "", "");
                                opcion = 3;
                            }
                        }
                    });

                    $("#txtFechaPago").change(function() {
                        if (!state) {
                            if (tools.validateDate($("#txtFechaPago").val()) && tools.validateDate($("#txtFechaFinal").val())) {
                                paginacion = 1;
                                loadTableHabilidad(5, '', 0, 0, 0, $("#txtFechaPago").val(), $("#txtFechaFinal").val());
                                opcion = 5;
                            }
                        }
                    });

                    $("#txtFechaFinal").change(function() {
                        if (!state) {
                            if (tools.validateDate($("#txtFechaPago").val()) && tools.validateDate($("#txtFechaFinal").val())) {
                                paginacion = 1;
                                loadTableHabilidad(5, '', 0, 0, 0, $("#txtFechaPago").val(), $("#txtFechaFinal").val());
                                opcion = 5;
                            }
                        }
                    });

                    $("#btnExportExcel").click(function() {
                        if ($("#txtBuscar").val() == '' && $("#cbTipoHabilidad").val() == 0 && $("#cbCapitulo").val() == 0) {
                            openExcelHabilidad(0, '', 0, 0, 0);
                        } else if ($("#txtBuscar").val() != '' && $("#cbTipoHabilidad").val() == 0 && $("#cbCapitulo").val() == 0) {
                            openExcelHabilidad(1, '', $("#txtBuscar").val(), 0, 0, 0);
                        } else if ($("#txtBuscar").val() == '' && $("#cbTipoHabilidad").val() != 0 && $("#cbCapitulo").val() == 0) {
                            openExcelHabilidad(2, '', $("#cbTipoHabilidad").val(), 0, 0);
                        } else if ($("#txtBuscar").val() == '' && $("#cbTipoHabilidad").val() != 0 && $("#cbCapitulo").val() != 0) {
                            openExcelHabilidad(3, '', $("#cbTipoHabilidad").val(), $("#cbCapitulo").val(), 0);
                        } else if ($("#txtBuscar").val() == '' && $("#cbTipoHabilidad").val() != 0 && $("#cbCapitulo").val() != 0) {
                            openExcelHabilidad(4, '', $("#cbTipoHabilidad").val(), $("#cbCapitulo").val(), $("#cbEspecialidad").val());
                        }
                    });

                    $("#txtBuscar").on("keyup", function(event) {
                        if (event.keyCode === 13) {
                            if (!state) {
                                paginacion = 1;
                                loadTableHabilidad(1, $("#txtBuscar").val(), 0, 0, 0, "", "");
                                opcion = 1;
                            }
                            $("#cbTipoHabilidad").val(0);
                            $("#cbCapitulo").select2("val", "0");
                        }
                        event.preventDefault();
                    });

                    $("#btnBuscar").click(function() {
                        if (!state) {
                            paginacion = 1;
                            loadTableHabilidad(1, $("#txtBuscar").val(), 0, 0, 0, "", "");
                            opcion = 1;
                            $("#cbTipoHabilidad").val(0);
                            $("#cbCapitulo").select2("val", "0");
                        }
                    });

                    $("#btnRecargar").click(function() {
                        loadInitHabilidad();
                        $("#txtFechaPago").val(null);
                        $("#txtFechaFinal").val(null);
                    });

                    $("#btnRecargar").keypress(function(event) {
                        if (event.which == 13) {
                            loadInitHabilidad();
                            $("#txtFechaPago").val(null);
                            $("#txtFechaFinal").val(null);
                        }
                        event.preventDefault();
                    });

                });

                function onEventPaginacion() {
                    switch (opcion) {
                        case 0:
                            loadTableHabilidad(0, "", 0, 0, 0, "", "");
                            break;
                        case 1:
                            loadTableHabilidad(1, $("#txtBuscar").val(), 0, 0, 0, "", "");
                            break;
                        case 2:
                            loadTableHabilidad(2, "", $("#cbTipoHabilidad").val(), 0, 0, "", "");
                            break;
                        case 3:
                            loadTableHabilidad(3, "", $("#cbTipoHabilidad").val(), $("#cbCapitulo").val(), 0, "", "");
                            break;
                        case 4:
                            loadTableHabilidad(4, "", $("#cbTipoHabilidad").val(), $("#cbCapitulo").val(), $("#cbEspecialidad").val(), "", "");
                            break;
                        case 5:
                            loadTableHabilidad(5, "", 0, 0, 0, $("#txtFechaPago").val(), $("#txtFechaFinal").val());
                            break;
                    }
                }

                function loadInitHabilidad() {
                    if (!state) {
                        paginacion = 1;
                        loadTableHabilidad(0, "", 0, 0, 0, "", "");
                        opcion = 0;
                    }
                }

                function loadTableHabilidad(opcion, search, tipoHabilidad, capitulo, especialidad, fecha, fechaFin) {
                    $.ajax({
                        url: "../app/controller/PersonaController.php",
                        method: "GET",
                        data: {
                            "type": "habilidadIngeniero",
                            "opcion": opcion,
                            "search": search,
                            "tipoHabilidad": tipoHabilidad,
                            "capitulo": capitulo,
                            "especialidad": especialidad,
                            "fecha": fecha,
                            "fechaFin": fechaFin,
                            "posicionPagina": ((paginacion - 1) * filasPorPagina),
                            "filasPorPagina": filasPorPagina
                        },
                        beforeSend: function() {
                            tbTable.empty();
                            tbTable.append('<tr class="text-center"><td colspan="9"><img src="./images/spiner.gif"/><p>cargando información.</p></td></tr>');
                            state = true;
                            totalPaginacion = 0;
                            arrayIngenieros = [];
                        },
                        success: function(result) {
                            if (result.estado === 1) {
                                tbTable.empty();
                                arrayIngenieros = result.habilidad;
                                if (arrayIngenieros.length == 0) {
                                    tbTable.append('<tr class="text-center"><td colspan="9"><p>No hay datos para mostrar</p></td></tr>');
                                    $("#lblPaginaActual").html(0);
                                    $("#lblPaginaSiguiente").html(0);
                                    state = false;
                                } else {
                                    for (let habilidad of arrayIngenieros) {

                                        let ultimopago = habilidad.UltimaCuota;

                                        tbTable.append('<tr>' +
                                            '<td class="text-center text-primary">' + habilidad.Id + '</td>' +
                                            '<td>' + habilidad.Cip + '</td>' +
                                            '<td>' + habilidad.Dni + '<br>' + habilidad.Apellidos + ', ' + habilidad.Nombres + '</td>' +
                                            '<td>' + habilidad.Condicion + '</td>' +
                                            '<td>' + habilidad.Capitulo + '<br>' + habilidad.Especialidad + '</td>' +
                                            '<td>' + habilidad.FechaColegiado + '</td>' +
                                            '<td>' + habilidad.FechaUltimaCuota + '</td>' +
                                            '<td>' + (habilidad.Habilidad == 'Habilitado' ? '<label class="text-primary text-bold">' + habilidad.Habilidad + '</label>' : '<label class="text-danger">' + habilidad.Habilidad + '</label>') + '</td>' +
                                            '<td>' + habilidad.HabilitadoHasta + '</td>' +
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
                                tbTable.append('<tr class="text-center"><td colspan="9"><p>' + result.message + '</p></td></tr>');
                                $("#lblPaginaActual").html(0);
                                $("#lblPaginaSiguiente").html(0);
                                state = false;
                            }
                        },
                        error: function(error) {
                            tbTable.empty();
                            tbTable.append('<tr class="text-center"><td colspan="9"><p>' + error.responseText + '</p></td></tr>');
                            $("#lblPaginaActual").html(0);
                            $("#lblPaginaSiguiente").html(0);
                            state = false;
                        }
                    });
                }

                async function loadCapitulos() {
                    try {
                        $("#cbCapitulo").empty();

                        const result = await axios.get("../app/web/CapituloWeb.php", {
                            params: {
                                "type": "allCapitulos"
                            }
                        });

                        $("#cbCapitulo").append('<option value="0">- Seleccione -</option>');
                        for (let value of result.data) {
                            $("#cbCapitulo").append('<option value="' + value.idCapitulo + '">' + value.Capitulo + '</option>');
                        }
                    } catch (error) {
                        $("#cbCapitulo").append('<option value="">- Seleccione -</option>');
                    }
                }

                async function loadEspecialidades(idCapitulo) {
                    try {
                        $("#cbEspecialidad").empty();

                        const result = await axios.get("../app/web/CapituloWeb.php", {
                            params: {
                                "type": "allEspecialidades",
                                "idCapitulo": idCapitulo
                            }
                        });

                        $("#cbEspecialidad").append('<option value="">- Seleccione -</option>');
                        for (let value of result.data) {
                            $("#cbEspecialidad").append('<option value="' + value.idEspecialidad + '">' + value.Especialidad + '</option>');
                        }
                        $('#cbEspecialidad').select2();
                    } catch (error) {
                        $("#cbEspecialidad").append('<option value="">- Seleccione -</option>');
                    }
                }

                function openExcelHabilidad(opcion, buscar, habilitado, capitulo, especialidad, fecha = '', fechaFin = '') {
                    window.open("../app/sunat/excelHabilidad.php?opcion=" + opcion + "&txtBuscar=" + buscar + "&cbHabilidad=" + habilitado + "&cbCapitulo=" + capitulo + "&cbEspecialidad=" + especialidad + "&fecha=" + fecha + "&fechaFin=" + fechaFin, "_blank");
                }
            </script>
        </body>

        </html>
<?php
    } else {
        echo '<script>location.href = "./index.php";</script>';
    }
}
