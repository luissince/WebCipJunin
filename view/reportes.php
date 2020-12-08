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
            <section class="content">

                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading"> <i class="fa fa-user"></i> Reportes</div>

                            <!-- Modal Resumen de ingresos -->
                            <div class="row">
                                <div class="modal fade" id="linkListaIngresos">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <i class="fa fa-close"></i>
                                                </button>
                                                <h4 class="modal-title">
                                                    <i class="fa fa-file-pdf-o"></i> Resumen de Ingresos Filtros
                                                </h4>
                                            </div>
                                            <div class="modal-body">

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="fi_ingresos">Fecha Inicio: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                            <input id="fi_ingresos" type="date" name="fi_ingresos" class="form-control" required="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="ff_ingresos">Fecha Fin: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                            <input id="ff_ingresos" type="date" name="ff_ingresos" class="form-control" required="">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-danger" name="btnAceptarIngresos" data-dismiss="modal" id="btnAceptarIngresos">
                                                    <i class="fa fa-check"></i> Aceptar</button>
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">
                                                    <i class="fa fa-remove"></i> Cancelar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Resumen de Aportes del CIN -->
                            <div class="row">
                                <div class="modal fade" id="linkListaResumenCIN">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <i class="fa fa-close"></i>
                                                </button>
                                                <h4 class="modal-title">
                                                    <i class="fa fa-file-pdf-o"></i> Aportes del CIN Filtros
                                                </h4>
                                            </div>
                                            <div class="modal-body">

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="fi_AportesCIN">Fecha Inicio: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                            <input id="fi_AportesCIN" type="date" name="fi_AportesCIN" class="form-control" required="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="ff_AportesCIN">Fecha Fin: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                            <input id="ff_AportesCIN" type="date" name="ff_AportesCIN" class="form-control" required="">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-danger" name="btnAceptarAportesCIN" id="btnAceptarAportesCIN">
                                                    <i class="fa fa-check"></i> Aceptar</button>
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">
                                                    <i class="fa fa-remove"></i> Cancelar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="panel-body">

                                <div class="row">
                                    <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12"></div>
                                    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                        <div class="row">

                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                <a href="" data-toggle="modal" data-target="#linkListaIngresos">
                                                    <div class="panel panel-default" style="border-style: dashed;border-width: 1px;border-color: #2A2A28;">
                                                        <div class="panel-body" style="text-align: center;">
                                                            <img src="images/portapapeles.png" alt="Vender" width="87">
                                                            <p style="margin-top: 10px;font-size: 14pt;color:#C68907;">
                                                                Resumen de Ingresos
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                <a href="" id="linkListaColegiados">
                                                    <div class="panel panel-default" style="border-style: dashed;border-width: 1px;border-color: #2A2A28;">
                                                        <div class="panel-body" style="text-align: center;">
                                                            <img src="images/informe-medico.png" alt="Vender" width="87">
                                                            <p style="margin-top: 10px;font-size: 14pt;color:#C68907;">
                                                                Lista de Colegiados
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                <a href="" data-toggle="modal" data-target="#linkListaResumenCIN">
                                                    <div class="panel panel-default" style="border-style: dashed;border-width: 1px;border-color: #2A2A28;">
                                                        <div class="panel-body" style="text-align: center;">
                                                            <img src="images/sitio-web.png" alt="Vender" width="87">
                                                            <p style="margin-top: 10px;font-size: 14pt;color:#C68907;">
                                                                Resumen de Aportes al CIN
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                <a href="" id="linkListaGlobal">
                                                    <div class="panel panel-default" style="border-style: dashed;border-width: 1px;border-color: #2A2A28;">
                                                        <div class="panel-body" style="text-align: center;">
                                                            <img src="images/reportglobal.png" alt="Vender" width="87">
                                                            <p style="margin-top: 10px;font-size: 14pt;color:#C68907;">
                                                                Reporte Global
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br><br>
                            </div>
                        </div>
                    </div>
                </div>

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->
    <script src="./js/tools.js"></script>
    <script>
        let tools = new Tools();

        $(document).ready(function() {

            $("#fi_ingresos").val(tools.getCurrentDate())
            $("#ff_ingresos").val(tools.getCurrentDate())

            $("#fi_AportesCIN").val(tools.getCurrentDate())
            $("#ff_AportesCIN").val(tools.getCurrentDate())

            $("#btnAceptarIngresos").click(function() {
                let fechaInicial = $("#fi_ingresos").val();
                let fechaFinal = $("#ff_ingresos").val();
                if (fechaInicial != '' && fechaFinal != null) {
                    window.open("../app/sunat/resumeningresos.php?fechaInicial=" + fechaInicial +
                        "&fechaFinal=" + fechaFinal, "_blank");
                }

            });

            $("#linkListaColegiados").click(function() {

            });

            $("#linkListaGlobal").click(function() {
                window.open("../app/sunat/resumenGlobal.php", "_blank");
            });


            $("#btnAceptarAportesCIN").click(function() {
                let fechaInicial = $("#fi_AportesCIN").val();
                let fechaFinal = $("#ff_AportesCIN").val();
                if (fechaInicial != '' && fechaFinal != null) {
                    window.open("../app/sunat/resumenaportecin.php?fechaInicial=" + fechaInicial +
                        "&fechaFinal=" + fechaFinal, "_blank");
                }
            });

        });
    </script>
</body>

</html>