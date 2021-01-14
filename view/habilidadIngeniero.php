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
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <input type="search" id="buscar" class="form-control" placeholder="Buscar por nombres o apellidos" aria-describedby="search" value="">
                            </div>
                        </div>

                        <div class="col-md-1 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <button class="btn btn-default">
                                    <i class="fa fa-search"></i> Buscar
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

                        <div class="col-md-5 col-sm-12 col-xs-12">
                            <div class="form-group" style="float: right;">
                                <button class="btn btn-success" id="btnEnvioMasivo">
                                    <i class="fa  fa-paper-plane"></i> Envio Masivo
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
                                        <th style="text-align: center;">#</th>
                                        <th>Cip</th>
                                        <th>Dni</th>
                                        <th>Ingeniero</th>
                                        <th>Condicion</th>
                                        <th>Fecha Colegiado</th>
                                        <th>Fecha Ult. Cuota</th>
                                        <th>Habilidad</th>
                                        <th>Opciones</th>
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
            let filasPorPagina = 15;
            let tbTable = $("#tbTableHabilidad");

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

                $("#btnactualizar").click(function() {
                    loadInitHabilidad()
                });

                $("#buscar").on("keyup", function(event) {
                    if (event.keyCode === 13) {
                        paginacion = 1;
                        loadTableHabilidad($("#buscar").val());
                        opcion = 1;
                    }
                });
            });

            function onEventPaginacion() {
                switch (opcion) {
                    case 0:
                        loadTableHabilidad("");
                        break;
                    case 1:
                        loadTableHabilidad($("#buscar").val());
                        break;
                }
            }

            function loadInitHabilidad() {
                if (!state) {
                    paginacion = 1;
                    loadTableHabilidad("");
                    opcion = 0;
                }
            }

            function loadTableHabilidad(search) {
                $.ajax({
                    url: "../app/controller/PersonaController.php",
                    method: "GET",
                    data: {
                        "type": "habilidadIngeniero",
                        "search": search,
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
                            tbTable.empty();
                            for (let habilidad of result.habilidad) {
                                
                                let ultimopago = (habilidad.FechaUltimaCuota).split('/').reverse().join('-');

                                // let image = '<img src="images/masculino.png" width="30">';
                                let btnEnviar = '<button class="btn btn-success btn-sm" onclick="EnviarHabilidad(\'' + habilidad.Cip + '\',\''+ ultimopago+'\')">' +
                                    '<i class="fa  fa-history"></i> Actualizar' +
                                    '</button>';

                                // let btnUpdate =
                                //     '<button class="btn btn-warning btn-sm" onclick="loadUpdateIngenieros(\'' +
                                //     persona.idDNI + '\')">' +
                                //     '<i class="fa fa-wrench"></i> Editar' +
                                //     '</button>';

                                tbTable.append('<tr>' +
                                    '<td style="text-align: center;color: #2270D1;">' + habilidad.Id + '</td>' +
                                    '<td>' + habilidad.Cip + '</td>' +
                                    '<td>' + habilidad.Dni + '</td>' +
                                    '<td>' + habilidad.Ingeniero + '</td>' +
                                    '<td>' + habilidad.Condicion + '</td>' +
                                    '<td>' + habilidad.FechaColegiado + '</td>' +
                                    '<td>' + habilidad.FechaUltimaCuota + '</td>' +
                                    '<td>' + habilidad.Habilidad + '</td>' +
                                    '<td>' +
                                    '' + btnEnviar + '' +
                                    '</td>' +
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
                                '<tr class="text-center"><td colspan="9"><p>' + result.message + '</p></td></tr>'
                            );
                            $("#lblPaginaActual").html(0);
                            $("#lblPaginaSiguiente").html(0);
                            state = false;
                        }
                    },
                    error: function(error) {
                        tbTable.empty();
                        tbTable.append(
                            '<tr class="text-center"><td colspan="9"><p>' + error.responseText + '</p></td></tr>'
                        );
                        $("#lblPaginaActual").html(0);
                        $("#lblPaginaSiguiente").html(0);
                        state = false;
                    }
                });
            }

            function EnviarHabilidad(cip, ultimopago){
                $.ajax({
                     url:"http://cip-junin.org.pe/sistema/UpdateLastPago.php",
                    method: "POST",
                    data: {
                        "cip": cip,
                        "UltimoPago": ultimopago
                    },
                    beforeSend: function() {
                    },
                    success: function(result) {
                        console.log(result);
                    },
                    error: function(error) {
                        console.log(error.responseText)
                    }
                });
            }
        </script>
    </body>

    </html>
<?php }
