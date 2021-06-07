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
                    <h3 class="no-margin">Habilidad <small> Lista </small> </h3>
                </section>

                <section class="content">
                    <div class="row">

                        <div class="col-lg-7 col-md-6 col-sm-12 col-xs-12">
                            <label>Filtrar por cip,dni, apellidos y nombres.</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="search" id="txtBuscar" class="form-control" placeholder="Buscar por n° cip, ° dni, nombres y/o apellidos" aria-describedby="search" value="">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-primary" id="btnBuscar">Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <div class="input-group">
                                    <input type="search" id="txtBuscar" class="form-control" placeholder="Buscar por n° cip, ° dni, nombres y/o apellidos" aria-describedby="search" value="">
                                    <span class="input-group-btn">
                                        <button id="btnBuscar" type="button" class="btn btn-info btn-flat"><i class="fa fa-search"></i> Buscar</button>
                                    </span>
                                </div>
                            </div> -->
                        </div>

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

                        <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <label>Opción.</label>
                            <div class="form-group">
                                <button class="btn btn-success" id="btnEnvioMasivo">
                                    <i class="fa fa-paper-plane"></i> Envio Masivo
                                </button>
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
                                        <th width="7%">Cip</th>
                                        <th width="7%">Dni</th>
                                        <th width="20%">Colegiado</th>
                                        <th width="10%">Condicion</th>
                                        <th width="10%">Fecha Colegiado</th>
                                        <th width="10%">Fecha Ult. Cuota</th>
                                        <th width="10%">Habilidad</th>
                                        <th width="10%">Habilitado Hasta</th>
                                        <th width="5%" class="text-center">Actualizar</th>
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

            $(document).ready(function() {

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

                $("#txtBuscar").on("keyup", function(event) {
                    if (event.keyCode === 13) {
                        if (!state) {
                            paginacion = 1;
                            loadTableHabilidad(1, $("#txtBuscar").val(), 0);
                            opcion = 1;
                        }
                    }
                });

                $("#btnBuscar").click(function() {
                    if (!state) {
                        paginacion = 1;
                        loadTableHabilidad(1, $("#txtBuscar").val(), 0);
                        opcion = 1;
                    }
                });

                $("#cbTipoHabilidad").change(function() {
                    if (!state) {
                        paginacion = 1;
                        loadTableHabilidad(2, $("#txtBuscar").val(), $("#cbTipoHabilidad").val());
                        opcion = 2;
                    }
                });

                $("#btnEnvioMasivo").click(function() {
                    tools.ModalDialog("Habilidad", "¿Está seguro de continuar?", function(value) {
                        if (value == true) {
                            for (let ingeniero of arrayIngenieros) {
                                EnviarHabilidad(ingeniero.Cip, ingeniero.UltimaCuota);
                            }
                        }
                    });
                });
            });

            function onEventPaginacion() {
                switch (opcion) {
                    case 0:
                        loadTableHabilidad(0, "", 0);
                        break;
                    case 1:
                        loadTableHabilidad(1, $("#txtBuscar").val(), 0);
                        break;
                    case 2:
                        loadTableHabilidad(2, $("#txtBuscar").val(), $("#cbTipoHabilidad").val());
                        break;
                }
            }

            function loadInitHabilidad() {
                if (!state) {
                    paginacion = 1;
                    loadTableHabilidad(0, "", 0);
                    opcion = 0;
                }
            }

            function loadTableHabilidad(opcion, search, tipoHabilidad) {
                $.ajax({
                    url: "../app/controller/PersonaController.php",
                    method: "GET",
                    data: {
                        "type": "habilidadIngeniero",
                        "opcion": opcion,
                        "search": search,
                        "tipoHabilidad": tipoHabilidad,
                        "posicionPagina": ((paginacion - 1) * filasPorPagina),
                        "filasPorPagina": filasPorPagina
                    },
                    beforeSend: function() {
                        tbTable.empty();
                        tbTable.append(
                            '<tr class="text-center"><td colspan="10"><img src="./images/spiner.gif"/><p>cargando información.</p></td></tr>'
                        );
                        state = true;
                        totalPaginacion = 0;
                        arrayIngenieros = [];
                    },
                    success: function(result) {
                        if (result.estado === 1) {
                            tbTable.empty();
                            arrayIngenieros = result.habilidad;
                            if (arrayIngenieros.length == 0) {
                                tbTable.append(
                                    '<tr class="text-center"><td colspan="10"><p>No hay datos para mostrar</p></td></tr>'
                                );
                                $("#lblPaginaActual").html(0);
                                $("#lblPaginaSiguiente").html(0);
                                state = false;
                            } else {
                                for (let habilidad of arrayIngenieros) {

                                    let ultimopago = habilidad.UltimaCuota;
                                    /* let ultimopago = (habilidad.FechaUltimaCuota).split('/').reverse().join('-');*/

                                    let btnEnviar = '<button class="btn btn-warning btn-xs" onclick="actualizarHabilidad(\'' + habilidad.Cip + '\',\'' + habilidad.Apellidos + '\',\'' + habilidad.Nombres + '\',\'' + habilidad.CodigoCondicion + '\',\'' + habilidad.Colegiatura + '\',\'' + ultimopago + '\',\'' + habilidad.Especialidad + '\')">' +
                                        '<i class="fa  fa-history" style="font-size:25px;"></i> ' +
                                        '</button>';

                                    tbTable.append('<tr>' +
                                        '<td class="text-center text-primary">' + habilidad.Id + '</td>' +
                                        '<td>' + habilidad.Cip + '</td>' +
                                        '<td>' + habilidad.Dni + '</td>' +
                                        '<td>' + habilidad.Apellidos + ', ' + habilidad.Nombres + '</td>' +
                                        '<td>' + habilidad.Condicion + '</td>' +
                                        '<td>' + habilidad.FechaColegiado + '</td>' +
                                        '<td>' + habilidad.FechaUltimaCuota + '</td>' +
                                        '<td>' + (habilidad.Habilidad == 'Habilitado' ? '<label class="text-primary text-bold">' + habilidad.Habilidad + '</label>' : '<label class="text-danger">' + habilidad.Habilidad + '</label>') + '</td>' +
                                        '<td>' + habilidad.HabilitadoHasta + '</td>' +
                                        '<td class="text-center">' + btnEnviar + '</td>' +
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
                                '<tr class="text-center"><td colspan="10"><p>' + result.message + '</p></td></tr>'
                            );
                            $("#lblPaginaActual").html(0);
                            $("#lblPaginaSiguiente").html(0);
                            state = false;
                        }
                    },
                    error: function(error) {
                        tbTable.empty();
                        tbTable.append(
                            '<tr class="text-center"><td colspan="10"><p>' + error.responseText + '</p></td></tr>'
                        );
                        $("#lblPaginaActual").html(0);
                        $("#lblPaginaSiguiente").html(0);
                        state = false;
                    }
                });
            }

            function EnviarHabilidad(cip, ultimopago) {
                $.ajax({
                    url: "http://cip-junin.org.pe/sistema/UpdateLastPago.php",
                    method: "POST",
                    dataType: "json",
                    data: {
                        "cip": cip,
                        "UltimoPago": ultimopago
                    },
                    beforeSend: function() {
                        console.log("iniciando...")
                    },
                    success: function(result) {
                        console.log(result);
                    },
                    error: function(error) {
                        console.log(error)
                    }
                });
            }

            function actualizarHabilidad(cip, apellidos, nombres, condicion, colegiatura, ultimopago, especialidad) {
                // console.log(cip)
                // console.log(apellidos)
                // console.log(nombres)
                // console.log(condicion)
                // console.log(colegiatura)
                // console.log(ultimopago)
                // console.log(especialidad)
                $.ajax({
                    url: "http://cip-junin.org.pe/sistema/UpdateLastPago.php",
                    method: "POST",
                    dataType: "json",
                    data: {
                        "cip": cip,
                        "apellidos": apellidos,
                        "nombres": nombres,
                        "condicion": condicion,
                        "colegiatura": colegiatura,
                        "ultimopago": ultimopago,
                        "sede": "JUNIN",
                        "especialidad": especialidad
                    },
                    beforeSend: function() {
                        tools.ModalAlertInfo("Habilidad", "Procesando petición...");
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            tools.ModalAlertSuccess("Habilidad", result.mensaje);
                        } else if (result.estado == 2) {
                            tools.ModalAlertWarning("Habilidad", result.mensaje);
                        } else if (result.estado == 3) {
                            tools.ModalAlertWarning("Habilidad", result.mensaje);
                        } else {
                            tools.ModalAlertWarning("Habilidad", result.mensaje);
                        }
                    },
                    error: function(error) {
                        tools.ModalAlertError("Habilidad", "Se produjo un error en actualizar la habilidad. Tiempo de conexión agotada, intente nuevamente.");
                    }
                });
            }
        </script>
    </body>

    </html>
<?php }
