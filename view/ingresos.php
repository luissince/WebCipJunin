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
                                <th>Codigo</th>
                                <th>Categoria</th>
                                <th>Concepto</th>
                                <th>Precio</th>
                                <th>Inicio</th>
                                <th>Fin</th>
                                <th>Estado Sunat</th>
                                <th>Observaciones Sunat</th>
                            </thead>
                            <tbody id="tbTable">

                            </tbody>

                        </table>
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

        });
    </script>
</body>

</html>