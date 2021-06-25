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
                    <h3 class="no-margin"> Notificaciones <small> Lista </small> </h3>
                </section>

                <section class="content">

                    <div class="row">

                        <!-- /.col -->
                        <div class="col-md-12">

                            <!-- /.box-header -->
                            <div class="box-body no-padding">
                                <div class="mailbox-controls">
                                    <!-- /.btn-group -->
                                    <button type="button" class="btn btn-default" id="btnActualizar"><i class="fa fa-refresh"></i> Recargar</button>
                                    <div class="pull-right">
                                        <label id="lblPaginaActual">0</label>
                                        <label>a</label>
                                        <label id="lblPaginaSiguiente">0</label>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary" id="btnIzquierda"><i class="fa fa-chevron-left"></i></button>
                                            <button type="button" class="btn btn-primary" id="btnDerecha"><i class="fa fa-chevron-right"></i></button>
                                        </div>
                                        <!-- /.btn-group -->
                                    </div>
                                    <!-- /.pull-right -->
                                </div>
                                <div class="table-responsive mailbox-messages">
                                    <table class="table table-hover table-striped" style="border-width: 1px;border-style: dashed;border-color: #E31E25;">
                                        <thead  style="background-color: #FDB2B1;color: #B72928;">
                                            <tr>
                                                <th class="text-center" width="5%" >#</th>
                                                <th width="20%">Mensaje</th>
                                                <th width="50%">Detalle</th>
                                                <th width="10%">Fecha</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbList">

                                        </tbody>
                                    </table>
                                    <!-- /.table -->
                                </div>
                                <!-- /.mail-box-messages -->
                            </div>
                            <!-- /. box -->
                        </div>
                        <!-- /.col -->
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
            let totalPaginacion = 0;
            let paginacion = 0;
            let filasPorPagina = 10;
            let tbList = $("#tbList");

            $(document).ready(function() {
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
                    loadInitNotificaciones();
                });

                loadInitNotificaciones();
            });

            function onEventPaginacion() {
                switch (opcion) {
                    case 0:
                        loadTableNotificaciones();
                        break;
                }
            }

            function loadInitNotificaciones() {
                if (!state) {
                    paginacion = 1;
                    loadTableNotificaciones();
                    opcion = 0;
                }
            }

            function loadTableNotificaciones() {             
                $.ajax({
                    url: "../app/controller/IngresoController.php",
                    method: "GET",
                    data: {
                        "type": "listaNotificaciones",
                        "posicionPagina": ((paginacion - 1) * filasPorPagina),
                        "filasPorPagina": filasPorPagina
                    },
                    beforeSend: function() {
                        tbList.empty();
                        tbList.append(
                            '<tr class="text-center"><td colspan="4"><img src="./images/spiner.gif"/><p>Cargando información.</p></td></tr>'
                        );
                        totalPaginacion=0;
                        state = true;
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            if (result.data.lenght == 0) {
                                tbList.empty();
                                tbList.append(
                                    '<tr class="text-center"><td colspan="4"><p>No hay datos para mostrar.</p></td></tr>'
                                );
                                $("#lblPaginaActual").html(0);
                                $("#lblPaginaSiguiente").html(0);
                                state = false;
                            } else {
                                tbList.empty();
                                for (let value of result.data) {
                                    tbList.append('<tr>' +
                                        '<td class="mailbox-star text-center">' + value.Id + '</td>' +
                                        '<td  class="mailbox-name">' + value.Nombre + '<br>' + value.Serie + '-' + value.NumRecibo + '</td>' +
                                        '<td  class="mailbox-subject">' + value.Estado + '</td>' +
                                        '<td  class="mailbox-date">' + tools.getDateForma(value.Fecha) + '</td>' +
                                        '</tr>');
                                }
                                totalPaginacion = parseInt(Math.ceil((parseFloat(result.total) / parseInt(
                                    filasPorPagina))));
                                $("#lblPaginaActual").html(paginacion);
                                $("#lblPaginaSiguiente").html(totalPaginacion);
                                state = false;
                            }
                        } else {
                            tbList.empty();
                            tbList.append(
                                '<tr class="text-center"><td colspan="4"><p>' + result.message + '</p></td></tr>'
                            );
                            $("#lblPaginaActual").html(0);
                            $("#lblPaginaSiguiente").html(0);
                            state = false;
                        }
                    },
                    error: function(error) {
                        tbList.empty();
                        tbList.append(
                            '<tr class="text-center"><td colspan="4"><p>' + error.responseText + '</p></td></tr>'
                        );
                        $("#lblPaginaActual").html(0);
                        $("#lblPaginaSiguiente").html(0);
                        state = false;
                    }
                });
            }
        </script>
    </body>

    </html>

<?php }
