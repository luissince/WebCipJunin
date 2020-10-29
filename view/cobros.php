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
            <section class="content">

                <div class="row">

                    <div class="col-lg-12 col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading"> <i class="fa fa-money"></i> Generar cobro</div>

                            <div class="row">

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <button type="button" class="btn btn-primary margin-xs " data-toggle="modal" data-target="#confirmar">
                                        <i class="fa fa-plus"></i> Colegiatura
                                    </button>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmar">
                                        <i class="fa fa-plus"></i> Cuotas
                                    </button>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmar">
                                        <i class="fa fa-plus"></i> Certificado
                                    </button>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmar">
                                        <i class="fa fa-plus"></i> Peritaje
                                    </button>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmar">
                                        <i class="fa fa-plus"></i> Otros
                                    </button>
                                </div>

                            </div>

                            <div>
                                <div>
                                    <table class="table">
                                        <thead style="background-color: #FDB2B1;color: #B72928;">
                                            <th>#</th>
                                            <th>Cantidad</th>
                                            <th>Concepto</th>
                                            <th>Impuesto</th>
                                            <th>Monto</th>
                                            <th>Editar</th>
                                            <th>Quitar</th>
                                        </thead>
                                    </table>
                                </div>
                                <div>
                                    <div>
                                        <div>COBRAR</div>
                                        <div>IMPORTE TOTAL</div>
                                        <div>S/ 0.00</div>
                                    </div>
                                    <div>
                                        <div>Comprobante</div>
                                        <div>
                                            <span>B001</span>
                                            <span>0000000</span>
                                        </div>
                                    </div>
                                    <div>
                                        <div>Colegiado</div>
                                        <div>N° Documento</div>
                                        <div>N° Cip</div>
                                        <div>Nombre/Razón Social</div>
                                    </div>
                                </div>
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
</body>

</html>