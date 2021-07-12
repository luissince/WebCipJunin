<?php
session_start();

if (!isset($_SESSION['IdUsuario'])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
    if ($_SESSION["Permisos"][0]["ver"] == 1) {
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
                    <section class="content">

                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading"> <i class="fa fa-user"></i> Bienvenido al Sistema</div>
                                    <div class="panel-body">

                                        <br><br>

                                        <div class="row">
                                            <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12"></div>
                                            <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <div class="row">

                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <a href="./ingenieros.php">
                                                            <div class="panel panel-default" style="border-style: dashed;border-width: 1px;border-color: #2A2A28;">
                                                                <div class="panel-body" style="text-align: center;">
                                                                    <img src="images/tutores.png" alt="Vender" width="84">
                                                                    <p style="margin-top: 10px;font-size: 14pt;color:#C68907;">
                                                                        Ingenieros
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <a href="./cobros.php">
                                                            <div class="panel panel-default" style="border-style: dashed;border-width: 1px;border-color: #2A2A28;">
                                                                <div class="panel-body" style="text-align: center;">
                                                                    <img src="images/pago.png" alt="Vender" width="85">
                                                                    <p style="margin-top: 10px;font-size: 14pt;color:#C68907;">
                                                                        Cobros
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <a href="./reportes.php">
                                                            <div class="panel panel-default" style="border-style: dashed;border-width: 1px;border-color: #2A2A28;">
                                                                <div class="panel-body" style="text-align: center;">
                                                                    <img src="images/reporte.png" alt="Vender" width="87">
                                                                    <p style="margin-top: 10px;font-size: 14pt;color:#C68907;">
                                                                        Reportes
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
                <?php include('./layout/footer.php') ?>
                <!-- end footer -->
            </div>
            <!-- ./wrapper -->
        </body>

        </html>
<?php
    } else {
        echo '<script>location.href = "./index.php";</script>';
    }
}
