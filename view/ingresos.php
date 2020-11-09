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
                <h3 class="no-margin"> Ingresos <small> Lista </small> </h3>
            </section>

            <section class="content">

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="form-group">
                                <label>Fecha de inicio:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="date" class="form-control pull-right" id="datepicker">
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="form-group">
                                <label>Fecha de fin:</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="date" class="form-control pull-right" id="datepicker">
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3" style="margin-top: 25px; margin-left: 50px;">
                        <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <input type="search" id="buscar" class="form-control" placeholder="Escribe para filtrar automaticamente" aria-describedby="search" value="" style="border-radius: 5px;">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12" style="margin-top: 10px;">
                        <table class="table table-striped" style="border-width: 1px;border-style: dashed;border-color: #E31E25;">
                            <thead style="background-color: #FDB2B1;color: #B72928;">
                                <th style="text-align: center;">#</th>
                                <th>Opciones</th>
                                <th>Fecha</th>
                                <th>Comprobante</th>
                                <th>Cliente</th>
                                <th>Total</th>
                                <th>EstadoSunat</th>
                                <th>Observaciones Sunat</th>
                            </thead>
                            <tbody id="tbTable">

                            </tbody>

                        </table>
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
        <?php include('./layout/footer.php'); ?>;
        <!-- end footer -->
    </div>
    <!-- ./wrapper -->
    <script>
        let state = false;
        let totalPaginacion = 0;
        let paginacion = 0;
        let filasPorPagina = 10;
        let tbTable = $("#tbTable");

        $(document).ready(function() {
            loadInitIngresos();

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
        });

        function loadInitIngresos() {
            if (!state) {
                paginacion = 1;
                loadTableIngresos();
            }
        }

        function loadTableIngresos() {
            $.ajax({
                url: "../app/controller/IngresoController2.php",
                method: "GET",
                data: {
                    "posicionPagina": ((paginacion - 1) * filasPorPagina),
                    "filasPorPagina": filasPorPagina
                },
                beforeSend: function() {
                    tbTable.empty();
                    tbTable.append(
                        '<tr class="text-center"><td colspan="8"><img src="./images/spiner.gif"/><p>cargando información.</p></td></tr>'
                    );
                    state = true;
                },
                success: function(result) {
                    console.log(result)
                    if (result.estado == 1) {
                        tbTable.empty();
                        for (let ingresos of result.data) {
                            let btnEstadoSunat = '<button class="btn btn-success btn-sm" onclick="">' +
                                '<i class="fa fa-plus-circle"></i> Enviar' +
                                '</button>';
                            let btnOpcion1 = '<button class="btn btn-danger btn-sm" onclick="">' +
                                '<i class="fa fa-file-pdf-o"></i></br>PDF'+
                                '</button>';
                            let btnOpcion2 = '<button class="btn btn-success btn-sm" onclick="">' +
                                '<i class="fa fa-file-excel-o"></i></br>XML' +
                                '</button>';

                            tbTable.append('<tr>' +
                                '<td style="text-align: center;color: #2270D1;">' +
                                '' + ingresos.id + '' +
                                '</td>' +
                                '<td>' + btnOpcion1+' '+btnOpcion2+ '</td>' +
                                '<td>' + ingresos.fecha + '</td>' +
                                '<td>' + ingresos.numRecibo + '</td>' +
                                '<td>' + ingresos.idUsuario + '</td>' +
                                '<td>' + '' + '</td>' +
                                '<td>' + btnEstadoSunat + '</td>' +
                                '<td>' + '' + '</td>' +
                                '</tr>'
                            );
                        }
                        totalPaginacion = parseInt(Math.ceil((parseFloat(result.total) / parseInt(
                            filasPorPagina))));
                        $("#lblPaginaActual").html(paginacion);
                        console.log(totalPaginacion)
                        $("#lblPaginaSiguiente").html(totalPaginacion);
                        state = false;
                    } else {
                        tbTable.empty();
                        tbTable.append(
                            '<tr class="text-center"><td colspan="8"><p>No se pudo cargar la información.</p></td></tr>'
                        );
                        $("#lblPaginaActual").html(0);
                        $("#lblPaginaSiguiente").html(0);
                        state = false;
                    }
                },

                error: function(error) {
                    console.log(error)
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
    </script>
</body>

</html>