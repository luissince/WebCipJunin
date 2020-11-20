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
                            <div class="panel-body">

                                <div class="row">
                                    <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12"></div>
                                    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                        <div class="row">

                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                <a href="" id="linkListaIngresos">
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
                                                <a href="" id="linkListaResumenCIN">
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
                                                <a href="" id="linkListaIngresos">
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
        <!-- start footer -->
        <?php include('./layout/footer.php'); ?>;
        <!-- end footer -->
    </div>
    <!-- ./wrapper -->
    <script>
        $(document).ready(function() {

            $("#linkListaIngresos").click(function() {
                window.open("../app/sunat/resumeningresos.php", "_blank");
            });

            $("#linkListaColegiados").click(function() {

            });

            $("#linkListaResumenCIN").click(function() {

            });

        });
    </script>
</body>

</html>